import Vue from 'vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerResultsComponent from '../../../../src/components/screener/sections/ScreenerResults.vue'

describe('ScreenerResults', () => {
  beforeEach(function () {
    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    const routes = [
      {
        name: 'screener-doctor',
        path: '/doctor'
      }
    ]

    const vueOptions = {
      template: '<div><screener-results></screener-results></div>',
      components: {
        screenerResults: ScreenerResultsComponent
      }
    }

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should display results', function (done) {
    this.vue.$store.commit(symbols.mutations.surveyWeight, 12)
    this.vue.$store.commit(symbols.mutations.contactData, { first_name: 'John' })

    this.vm.$nextTick(() => {
      const riskDiv = this.vm.$el.querySelector('div.risk_desc')
      expect(riskDiv.id).toBe('risk_high')
      const riskImage = this.vm.$el.querySelector('div#risk_image > img').getAttribute('src')
      expect(riskImage).toBe('~assets/images/screener-high_risk.png')
      const expectedText = 'John, thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to Jane or any of our staff to find out about our advanced tools for diagnosing sleep apnea.'
      expect(riskDiv.textContent).toContain(expectedText)
      done()
    })
  })

  it('should route to next page', function () {
    const nextButton = this.vm.$el.querySelector('a#sect5_next')
    nextButton.click()
    expect(this.vue.$router.currentRoute.name).toBe('screener-doctor')
  })
})
