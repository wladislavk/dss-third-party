import symbols from '../../symbols'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../constants'

export default {
  [symbols.getters.notificationsNumber] (state) {
    const stateNumbers = state[symbols.state.notificationNumbers]
    let notificationsNumber =
      this.headerInfo.pendingLetters.length +
      stateNumbers[NOTIFICATION_NUMBERS.preAuth] +
      stateNumbers[NOTIFICATION_NUMBERS.rejectedPreAuth] +
      stateNumbers[NOTIFICATION_NUMBERS.patientContacts] +
      stateNumbers[NOTIFICATION_NUMBERS.patientInsurances] +
      stateNumbers[NOTIFICATION_NUMBERS.patientChanges] +
      stateNumbers[NOTIFICATION_NUMBERS.emailBounces] +
      stateNumbers[NOTIFICATION_NUMBERS.unsignedNotes] +
      stateNumbers[NOTIFICATION_NUMBERS.pendingDuplicates] +
      state[symbols.state.pendingClaimsNumber]
    if (state[symbols.state.userInfo].userType === DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
      notificationsNumber += stateNumbers[NOTIFICATION_NUMBERS.unmailedClaims]
    }
    return notificationsNumber
  },
  [symbols.getters.isUserDoctor] (state) {
    return (state[symbols.state.userInfo].docId === state[symbols.state.userInfo].userId)
  }
}
