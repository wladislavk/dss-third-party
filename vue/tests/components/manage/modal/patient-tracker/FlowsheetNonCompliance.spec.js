import store from '../../../../../src/store'
import symbols from '../../../../../src/symbols'
import FlowsheetNonComplianceComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetNonCompliance.vue'
import endpoints from '../../../../../src/endpoints'
import { NON_COMPLIANT_ID } from '../../../../../src/constants/chart'
import TestCase from '../../../../cases/ComponentTestCase'

describe('FlowsheetNonCompliance component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.flowsheetNonCompliance,
      params: {
        patientId: 42,
        flowId: 1
      }
    }

    this.testCase.setComponent(FlowsheetNonComplianceComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows modal', function () {
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What is the reason John Doe is non-compliant?')
    const treatmentOptions = vm.$el.querySelectorAll('option')
    expect(treatmentOptions.length).toBe(4)
    const secondTreatment = treatmentOptions[1]
    expect(secondTreatment.getAttribute('value')).toBe('lost device')
    expect(secondTreatment.textContent).toBe('Lost Device')
  })

  it('sets treatment', function (done) {
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = 'lost device'
    selector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      this.testCase.stubRequest({
        url: endpoints.appointmentSummaries.update + '/1'
      })

      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      this.testCase.wait(() => {
        const requestResults = this.testCase.getRequestResults()
        expect(requestResults.length).toBe(2)
        const expectedFirst = {
          url: endpoints.appointmentSummaries.update + '/1',
          body: {
            noncomp_reason: 'lost device'
          }
        }
        expect(requestResults[0]).toEqual(expectedFirst)

        const expectedModal = {
          name: '',
          params: {}
        }
        expect(store.state.main[symbols.state.modal]).toEqual(expectedModal)
        done()
      })
    })
  })

  it('sets treatment with reason', function (done) {
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = 'other'
    selector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      this.testCase.stubRequest({
        url: endpoints.appointmentSummaries.update + '/1'
      })

      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      this.testCase.wait(() => {
        const expectedModal = {
          name: symbols.modals.flowsheetReason,
          params: {
            flowId: 1,
            segmentId: NON_COMPLIANT_ID,
            patientId: 42
          }
        }
        expect(store.state.main[symbols.state.modal]).toEqual(expectedModal)
        done()
      })
    })
  })
})
