import moment from 'moment'
import store from '../../../../src/store'
import TrackerSectionTwoComponent from '../../../../src/components/manage/chart/TrackerSectionTwo.vue'
import symbols from '../../../../src/symbols'
import { INITIAL_FUTURE_APPOINTMENT } from '../../../../src/constants/chart'
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

    const props = {
      patientId: 42
    }

    this.testCase.setComponent(TrackerSectionTwoComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows with empty data', function () {
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
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.store
    })
    const vm = this.testCase.mount()

    const datePicker = vm.$el.querySelector('input#next_step_date')
    expect(datePicker.getAttribute('disabled')).toBe('disabled')
    const stepSelector = vm.$el.querySelector('select#next_step')
    stepSelector.value = '2'
    stepSelector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      expect(datePicker.getAttribute('disabled')).toBeNull()
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(2)
      const expectedFirst = {
        url: endpoints.appointmentSummaries.store,
        body: {
          step_id: 2,
          patient_id: 42,
          appt_type: 0
        }
      }
      expect(requestResults[0]).toEqual(expectedFirst)
      done()
    })
  })

  it('updates existing appointment', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.store
    })
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.destroy + '/10'
    })
    store.state.flowsheet[symbols.state.futureAppointment] = {
      id: 10,
      segmentId: 1,
      dateScheduled: null,
      dateUntil: null
    }
    const vm = this.testCase.mount()

    const stepSelector = vm.$el.querySelector('select#next_step')
    expect(stepSelector.value).toBe('1')
    stepSelector.value = '2'
    stepSelector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(3)
      const expectedFirst = {
        url: endpoints.appointmentSummaries.destroy + '/10'
      }
      expect(requestResults[0]).toEqual(expectedFirst)
      const expectedSecond = {
        url: endpoints.appointmentSummaries.store,
        body: {
          step_id: 2,
          patient_id: 42,
          appt_type: 0
        }
      }
      expect(requestResults[1]).toEqual(expectedSecond)
      done()
    })
  })

  it('updates scheduled date', function (done) {
    // @todo: "selected" event does not fire programmatically on datepicker, preventing to do the check
    done()
  })

  it('updates tracker notes', function (done) {
    this.testCase.stubRequest({
      url: endpoints.patientSummaries.updateTrackerNotes
    })
    const vm = this.testCase.mount()

    const trackerNotes = vm.$el.querySelector('input#tracker-notes')
    expect(trackerNotes.value).toBe('')
    trackerNotes.value = 'foo'
    trackerNotes.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(2)
      const expectedFirst = {
        url: endpoints.patientSummaries.updateTrackerNotes,
        body: {
          patient_id: 42,
          tracker_notes: 'foo'
        }
      }
      expect(requestResults[0]).toEqual(expectedFirst)
      done()
    })
  })
})
