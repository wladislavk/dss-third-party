import sinon from 'sinon'
import TestCase from '../../../cases/StoreTestCase'
import http from '../../../../src/services/http'
import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'
import endpoints from '../../../../src/endpoints'
import { CONSULT_ID } from '../../../../src/constants/chart'
import { INITIAL_FUTURE_APPOINTMENT } from 'src/constants/chart'

describe('Flowsheet module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('appointmentSummariesByPatient action', () => {
    it('retrieves appointment summaries', function (done) {
      const patientId = 42
      const postData = []
      const result = {
        data: {
          data: [
            {
              id: 1,
              name: 'foo'
            },
            {
              id: 2,
              name: 'bar'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, patientId)

      const expectedMutations = [
        {
          type: symbols.mutations.clearAppointmentSummary,
          payload: {}
        },
        {
          type: symbols.mutations.getAppointmentSummary,
          payload: {
            id: 1,
            name: 'foo'
          }
        },
        {
          type: symbols.mutations.getAppointmentSummary,
          payload: {
            id: 2,
            name: 'bar'
          }
        }
      ]
      const expectedActions = [
        {
          type: symbols.actions.lettersByPatientAndInfo,
          payload: patientId
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          { path: endpoints.appointmentSummaries.byPatient + '/' + patientId }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const patientId = 42
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.appointmentSummariesByPatient](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'appointmentSummariesByPatient',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('lettersByPatientAndInfo action', () => {
    it('retrieves letters', function (done) {
      const patientId = 42
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: [
          {
            id: 10
          },
          {
            id: 12
          },
          {
            id: 12
          },
          {
            id: 11
          }
        ]
      })
      const postData = []
      const result = {
        data: {
          data: ['foo', 'bar']
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, patientId)

      const expectedMutations = [
        {
          type: symbols.mutations.appointmentSummaryLetters,
          payload: ['foo', 'bar']
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedUrl = endpoints.letters.byPatientAndInfo + '?patient_id=42&info_ids%5B0%5D=10&info_ids%5B1%5D=12&info_ids%5B2%5D=11'
        const expectedHttp = [
          { path: expectedUrl }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const patientId = 42
      this.testCase.setState({
        [symbols.state.appointmentSummaries]: []
      })
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.lettersByPatientAndInfo](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getLettersByPatientAndInfo',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('addAppointmentSummary action', () => {
    it('adds appointment summary', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: CONSULT_ID
      }
      const postData = []
      const result = {
        data: {
          data: { id: 12 }
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)
      const expectedMutations = [
        {
          type: symbols.mutations.setExistingDevice,
          payload: 0
        }
      ]
      const expectedActions = [
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
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: CONSULT_ID,
              patient_id: 42,
              appt_type: 1
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('has non-existent segment', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: 99
      }
      const result = {
        data: {
          data: { id: 12 }
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)
      const expectedMutations = [
        {
          type: symbols.mutations.setExistingDevice,
          payload: 0
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual([])
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const initialData = {
        patientId: 42,
        segmentId: CONSULT_ID
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.addAppointmentSummary](this.testCase.mocks, initialData)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'addAppointmentSummary',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
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
      const expectedMutations = []
      const expectedActions = [
        {
          type: symbols.actions.appointmentSummariesByPatient,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
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
      const expectedMutations = []
      const expectedActions = [
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
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
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
      const expectedMutations = [
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
      ]
      const expectedActions = [
        {
          type: symbols.actions.appointmentSummariesByPatient,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
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
      const expectedMutations = []
      const expectedActions = [
        {
          type: symbols.actions.appointmentSummariesByPatient,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
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
      const expectedMutations = [
        {
          type: symbols.mutations.setExistingDevice,
          payload: 1
        }
      ]
      const expectedActions = [
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
      expect(this.testCase.mutations).toEqual(expectedMutations)
      expect(this.testCase.actions).toEqual(expectedActions)
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
      expect(this.testCase.mutations).toEqual([])
      expect(this.testCase.actions).toEqual([])
    })
  })

  describe('updateAppointmentSummary action', () => {
    it('updates appointment summary', function (done) {
      const postData = []
      this.sandbox.stub(http, 'put').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve()
      })
      const payload = {
        id: 10,
        patientId: 11,
        data: { foo: 'bar' }
      }
      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, payload)
      const expectedActions = [
        {
          type: symbols.actions.appointmentSummariesByPatient,
          payload: 11
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.update + '/10',
            payload: { foo: 'bar' }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const payload = {
        id: 10,
        patientId: 11,
        data: { foo: 'bar' }
      }
      this.sandbox.stub(http, 'put').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.updateAppointmentSummary](this.testCase.mocks, payload)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'updateAppointmentSummary',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('deleteAppointmentSummary action', () => {
    it('deletes appointment summary', function (done) {
      const postData = []
      this.sandbox.stub(http, 'delete').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve()
      })
      const id = 10
      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, id)
      const expectedMutations = [
        {
          type: symbols.mutations.removeAppointmentSummary,
          payload: 10
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.destroy + '/10'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const id = 10
      this.sandbox.stub(http, 'delete').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.deleteAppointmentSummary](this.testCase.mocks, id)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'deleteAppointmentSummary',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('devicesByStatus action', () => {
    it('retrieves devices', function (done) {
      const postData = []
      const result = {
        data: {
          data: [
            { deviceid: '1' },
            { deviceid: '2' }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.devicesByStatus](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.devices,
          payload: [
            { deviceid: '1' },
            { deviceid: '2' }
          ]
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.devices.byStatus
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.devicesByStatus](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getDevicesByStatus',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('finalTrackerRank action', () => {
    it('sets tracker rank', function (done) {
      const patientId = 42
      const postData = []
      const result = {
        data: {
          data: {
            final_rank: '1',
            final_segment: '2',
            last_segment: '0'
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)
      const expectedMutations = [
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
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual([])
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.finalRank + '/42'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('sets tracker rank for last segment', function (done) {
      const patientId = 42
      const result = {
        data: {
          data: {
            final_rank: '1',
            final_segment: '2',
            last_segment: '3'
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.trackerStepsNext,
          payload: 3
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const patientId = 42
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.finalTrackerRank](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'finalTrackerRank',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('trackerSteps action', () => {
    it('sets tracker steps', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            first: [
              { id: '1' },
              { id: '2' }
            ],
            second: [
              { id: '3' },
              { id: '4' }
            ]
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.trackerSteps](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.clearTrackerSteps,
          payload: {}
        },
        {
          type: symbols.mutations.trackerSteps,
          payload: {
            data: [
              { id: '1' },
              { id: '2' }
            ],
            section: 1
          }
        },
        {
          type: symbols.mutations.trackerSteps,
          payload: {
            data: [
              { id: '3' },
              { id: '4' }
            ],
            section: 2
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.flowsheetSteps.bySection
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.trackerSteps](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'trackerSteps',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('trackerStepsNext action', () => {
    it('sets tracker steps', function (done) {
      const lastSegment = 18
      const postData = []
      const result = {
        data: {
          data: ['foo', 'bar']
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, lastSegment)
      const expectedMutations = [
        {
          type: symbols.mutations.trackerStepsNext,
          payload: ['foo', 'bar']
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.flowsheetSteps.byNextStep + '/18'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const lastSegment = 18
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.trackerStepsNext](this.testCase.mocks, lastSegment)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'trackerStepsNext',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('patientTrackerNotes action', () => {
    it('retrieves patient tracker notes', function (done) {
      const patientId = 42
      const postData = []
      const result = {
        data: {
          data: ['foo', 'bar']
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, patientId)
      const expectedMutations = [
        {
          type: symbols.mutations.patientTrackerNotes,
          payload: ['foo', 'bar']
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.patientSummaries.getTrackerNotes + '/42'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const patientId = 42
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.patientTrackerNotes](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'patientTrackerNotes',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('updateTrackerNotes action', () => {
    it('updates tracker notes', function (done) {
      const initialData = {
        patientId: 42,
        trackerNotes: 'notes'
      }
      const postData = []
      this.sandbox.stub(http, 'put').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve()
      })
      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, initialData)
      const expectedActions = [
        {
          type: symbols.actions.patientTrackerNotes,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          {
            path: endpoints.patientSummaries.updateTrackerNotes,
            payload: {
              patient_id: 42,
              tracker_notes: 'notes'
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const initialData = {
        patientId: 42,
        trackerNotes: 'notes'
      }
      this.sandbox.stub(http, 'put').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.updateTrackerNotes](this.testCase.mocks, initialData)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'updateTrackerNotes',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('futureAppointment action', () => {
    it('sets future appointment without data', function (done) {
      const patientId = 42
      const postData = []
      const result = {
        data: {
          data: null
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)
      const expectedMutations = []
      const expectedActions = [
        {
          type: symbols.actions.patientTrackerNotes,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.futureAppointment + '/42'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('sets future appointment with data', function (done) {
      const patientId = 42
      const result = {
        data: {
          data: {
            id: '1'
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.resolve(result)
      })
      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)
      const expectedMutations = [
        {
          type: symbols.mutations.futureAppointment,
          payload: { id: '1' }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const patientId = 42
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.futureAppointment](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'futureAppointment',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('addFutureAppointment action', () => {
    it('adds future appointment', function (done) {
      const initialData = {
        segmentId: 2,
        patientId: 42
      }
      const postData = []
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve()
      })
      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, initialData)
      const expectedActions = [
        {
          type: symbols.actions.futureAppointment,
          payload: 42
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.store,
            payload: {
              step_id: 2,
              patient_id: 42,
              appt_type: 0
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const initialData = {
        segmentId: 2,
        patientId: 42
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.addFutureAppointment](this.testCase.mocks, initialData)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'addFutureAppointment',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('deleteFutureAppointment action', () => {
    it('deletes future appointment', function (done) {
      const postData = []
      this.sandbox.stub(http, 'delete').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve()
      })
      const id = 10
      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, id)
      const expectedMutations = [
        {
          type: symbols.mutations.futureAppointment,
          payload: INITIAL_FUTURE_APPOINTMENT
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.appointmentSummaries.destroy + '/10'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const id = 10
      this.sandbox.stub(http, 'delete').callsFake(() => {
        return Promise.reject(new Error())
      })
      FlowsheetModule.actions[symbols.actions.deleteFutureAppointment](this.testCase.mocks, id)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'deleteFutureAppointment',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })
})
