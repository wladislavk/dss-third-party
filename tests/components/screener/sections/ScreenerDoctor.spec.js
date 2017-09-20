import Vue from 'vue'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerDoctorComponent from '../../../../src/components/screener/sections/ScreenerDoctor.vue'
import sinon from 'sinon'
import fancybox from '../../../../src/services/fancybox'

describe('ScreenerDoctor', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()

    this.sandbox.stub(fancybox, 'screenerDoctor').callsFake(() => {})

    moxios.install()

    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    const routes = [
      {
        name: 'screener-hst',
        path: '/hst'
      },
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    const vueOptions = {
      template: '<div><screener-doctor></screener-doctor></div>',
      components: {
        screenerDoctor: ScreenerDoctorComponent
      }
    }

    this.epworthMockData = [
      {
        id: 1,
        epworth: 'foo',
        selected: 1
      },
      {
        id: 2,
        epworth: 'bar',
        selected: 0
      },
      {
        id: 3,
        epworth: 'baz',
        selected: 4
      }
    ]

    moxios.stubRequest(process.env.API_PATH + 'epworth-sleepiness-scale/sorted-with-status', {
      status: 200,
      responseText: {
        data: this.epworthMockData
      }
    })

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('should display results', function (done) {
    this.vue.$store.commit(symbols.mutations.surveyWeight, 12)
    this.vue.$store.commit(symbols.mutations.epworthWeight, 1)
    this.vue.$store.commit(symbols.mutations.cpap, 4)

    const contactData = {
      first_name: 'John',
      last_name: 'Doe',
      phone: '2233223223'
    }
    this.vue.$store.commit(symbols.mutations.contactData, contactData)

    const symptomData = {
      driving: 6,
      gasping: 0
    }
    this.vue.$store.commit(symbols.mutations.symptoms, symptomData)

    const coMorbidityData = {
      rx_stroke: true,
      rx_diabetes: true
    }
    this.vue.$store.commit(symbols.mutations.coMorbidity, coMorbidityData)

    moxios.wait(() => {
      const epworthProps = {
        1: 1,
        2: 0,
        3: 4
      }
      this.vue.$store.commit(symbols.mutations.modifyEpworthProps, epworthProps)

      const riskImage = this.vm.$el.querySelector('div#risk_image_doc > img').getAttribute('src')
      expect(riskImage).toBe('~assets/images/screener-high_risk.png')

      const resultsDiv = this.vm.$el.querySelector('div#results_div')
      expect(resultsDiv.style.display).toBe('none')
      const resultsButton = this.vm.$el.querySelector('a#sect_results_next')
      resultsButton.click()
      this.vm.$nextTick(() => {
        expect(resultsDiv.style.display).toBe('')

        const contactDivs = this.vm.$el.querySelectorAll('div.contact_div')
        expect(contactDivs.length).toBe(3)
        expect(contactDivs[0].querySelector('label').textContent).toBe('First Name')
        expect(contactDivs[0].querySelector('span').textContent).toBe('John')
        expect(contactDivs[1].querySelector('label').textContent).toBe('Last Name')
        expect(contactDivs[1].querySelector('span').textContent).toBe('Doe')
        expect(contactDivs[2].querySelector('label').textContent).toBe('Phone Number')
        expect(contactDivs[2].querySelector('span').textContent).toBe('2233223223')

        const epworthWeight = this.vm.$el.querySelector('span#r_ep_total').textContent
        expect(epworthWeight).toBe('1')

        const epworthDivs = this.vm.$el.querySelectorAll('div.epworth_div')
        expect(epworthDivs.length).toBe(2)
        expect(epworthDivs[1].querySelector('span').textContent).toBe('4')
        expect(epworthDivs[1].querySelector('label').textContent).toBe('baz')

        const symptomDivs = this.vm.$el.querySelectorAll('div.symptom_div')
        expect(symptomDivs.length).toBe(12)
        expect(symptomDivs[0].querySelector('span').textContent).toBe('No')
        expect(symptomDivs[0].querySelector('label').textContent).toBe('Have you ever been told you stop breathing while asleep?')
        expect(symptomDivs[1].querySelector('span').textContent).toBe('Yes')
        expect(symptomDivs[1].querySelector('label').textContent).toBe('Have you ever fallen asleep or nodded off while driving?')
        expect(symptomDivs[2].querySelector('span').textContent).toBe('No')
        expect(symptomDivs[2].querySelector('label').textContent).toBe('Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?')

        const cpap = this.vm.$el.querySelector('span#r_rx_cpap')
        expect(cpap.textContent).toBe('Yes')

        const coMorbidityLines = this.vm.$el.querySelectorAll('ul#r_diagnosed > li')
        expect(coMorbidityLines.length).toBe(2)
        expect(coMorbidityLines[0].textContent).toBe('Stroke')
        expect(coMorbidityLines[1].textContent).toBe('Diabetes')

        done()
      })
    })
  })

  it('should route to intro', function () {
    const link = this.vm.$el.querySelector('a#finish_ok')
    link.click()
    expect(this.vue.$router.currentRoute.name).toBe('screener-intro')
  })

  it('should route to HST', function () {
    const link = this.vm.$el.querySelector('a#sect6_next')
    link.click()
    expect(this.vue.$router.currentRoute.name).toBe('screener-hst')
  })
})
