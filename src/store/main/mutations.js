import symbols from '../../symbols'
import { NOTIFICATION_NUMBERS, HST_STATUSES } from '../../constants/main'

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
  [symbols.mutations.patientSearchList] (state, data) {
    state[symbols.state.patientSearchList] = data
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
  [symbols.mutations.patientData] (state, data) {
    const insuranceType = parseInt(data.insuranceType)
    let hasMedicare = false
    if (insuranceType === 1) {
      hasMedicare = true
    }
    const premedCheck = parseInt(data.preMedCheck)
    const allergen = !!data.hasAllergen
    let title = state[symbols.state.headerTitle]
    if (premedCheck) {
      title += 'Pre-medication: ' + data.preMed + '\n'
    }
    if (allergen) {
      title += 'Allergens: ' + data.otherAllergens + '\n'
    }
    let hstStatus = ''
    const dataStatus = parseInt(data.hstStatus)
    if (HST_STATUSES.hasOwnProperty(dataStatus)) {
      hstStatus = HST_STATUSES[dataStatus]
    }
    state[symbols.mutations.allergen] = allergen
    state[symbols.state.medicare] = hasMedicare
    state[symbols.state.premedCheck] = premedCheck
    state[symbols.state.patientName] = data.firstName + ' ' + data.lastName
    state[symbols.state.displayAlert] = !!data.displayAlert
    state[symbols.state.headerTitle] = title
    state[symbols.state.headerAlertText] = data.alertText
    state[symbols.state.questionnaireStatuses] = {
      symptoms: parseInt(data.questionnaireData.symptomsStatus),
      treatments: parseInt(data.questionnaireData.treatmentsStatus),
      history: parseInt(data.questionnaireData.historyStatus)
    }
    state[symbols.state.isEmailBounced] = !!data.isEmailBounced
    state[symbols.state.totalPatientContacts] = parseInt(data.patientContactsNumber)
    state[symbols.state.totalPatientInsurances] = parseInt(data.patientInsurancesNumber)
    state[symbols.state.totalSubPatients] = parseInt(data.subPatientsNumber)
    state[symbols.state.rejectedClaimsForCurrentPatient] = data.rejectedClaims
    state[symbols.state.patientHomeSleepTestStatus] = hstStatus
    state[symbols.state.incompleteHomeSleepTests] = data.incompleteHomeSleepTests
  },
  [symbols.mutations.clearPatientData] (state) {
    state[symbols.mutations.allergen] = 0
    state[symbols.state.medicare] = 0
    state[symbols.state.premedCheck] = 0
    state[symbols.state.patientName] = ''
    state[symbols.state.displayAlert] = false
    state[symbols.state.headerTitle] = ''
    state[symbols.state.headerAlertText] = ''
    state[symbols.state.questionnaireStatuses] = {
      symptoms: 0,
      treatments: 0,
      history: 0
    }
    state[symbols.state.isEmailBounced] = false
    state[symbols.state.totalPatientContacts] = 0
    state[symbols.state.totalPatientInsurances] = 0
    state[symbols.state.totalSubPatients] = 0
    state[symbols.state.rejectedClaimsForCurrentPatient] = []
    state[symbols.state.patientHomeSleepTestStatus] = ''
    state[symbols.state.incompleteHomeSleepTests] = []
  },
  [symbols.mutations.showSearchHints] (state) {
    state[symbols.state.showSearchHints] = true
  },
  [symbols.mutations.hideSearchHints] (state) {
    state[symbols.state.showSearchHints] = false
  }
}
