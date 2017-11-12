import symbols from '../../symbols'
import { NOTIFICATION_NUMBERS } from '../../constants/main'

export default {
  [symbols.state.mainToken]: '',
  [symbols.state.modal]: {
    name: '',
    params: {}
  },
  [symbols.state.popupEdit]: false,
  [symbols.state.courseStaff]: {
    useCourse: 0,
    useCourseStaff: 0
  },
  [symbols.state.docInfo]: {
    homepage: '',
    manageStaff: 0,
    useEligibleApi: 0,
    useLetters: 0,
    usePatientPortal: 0
  },
  [symbols.state.userInfo]: {
    userId: 0,
    docId: 0,
    loginId: 0,
    manageStaff: 0,
    userType: 0,
    useCourse: 0,
    username: ''
  },
  [symbols.state.notificationNumbers]: {
    [NOTIFICATION_NUMBERS.alerts]: 0,
    [NOTIFICATION_NUMBERS.emailBounces]: 0,
    [NOTIFICATION_NUMBERS.faxAlerts]: 0,
    [NOTIFICATION_NUMBERS.hst]: 0,
    [NOTIFICATION_NUMBERS.patientChanges]: 0,
    [NOTIFICATION_NUMBERS.patientContacts]: 0,
    [NOTIFICATION_NUMBERS.patientInsurances]: 0,
    [NOTIFICATION_NUMBERS.patientNotifications]: 0,
    [NOTIFICATION_NUMBERS.paymentReports]: 0,
    [NOTIFICATION_NUMBERS.pendingClaims]: 0,
    [NOTIFICATION_NUMBERS.pendingDuplicates]: 0,
    [NOTIFICATION_NUMBERS.pendingLetters]: 0,
    [NOTIFICATION_NUMBERS.preAuth]: 0,
    [NOTIFICATION_NUMBERS.rejectedClaims]: 0,
    [NOTIFICATION_NUMBERS.rejectedHst]: 0,
    [NOTIFICATION_NUMBERS.rejectedPreAuth]: 0,
    [NOTIFICATION_NUMBERS.requestedHst]: 0,
    [NOTIFICATION_NUMBERS.unmailedClaims]: 0,
    [NOTIFICATION_NUMBERS.unmailedLetters]: 0,
    [NOTIFICATION_NUMBERS.unsignedNotes]: 0
  },
  [symbols.state.patientId]: 0,
  [symbols.state.patientName]: '',
  [symbols.state.patientHomeSleepTestStatus]: '',
  [symbols.state.medicare]: 0,
  [symbols.state.premedCheck]: 0,
  [symbols.state.headerTitle]: '',
  [symbols.state.headerAlertText]: '',
  [symbols.state.displayAlert]: false,
  [symbols.state.allergen]: 0,
  [symbols.state.incompleteHomeSleepTests]: [],
  [symbols.state.showAllWarnings]: true,
  [symbols.state.companyLogo]: '',
  [symbols.state.questionnaireStatuses]: {
    symptoms: 0,
    treatments: 0,
    history: 0
  },
  [symbols.state.isEmailBounced]: false,
  [symbols.state.totalPatientContacts]: 0,
  [symbols.state.totalPatientInsurances]: 0,
  [symbols.state.rejectedClaimsForCurrentPatient]: [],
  [symbols.state.showSearchHints]: false,
  [symbols.state.patientSearchList]: []
}
