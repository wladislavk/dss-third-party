import moxios from 'moxios'
import moment from 'moment'
import store from '../../../../src/store'
import TrackerSectionTwoComponent from '../../../../src/components/manage/chart/TrackerSectionTwo.vue'
import symbols from '../../../../src/symbols'
import { INITIAL_FUTURE_APPOINTMENT } from '../../../../src/constants/chart'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('TrackerSectionTwo component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.flowsheet[symbols.state.trackerStepsNext] = [
      {
        id: 1,
        name: 'foo'
      },
      {
        id: 2,
        name: 'bar'
      }
    ]
    store.state.flowsheet[symbols.state.futureAppointment] = INITIAL_FUTURE_APPOINTMENT

    this.testCase.setComponent(TrackerSectionTwoComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows with empty data', function () {
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const rootDiv = vm.$el
    expect(rootDiv.className).toBe('sched_div current_step')
    const stepSelector = rootDiv.querySelector('select#next_step')
    expect(stepSelector.value).toBe('0')
    const stepOptions = stepSelector.querySelectorAll('option')
    expect(stepOptions.length).toBe(3)
    const secondOption = stepOptions[1]
    expect(secondOption.getAttribute('value')).toBe('1')
    expect(secondOption.textContent).toBe('foo')
    const datePicker = vm.$el.querySelector('input#next_step_date')
    expect(datePicker.value).toBe('')
    expect(datePicker.getAttribute('disabled')).toBe('disabled')
    const interval = rootDiv.querySelector('span#next_step_until')
    expect(interval.textContent).toBe('')
    const trackerNotes = rootDiv.querySelector('input#tracker-notes')
    expect(trackerNotes.value).toBe('')
  })

  it('shows with pre-set future appointment', function (done) {
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const midnight = moment(moment().format('MM/DD/YYYY'), 'MM/DD/YYYY')
    const inTenDays = midnight.add(10, 'days')
    store.state.flowsheet[symbols.state.futureAppointment] = {
      id: 1,
      segmentId: 1,
      dateScheduled: new Date(inTenDays.format('YYYY-MM-DD HH:mm')),
      dateUntil: null
    }
    vm.$nextTick(() => {
      const rootDiv = vm.$el
      expect(rootDiv.className).toBe('sched_div')
      const stepSelector = rootDiv.querySelector('select#next_step')
      expect(stepSelector.value).toBe('1')
      const datePicker = vm.$el.querySelector('input#next_step_date')
      expect(datePicker.value).toBe(inTenDays.format('MM/DD/YYYY'))
      expect(datePicker.getAttribute('disabled')).toBeNull()
      const interval = rootDiv.querySelector('span#next_step_until')
      expect(interval.textContent).toBe('10 days')
      done()
    })
  })

  it('creates new appointment', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.store), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const datePicker = vm.$el.querySelector('input#next_step_date')
    expect(datePicker.getAttribute('disabled')).toBe('disabled')
    const stepSelector = vm.$el.querySelector('select#next_step')
    stepSelector.value = '2'
    stepSelector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(datePicker.getAttribute('disabled')).toBeNull()
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.url).toBe(http.formUrl(endpoints.appointmentSummaries.store))
      const expectedData = {
        step_id: 2,
        patient_id: 42,
        appt_type: 0
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      done()
    })
  })

  it('updates existing appointment', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.store), {
      status: 200,
      responseText: {
        data: []
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.destroy + '/10'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    store.state.flowsheet[symbols.state.futureAppointment] = {
      id: 10,
      segmentId: 1,
      dateScheduled: null,
      dateUntil: null
    }
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const stepSelector = vm.$el.querySelector('select#next_step')
    expect(stepSelector.value).toBe('1')
    stepSelector.value = '2'
    stepSelector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(3)
      const deleteRequest = moxios.requests.at(0)
      expect(deleteRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.destroy + '/10'))
      const addRequest = moxios.requests.at(1)
      expect(addRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.store))
      const expectedData = {
        step_id: 2,
        patient_id: 42,
        appt_type: 0
      }
      expect(JSON.parse(addRequest.config.data)).toEqual(expectedData)
      done()
    })
  })

  it('updates scheduled date', function (done) {
    // @todo: "selected" event does not fire programmatically on datepicker, preventing to do the check
    done()
  })

  it('updates tracker notes', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.patientSummaries.updateTrackerNotes), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const props = {
      patientId: 42
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const trackerNotes = vm.$el.querySelector('input#tracker-notes')
    expect(trackerNotes.value).toBe('')
    trackerNotes.value = 'foo'
    trackerNotes.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.url).toBe(http.formUrl(endpoints.patientSummaries.updateTrackerNotes))
      const expectedData = {
        patient_id: 42,
        tracker_notes: 'foo'
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      done()
    })
  })
})
