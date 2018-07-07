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
    it('retrieves appointment summaries', function (done) {
      const patientId = 42
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

      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.byPatient + '/' + patientId },
          mutations: [
            {
              type: symbols.mutations.clearAppointmentSummary,
              payload: {}
            },
            {
              type: symbols.mutations.getAppointmentSummary,
              payload: firstItem
            },
            {
              type: symbols.mutations.getAppointmentSummary,
              payload: secondItem
            }
          ],
          actions: [
            {
              type: symbols.actions.lettersByPatientAndInfo,
              payload: patientId
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      const patientId = 42
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.byPatient + '/' + patientId },
          mutations: [
            {
              type: symbols.mutations.clearAppointmentSummary,
              payload: {}
            }
          ],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'appointmentSummariesByPatient',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('lettersByPatientAndInfo action', () => {
    it('retrieves letters', function (done) {
      const patientId = 42
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

      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        const expectedUrl = endpoints.letters.byPatientAndInfo + '?patient_id=42&info_ids%5B0%5D=10&info_ids%5B1%5D=12&info_ids%5B2%5D=11'
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
      const patientId = 42
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: []
      })
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.letters.byPatientAndInfo + '?patient_id=42' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'getLettersByPatientAndInfo',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('addAppointmentSummary action', () => {
    it('adds appointment summary', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: CONSULT_ID
      }
      const response = { id: 12 }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: CONSULT_ID,
              patient_id: 42,
              appt_type: 1
            }
          },
          mutations: [
            {
              type: symbols.mutations.setExistingDevice,
              payload: 0
            }
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
                flowId: 12,
                patientId: 42
              }
            }
          ]
        })
        done()
      })
    })
    it('has non-existent segment', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: 99
      }
      const response = { id: 12 }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: 99,
              patient_id: 42,
              appt_type: 1
            }
          },
          mutations: [
            {
              type: symbols.mutations.setExistingDevice,
              payload: 0
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: CONSULT_ID
      }
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: CONSULT_ID,
              patient_id: 42,
              appt_type: 1
            }
          },
          mutations: [
            {
              type: symbols.mutations.setExistingDevice,
              payload: 0
            }
          ],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'addAppointmentSummary',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('executeFlowsheetAction action', () => {
    it('works without action and modal', function (done) {
      const payload = {
        segmentData: {
          number: 2,
          modal: null,
          action: null
        },
        patientId: 42,
        flowId: 13
      }

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('works with action', function (done) {
      const payload = {
        segmentData: {
          number: 2,
          modal: null,
          action: symbols.actions.setExistingDevice
        },
        patientId: 42,
        flowId: 13
      }

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            {
              type: symbols.actions.setExistingDevice,
              payload: {
                flowId: 13,
                patientId: 42
              }
            },
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('works with modal', function (done) {
      this.testCase.setGetters({
        [symbols.getters.shouldPreventFlowsheetModal]: false
      })
      const payload = {
        segmentData: {
          number: 2,
          modal: symbols.modals.impressionDevice,
          action: null
        },
        patientId: 42,
        flowId: 13
      }

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [
            {
              type: symbols.mutations.modal,
              payload: {
                name: symbols.modals.impressionDevice,
                params: {
                  flowId: 13,
                  segmentId: 2,
                  patientId: 42,
                  white: true
                }
              }
            }
          ],
          actions: [
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('works with modal and existing device', function (done) {
      this.testCase.setGetters({
        [symbols.getters.shouldPreventFlowsheetModal]: true
      })
      const payload = {
        segmentData: {
          number: 2,
          modal: symbols.modals.impressionDevice,
          action: null
        },
        patientId: 42,
        flowId: 13
      }

      FlowsheetModule.actions[symbols.actions.executeFlowsheetAction](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {},
          mutations: [],
          actions: [
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: 42
            }
          ]
        })
        done()
      })
    })
  })

  describe('setExistingDevice action', () => {
    it('sets device', function () {
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: [
          {
            deviceId: 1
          },
          {
            deviceId: 2
          }
        ]
      })
      const payload = {
        flowId: 13,
        patientId: 42
      }

      FlowsheetModule.actions[symbols.actions.setExistingDevice](this.testCase.mocks, payload)

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [
          {
            type: symbols.mutations.setExistingDevice,
            payload: 1
          }
        ],
        actions: [
          {
            type: symbols.actions.updateAppointmentSummary,
            payload: {
              id: 13,
              data: {
                device_id: 1
              },
              patientId: 42
            }
          }
        ]
      })
    })
    it('returns if device not found', function () {
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: [
          {
            deviceId: 0
          },
          {
            deviceId: 0
          }
        ]
      })
      const payload = {
        flowId: 13,
        patientId: 42
      }

      FlowsheetModule.actions[symbols.actions.setExistingDevice](this.testCase.mocks, payload)

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [],
        actions: []
      })
    })
  })

  describe('updateAppointmentSummary action', () => {
    it('updates appointment summary', function (done) {
      this.testCase.stubRequest({})
      const payload = {
        id: 10,
        patientId: 11,
        data: { foo: 'bar' }
      }

      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.update + '/10',
            payload: { foo: 'bar' }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.appointmentSummariesByPatient,
              payload: 11
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      const payload = {
        id: 10,
        patientId: 11,
        data: { foo: 'bar' }
      }
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.update + '/10',
            payload: { foo: 'bar' }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'updateAppointmentSummary',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('deleteAppointmentSummary action', () => {
    it('deletes appointment summary', function (done) {
      this.testCase.stubRequest({})
      const id = 10

      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, id)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.destroy + '/10' },
          mutations: [
            {
              type: symbols.mutations.removeAppointmentSummary,
              payload: 10
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      const id = 10
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, id)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.destroy + '/10' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'deleteAppointmentSummary',
                response: new Error()
              }
            }
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
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'getDevicesByStatus',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('finalTrackerRank action', () => {
    it('sets tracker rank', function (done) {
      const patientId = 42
      const response = {
        final_rank: '1',
        final_segment: '2',
        last_segment: '0'
      }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.finalRank + '/42' },
          mutations: [
            {
              type: symbols.mutations.finalTrackerRank,
              payload: 1
            },
            {
              type: symbols.mutations.finalTrackerSegment,
              payload: 2
            },
            {
              type: symbols.mutations.lastTrackerSegment,
              payload: 0
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('sets tracker rank for last segment', function (done) {
      const patientId = 42
      const response = {
        final_rank: '1',
        final_segment: '2',
        last_segment: '3'
      }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.finalRank + '/42' },
          mutations: [
            {
              type: symbols.mutations.finalTrackerRank,
              payload: 1
            },
            {
              type: symbols.mutations.finalTrackerSegment,
              payload: 2
            },
            {
              type: symbols.mutations.lastTrackerSegment,
              payload: 3
            }
          ],
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
      const patientId = 42
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.finalRank + '/42' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'finalTrackerRank',
                response: new Error()
              }
            }
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
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'trackerSteps',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('trackerStepsNext action', () => {
    it('sets tracker steps', function (done) {
      const lastSegment = 18
      const response = ['foo', 'bar']
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, lastSegment)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.flowsheetSteps.byNextStep + '/18' },
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
      const lastSegment = 18
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, lastSegment)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.flowsheetSteps.byNextStep + '/18' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'trackerStepsNext',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('patientTrackerNotes action', () => {
    it('retrieves patient tracker notes', function (done) {
      const patientId = 42
      const response = ['foo', 'bar']
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.patientSummaries.getTrackerNotes + '/42' },
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
      const patientId = 42
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.patientSummaries.getTrackerNotes + '/42' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'patientTrackerNotes',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('updateTrackerNotes action', () => {
    it('updates tracker notes', function (done) {
      const initialData = {
        patientId: 42,
        trackerNotes: 'notes'
      }
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.patientSummaries.updateTrackerNotes,
            payload: {
              patient_id: 42,
              tracker_notes: 'notes'
            }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.patientTrackerNotes,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      const initialData = {
        patientId: 42,
        trackerNotes: 'notes'
      }
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.patientSummaries.updateTrackerNotes,
            payload: {
              patient_id: 42,
              tracker_notes: 'notes'
            }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'updateTrackerNotes',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('futureAppointment action', () => {
    it('sets future appointment without data', function (done) {
      const patientId = 42
      this.testCase.stubRequest({response: null})

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.futureAppointment + '/42' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.patientTrackerNotes,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('sets future appointment with data', function (done) {
      const patientId = 42
      const response = { id: '1' }
      this.testCase.stubRequest({response: response})

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.futureAppointment + '/42' },
          mutations: [
            {
              type: symbols.mutations.futureAppointment,
              payload: response
            }
          ],
          actions: [
            {
              type: symbols.actions.patientTrackerNotes,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      const patientId = 42
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.futureAppointment + '/42' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'futureAppointment',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('addFutureAppointment action', () => {
    it('adds future appointment', function (done) {
      const initialData = {
        segmentId: 2,
        patientId: 42
      }
      this.testCase.stubRequest({})

      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: 2,
              patient_id: 42,
              appt_type: 0
            }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.futureAppointment,
              payload: 42
            }
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      const initialData = {
        segmentId: 2,
        patientId: 42
      }
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, initialData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: 2,
              patient_id: 42,
              appt_type: 0
            }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'addFutureAppointment',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('deleteFutureAppointment action', () => {
    it('deletes future appointment', function (done) {
      this.testCase.stubRequest({})
      const id = 10

      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, id)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.destroy + '/10' },
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
      const id = 10
      this.testCase.stubErrorRequest()

      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, id)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.appointmentSummaries.destroy + '/10' },
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'deleteFutureAppointment',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })
})
