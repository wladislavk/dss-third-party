import QueryStringComposer from 'qs'
import symbols from '../../symbols'
import http from '../../services/http'
import endpoints from '../../endpoints'
import { INITIAL_FUTURE_APPOINTMENT } from '../../constants/chart'
import { APPOINTMENT_SUMMARY_SEGMENTS } from 'src/constants/chart'

export default {
  [symbols.actions.appointmentSummariesByPatient] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.appointmentSummaries.byPatient + '/' + patientId).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.getAppointmentSummary, data)
      dispatch(symbols.actions.lettersByPatientAndInfo, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'appointmentSummariesByPatient', response: response})
    })
  },

  [symbols.actions.lettersByPatientAndInfo] ({ rootState, state, commit, dispatch }, patientId) {
    const infoIds = []
    const summaries = state[symbols.state.appointmentSummaries]
    for (let summary of summaries) {
      if (infoIds.indexOf(summary.id) === -1) {
        infoIds.push(summary.id)
      }
    }
    const queryStringData = {
      patient_id: patientId,
      info_ids: infoIds
    }
    const queryString = QueryStringComposer.stringify(queryStringData)
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.letters.byPatientAndInfo + '?' + queryString).then((response) => {
      commit(symbols.mutations.appointmentSummaryLetters, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getLettersByPatientAndInfo', response: response})
    })
  },

  [symbols.actions.addAppointmentSummary] ({ rootState, commit, dispatch }, {segmentId, patientId}) {
    http.token = rootState.main[symbols.state.mainToken]
    const newStep = {
      step_id: segmentId,
      patient_id: patientId,
      appt_type: 1
    }
    commit(symbols.mutations.setExistingDevice, 0)
    http.post(endpoints.appointmentSummaries.store, newStep).then((response) => {
      const data = response.data.data
      let segmentData = null
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === segmentId) {
          segmentData = segment
        }
      }
      if (!segmentData) {
        return
      }
      const actionData = {
        segmentData: segmentData,
        flowId: data.id,
        patientId: patientId
      }
      dispatch(symbols.actions.executeFlowsheetAction, actionData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'addAppointmentSummary', response: response})
    })
  },

  [symbols.actions.executeFlowsheetAction] ({getters, commit, dispatch}, {segmentData, flowId, patientId}) {
    const promise = new Promise((resolve) => {
      if (!segmentData.action) {
        resolve()
        return
      }
      const actionData = {
        flowId: flowId,
        patientId: patientId
      }
      dispatch(segmentData.action, actionData).then(() => {
        resolve()
      })
    })
    promise.then(() => {
      if (segmentData.modal && !getters[symbols.getters.shouldPreventFlowsheetModal]) {
        const modalData = {
          name: segmentData.modal,
          params: {
            flowId: flowId,
            segmentId: segmentData.number,
            patientId: patientId,
            white: true
          }
        }
        commit(symbols.mutations.modal, modalData)
      }
      dispatch(symbols.actions.appointmentSummariesByPatient, patientId)
    })
  },

  [symbols.actions.setExistingDevice] ({ state, commit, dispatch }, { flowId, patientId }) {
    for (let summary of state[symbols.state.appointmentSummaries]) {
      if (summary.deviceId) {
        commit(symbols.mutations.setExistingDevice, summary.deviceId)
        const postData = {
          id: flowId,
          data: {
            device_id: summary.deviceId
          },
          patientId: patientId
        }
        dispatch(symbols.actions.updateAppointmentSummary, postData)
        return
      }
    }
  },

  [symbols.actions.updateAppointmentSummary] ({ rootState, dispatch }, { id, data, patientId }) {
    http.token = rootState.main[symbols.state.mainToken]
    return http.put(endpoints.appointmentSummaries.update + '/' + id, data).then(() => {
      dispatch(symbols.actions.appointmentSummariesByPatient, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'updateAppointmentSummary', response: response})
    })
  },

  [symbols.actions.deleteAppointmentSummary] ({ rootState, commit, dispatch }, id) {
    http.token = rootState.main[symbols.state.mainToken]
    http.delete(endpoints.appointmentSummaries.destroy + '/' + id).then(() => {
      commit(symbols.mutations.removeAppointmentSummary, id)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'deleteAppointmentSummary', response: response})
    })
  },

  [symbols.actions.devicesByStatus] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.devices.byStatus).then((response) => {
      commit(symbols.mutations.devices, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getDevicesByStatus', response: response})
    })
  },

  [symbols.actions.finalTrackerRank] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.appointmentSummaries.finalRank + '/' + patientId).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.finalTrackerRank, parseInt(data.final_rank))
      commit(symbols.mutations.finalTrackerSegment, parseInt(data.final_segment))
      const lastTrackerSegment = parseInt(data.last_segment)
      commit(symbols.mutations.lastTrackerSegment, lastTrackerSegment)
      if (lastTrackerSegment) {
        dispatch(symbols.actions.trackerStepsNext, lastTrackerSegment)
      }
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'finalTrackerRank', response: response})
    })
  },

  [symbols.actions.trackerSteps] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.flowsheetSteps.bySection).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.clearTrackerSteps)
      commit(symbols.mutations.trackerSteps, {data: data.first, section: 1})
      commit(symbols.mutations.trackerSteps, {data: data.second, section: 2})
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'trackerSteps', response: response})
    })
  },

  [symbols.actions.trackerStepsNext] ({ rootState, commit, dispatch }, lastTrackerSegment) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.flowsheetSteps.byNextStep + '/' + lastTrackerSegment).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.trackerStepsNext, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'trackerStepsNext', response: response})
    })
  },

  [symbols.actions.patientTrackerNotes] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    return http.get(endpoints.patientSummaries.getTrackerNotes + '/' + patientId).then((response) => {
      commit(symbols.mutations.patientTrackerNotes, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'patientTrackerNotes', response: response})
    })
  },

  [symbols.actions.updateTrackerNotes] ({ rootState, dispatch }, { patientId, trackerNotes }) {
    http.token = rootState.main[symbols.state.mainToken]
    const data = {
      patient_id: patientId,
      tracker_notes: trackerNotes
    }
    http.put(endpoints.patientSummaries.updateTrackerNotes, data).then(() => {
      dispatch(symbols.actions.patientTrackerNotes, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'updateTrackerNotes', response: response})
    })
  },

  [symbols.actions.futureAppointment] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    return new Promise((resolve, reject) => {
      http.get(endpoints.appointmentSummaries.futureAppointment + '/' + patientId).then((response) => {
        const data = response.data.data
        if (data) {
          commit(symbols.mutations.futureAppointment, data)
        }
        dispatch(symbols.actions.patientTrackerNotes, patientId).then(() => {
          resolve()
        })
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'futureAppointment', response: response})
        reject(response)
      })
    })
  },

  [symbols.actions.addFutureAppointment] ({rootState, dispatch}, {segmentId, patientId}) {
    http.token = rootState.main[symbols.state.mainToken]
    const newStep = {
      step_id: segmentId,
      patient_id: patientId,
      appt_type: 0
    }
    http.post(endpoints.appointmentSummaries.store, newStep).then(() => {
      dispatch(symbols.actions.futureAppointment, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'addFutureAppointment', response: response})
    })
  },

  [symbols.actions.deleteFutureAppointment] ({rootState, commit, dispatch}, appointmentId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.delete(endpoints.appointmentSummaries.destroy + '/' + appointmentId).then(() => {
      commit(symbols.mutations.futureAppointment, INITIAL_FUTURE_APPOINTMENT)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'deleteFutureAppointment', response: response})
    })
  }
}
