import Vue from 'vue'
import VueRouter from 'vue-router'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import ScreenerResultsComponent from '../../../../src/components/screener/sections/ScreenerResults.vue'
import store from '../../../../src/store'

describe('ScreenerResults', () => {
  beforeEach(function () {
    moxios.install()

    const routes = [
      {
        name: 'screener-doctor',
        path: '/doctor'
      }
    ]

    const Component = Vue.extend(ScreenerResultsComponent)
    this.mount = function () {
      return new Component({
        store: store,
        router: new VueRouter({routes})
      }).$mount()
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
  })

  it('should display results', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.users.show + '/1'), {
      status: 200,
      responseText: {
        data: { first_name: 'Jane' }
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

    const vm = this.mount()

    moxios.wait(() => {
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
    const vm = this.mount()
    const nextButton = vm.$el.querySelector('a#sect5_next')
    nextButton.click()
    expect(vm.$router.currentRoute.name).toBe('screener-doctor')
  })
})
