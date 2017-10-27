import symbols from '../../symbols'
import { NOTIFICATION_NUMBERS } from '../../constants'

export default {
  [symbols.mutations.mainToken] (state, token) {
    state[symbols.state.mainToken] = token
  },
  [symbols.mutations.popupEdit] (state, { value }) {
    state[symbols.state.popupEdit] = value
  },
  [symbols.mutations.pendingClaimsNumber] (state, number) {
    state[symbols.state.pendingClaimsNumber] = parseInt(number)
  },
  [symbols.mutations.paymentReportsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.paymentReports] = parseInt(number)
  },
  [symbols.mutations.patientContactsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientContacts] = parseInt(number)
  },
  [symbols.mutations.unmailedClaimsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.unmailedClaims] = parseInt(number)
  },
  [symbols.mutations.unmailedLettersNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.unmailedLetters] = parseInt(number)
  },
  [symbols.mutations.rejectedClaimsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.rejectedClaims] = parseInt(number)
  },
  [symbols.mutations.preauthNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.preAuth] = parseInt(number)
  },
  [symbols.mutations.pendingPreauthNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingPreAuth] = parseInt(number)
  },
  [symbols.mutations.rejectedPreauthNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.rejectedPreAuth] = parseInt(number)
  },
  [symbols.mutations.alertsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.alerts] = parseInt(number)
  },
  [symbols.mutations.supportTicketsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets] = parseInt(number)
  },
  [symbols.mutations.faxAlertsNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.faxAlerts] = parseInt(number)
  },
  [symbols.mutations.unsignedNotesNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.unsignedNotes] = parseInt(number)
  },
  [symbols.mutations.emailBouncesNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.emailBounces] = parseInt(number)
  },
  [symbols.mutations.pendingDuplicatesNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingDuplicates] = parseInt(number)
  },
  [symbols.mutations.patientChangesNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientChanges] = parseInt(number)
  },
  [symbols.mutations.hstNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.hst] = parseInt(number)
  },
  [symbols.mutations.requestedHstNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.requestedHst] = parseInt(number)
  },
  [symbols.mutations.rejectedHstNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.rejectedHst] = parseInt(number)
  },
  [symbols.mutations.patientInsurancesNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientInsurances] = parseInt(number)
  },
  [symbols.mutations.pendingLettersNumber] (state, number) {
    state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingLetters] = number
  },
  [symbols.mutations.courseStaff] ({state}, courseStaffData) {
    state[symbols.state.courseStaff] = courseStaffData
  },
  [symbols.mutations.docInfo] ({state}, docInfo) {
    state[symbols.state.docInfo] = docInfo
  },
  [symbols.mutations.userInfo] ({state}, userInfo) {
    state[symbols.state.userInfo] = userInfo
  },
  [symbols.mutations.usePaymentReports] ({state}, data) {
    state[symbols.state.usePaymentReports] = data
  }
}
