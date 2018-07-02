import moxios from 'moxios'
import store from '../../../../../src/store'
import FlowsheetReasonComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetReason.vue'
import symbols from 'src/symbols'
import { DELAYING_ID } from 'src/constants/chart'
import endpoints from 'src/endpoints'
import TestCase from '../../../../cases/ComponentTestCase'

describe('FlowsheetReason component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.flowsheet[symbols.state.appointmentSummaries] = [
      {
        id: 1,
        description: 'foo'
      },
      {
        id: 2,
        description: 'bar'
      }
    ]
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.flowsheetReason,
      params: {
        patientId: 42,
        flowId: 1,
        segmentId: DELAYING_ID
      }
    }

    this.testCase.setComponent(FlowsheetReasonComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows reason', function () {
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('td.cat_head')
    expect(header.textContent).toBe('Reason for Delaying Treatment')
    const textarea = vm.$el.querySelector('textarea')
    expect(textarea.value).toBe('foo')
  })

  it('shows reason without summary', function () {
    store.state.main[symbols.state.modal].params.flowId = 99
    const vm = this.testCase.mount()

    const textarea = vm.$el.querySelector('textarea')
    expect(textarea.value).toBe('')
  })

  it('updates reason', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.update + '/1'
    })
    const vm = this.testCase.mount()

    const textarea = vm.$el.querySelector('textarea')
    textarea.value = 'new reason'
    textarea.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        const requestResults = this.testCase.getRequestResults()
        expect(requestResults.length).toBe(2)
        const expectedFirst = {
          url: endpoints.appointmentSummaries.update + '/1',
          body: {
            reason: 'new reason'
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

  it('updates with empty data', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.update + '/1'
    })
    const vm = this.testCase.mount()

    const textarea = vm.$el.querySelector('textarea')
    textarea.value = ''
    textarea.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        const requestResults = this.testCase.getRequestResults()
        expect(requestResults.length).toBe(2)
        const expectedFirst = {
          url: endpoints.appointmentSummaries.update + '/1',
          body: {
            reason: 'foo'
          }
        }
        expect(requestResults[0]).toEqual(expectedFirst)
        done()
      })
    })
  })
})
