import http from '../services/http'
import symbols from '../symbols'
import * as constants from '../constants'

const initialState = {
  [symbols.state.sessionData]: {
    screenerId: 0,
    docId: 0,
    userId: 0
  },
  [symbols.state.companyData]: {
    id: 0,
    name: '',
    logo: ''
  },
  [symbols.state.doctorName]: '',
  [symbols.state.screenerWeights]: {
    coMorbidity: 0,
    epworth: 0,
    survey: 0
  },
  [symbols.state.contactData]: constants.INITIAL_CONTACT_DATA,
  [symbols.state.epworthProps]: [],
  [symbols.state.epworthOptions]: constants.EPWORTH_OPTIONS,
  [symbols.state.symptoms]: constants.INITIAL_SYMPTOMS,
  [symbols.state.coMorbidityData]: constants.INITIAL_CO_MORBIDITY,
  [symbols.state.cpap]: {
    name: 'rx_cpap',
    label: 'Have you ever used CPAP before?',
    weight: 4,
    selected: false
  }
}

export default {
  state: JSON.parse(JSON.stringify(initialState)),
  getters: {
    [symbols.getters.fullName] (state) {
      const contactData = state[symbols.state.contactData]
      let firstName = ''
      let lastName = ''
      for (let nameField of contactData) {
        if (nameField.camelName === 'firstName') {
          firstName = nameField.value
        }
        if (nameField.camelName === 'lastName') {
          lastName = nameField.value
        }
      }
      return firstName + ' ' + lastName
    },
    [symbols.getters.fullContactData] (state) {
      const contactData = state[symbols.state.contactData]
      const contactProperties = state.screener[symbols.state.contactProperties]
      for (let contactElement of contactData) {
        if (contactProperties.hasOwnProperty(contactElement.camelName)) {
          contactData.value = contactProperties[contactElement.camelName]
        }
      }
      return contactData
    },
    [symbols.getters.submitScreenerFailure] (state) {
      return state[symbols.state.submitScreenerFailure]
    },
    [symbols.getters.calculateRisk] (state) {
      const surveyWeight = state[symbols.state.screenerWeights].surveyWeight
      const epworthWeight = state[symbols.state.screenerWeights].epworthWeight
      const coMorbidityWeight = state[symbols.state.screenerWeights].coMorbidityWeight
      if (surveyWeight > 15 || epworthWeight > 18 || coMorbidityWeight > 3) {
        return 'severe'
      }
      if (surveyWeight > 11 || epworthWeight > 14 || coMorbidityWeight > 2) {
        return 'high'
      }
      if (surveyWeight > 7 || epworthWeight > 9 || coMorbidityWeight > 1) {
        return 'moderate'
      }
      return 'low'
    }
  },
  mutations: {
    [symbols.mutations.restoreInitialScreener] (state) {
      const initialStateCopy = JSON.parse(JSON.stringify(initialState))
      for (let property in initialState) {
        state[property] = initialStateCopy[property]
      }
    },
    [symbols.mutations.contactData] (state, contactData) {
      state[symbols.state.contactData] = contactData
    },
    [symbols.mutations.companyData] (state, companyData) {
      state[symbols.state.companyData] = companyData
    },
    [symbols.mutations.coMorbidityWeight] (state, weight) {
      state[symbols.state.screenerWeights].coMorbidity = weight
    },
    [symbols.mutations.epworthWeight] (state, weight) {
      state[symbols.state.screenerWeights].epworth = weight
    },
    [symbols.mutations.surveyWeight] (state, weight) {
      state[symbols.state.screenerWeights].survey = weight
    },
    [symbols.mutations.setEpworthProps] (state, epworthProps) {
      state[symbols.state.epworthProps] = epworthProps
    },
    [symbols.mutations.doctorName] (state, name) {
      state[symbols.state.doctorName] = name
    },
    [symbols.mutations.symptoms] (state, symptoms) {
      state[symbols.state.symptoms] = symptoms
    },
    [symbols.mutations.coMorbidity] (state, coMorbidity) {
      state[symbols.state.coMorbidityData] = coMorbidity
    },
    [symbols.mutations.cpap] (state, cpap) {
      state[symbols.state.cpap] = cpap
    }
  },
  actions: {
    [symbols.actions.getDoctorData] ({ commit }) {
      // @todo: add ajax request
      const doctorName = ''
      commit(symbols.mutations.doctorName, doctorName)
    },
    [symbols.actions.getCompanyData] ({ commit }) {
      // @todo: add ajax request
      const companyData = {}
      commit(symbols.mutations.companyData, companyData)
    },
    [symbols.actions.submitScreener] ({ state }) {
      const contactProperties = state[symbols.state.contactProperties]
      const symptoms = state[symbols.state.symptoms]
      const coMorbidityData = state[symbols.state.coMorbidityData]
      const cpap = state[symbols.state.cpap]
      const epworthProps = state[symbols.state.epworthProps]
      const sessionData = state[symbols.state.sessionData]

      const screenerData = {
        docid: sessionData.docId,
        userid: sessionData.userId,
        first_name: contactProperties.firstName,
        last_name: contactProperties.lastName,
        phone: contactProperties.phone,
        cpap: cpap.selected
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

      return http.request('post', 'script/submit_screener.php', screenerData)
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
        if (coMorbidity.name.checked) {
          coMorbidityWeight += coMorbidity.weight
        }
      }

      const cpap = state[symbols.state.cpap]
      if (cpap.checked) {
        coMorbidityWeight += cpap.weight
      }
      commit(symbols.mutations.coMorbidityWeight, coMorbidityWeight)

      const symptoms = this.$store.state[symbols.state.symptoms]
      let surveyWeight = 0
      for (let symptom of symptoms) {
        if (symptom.selected) {
          surveyWeight += parseInt(symptom.selected, 10)
        }
      }
      commit(symbols.mutations.surveyWeight, surveyWeight)

      this.$router.push({ name: 'screener-results' })
    },
    [symbols.actions.setEpworthProps] ({ commit }) {
      http.get('epworth-sleepiness-scale/sorted-with-status').then(
        (response) => {
          const data = response.data.data
          for (let element of data) {
            element.error = false
            element.selected = ''
          }
          commit(symbols.mutations.setEpworthProps, data)
        }
      )
    },
    [symbols.actions.submitHst] ({ state }, { hstCompany }) {
      const sessionData = state[symbols.state.sessionData]

      function getContactValue (propertyName) {
        for (let element of this.contactData) {
          if (element.camelName === propertyName) {
            return element.value
          }
        }
        return null
      }

      const ajaxData = {
        screenerid: sessionData.screenerId,
        docid: sessionData.docId,
        userid: sessionData.userId,
        companyid: hstCompany,
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

      return http.request('post', 'script/submit_hst.php', ajaxData)
    }
  }
}
