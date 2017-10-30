import symbols from '../../symbols'
import { NOTIFICATION_NUMBERS } from '../../constants'

export default {
  [symbols.mutations.mainToken] (state, token) {
    state[symbols.state.mainToken] = token
  },
  [symbols.mutations.popupEdit] (state, { value }) {
    state[symbols.state.popupEdit] = value
  },
  [symbols.mutations.notificationNumbers] (state, numbers) {
    state[symbols.state.notificationNumbers] = {
      [NOTIFICATION_NUMBERS.pendingClaims]: parseInt(numbers.pending_claims),
      [NOTIFICATION_NUMBERS.paymentReports]: parseInt(numbers.payment_reports),
      [NOTIFICATION_NUMBERS.patientContacts]: parseInt(numbers.patient_contacts),
      [NOTIFICATION_NUMBERS.unmailedClaims]: parseInt(numbers.unmailed_claims),
      [NOTIFICATION_NUMBERS.unmailedLetters]: parseInt(numbers.unmailed_letters),
      [NOTIFICATION_NUMBERS.rejectedClaims]: parseInt(numbers.rejected_claims),
      [NOTIFICATION_NUMBERS.preAuth]: parseInt(numbers.completed_preauth),
      [NOTIFICATION_NUMBERS.pendingPreAuth]: parseInt(numbers.pending_preauth),
      [NOTIFICATION_NUMBERS.rejectedPreAuth]: parseInt(numbers.rejected_preauth),
      [NOTIFICATION_NUMBERS.supportTickets]: parseInt(numbers.support_tickets),
      [NOTIFICATION_NUMBERS.faxAlerts]: parseInt(numbers.fax_alerts),
      [NOTIFICATION_NUMBERS.unsignedNotes]: parseInt(numbers.unsigned_notes),
      [NOTIFICATION_NUMBERS.emailBounces]: parseInt(numbers.email_bounces),
      [NOTIFICATION_NUMBERS.pendingDuplicates]: parseInt(numbers.pending_duplicates),
      [NOTIFICATION_NUMBERS.patientChanges]: parseInt(numbers.patient_changes),
      [NOTIFICATION_NUMBERS.hst]: parseInt(numbers.completed_hst),
      [NOTIFICATION_NUMBERS.requestedHst]: parseInt(numbers.requested_hst),
      [NOTIFICATION_NUMBERS.rejectedHst]: parseInt(numbers.rejected_hst),
      [NOTIFICATION_NUMBERS.patientInsurances]: parseInt(numbers.patient_insurances),
      [NOTIFICATION_NUMBERS.pendingLetters]: parseInt(numbers.pending_letters)
    }
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
  [symbols.mutations.modal] ({state}, component) {
    state[symbols.state.modal] = component
  },
  [symbols.mutations.medicare] ({state}, data) {
    state[symbols.state.medicare] = data
  },
  [symbols.mutations.premedCheck] ({state}, data) {
    state[symbols.state.premedCheck] = parseInt(data)
  },
  [symbols.mutations.headerAlertText] ({state}, data) {
    state[symbols.state.headerAlertText] = data
  },
  [symbols.mutations.headerTitle] ({state}, data) {
    state[symbols.state.headerTitle] = data
  },
  [symbols.mutations.patientName] ({state}, {firstName, lastName}) {
    state[symbols.mutations.patientName] = firstName + ' ' + lastName
  },
  [symbols.mutations.displayAlert] ({state}, data) {
    state[symbols.state.displayAlert] = !!data
  },
  [symbols.mutations.allergen] ({state}, data) {
    state[symbols.state.allergen] = data
  },
  [symbols.mutations.patientHomeSleepTestStatus] ({state}, data) {
    state[symbols.state.patientHomeSleepTestStatus] = data
  },
  [symbols.mutations.incompleteHomeSleepTests] ({state}, data) {
    state[symbols.state.incompleteHomeSleepTests] = data
  }
}
