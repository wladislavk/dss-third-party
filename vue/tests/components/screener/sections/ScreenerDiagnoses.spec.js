import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerDiagnosesComponent from '../../../../src/components/screener/sections/ScreenerDiagnoses.vue'
import $ from 'jquery'

describe('ScreenerDiagnoses', () => {
  beforeEach(function () {
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
        name: 'screener-results',
        path: '/results'
      }
    ]

    const vueOptions = {
      template: '<div><screener-diagnoses></screener-diagnoses></div>',
      components: {
        screenerDiagnoses: ScreenerDiagnosesComponent
      }
    }

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
  })

  it('should display existing fields', function () {
    const allLabels = this.vm.$el.querySelectorAll('div#sect4 > div.field')
    expect(allLabels.length).toBe(8)

    const getLabel = (number) => {
      const index = number - 1
      return allLabels[index].querySelector('label').textContent.trim()
    }

    expect(getLabel(1)).toBe('Heart Failure')
    expect(getLabel(2)).toBe('Stroke')
  })

  it('should update data when form is submitted', function (done) {
    const epworthProps = [
      {
        id: 1,
        selected: 0
      },
      {
        id: 2,
        selected: 1
      },
      {
        id: 3,
        selected: 2
      }
    ]
    this.vue.$store.commit(symbols.mutations.setEpworthProps, epworthProps)

    moxios.stubRequest(http.formUrl(endpoints.screeners.store), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    const nextButton = this.vm.$el.querySelector('a#sect4_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    const firstInput = this.vm.$el.querySelector('input#rx_heart_disease')
    const secondInput = this.vm.$el.querySelector('input#rx_hypertension')
    firstInput.click()
    secondInput.click()

    const cpapButtonId = this.vue.$store.state.screener[symbols.state.cpap].name + '1'
    this.vm.$el.querySelector('input#' + cpapButtonId).click()

    nextButton.click()

    moxios.wait(() => {
      const request = moxios.requests.mostRecent()
      const expectedRequest = {
        docid: 0,
        userid: 0,
        epworth: [
          {
            id: 1,
            selected: 0
          },
          {
            id: 2,
            selected: 1
          },
          {
            id: 3,
            selected: 2
          }
        ],
        first_name: '',
        last_name: '',
        phone: '',
        breathing: false,
        driving: false,
        gasping: false,
        sleepy: false,
        snore: false,
        weight_gain: false,
        blood_pressure: false,
        jerk: false,
        burning: false,
        headaches: false,
        falling_asleep: false,
        staying_asleep: false,
        rx_cpap: 4,
        rx_heart_disease: 2,
        rx_stroke: 0,
        rx_hypertension: 1,
        rx_diabetes: 0,
        rx_metabolic_syndrome: 0,
        rx_obesity: 0,
        rx_heartburn: 0,
        rx_afib: 0
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedRequest)

      expect(nextButton.classList.contains('disabled')).toBe(true)
      expect(this.vue.$router.currentRoute.name).toBe('screener-results')
      expect(this.vue.$store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(7)
      done()
    })
  })

  it('should throw error when server returns 400', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.screeners.store), {
      status: 400,
      responseText: {
        errors: {}
      }
    })

    const nextButton = this.vm.$el.querySelector('a#sect4_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    const cpapButtonId = this.vue.$store.state.screener[symbols.state.cpap].name + '1'
    this.vm.$el.querySelector('input#' + cpapButtonId).click()

    moxios.wait(() => {
      expect(nextButton.classList.contains('disabled')).toBe(false)
      expect(this.vue.$store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      done()
    })
  })
})
