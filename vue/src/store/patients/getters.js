import symbols from '../../symbols'
import { HST_STATUSES } from '../../constants/main'

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
  },

  [symbols.getters.hstStatus] (state) {
    const incompleteHSTs = state[symbols.state.incompleteHomeSleepTests]
    if (!incompleteHSTs.length) {
      return ''
    }
    const lastHST = incompleteHSTs[incompleteHSTs.length - 1]
    if (!HST_STATUSES.hasOwnProperty(lastHST)) {
      return ''
    }
    return HST_STATUSES[lastHST]
  }
}
