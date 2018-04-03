import QueryStringComposer from 'qs'
import symbols from '../../symbols'
import http from '../../services/http'
import endpoints from '../../endpoints'

export default {
  [symbols.actions.appointmentSummariesByPatient] ({ rootState, commit, dispatch }, patientId) {
    commit(symbols.mutations.clearAppointmentSummary)
    http.token = rootState.main[symbols.state.mainToken]
    return new Promise((resolve, reject) => {
      http.get(endpoints.appointmentSummaries.byPatient + '/' + patientId).then((response) => {
        const data = response.data.data
        for (let element of data) {
          commit(symbols.mutations.getAppointmentSummary, element)
        }
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'appointmentSummariesByPatient', response: response})
        reject(new Error())
      })
    })
  },

  [symbols.actions.getAppointmentSummary] ({ rootState, commit, dispatch }, summaryId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.appointmentSummaries.show + '/' + summaryId).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.getAppointmentSummary, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getAppointmentSummary', response: response})
    })
  },

  [symbols.actions.addAppointmentSummary] ({ rootState, commit, dispatch }, {segmentId, patientId}) {
    http.token = rootState.main[symbols.state.mainToken]
    const newStep = {
      step_id: segmentId,
      patient_id: patientId
    }
    http.post(endpoints.appointmentSummaries.store, newStep).then((response) => {
      const data = response.data.data
      let modalData = {}
      let hasPatient = false
      let modalName = ''
      switch (segmentId) {
        case 9:
          modalName = symbols.modals.flowsheetNonCompliance
          break
        case 5:
          modalName = symbols.modals.flowsheetDelayTreatment
          break
        case 3:
          // fall through
        case 15:
          hasPatient = true
          modalName = symbols.modals.flowsheetStudyType
          break
        case 4:
        // fall through
        case 7:
          hasPatient = true
          modalName = symbols.modals.impressionDevice
          break
        // end switch cases
      }
      if (modalName) {
        modalData = {
          name: modalName,
          params: {
            flowId: data.id,
            segmentId: segmentId
          }
        }
        if (hasPatient) {
          modalData.params.patientId = patientId
        }
        commit(symbols.mutations.modal, modalData)
      }
      dispatch(symbols.actions.appointmentSummariesByPatient, patientId).then(() => {
        dispatch(symbols.actions.lettersByPatientAndInfo, patientId)
      })
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'addAppointmentSummary', response: response})
    })
  },

  [symbols.actions.updateAppointmentSummary] ({ rootState, commit, dispatch }, { id, data }) {
    http.token = rootState.main[symbols.state.mainToken]
    return http.put(endpoints.appointmentSummaries.update + '/' + id, data).then(() => {
      commit(symbols.mutations.updateAppointmentSummary, {id, data})
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
      commit(symbols.mutations.letters, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getLettersByPatientAndInfo', response: response})
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

  [symbols.actions.patientTrackerNotes] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    const patientId = rootState.patients[symbols.state.patientId]
    http.get(endpoints.patientSummaries.getTrackerNotes + '/' + patientId).then((response) => {
      commit(symbols.mutations.patientTrackerNotes, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'patientTrackerNotes', response: response})
    })
  },

  [symbols.actions.futureAppointment] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    const patientId = rootState.patients[symbols.state.patientId]
    http.get(endpoints.appointmentSummaries.futureAppointment + '/' + patientId).then((response) => {
      const data = response.data.data
      if (data) {
        commit(symbols.mutations.futureAppointment, data)
      }
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'futureAppointment', response: response})
    })
  }
}
