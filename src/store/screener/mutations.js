import initialState from './state'
import symbols from '../../symbols'

export default {
  [symbols.mutations.restoreInitialScreener] (state) {
    const initialStateCopy = JSON.parse(JSON.stringify(initialState))
    for (let property in initialState) {
      state[property] = initialStateCopy[property]
    }
  },
  [symbols.mutations.restoreInitialScreenerKeepSession] (state) {
    const initialStateCopy = JSON.parse(JSON.stringify(initialState))
    for (let property in initialState) {
      if (property !== symbols.state.sessionData && property !== symbols.state.screenerToken) {
        state[property] = initialStateCopy[property]
      }
    }
  },
  [symbols.mutations.contactData] (state, storedContacts) {
    for (let field of state[symbols.state.contactData]) {
      if (storedContacts.hasOwnProperty(field.name)) {
        field.value = storedContacts[field.name]
      }
    }
  },
  [symbols.mutations.companyData] (state, companyData) {
    for (let company of companyData) {
      if (company.hasOwnProperty('logo') && company.logo) {
        company.logo = process.env.IMAGE_PATH + company.logo
      }
    }
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
  [symbols.mutations.setEpworthErrors] (state, errors) {
    for (let prop of state[symbols.state.epworthProps]) {
      const errorIndex = errors.indexOf(prop.epworth)
      prop.error = (errorIndex !== -1)
    }
  },
  [symbols.mutations.setEpworthProps] (state, epworthProps) {
    state[symbols.state.epworthProps] = epworthProps
  },
  [symbols.mutations.modifyEpworthProps] (state, storedProps) {
    for (let prop of state[symbols.state.epworthProps]) {
      prop.error = false
      if (storedProps.hasOwnProperty(prop.epworthid)) {
        prop.selected = storedProps[prop.epworthid]
      }
    }
  },
  [symbols.mutations.doctorName] (state, name) {
    state[symbols.state.doctorName] = name
  },
  [symbols.mutations.symptoms] (state, storedSymptoms) {
    for (let symptom of state[symbols.state.symptoms]) {
      if (storedSymptoms.hasOwnProperty(symptom.name)) {
        symptom.selected = storedSymptoms[symptom.name]
      }
    }
  },
  [symbols.mutations.coMorbidity] (state, storedConditions) {
    for (let condition of state[symbols.state.coMorbidityData]) {
      if (storedConditions.hasOwnProperty(condition.name)) {
        condition.checked = storedConditions[condition.name]
      }
    }
  },
  [symbols.mutations.cpap] (state, storedCpap) {
    state[symbols.state.cpap].selected = storedCpap
  },
  [symbols.mutations.sessionData] (state, sessionData) {
    state[symbols.state.sessionData] = sessionData
  },
  [symbols.mutations.screenerId] (state, screenerId) {
    state[symbols.state.screenerId] = screenerId
  },
  [symbols.mutations.screenerToken] (state, screenerToken) {
    state[symbols.state.screenerToken] = screenerToken
  },
  [symbols.mutations.showFancybox] (state) {
    state[symbols.state.showFancybox] = true
  },
  [symbols.mutations.hideFancybox] (state) {
    state[symbols.state.showFancybox] = false
  }
}
