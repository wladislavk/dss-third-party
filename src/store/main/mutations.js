import symbols from '../../symbols'
import { NOTIFICATION_NUMBERS } from '../../constants/main'

export default {
  [symbols.mutations.mainToken] (state, token) {
    state[symbols.state.mainToken] = token
  },
  [symbols.mutations.popupEdit] (state, { value }) {
    state[symbols.state.popupEdit] = value
  },
  [symbols.mutations.notificationNumbers] (state, numbers) {
    const patientContacts = parseInt(numbers.patient_contacts)
    const patientInsurances = parseInt(numbers.patient_insurances)
    const patientChanges = parseInt(numbers.patient_changes)
    const patientNotifications = patientContacts + patientInsurances + patientChanges
    state[symbols.state.notificationNumbers] = {
      [NOTIFICATION_NUMBERS.pendingClaims]: parseInt(numbers.pending_claims),
      [NOTIFICATION_NUMBERS.paymentReports]: parseInt(numbers.payment_reports),
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
      [NOTIFICATION_NUMBERS.hst]: parseInt(numbers.completed_hst),
      [NOTIFICATION_NUMBERS.requestedHst]: parseInt(numbers.requested_hst),
      [NOTIFICATION_NUMBERS.rejectedHst]: parseInt(numbers.rejected_hst),
      [NOTIFICATION_NUMBERS.pendingLetters]: parseInt(numbers.pending_letters),
      [NOTIFICATION_NUMBERS.patientContacts]: patientContacts,
      [NOTIFICATION_NUMBERS.patientInsurances]: patientInsurances,
      [NOTIFICATION_NUMBERS.patientChanges]: patientChanges,
      [NOTIFICATION_NUMBERS.patientNotifications]: patientNotifications
    }
  },
  [symbols.mutations.courseStaff] (state, courseStaffData) {
    state[symbols.state.courseStaff] = courseStaffData
  },
  [symbols.mutations.docInfo] (state, docInfo) {
    state[symbols.state.docInfo] = docInfo
  },
  [symbols.mutations.userInfo] (state, userInfo) {
    state[symbols.state.userInfo] = userInfo
  },
  [symbols.mutations.modal] (state, payload) {
    const componentName = payload.name
    let params = {}
    if (payload.hasOwnProperty('params')) {
      params = payload.params
    }
    state[symbols.state.modal] = {
      name: componentName,
      params: params
    }
  },
  [symbols.mutations.medicare] (state, data) {
    state[symbols.state.medicare] = data
  },
  [symbols.mutations.premedCheck] (state, data) {
    state[symbols.state.premedCheck] = parseInt(data)
  },
  [symbols.mutations.headerAlertText] (state, data) {
    state[symbols.state.headerAlertText] = data
  },
  [symbols.mutations.headerTitle] (state, data) {
    state[symbols.state.headerTitle] = data
  },
  [symbols.mutations.patientName] (state, {firstName, lastName}) {
    state[symbols.state.patientName] = firstName + ' ' + lastName
  },
  [symbols.mutations.displayAlert] (state, data) {
    state[symbols.state.displayAlert] = !!data
  },
  [symbols.mutations.allergen] (state, data) {
    state[symbols.state.allergen] = data
  },
  [symbols.mutations.patientHomeSleepTestStatus] (state, data) {
    state[symbols.state.patientHomeSleepTestStatus] = data
  },
  [symbols.mutations.incompleteHomeSleepTests] (state, data) {
    state[symbols.state.incompleteHomeSleepTests] = data
  },
  [symbols.mutations.patientId] (state, data) {
    state[symbols.state.patientId] = parseInt(data)
  },
  [symbols.mutations.showAllWarnings] (state) {
    state[symbols.state.showAllWarnings] = true
  },
  [symbols.mutations.hideAllWarnings] (state) {
    state[symbols.state.showAllWarnings] = false
  },
  [symbols.mutations.companyLogo] (state, image) {
    state[symbols.state.companyLogo] = image
  },
  [symbols.mutations.questionnaireStatuses] (state, data) {
    state[symbols.state.questionnaireStatuses] = data
  },
  [symbols.mutations.bouncedEmailsNumberForCurrentPatient] (state, number) {
    state[symbols.state.bouncedEmailsNumberForCurrentPatient] = number
  },
  [symbols.mutations.totalPatientContacts] (state, number) {
    state[symbols.state.totalPatientContacts] = number
  },
  [symbols.mutations.totalPatientInsurances] (state, number) {
    state[symbols.state.totalPatientInsurances] = number
  },
  [symbols.mutations.totalSubPatients] (state, number) {
    state[symbols.state.totalSubPatients] = number
  },
  [symbols.mutations.rejectedClaimsForCurrentPatient] (state, data) {
    state[symbols.state.rejectedClaimsForCurrentPatient] = data
  }
}
