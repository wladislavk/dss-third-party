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
    let queryString = '?patient_id=' + patientId
    if (infoIds.length) {
      queryString += '&info_ids=' + infoIds.join(',')
    }
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.letters.byPatientAndInfo + queryString).then((response) => {
      commit(symbols.mutations.letters, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getLettersByPatientAndInfo', response: response})
    })
  }
}
