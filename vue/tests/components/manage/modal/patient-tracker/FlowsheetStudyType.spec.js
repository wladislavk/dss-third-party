import store from '../../../../../src/store'
import symbols from '../../../../../src/symbols'
import FlowsheetStudyTypeComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetStudyType.vue'
import { BASELINE_TEST_ID, TITRATION_STUDY_ID } from '../../../../../src/constants/chart'
import endpoints from '../../../../../src/endpoints'
import TestCase from '../../../../cases/ComponentTestCase'

describe('FlowsheetStudyType component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.flowsheetStudyType,
      params: {
        patientId: 42,
        segmentId: 0,
        flowId: 1
      }
    }

    this.testCase.setComponent(FlowsheetStudyTypeComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows titration types', function () {
    store.state.main[symbols.state.modal].params.segmentId = TITRATION_STUDY_ID
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What type of sleep test will be performed on John Doe?')
    const studyTypeOptions = vm.$el.querySelectorAll('option')
    expect(studyTypeOptions.length).toBe(3)
    const firstStudyType = studyTypeOptions[1]
    expect(firstStudyType.getAttribute('value')).toBe('HST Titration')
    expect(firstStudyType.textContent).toBe('HST Titration')
  })

  it('shows baseline types', function () {
    store.state.main[symbols.state.modal].params.segmentId = BASELINE_TEST_ID
    const vm = this.testCase.mount()

    const studyTypeOptions = vm.$el.querySelectorAll('option')
    expect(studyTypeOptions.length).toBe(3)
    const secondStudyType = studyTypeOptions[2]
    expect(secondStudyType.getAttribute('value')).toBe('PSG Baseline')
    expect(secondStudyType.textContent).toBe('PSG Baseline')
  })

  it('selects study type', function (done) {
    store.state.main[symbols.state.modal].params.segmentId = BASELINE_TEST_ID

    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.update + '/1'
    })
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = 'PSG Baseline'
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      this.testCase.wait(() => {
        const requestResults = this.testCase.getRequestResults()
        expect(requestResults.length).toBe(2)
        const expectedFirst = {
          url: endpoints.appointmentSummaries.update + '/1',
          body: {
            type: 'PSG Baseline'
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
})
