import symbols from '../../symbols'

export default {
  [symbols.getters.patientId] (state) {
    return state[symbols.state.patientId]
  },

  [symbols.getters.showWarningAboutQuestionnaireChanges] (state) {
    // @todo: eliminate magic number
    const correctStatus = 2
    const questionnaireStatuses = state[symbols.state.questionnaireStatuses]
    if (questionnaireStatuses.symptoms === correctStatus) {
      return true
    }
    if (questionnaireStatuses.treatments === correctStatus) {
      return true
    }
    if (questionnaireStatuses.history === correctStatus) {
      return true
    }
    return false
  },

  [symbols.getters.showWarningAboutBouncedEmails] (state) {
    return state[symbols.state.isEmailBounced]
  },

  [symbols.getters.showWarningAboutPatientChanges] (state) {
    if (state[symbols.state.totalSubPatients]) {
      return true
    }
    if (state[symbols.state.totalPatientContacts]) {
      return true
    }
    if (state[symbols.state.totalPatientInsurances]) {
      return true
    }
    return false
  }
}
