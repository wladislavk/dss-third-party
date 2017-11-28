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
  }
}
