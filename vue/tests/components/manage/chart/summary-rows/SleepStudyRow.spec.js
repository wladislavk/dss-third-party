import moxios from 'moxios'
import SleepStudyRowComponent from '../../../../../src/components/manage/chart/summary-rows/SleepStudyRow.vue'
import { BASELINE_TEST_ID } from '../../../../../src/constants/chart'
import endpoints from '../../../../../src/endpoints'
import http from '../../../../../src/services/http'
import TestCase from '../../../../cases/ComponentTestCase'

describe('SleepStudyRow component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      patientId: 42,
      elementId: 1,
      segmentId: BASELINE_TEST_ID
    }

    this.testCase.setComponent(SleepStudyRowComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows sleep studies', function () {
    this.props.studyType = 'PSG Baseline'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const selector = vm.$el
    expect(selector.id).toBe('study_type_1')
    expect(selector.getAttribute('name')).toBe('data[1][study_type]')
    const options = selector.querySelectorAll('option')
    expect(options.length).toBe(3)
    expect(options[1].getAttribute('value')).toBe('HST Baseline')
    expect(options[1].innerText).toBe('HST Baseline')
    expect(selector.value).toBe('PSG Baseline')
  })

  it('shows without sleep study data', function () {
    this.props.segmentId = 99
    this.props.studyType = ''
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const selector = vm.$el
    expect(selector.value).toBe('')
  })

  it('updates sleep study', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    this.props.studyType = 'PSG Baseline'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = 'HST Baseline'
    selector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.config.data).not.toBeUndefined()
      const expectedData = {
        type: 'HST Baseline'
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      done()
    })
  })

  it('updates to empty data', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    this.props.studyType = 'PSG Baseline'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = ''
    selector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(0)
      done()
    })
  })
})
