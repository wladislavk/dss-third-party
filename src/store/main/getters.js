import symbols from '../../symbols'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../constants/main'

export default {
  [symbols.getters.notificationsNumber] (state) {
    const stateNumbers = state[symbols.state.notificationNumbers]
    let notificationsNumber =
      stateNumbers[NOTIFICATION_NUMBERS.pendingLetters] +
      stateNumbers[NOTIFICATION_NUMBERS.preAuth] +
      stateNumbers[NOTIFICATION_NUMBERS.rejectedPreAuth] +
      stateNumbers[NOTIFICATION_NUMBERS.patientContacts] +
      stateNumbers[NOTIFICATION_NUMBERS.patientInsurances] +
      stateNumbers[NOTIFICATION_NUMBERS.patientChanges] +
      stateNumbers[NOTIFICATION_NUMBERS.emailBounces] +
      stateNumbers[NOTIFICATION_NUMBERS.unsignedNotes] +
      stateNumbers[NOTIFICATION_NUMBERS.pendingDuplicates] +
      stateNumbers[NOTIFICATION_NUMBERS.pendingClaims]
    if (state[symbols.state.userInfo].userType === DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
      notificationsNumber += stateNumbers[NOTIFICATION_NUMBERS.unmailedClaims]
    }
    return notificationsNumber
  },

  [symbols.getters.isUserDoctor] (state) {
    return (state[symbols.state.userInfo].docId === state[symbols.state.userInfo].userId)
  },

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
