import TestCase from '../../../cases/StoreTestCase'
import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'
import endpoints from '../../../../src/endpoints'
import { CONSULT_ID } from '../../../../src/constants/chart'
import { INITIAL_FUTURE_APPOINTMENT } from 'src/constants/chart'

describe('Flowsheet module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('appointmentSummariesByPatient action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.expectedHttp = { path: endpoints.appointmentSummaries.byPatient + '/' + this.patientId }
      this.clearSummaryMutation = {
        type: symbols.mutations.clearAppointmentSummary,
        payload: {}
      }
    })
    it('retrieves appointment summaries', function (done) {
      const firstItem = {
        id: 1,
        name: 'foo'
      }
      const secondItem = {
        id: 2,
        name: 'bar'
      }
      const response = [firstItem, secondItem]
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.getAppointmentSummary,
              payload: response
            }
          ],
          actions: [
            {
              type: symbols.actions.lettersByPatientAndInfo,
              payload: this.patientId
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('appointmentSummariesByPatient')
          ]
        })
        done()
      })
    })
  })

  describe('lettersByPatientAndInfo action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.expectedUrl = endpoints.letters.byPatientAndInfo + '?patient_id=' + this.patientId
    })
    it('retrieves letters', function (done) {
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: [
          { id: 10 },
          { id: 12 },
          { id: 12 },
          { id: 11 }
        ]
      })
      const response = ['foo', 'bar']
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        const expectedUrl = this.expectedUrl + '&info_ids%5B0%5D=10&info_ids%5B1%5D=12&info_ids%5B2%5D=11'
        expect(this.testCase.getResults()).toEqual({
          http: { path: expectedUrl },
          mutations: [
            {
              type: symbols.mutations.appointmentSummaryLetters,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: []
      })
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: this.expectedUrl },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getLettersByPatientAndInfo')
          ]
        })
        done()
      })
    })
  })

  describe('addAppointmentSummary action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.flowId = 12
      this.existingDeviceMutation = {
        type: symbols.mutations.setExistingDevice,
        payload: 0
      }
      this.setInitialData = function (segmentId) {
        return {
          patientId: this.patientId,
          segmentId: segmentId
        }
      }
    })
    it('adds appointment summary', function (done) {
      const response = { id: this.flowId }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, this.setInitialData(CONSULT_ID))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: CONSULT_ID,
              patient_id: this.patientId,
              appt_type: 1
            }
          },
          mutations: [
            this.existingDeviceMutation
          ],
          actions: [
            {
              type: symbols.actions.executeFlowsheetAction,
              payload: {
                segmentData: {
                  number: CONSULT_ID,
                  text: 'Consult',
                  modal: null,
                  action: null,
                  canBeDeleted: true,
                  types: [],
                  className: '',
                  isDevice: false,
                  isSleepStudy: false,
                  isReason: false
                },
                flowId: this.flowId,
                patientId: this.patientId
              }
            }
          ]
        })
        done()
      })
    })
    it('has non-existent segment', function (done) {
      const segmentId = 99
      const response = { id: this.flowId }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, this.setInitialData(segmentId))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: segmentId,
              patient_id: this.patientId,
              appt_type: 1
            }
          },
          mutations: [
            this.existingDeviceMutation
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, this.setInitialData(CONSULT_ID))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: CONSULT_ID,
              patient_id: this.patientId,
              appt_type: 1
            }
          },
          mutations: [
            this.existingDeviceMutation
          ],
          actions: [
            this.testCase.getErrorHandler('addAppointmentSummary')
          ]
        })
        done()
      })
    })
  })

  describe('executeFlowsheetAction action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.flowId = 13
      this.segmentId = 2
      this.modal = null
      this.action = null
      this.setPayload = function () {
        return {
          segmentData: {
            number: this.segmentId,
            modal: this.modal,
            action: this.action
          },
          patientId: this.patientId,
          flowId: this.flowId
        }
      }
      this.summaryByPatientAction = {
        type: symbols.actions.appointmentSummariesByPatient,
        payload: this.patientId
      }
    })
    it('works without action and modal', function (done) {
      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, this.setPayload())

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            this.summaryByPatientAction
          ]
        })
        done()
      })
    })
    it('works with action', function (done) {
      this.action = symbols.actions.setExistingDevice

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, this.setPayload())

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            {
              type: symbols.actions.setExistingDevice,
              payload: {
                flowId: this.flowId,
                patientId: this.patientId
              }
            },
            this.summaryByPatientAction
          ]
        })
        done()
      })
    })
    it('works with modal', function (done) {
      this.testCase.setGetters({
        [symbols.getters.shouldPreventFlowsheetModal]: false
      })
      this.modal = symbols.modals.impressionDevice

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, this.setPayload())

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [
            {
              type: symbols.mutations.modal,
              payload: {
                name: symbols.modals.impressionDevice,
                params: {
                  flowId: this.flowId,
                  segmentId: this.segmentId,
                  patientId: this.patientId,
                  white: true
                }
              }
            }
          ],
          actions: [
            this.summaryByPatientAction
          ]
        })
        done()
      })
    })
    it('works with modal and existing device', function (done) {
      this.testCase.setGetters({
        [symbols.getters.shouldPreventFlowsheetModal]: true
      })
      this.modal = symbols.modals.impressionDevice

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, this.setPayload())

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            this.summaryByPatientAction
          ]
        })
        done()
      })
    })
  })

  describe('setExistingDevice action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.flowId = 13
      this.payload = {
        flowId: this.flowId,
        patientId: this.patientId
      }
      this.setSummaries = function (firstDeviceId, secondDeviceId) {
        this.testCase.setState({
          [symbols.state.appointmentSummaries]: [
            { deviceId: firstDeviceId },
            { deviceId: secondDeviceId }
          ]
        })
      }
    })
    it('sets device', function () {
      const firstDeviceId = 1
      const secondDeviceId = 2
      this.setSummaries(firstDeviceId, secondDeviceId)

      FlowsheetModule.actions[symbols.actions.setExistingDevice](this.testCase.mocks, this.payload)

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [
          {
            type: symbols.mutations.setExistingDevice,
            payload: firstDeviceId
          }
        ],
        actions: [
          {
            type: symbols.actions.updateAppointmentSummary,
            payload: {
              id: this.flowId,
              data: {
                device_id: firstDeviceId
              },
              patientId: this.patientId
            }
          }
        ]
      })
    })
    it('returns if device not found', function () {
      const firstDeviceId = 0
      const secondDeviceId = 0
      this.setSummaries(firstDeviceId, secondDeviceId)

      FlowsheetModule.actions[symbols.actions.setExistingDevice](this.testCase.mocks, this.payload)

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [],
        actions: []
      })
    })
  })

  describe('updateAppointmentSummary action', () => {
    beforeEach(function () {
      this.flowId = 10
      this.patientId = 11
      this.data = { foo: 'bar' }
      this.payload = {
        id: this.flowId,
        patientId: this.patientId,
        data: this.data
      }
      this.expectedHttp = {
        path: endpoints.appointmentSummaries.update + '/' + this.flowId,
        payload: this.data
      }
    })
    it('updates appointment summary', function (done) {
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, this.payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: this.patientId
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, this.payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('updateAppointmentSummary')
          ]
        })
        done()
      })
    })
  })

  describe('deleteAppointmentSummary action', () => {
    beforeEach(function () {
      this.flowId = 10
      this.expectedHttp = { path: endpoints.appointmentSummaries.destroy + '/' + this.flowId }
    })
    it('deletes appointment summary', function (done) {
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, this.flowId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.removeAppointmentSummary,
              payload: this.flowId
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, this.flowId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('deleteAppointmentSummary')
          ]
        })
        done()
      })
    })
  })

  describe('devicesByStatus action', () => {
    it('retrieves devices', function (done) {
      const response = [
        { deviceid: '1' },
        { deviceid: '2' }
      ]
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.devicesByStatus](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.devices.byStatus },
          mutations: [
            {
              type: symbols.mutations.devices,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.devicesByStatus](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.devices.byStatus },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getDevicesByStatus')
          ]
        })
        done()
      })
    })
  })

  describe('finalTrackerRank action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.expectedHttp = { path: endpoints.appointmentSummaries.finalRank + '/' + this.patientId }
      this.finalRank = 0
      this.finalSegment = 0
      this.lastSegment = 0
      this.setResponse = function () {
        return {
          final_rank: '' + this.finalRank,
          final_segment: '' + this.finalSegment,
          last_segment: '' + this.lastSegment
        }
      }
      this.getMutations = function () {
        return [
          {
            type: symbols.mutations.finalTrackerRank,
            payload: this.finalRank
          },
          {
            type: symbols.mutations.finalTrackerSegment,
            payload: this.finalSegment
          },
          {
            type: symbols.mutations.lastTrackerSegment,
            payload: this.lastSegment
          }
        ]
      }
    })
    it('sets tracker rank', function (done) {
      this.finalRank = 1
      this.finalSegment = 2
      this.lastSegment = 0
      this.testCase.stubRequest({response: this.setResponse()})

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: this.getMutations(),
          actions: []
        })
        done()
      })
    })
    it('sets tracker rank for last segment', function (done) {
      this.finalRank = 1
      this.finalSegment = 2
      this.lastSegment = 3
      this.testCase.stubRequest({response: this.setResponse()})

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: this.getMutations(),
          actions: [
            {
              type: symbols.actions.trackerStepsNext,
              payload: 3
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('finalTrackerRank')
          ]
        })
        done()
      })
    })
  })

  describe('trackerSteps action', () => {
    it('sets tracker steps', function (done) {
      const firstSection = [
        { id: '1' },
        { id: '2' }
      ]
      const secondSection = [
        { id: '3' },
        { id: '4' }
      ]
      const response = {
        first: firstSection,
        second: secondSection
      }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.trackerSteps](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.flowsheetSteps.bySection },
          mutations: [
            {
              type: symbols.mutations.clearTrackerSteps,
              payload: {}
            },
            {
              type: symbols.mutations.trackerSteps,
              payload: {
                data: firstSection,
                section: 1
              }
            },
            {
              type: symbols.mutations.trackerSteps,
              payload: {
                data: secondSection,
                section: 2
              }
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.trackerSteps](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.flowsheetSteps.bySection },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('trackerSteps')
          ]
        })
        done()
      })
    })
  })

  describe('trackerStepsNext action', () => {
    beforeEach(function () {
      this.lastSegment = 18
      this.expectedHttp = { path: endpoints.flowsheetSteps.byNextStep + '/' + this.lastSegment }
    })
    it('sets tracker steps', function (done) {
      const response = ['foo', 'bar']
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, this.lastSegment)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.trackerStepsNext,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, this.lastSegment)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('trackerStepsNext')
          ]
        })
        done()
      })
    })
  })

  describe('patientTrackerNotes action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.expectedHttp = { path: endpoints.patientSummaries.getTrackerNotes + '/' + this.patientId }
    })
    it('retrieves patient tracker notes', function (done) {
      const response = ['foo', 'bar']
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.patientTrackerNotes,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('patientTrackerNotes')
          ]
        })
        done()
      })
    })
  })

  describe('updateTrackerNotes action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.trackerNotes = 'notes'
      this.initialData = {
        patientId: this.patientId,
        trackerNotes: this.trackerNotes
      }
      this.expectedHttp = {
        path: endpoints.patientSummaries.updateTrackerNotes,
        payload: {
          patient_id: this.patientId,
          tracker_notes: this.trackerNotes
        }
      }
    })
    it('updates tracker notes', function (done) {
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, this.initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.patientTrackerNotes,
              payload: this.patientId
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, this.initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('updateTrackerNotes')
          ]
        })
        done()
      })
    })
  })

  describe('futureAppointment action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.expectedHttp = { path: endpoints.appointmentSummaries.futureAppointment + '/' + this.patientId }
      this.trackerNotesAction = {
        type: symbols.actions.patientTrackerNotes,
        payload: this.patientId
      }
    })
    it('sets future appointment without data', function (done) {
      this.testCase.stubRequest({response: null})

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.trackerNotesAction
          ]
        })
        done()
      })
    })
    it('sets future appointment with data', function (done) {
      const response = { id: '1' }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.futureAppointment,
              payload: response
            }
          ],
          actions: [
            this.trackerNotesAction
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('futureAppointment')
          ]
        })
        done()
      })
    })
  })

  describe('addFutureAppointment action', () => {
    beforeEach(function () {
      this.patientId = 42
      this.segmentId = 2
      this.initialData = {
        segmentId: this.segmentId,
        patientId: this.patientId
      }
      this.expectedHttp = {
        path: endpoints.appointmentSummaries.store,
        payload: {
          step_id: this.segmentId,
          patient_id: this.patientId,
          appt_type: 0
        }
      }
    })
    it('adds future appointment', function (done) {
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, this.initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.futureAppointment,
              payload: this.patientId
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, this.initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('addFutureAppointment')
          ]
        })
        done()
      })
    })
  })

  describe('deleteFutureAppointment action', () => {
    beforeEach(function () {
      this.appointmentId = 10
      this.expectedHttp = { path: endpoints.appointmentSummaries.destroy + '/' + this.appointmentId }
    })
    it('deletes future appointment', function (done) {
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, this.appointmentId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.futureAppointment,
              payload: INITIAL_FUTURE_APPOINTMENT
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, this.appointmentId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('deleteFutureAppointment')
          ]
        })
        done()
      })
    })
  })
})
