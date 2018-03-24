import symbols from '../../symbols'

export default {
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
  [symbols.getters.calculateRisk] (state) {
    const surveyWeight = state[symbols.state.screenerWeights].survey
    const epworthWeight = state[symbols.state.screenerWeights].epworth
    const coMorbidityWeight = state[symbols.state.screenerWeights].coMorbidity
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
}
