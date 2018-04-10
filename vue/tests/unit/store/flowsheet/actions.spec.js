import sinon from 'sinon'
import TestCase from '../../../cases/StoreTestCase'
import http from '../../../../src/services/http'
import symbols from '../../../../src/symbols'
import FlowsheetModule from '../../../../src/store/flowsheet'
import endpoints from '../../../../src/endpoints'
import { CONSULT_ID } from '../../../../src/constants/chart'

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
              action: null
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
    it('handles error', function () {

    })
  })

  describe('deleteAppointmentSummary action', () => {
  })

  describe('devicesByStatus action', () => {
  })

  describe('finalTrackerRank action', () => {
  })

  describe('trackerSteps action', () => {
  })

  describe('trackerStepsNext action', () => {
  })

  describe('patientTrackerNotes action', () => {
  })

  describe('updateTrackerNotes action', () => {
  })

  describe('futureAppointment action', () => {
  })

  describe('addFutureAppointment action', () => {
  })

  describe('deleteFutureAppointment action', () => {
  })
})
