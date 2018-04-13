import moxios from 'moxios'
import sinon from 'sinon'
import Vue from 'vue'
import store from '../../../../src/store'
import AppointmentSummaryRowComponent from '../../../../src/components/manage/chart/AppointmentSummaryRow.vue'
import {
  BASELINE_TEST_ID,
  DELAYING_ID,
  IMPRESSIONS_ID,
  INITIAL_CONTACT_ID,
  NON_COMPLIANT_ID
} from '../../../../src/constants/chart'
import Alerter from '../../../../src/services/Alerter'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'

describe('AppointmentSummaryRow component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    moxios.install()

    Vue.component('sleep-study-row', {
      template: '<div class="sleep-study-row"></div>'
    })
    Vue.component('reason-row', {
      template: '<div class="reason-row"></div>'
    })
    Vue.component('device-row', {
      template: '<div class="device-row"></div>'
    })
    const Component = Vue.extend(AppointmentSummaryRowComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('shows sleep study row', function (done) {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: BASELINE_TEST_ID,
      dateCompleted: new Date('2016-01-02'),
      studyType: 'foo'
    }
    const vm = this.mount(props)
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
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      dateCompleted: new Date('2016-01-02'),
      delayReason: 'delay reason',
      nonComplianceReason: 'non-compliance reason'
    }
    const vm = this.mount(props)
    const subComponent = vm.$el.querySelector('td.form-inline div.reason-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('segment-id')).toBe('' + DELAYING_ID)
    expect(subComponent.getAttribute('reason')).toBe('delay reason')
  })

  it('shows reason row with non-compliance', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: NON_COMPLIANT_ID,
      dateCompleted: new Date('2016-01-02'),
      nonComplianceReason: 'non-compliance reason'
    }
    const vm = this.mount(props)
    const subComponent = vm.$el.querySelector('td.form-inline div.reason-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('segment-id')).toBe('' + NON_COMPLIANT_ID)
    expect(subComponent.getAttribute('reason')).toBe('non-compliance reason')
  })

  it('shows device row', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: IMPRESSIONS_ID,
      dateCompleted: new Date('2016-01-02'),
      deviceId: 5
    }
    const vm = this.mount(props)
    const subComponent = vm.$el.querySelector('td.form-inline div.device-row')
    expect(subComponent).not.toBeNull()
    expect(subComponent.getAttribute('patient-id')).toBe('42')
    expect(subComponent.getAttribute('element-id')).toBe('1')
    expect(subComponent.getAttribute('device-id')).toBe('5')
  })

  it('shows row with letters', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: IMPRESSIONS_ID,
      dateCompleted: new Date('2016-01-02'),
      deviceId: 5,
      letterCount: 2
    }
    const vm = this.mount(props)
    const lettersLink = vm.$el.querySelector('td.letters a')
    expect(lettersLink).not.toBeNull()
    expect(lettersLink.getAttribute('href')).toContain('dss_summ.php?sect=letters&pid=42')
    expect(lettersLink.innerText).toBe('2 Letters')
    const lettersSpan = vm.$el.querySelector('td.letters span')
    expect(lettersSpan).toBeNull()
  })

  it('shows row without segment data', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: 99,
      dateCompleted: new Date('2016-01-02')
    }
    const vm = this.mount(props)
    const title = vm.$el.querySelector('span.title')
    expect(title.innerText).toBe('')
    const subComponent = vm.$el.querySelector('td.form-inline div')
    expect(subComponent).toBeNull()
  })

  it('shows row that cannot be deleted', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: INITIAL_CONTACT_ID,
      dateCompleted: new Date('2016-01-02')
    }
    const vm = this.mount(props)
    const deleteButton = vm.$el.querySelector('a.deleteButton')
    expect(deleteButton).toBeNull()
  })

  it('deletes step', function (done) {
    let isAlerted = false
    this.sandbox.stub(Alerter, 'alert').callsFake(() => {
      isAlerted = true
    })
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })
    const endpoint = endpoints.appointmentSummaries.destroy + '/1'
    moxios.stubRequest(http.formUrl(endpoint), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: BASELINE_TEST_ID,
      dateCompleted: new Date('2016-01-02'),
      studyType: 'foo'
    }
    const vm = this.mount(props)
    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    moxios.wait(() => {
      expect(isAlerted).toBe(false)
      expect(moxios.requests.count()).toBe(1)
      expect(moxios.requests.at(0).url).toBe(http.formUrl(endpoint))
      done()
    })
  })

  it('deletes step without confirmation', function (done) {
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: BASELINE_TEST_ID,
      dateCompleted: new Date('2016-01-02'),
      studyType: 'foo'
    }
    const vm = this.mount(props)
    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    vm.$nextTick(() => {
      expect(moxios.requests.count()).toBe(0)
      done()
    })
  })

  it('deletes step with sent letters', function (done) {
    let isAlerted = false
    this.sandbox.stub(Alerter, 'alert').callsFake(() => {
      isAlerted = true
    })
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: BASELINE_TEST_ID,
      dateCompleted: new Date('2016-01-02'),
      studyType: 'foo',
      lettersSent: true
    }
    const vm = this.mount(props)
    const deleteButton = vm.$el.querySelector('a.deleteButton')
    deleteButton.click()
    vm.$nextTick(() => {
      expect(isAlerted).toBe(true)
      done()
    })
  })

  it('updates completed date', function (done) {
    // @todo: "selected" event does not fire programmatically on datepicker, preventing to do the check
    done()
  })
})
