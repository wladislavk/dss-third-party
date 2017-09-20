import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.getDoctorData] ({ commit }) {
    // @todo: add ajax request
    const doctorName = 'Jane'
    commit(symbols.mutations.doctorName, doctorName)
  },
  [symbols.actions.getCompanyData] ({ commit }) {
    // @todo: add ajax request
    const companyData = []
    commit(symbols.mutations.companyData, companyData)
  },
  [symbols.actions.submitScreener] ({ state }) {
    const contactData = state[symbols.state.contactData]
    const symptoms = state[symbols.state.symptoms]
    const coMorbidityData = state[symbols.state.coMorbidityData]
    const cpap = state[symbols.state.cpap]
    const epworthProps = state[symbols.state.epworthProps]
    const sessionData = state[symbols.state.sessionData]

    const screenerData = {
      docid: sessionData.docId,
      userid: sessionData.userId,
      cpap: cpap.selected
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

    let epworthPropertyName = ''
    for (let epworth of epworthProps) {
      epworthPropertyName = 'epworth_' + epworth.id
      screenerData[epworthPropertyName] = epworth.selected
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

    return http.request('post', 'script/submit_screener.php', { data: screenerData })
  },

  [symbols.actions.parseScreenerResults] ({ state, commit }) {
    let epworthWeight = 0
    for (let epworth of state[symbols.state.epworthProps]) {
      epworthWeight += epworth.selected
    }
    commit(symbols.mutations.epworthWeight, epworthWeight)

    const coMorbidityData = state[symbols.state.coMorbidityData]

    let coMorbidityWeight = 0
    for (let coMorbidity of coMorbidityData) {
      if (coMorbidity.checked) {
        coMorbidityWeight += coMorbidity.weight
      }
    }

    const cpap = state[symbols.state.cpap]
    if (cpap.selected) {
      coMorbidityWeight += cpap.weight
    }
    commit(symbols.mutations.coMorbidityWeight, coMorbidityWeight)

    const symptoms = state[symbols.state.symptoms]
    let surveyWeight = 0
    for (let symptom of symptoms) {
      if (symptom.selected) {
        surveyWeight += parseInt(symptom.selected, 10)
      }
    }
    commit(symbols.mutations.surveyWeight, surveyWeight)
  },
  [symbols.actions.setEpworthProps] ({ commit }) {
    http.get('epworth-sleepiness-scale/sorted-with-status').then(
      (response) => {
        const data = response.data.data
        for (let element of data) {
          element.selected = ''
          element.error = false
        }
        commit(symbols.mutations.setEpworthProps, data)
      }
    )
  },
  [symbols.actions.submitHst] ({ state }, { companyId, contactData }) {
    const sessionData = state[symbols.state.sessionData]

    function getContactValue (propertyName) {
      for (let element of contactData) {
        if (element.camelName === propertyName) {
          return element.value
        }
      }
      return ''
    }

    const ajaxData = {
      screenerid: sessionData.screenerId,
      docid: sessionData.docId,
      userid: sessionData.userId,
      companyid: companyId,
      patient_first_name: getContactValue('firstName'),
      patient_last_name: getContactValue('lastName'),
      patient_cell_phone: getContactValue('phone'),
      patient_email: getContactValue('email'),
      patient_dob: getContactValue('dob')
    }

    for (let epworth of state[symbols.state.epworthProps]) {
      let ajaxProperty = 'epworth_' + epworth.id
      ajaxData[ajaxProperty] = epworth.value
    }

    return http.request('post', 'submit-hst', ajaxData)
  }
}
