import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerHstComponent from '../../../../src/components/screener/sections/ScreenerHst.vue'

describe('ScreenerHST', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    const routes = [
      {
        name: 'start',
        path: '/'
      },
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    const vueOptions = {
      template: '<div><screener-hst></screener-hst></div>',
      components: {
        screenerHst: ScreenerHstComponent
      }
    }

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()
    this.vue.$router.push({name: 'start'})

    const sessionData = {
      docId: 2,
      userId: 3
    }
    this.vue.$store.commit(symbols.mutations.sessionData, sessionData)
    this.vue.$store.commit(symbols.mutations.screenerId, 1)

    const contactData = {
      first_name: 'John',
      last_name: 'Doe',
      phone: '2233223223'
    }
    this.vue.$store.commit(symbols.mutations.contactData, contactData)

    moxios.stubRequest(http.formUrl(endpoints.companies.homeSleepTest), {
      status: 200,
      responseText: {
        data: [
          {
            id: 1,
            name: 'First',
            logo: 'first.png'
          },
          {
            id: 2,
            name: 'Second',
            logo: ''
          }
        ]
      }
    })
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
  })

  it('should display existing data', function (done) {
    moxios.wait(() => {
      const companyDivs = this.vm.$el.querySelectorAll('div.company_div')
      expect(companyDivs.length).toBe(2)
      expect(companyDivs[0].querySelector('label').textContent).toBe('First')
      expect(companyDivs[1].querySelector('label').textContent).toBe('Second')

      const leftContactDivs = this.vm.$el.querySelectorAll('div#hst_column_left > div.contact_div')
      const rightContactDivs = this.vm.$el.querySelectorAll('div#hst_column_right > div.contact_div')
      expect(leftContactDivs.length).toBe(3)
      expect(rightContactDivs.length).toBe(2)
      expect(leftContactDivs[0].querySelector('label').textContent).toBe('First Name')
      expect(leftContactDivs[0].querySelector('input').value).toBe('John')
      expect(leftContactDivs[1].querySelector('label').textContent).toBe('Last Name')
      expect(leftContactDivs[1].querySelector('input').value).toBe('Doe')
      expect(leftContactDivs[2].querySelector('label').textContent).toBe('Date of Birth')
      expect(leftContactDivs[2].querySelector('input').value).toBe('')
      expect(rightContactDivs[0].querySelector('label').textContent).toBe('Phone Number')
      expect(rightContactDivs[0].querySelector('input').value).toBe('2233223223')
      expect(rightContactDivs[1].querySelector('label').textContent).toBe('Email')
      expect(rightContactDivs[1].querySelector('input').value).toBe('')

      done()
    })
  })

  it('should send HST request', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.homeSleepTests.store), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    moxios.wait(() => {
      const companyButton = this.vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const firstNameInput = this.vm.$el.querySelector('input#hst_first_name')
      firstNameInput.value = 'Jane'
      firstNameInput.dispatchEvent(new Event('change'))
      const dobInput = this.vm.$el.querySelector('input#hst_dob')
      dobInput.value = '08/25/1985'
      dobInput.dispatchEvent(new Event('change'))
      const emailInput = this.vm.$el.querySelector('input#hst_email')
      emailInput.value = 'foo@bar.com'
      emailInput.dispatchEvent(new Event('change'))

      const submitButton = this.vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      moxios.wait(() => {
        const request = moxios.requests.mostRecent()
        const expectedData = {
          screener_id: 1,
          doc_id: 2,
          user_id: 3,
          company_id: '2',
          patient_firstname: 'Jane',
          patient_lastname: 'Doe',
          patient_cell_phone: '2233223223',
          patient_email: 'foo@bar.com',
          patient_dob: '08/25/1985'
        }
        expect(JSON.parse(request.config.data)).toEqual(expectedData)

        expect(this.vue.$store.state.screener[symbols.state.contactData][0].value).toBe('')
        expect(this.vue.$router.currentRoute.name).toBe('screener-intro')

        done()
      })
    })
  })

  it('should give error if company is not set', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.homeSleepTests.store), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    moxios.wait(() => {
      const firstNameInput = this.vm.$el.querySelector('input#hst_first_name')
      firstNameInput.value = 'Jane'
      firstNameInput.dispatchEvent(new Event('change'))
      const dobInput = this.vm.$el.querySelector('input#hst_dob')
      dobInput.value = '08/25/1985'
      dobInput.dispatchEvent(new Event('change'))
      const emailInput = this.vm.$el.querySelector('input#hst_email')
      emailInput.value = 'foo@bar.com'
      emailInput.dispatchEvent(new Event('change'))

      const submitButton = this.vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.vm.$nextTick(() => {
        expect(this.vue.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })

  it('should give error if contact data is not set', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.homeSleepTests.store), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    moxios.wait(() => {
      const companyButton = this.vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const firstNameInput = this.vm.$el.querySelector('input#hst_first_name')
      firstNameInput.value = 'Jane'
      firstNameInput.dispatchEvent(new Event('change'))
      const emailInput = this.vm.$el.querySelector('input#hst_email')
      emailInput.value = 'foo@bar.com'
      emailInput.dispatchEvent(new Event('change'))

      const submitButton = this.vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.vm.$nextTick(() => {
        expect(this.vue.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })

  it('should give error if ajax request returned 400', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.homeSleepTests.store), {
      status: 400,
      responseText: {
        data: {}
      }
    })

    moxios.wait(() => {
      const companyButton = this.vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const firstNameInput = this.vm.$el.querySelector('input#hst_first_name')
      firstNameInput.value = 'Jane'
      firstNameInput.dispatchEvent(new Event('change'))
      const dobInput = this.vm.$el.querySelector('input#hst_dob')
      dobInput.value = '08/25/1985'
      dobInput.dispatchEvent(new Event('change'))
      const emailInput = this.vm.$el.querySelector('input#hst_email')
      emailInput.value = 'foo@bar.com'
      emailInput.dispatchEvent(new Event('change'))

      const submitButton = this.vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      moxios.wait(() => {
        expect(this.vue.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })
})
