import QueryStringComposer from 'qs'
import symbols from '../../symbols'
import http from '../../services/http'
import endpoints from '../../endpoints'
import Alerter from '../../services/Alerter'

export default {
  [symbols.actions.updateAppointmentSummary] ({ rootState, dispatch }, { id, patientId, data }) {
    http.token = rootState.main[symbols.state.mainToken]
    return http.put(endpoints.appointmentSummaries.update + '/' + id, data).then(() => {
      dispatch(symbols.actions.appointmentSummariesByPatient, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'updateAppointmentSummary', response: response})
    })
  },

  [symbols.actions.deleteAppointmentSummary] ({ rootState, dispatch }, { id, patientId }) {
    const confirmText = 'Are you sure you want to delete this appointment?'
    if (!Alerter.isConfirmed(confirmText)) {
      return
    }
    http.token = rootState.main[symbols.state.mainToken]
    http.delete(endpoints.appointmentSummaries.destroy + '/' + id).then(() => {
      dispatch(symbols.actions.appointmentSummariesByPatient, patientId)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'deleteAppointmentSummary', response: response})
    })
  },

  [symbols.actions.appointmentSummariesByPatient] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    return new Promise((resolve, reject) => {
      http.get(endpoints.appointmentSummaries.byPatient + '/' + patientId).then((response) => {
        commit(symbols.mutations.appointmentSummaries, response.data.data)
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'appointmentSummariesByPatient', response: response})
        reject(new Error())
      })
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

  [symbols.actions.insertTrackerStep] ({ commit }, responseData) {
    const newStep = {
      id: responseData.id,
      title: responseData.title,
      letterCount: responseData.letters,
      dateCompleted: responseData.datecomp
    }
    let modalData = {}
    switch (this.id) {
      case 9:
        modalData = {
          name: 'flowsheetNonCompliance',
          params: {
            flowId: responseData.id
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
        break
      case 5:
        modalData = {
          name: 'flowsheetDelayTreatment',
          params: {
            flowId: responseData.id
          }
        }
        commit(symbols.mutations.modal, modalData)
        break
      case 3:
        modalData = {
          name: 'flowsheetStudyType',
          params: {
            flowId: responseData.id,
            patientId: this.patientId
          }
        }
        commit(symbols.mutations.modal, modalData)
        break
      case 15:
        modalData = {
          name: 'flowsheetStudyType',
          params: {
            flowId: responseData.id,
            patientId: this.patientId
          }
        }
        commit(symbols.mutations.modal, modalData)
        break
      case 4:
      // fall through
      case 7:
        if (responseData.impression) {
          newStep.impression = responseData.impression
          break
        }
        modalData = {
          name: 'impressionDevice',
          params: {
            flowId: responseData.id,
            patientId: this.patientId
          }
        }
        commit(symbols.mutations.modal, modalData)
        break
      // end switch cases
    }
    commit(symbols.mutations.insertTrackerStep, newStep)
  },

  [symbols.actions.stepsByRank] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.appointmentSummaries.stepsByRank + '/' + patientId).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.stepsByRank, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getStepsByRank', response: response})
    })
  },

  [symbols.actions.getAppointmentSummary] ({ rootState, commit, dispatch }, summaryId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.appointmentSummaries.show + '/' + summaryId).then((response) => {
      const data = response.data.data
      const parsedData = {
        id: data.id,
        segmentId: data.segmentid
      }
      commit(symbols.mutations.getAppointmentSummary, parsedData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getAppointmentSummary', response: response})
    })
  }
}
