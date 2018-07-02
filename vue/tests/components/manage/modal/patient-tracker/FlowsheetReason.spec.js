import moxios from 'moxios'
import store from '../../../../../src/store'
import FlowsheetReasonComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetReason.vue'
import symbols from 'src/symbols'
import { DELAYING_ID } from 'src/constants/chart'
import http from 'src/services/http'
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
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })
    const vm = this.testCase.mount()

    const textarea = vm.$el.querySelector('textarea')
    textarea.value = 'new reason'
    textarea.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        expect(moxios.requests.count()).toBe(2)
        const firstRequest = moxios.requests.at(0)
        expect(firstRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.update + '/1'))
        const expectedData = {
          reason: 'new reason'
        }
        expect(JSON.parse(firstRequest.config.data)).toEqual(expectedData)
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
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })
    const vm = this.testCase.mount()

    const textarea = vm.$el.querySelector('textarea')
    textarea.value = ''
    textarea.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        expect(moxios.requests.count()).toBe(2)
        const firstRequest = moxios.requests.at(0)
        expect(firstRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.update + '/1'))
        const expectedData = {
          reason: 'foo'
        }
        expect(JSON.parse(firstRequest.config.data)).toEqual(expectedData)
        done()
      })
    })
  })
})
