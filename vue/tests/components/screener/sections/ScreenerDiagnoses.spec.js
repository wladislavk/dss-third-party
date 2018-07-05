import endpoints from '../../../../src/endpoints'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import ScreenerDiagnosesComponent from '../../../../src/components/screener/sections/ScreenerDiagnoses.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerDiagnoses', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerDiagnosesComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-results',
        path: '/results'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display existing fields', function () {
    const vm = this.testCase.mount()

    const allLabels = vm.$el.querySelectorAll('div#sect4 > div.field')
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
    store.commit(symbols.mutations.setEpworthProps, epworthProps)

    this.testCase.stubRequest({
      url: endpoints.screeners.store
    })

    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect4_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    const firstInput = vm.$el.querySelector('input#rx_heart_disease')
    const secondInput = vm.$el.querySelector('input#rx_hypertension')
    firstInput.click()
    secondInput.click()

    store.commit(symbols.mutations.addStoredCpap, store.state.screener[symbols.state.cpap].weight)

    nextButton.click()

    moxios.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).not.toBe(0)
      const lastRequest = requestResults[requestResults.length - 1]
      expect(lastRequest.hasOwnProperty('body')).toBe(true)
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
      expect(lastRequest.body).toEqual(expectedRequest)

      expect(nextButton.classList.contains('disabled')).toBe(true)
      expect(vm.$router.currentRoute.name).toBe('screener-results')
      expect(store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(7)
      done()
    })
  })

  it('should throw error when server returns 400', function (done) {
    this.testCase.stubRequest({
      url: endpoints.screeners.store,
      status: 400
    })
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect4_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    const cpapButtonId = store.state.screener[symbols.state.cpap].name + '1'
    vm.$el.querySelector('input#' + cpapButtonId).click()

    moxios.wait(() => {
      expect(nextButton.classList.contains('disabled')).toBe(false)
      expect(store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      done()
    })
  })
})
