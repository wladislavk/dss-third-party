import moxios from 'moxios'
import AppointmentSummaryRowComponent from '../../../../src/components/manage/chart/AppointmentSummaryRow.vue'
import {
  BASELINE_TEST_ID,
  DELAYING_ID,
  IMPRESSIONS_ID,
  INITIAL_CONTACT_ID,
  NON_COMPLIANT_ID
} from '../../../../src/constants/chart'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('AppointmentSummaryRow component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      patientId: 42,
      elementId: 1,
      dateCompleted: new Date('2016-01-02')
    }

    const childComponents = [
      'sleep-study-row',
      'reason-row',
      'device-row'
    ]
    this.testCase.setComponent(AppointmentSummaryRowComponent)
    this.testCase.setChildComponents(childComponents)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows sleep study row', function (done) {
    this.props.segmentId = BASELINE_TEST_ID
    this.props.studyType = 'foo'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    expect(vm.$el.id).toBe('completed_row_1')
    const title = vm.$el.querySelector('span.title')
    expect(title.innerText).toBe('Baseline Sleep Test')
    const subComponent = vm.$el.querySelector('td.form-inline div.sleep-study-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('segment-id')).toBe('' + BASELINE_TEST_ID)
    expect(subComponent.getAttribute('study-type')).toBe('foo')
    const lettersLink = vm.$el.querySelector('td.letters a')
    expect(lettersLink).toBeNull()
    const lettersSpan = vm.$el.querySelector('td.letters span')
    expect(lettersSpan).not.toBeNull()
    const deleteButton = vm.$el.querySelector('a.deleteButton')
    expect(deleteButton).not.toBeNull()
    const datepickerInput = vm.$el.querySelector('input#completed_date_1')
    expect(datepickerInput).not.toBeNull()
    vm.$nextTick(() => {
      expect(datepickerInput.value).toBe('01/02/2016')
      done()
    })
  })

  it('shows reason row with delay', function () {
    this.props.segmentId = DELAYING_ID
    this.props.delayReason = 'delay reason'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const subComponent = vm.$el.querySelector('td.form-inline div.reason-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('segment-id')).toBe('' + DELAYING_ID)
    expect(subComponent.getAttribute('reason')).toBe('delay reason')
  })

  it('shows reason row with non-compliance', function () {
    this.props.segmentId = NON_COMPLIANT_ID
    this.props.nonComplianceReason = 'non-compliance reason'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const subComponent = vm.$el.querySelector('td.form-inline div.reason-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('segment-id')).toBe('' + NON_COMPLIANT_ID)
    expect(subComponent.getAttribute('reason')).toBe('non-compliance reason')
  })

  it('shows device row', function () {
    this.props.segmentId = IMPRESSIONS_ID
    this.props.deviceId = 5
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const subComponent = vm.$el.querySelector('td.form-inline div.device-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('device-id')).toBe('5')
  })

  it('shows row with letters', function () {
    this.props.segmentId = IMPRESSIONS_ID
    this.props.deviceId = 5
    this.props.letterCount = 2
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const lettersLink = vm.$el.querySelector('td.letters a')
    expect(lettersLink).not.toBeNull()
    expect(lettersLink.getAttribute('href')).toContain('dss_summ.php?sect=letters&pid=42')
    expect(lettersLink.innerText).toBe('2 Letters')
    const lettersSpan = vm.$el.querySelector('td.letters span')
    expect(lettersSpan).toBeNull()
  })

  it('shows row without segment data', function () {
    this.props.segmentId = 99
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const title = vm.$el.querySelector('span.title')
    expect(title.innerText).toBe('')
    const subComponent = vm.$el.querySelector('td.form-inline div')
    expect(subComponent).toBeNull()
  })

  it('shows row that cannot be deleted', function () {
    this.props.segmentId = INITIAL_CONTACT_ID
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deleteButton = vm.$el.querySelector('a.deleteButton')
    expect(deleteButton).toBeNull()
  })

  it('deletes step', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.destroy + '/1'
    })
    this.props.segmentId = BASELINE_TEST_ID
    this.props.studyType = 'foo'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    moxios.wait(() => {
      expect(this.testCase.alertText).toBe('')
      expect(moxios.requests.count()).toBe(1)
      expect(moxios.requests.at(0).url).toBe(http.formUrl(endpoints.appointmentSummaries.destroy + '/1'))
      done()
    })
  })

  it('deletes step without confirmation', function (done) {
    this.testCase.confirmDialog = false
    this.props.segmentId = BASELINE_TEST_ID
    this.props.studyType = 'foo'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    vm.$nextTick(() => {
      expect(moxios.requests.count()).toBe(0)
      done()
    })
  })

  it('deletes step with sent letters', function (done) {
    this.props.segmentId = BASELINE_TEST_ID
    this.props.studyType = 'foo'
    this.props.lettersSent = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    vm.$nextTick(() => {
      expect(this.testCase.alertText).not.toBe('')
      done()
    })
  })

  it('updates completed date', function (done) {
    // @todo: "selected" event does not fire programmatically on datepicker, preventing to do the check
    done()
  })
})
