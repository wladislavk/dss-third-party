import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import ScreenerHstComponent from '../../../../src/components/screener/sections/ScreenerHst.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerHST', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerHstComponent)
    this.testCase.setRoutes([
      {
        name: 'start',
        path: '/'
      },
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ])
    this.testCase.setActiveRoute('start')

    const sessionData = {
      docId: 2,
      userId: 3
    }
    store.commit(symbols.mutations.sessionData, sessionData)
    store.commit(symbols.mutations.screenerId, 1)

    store.commit(symbols.mutations.addStoredContact, { name: 'first_name', value: 'Jane' })
    store.commit(symbols.mutations.addStoredContact, { name: 'last_name', value: 'Doe' })
    store.commit(symbols.mutations.addStoredContact, { name: 'phone', value: '2233223223' })
    store.commit(symbols.mutations.addStoredContact, { name: 'dob', value: '08/25/1985' })
    store.commit(symbols.mutations.addStoredContact, { name: 'email', value: 'foo@bar.com' })
    store.commit(symbols.mutations.addStoredContact, { name: 'class', value: 'foo' })
    store.commit(symbols.mutations.contactData)

    this.testCase.stubRequest({
      url: endpoints.companies.homeSleepTest,
      response: [
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
    })
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display existing data', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const companyDivs = vm.$el.querySelectorAll('div.company_div')
      expect(companyDivs.length).toBe(2)
      expect(companyDivs[0].querySelector('label').textContent).toBe('First')
      expect(companyDivs[1].querySelector('label').textContent).toBe('Second')

      const leftContactDivs = vm.$el.querySelectorAll('div#hst_column_left > div.contact_div')
      const rightContactDivs = vm.$el.querySelectorAll('div#hst_column_right > div.contact_div')
      expect(leftContactDivs.length).toBe(3)
      expect(rightContactDivs.length).toBe(2)
      done()
    })
  })

  it('should send HST request', function (done) {
    this.testCase.stubRequest({
      url: endpoints.homeSleepTests.store
    })
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const companyButton = vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const submitButton = vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.testCase.wait(() => {
        const requestResults = this.testCase.getRequestResults()
        expect(requestResults.length).not.toBe(0)
        const lastRequest = requestResults[requestResults.length - 1]
        expect(lastRequest.hasOwnProperty('body')).toBe(true)
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
        expect(lastRequest.body).toEqual(expectedData)
        expect(store.state.screener[symbols.state.contactData][0].value).toBe('')
        expect(vm.$router.currentRoute.name).toBe('screener-intro')
        done()
      })
    })
  })

  it('should give error if company is not set', function (done) {
    this.testCase.stubRequest({
      url: endpoints.homeSleepTests.store
    })
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const submitButton = vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })

  it('should give error if contact data is not set', function (done) {
    this.testCase.stubRequest({
      url: endpoints.homeSleepTests.store
    })
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      store.commit(symbols.mutations.addStoredContact, {name: 'dob', value: ''})
      store.commit(symbols.mutations.contactData)

      const companyButton = vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const submitButton = vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })

  it('should give error if ajax request returned 400', function (done) {
    this.testCase.stubRequest({
      url: endpoints.homeSleepTests.store,
      status: 400
    })
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const companyButton = vm.$el.querySelector('input#hst_company_id_2')
      companyButton.click()

      const submitButton = vm.$el.querySelector('a#sect7_next')
      submitButton.click()

      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('start')
        done()
      })
    })
  })
})
