import axios from 'axios'
import http from '../../services/http'
import symbols from '../../symbols'
import endpoints from '../../endpoints'
import ProcessWrapper from '../../wrappers/ProcessWrapper'

export default {
  [symbols.actions.getDoctorData] ({ state, commit }) {
    http.token = state[symbols.state.screenerToken]
    const doctorId = state[symbols.state.sessionData].docId
    http.get(endpoints.users.show + '/' + doctorId).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.doctorName, data.first_name)
    })
  },

  [symbols.actions.submitScreener] ({ state }) {
    const contactData = state[symbols.state.contactData]
    const symptoms = state[symbols.state.symptoms]
    const coMorbidityData = state[symbols.state.coMorbidityData]
    const cpap = state[symbols.state.cpap]
    const sessionData = state[symbols.state.sessionData]
    const epworthProps = state[symbols.state.epworthProps]

    const screenerData = {
      docid: sessionData.docId,
      userid: sessionData.userId,
      rx_cpap: cpap.selected,
      epworth: []
    }

    for (let contactProperty of contactData) {
      switch (contactProperty.camelName) {
        case 'firstName':
          screenerData.first_name = contactProperty.value
          break
        case 'lastName':
          screenerData.last_name = contactProperty.value
          break
        case 'phone':
          screenerData.phone = contactProperty.value
          break
      }
    }

    for (let epworth of epworthProps) {
      screenerData.epworth.push(epworth)
    }

    for (let symptom of symptoms) {
      screenerData[symptom.name] = symptom.selected
    }

    for (let coMorbidity of coMorbidityData) {
      screenerData[coMorbidity.name] = 0
      if (coMorbidity.checked) {
        screenerData[coMorbidity.name] = coMorbidity.weight
      }
    }

    http.token = state[symbols.state.screenerToken]
    return http.request('post', endpoints.screeners.store, screenerData)
  },

  [symbols.actions.parseScreenerResults] ({ state, commit }, { id }) {
    commit(symbols.mutations.screenerId, id)

    let epworthWeight = 0
    for (let epworth of state[symbols.state.epworthProps]) {
      epworthWeight += parseInt(epworth.selected)
    }
    commit(symbols.mutations.epworthWeight, epworthWeight)

    const coMorbidityData = state[symbols.state.coMorbidityData]

    let coMorbidityWeight = 0
    for (let coMorbidity of coMorbidityData) {
      if (coMorbidity.checked) {
        coMorbidityWeight += parseInt(coMorbidity.weight)
      }
    }

    const cpap = state[symbols.state.cpap]
    if (cpap.selected) {
      coMorbidityWeight += parseInt(cpap.weight)
    }
    commit(symbols.mutations.coMorbidityWeight, coMorbidityWeight)

    const symptoms = state[symbols.state.symptoms]
    let surveyWeight = 0
    for (let symptom of symptoms) {
      if (symptom.selected) {
        surveyWeight += parseInt(symptom.selected)
      }
    }
    commit(symbols.mutations.surveyWeight, surveyWeight)
  },

  [symbols.actions.setEpworthProps] ({ state, commit }) {
    http.token = state[symbols.state.screenerToken]
    http.get(endpoints.epworthSleepinessScale.index + '?status=1&order=sortby').then((response) => {
      const data = response.data.data
      for (let element of data) {
        element.selected = ''
        element.error = false
      }
      commit(symbols.mutations.setEpworthProps, data)
    })
  },

  [symbols.actions.submitHst] ({ state }, { companyId, contactData }) {
    http.token = state[symbols.state.screenerToken]
    const sessionData = state[symbols.state.sessionData]
    const screenerId = state[symbols.state.screenerId]

    function getContactValue (propertyName) {
      for (let element of contactData) {
        if (element.camelName === propertyName) {
          return element.value
        }
      }
      return ''
    }

    const ajaxData = {
      screener_id: screenerId,
      doc_id: sessionData.docId,
      user_id: sessionData.userId,
      company_id: companyId,
      patient_firstname: getContactValue('firstName'),
      patient_lastname: getContactValue('lastName'),
      patient_cell_phone: getContactValue('phone'),
      patient_email: getContactValue('email'),
      patient_dob: getContactValue('dob')
    }

    return http.request('post', endpoints.homeSleepTests.store, ajaxData)
  },

  [symbols.actions.authenticateScreener] ({ commit, dispatch }, payload) {
    return new Promise((resolve, reject) => {
      axios.post(ProcessWrapper.getApiRoot() + 'auth', payload).then((response) => {
        const data = response.data
        if (!data.hasOwnProperty('token') || !data.token) {
          throw new Error('No token retrieved')
        }
        commit(symbols.mutations.screenerToken, data.token)
        dispatch(symbols.actions.setSessionData)
        resolve()
      }).catch((reason) => {
        let newReason = 'Authentication failed'
        if (reason instanceof Error && reason.message) {
          newReason = reason.message
        }
        reject(new Error(newReason))
      })
    })
  },

  [symbols.actions.setSessionData] ({ state, commit }) {
    http.token = state[symbols.state.screenerToken]
    return http.request('get', endpoints.users.current).then((response) => {
      const data = response.data.data
      const sessionData = {
        userId: data.userid,
        docId: data.docid
      }
      commit(symbols.mutations.sessionData, sessionData)
    }).catch(() => {
      throw new Error('No user ID retrieved')
    })
  }
}
