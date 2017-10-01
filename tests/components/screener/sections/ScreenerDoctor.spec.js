import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerDoctorComponent from '../../../../src/components/screener/sections/ScreenerDoctor.vue'
import sinon from 'sinon'
import $ from 'jquery'

describe('ScreenerDoctor', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()

    window.$ = $
    window.jQuery = $
    const buttonUI = require('jquery-ui/button')
    window.$.fn.extend = buttonUI

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
        epworthid: 1,
        epworth: 'foo',
        selected: 1
      },
      {
        epworthid: 2,
        epworth: 'bar',
        selected: 0
      },
      {
        epworthid: 3,
        epworth: 'baz',
        selected: 4
      }
    ]

    moxios.stubRequest(http.formUrl(endpoints.epworthSleepinessScale.index + '?status=1&order=sortby'), {
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
      expect(riskImage).toContain('screener-high_risk')

      const resultsDiv = this.vm.$el.querySelector('div#results_div')
      expect(resultsDiv.style.display).toBe('none')
      const resultsButton = this.vm.$el.querySelector('a#sect_results_next')
      resultsButton.click()
      this.vm.$nextTick(() => {
        expect(resultsDiv.style.display).toBe('')

        const contactDivs = this.vm.$el.querySelectorAll('div.contact_div')
        expect(contactDivs.length).toBe(3)
        expect(contactDivs[0].querySelector('label').textContent).toBe('First name:')
        expect(contactDivs[0].querySelector('span').textContent).toBe('John')
        expect(contactDivs[1].querySelector('label').textContent).toBe('Last name:')
        expect(contactDivs[1].querySelector('span').textContent).toBe('Doe')
        expect(contactDivs[2].querySelector('label').textContent).toBe('Phone:')
        expect(contactDivs[2].querySelector('span').textContent).toBe('2233223223')

        const epworthWeight = this.vm.$el.querySelector('span#r_ep_total').textContent
        expect(epworthWeight).toBe('1')

        const epworthDivs = this.vm.$el.querySelectorAll('div.epworth_div')
        expect(epworthDivs.length).toBe(2)
        expect(epworthDivs[1].querySelector('span').textContent).toBe('4')
        expect(epworthDivs[1].querySelector('label').textContent).toBe('baz')

        const symptomDivs = this.vm.$el.querySelectorAll('div.symptom_div')
        expect(symptomDivs.length).toBe(1)
        expect(symptomDivs[0].querySelector('span').textContent).toBe('Yes')
        expect(symptomDivs[0].querySelector('label').textContent).toBe('Have you ever fallen asleep or nodded off while driving?')

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
    expect(this.vue.$store.state.screener[symbols.state.showFancybox]).toBe(false)
    const link = this.vm.$el.querySelector('a#fancy-reg')
    link.click()
    expect(this.vue.$store.state.screener[symbols.state.showFancybox]).toBe(true)
  })

  it('should route to HST', function () {
    const link = this.vm.$el.querySelector('a#sect6_next')
    link.click()
    expect(this.vue.$router.currentRoute.name).toBe('screener-hst')
  })
})
