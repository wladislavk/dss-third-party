import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import ScreenerResultsComponent from '../../../../src/components/screener/sections/ScreenerResults.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerResults', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerResultsComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-doctor',
        path: '/doctor'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display results', function (done) {
    this.testCase.stubRequest({
      url: endpoints.users.show + '/1',
      response: {
        first_name: 'Jane'
      }
    })

    store.commit(symbols.mutations.sessionData, { docId: 1 })
    store.commit(symbols.mutations.surveyWeight, 12)
    store.state.screener[symbols.state.contactData] = [
      {
        camelName: 'firstName',
        value: 'John'
      }
    ]
    store.dispatch(symbols.actions.getDoctorData)

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const riskDiv = vm.$el.querySelector('div.risk_desc')
      expect(riskDiv.id).toBe('risk_high')
      const riskImage = vm.$el.querySelector('div#risk_image > img').getAttribute('src')
      expect(riskImage).toContain('screener-high_risk')
      const expectedText = 'John, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to Jane or any of our staff to find out about our advanced tools for diagnosing sleep apnea.'
      expect(riskDiv.textContent).toContain(expectedText)
      done()
    })
  })

  it('should route to next page', function () {
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect5_next')
    nextButton.click()
    expect(vm.$router.currentRoute.name).toBe('screener-doctor')
  })
})
