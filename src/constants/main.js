export const TASK_TYPES = {
  OVERDUE: 'overdue',
  TODAY: 'today',
  TOMORROW: 'tomorrow',
  THIS_WEEK: 'thisWeek',
  NEXT_WEEK: 'nextWeek',
  LATER: 'later',
  FUTURE: 'future'
}

export const NOTIFICATION_NUMBERS = {
  emailBounces: 'EMAIL_BOUNCES',
  faxAlerts: 'FAX_ALERTS',
  hst: 'HST',
  patientChanges: 'PATIENT_CHANGES',
  patientContacts: 'PATIENT_CONTACTS',
  patientInsurances: 'PATIENT_INSURANCES',
  patientNotifications: 'PATIENT_NOTIFICATIONS',
  paymentReports: 'PAYMENT_REPORTS',
  pendingClaims: 'PENDING_CLAIMS',
  pendingDuplicates: 'PENDING_DUPLICATES',
  pendingLetters: 'PENDING_LETTERS',
  pendingPreAuth: 'PENDING_PRE_AUTH',
  preAuth: 'PRE_AUTH',
  rejectedClaims: 'REJECTED_CLAIMS',
  rejectedHst: 'REJECTED_HST',
  rejectedPreAuth: 'REJECTED_PRE_AUTH',
  requestedHst: 'REQUESTED_HST',
  supportTickets: 'SUPPORT_TICKETS',
  unmailedClaims: 'UNMAILED_CLAIMS',
  unmailedLetters: 'UNMAILED_LETTERS',
  unsignedNotes: 'UNSIGNED_NOTES'
}

export const DSS_CONSTANTS = {
  DSS_USER_TYPE_FRANCHISEE: 1,
  DSS_USER_TYPE_SOFTWARE: 2,

  DSS_DEVICE_SETTING_TYPE_RANGE: 0,
  DSS_DEVICE_SETTING_TYPE_FLAG: 1,

  DSS_REFERRED_PATIENT: 1,
  DSS_REFERRED_PHYSICIAN: 2,
  DSS_REFERRED_MEDIA: 3,
  DSS_REFERRED_FRANCHISE: 4,
  DSS_REFERRED_DSSOFFICE: 5,
  DSS_REFERRED_OTHER: 6,

  // Pre-authorization statuses (pre-auth)
  DSS_PREAUTH_PENDING: 0,
  DSS_PREAUTH_COMPLETE: 1,
  DSS_PREAUTH_PREAUTH_PENDING: 2,
  DSS_PREAUTH_REJECTED: 3,

  // Pre-authorization statuses (pre-auth)
  DSS_HST_CANCELED: -1,
  DSS_HST_REQUESTED: 0,
  DSS_HST_PENDING: 1,
  DSS_HST_SCHEDULED: 2,
  DSS_HST_COMPLETE: 3,
  DSS_HST_REJECTED: 4,
  DSS_HST_CONTACTED: 5,

  // Transaction Payers (ledger)
  DSS_TRXN_PAYER_PRIMARY: 0,
  DSS_TRXN_PAYER_SECONDARY: 1,
  DSS_TRXN_PAYER_PATIENT: 2,
  DSS_TRXN_PAYER_WRITEOFF: 3,
  DSS_TRXN_PAYER_DISCOUNT: 4,

  // Transaction Payment Types (ledger)
  DSS_TRXN_PYMT_CREDIT: 0,
  DSS_TRXN_PYMT_DEBIT: 1,
  DSS_TRXN_PYMT_CHECK: 2,
  DSS_TRXN_PYMT_CASH: 3,
  DSS_TRXN_PYMT_WRITEOFF: 4,
  DSS_TRXN_PYMT_EFT: 5,

  // Transaction types (ledger)
  DSS_TRXN_TYPE_MED: 1,
  DSS_TRXN_TYPE_PATIENT: 2,
  DSS_TRXN_TYPE_INS: 3,
  DSS_TRXN_TYPE_DIAG: 4,
  DSS_TRXN_TYPE_ADJ: 6
}

export const TRANSACTION_TYPE_LABELS = {
  [DSS_CONSTANTS.DSS_TRXN_TYPE_MED]: 'Medical Code',
  [DSS_CONSTANTS.DSS_TRXN_TYPE_PATIENT]: 'Patient Payment Code',
  [DSS_CONSTANTS.DSS_TRXN_TYPE_INS]: 'Insurance Payment Code',
  [DSS_CONSTANTS.DSS_TRXN_TYPE_DIAG]: 'Dianostic Code',
  [DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ]: 'Adjustment Code'
}

export const PAYMENT_TYPE_LABELS = {
  [DSS_CONSTANTS.DSS_TRXN_PYMT_CREDIT]: 'Credit Card',
  [DSS_CONSTANTS.DSS_TRXN_PYMT_DEBIT]: 'Debit',
  [DSS_CONSTANTS.DSS_TRXN_PYMT_CHECK]: 'Check',
  [DSS_CONSTANTS.DSS_TRXN_PYMT_CASH]: 'Cash',
  [DSS_CONSTANTS.DSS_TRXN_PYMT_WRITEOFF]: 'Write Off',
  [DSS_CONSTANTS.DSS_TRXN_PYMT_EFT]: 'E-Funds Transfer (EFT)'
}

export const TRANSACTION_PAYER_LABELS = {
  [DSS_CONSTANTS.DSS_TRXN_PAYER_PRIMARY]: 'Primary Insurance',
  [DSS_CONSTANTS.DSS_TRXN_PAYER_SECONDARY]: 'Secondary Insurance',
  [DSS_CONSTANTS.DSS_TRXN_PAYER_PATIENT]: 'Patient',
  [DSS_CONSTANTS.DSS_TRXN_PAYER_WRITEOFF]: 'Write Off',
  [DSS_CONSTANTS.DSS_TRXN_PAYER_DISCOUNT]: 'Professional Discount'
}

export const PREAUTH_STATUS_LABELS = {
  [DSS_CONSTANTS.DSS_PREAUTH_PENDING]: 'Pending',
  [DSS_CONSTANTS.DSS_PREAUTH_COMPLETE]: 'Complete',
  [DSS_CONSTANTS.DSS_PREAUTH_PREAUTH_PENDING]: 'Pre-Auth Pending',
  [DSS_CONSTANTS.DSS_PREAUTH_REJECTED]: 'Rejected'
}

export const REFERRED_LABELS = [
  '',
  'Patient',
  'Physician',
  'Media',
  'Internal',
  'DSS Office',
  'Other'
]

export const STANDARD_META = {
  requiresAuth: true,
  requiresManageTemplate: true
}

export const HST_STATUSES = {
  [DSS_CONSTANTS.DSS_HST_CANCELED]: 'Cancelled',
  [DSS_CONSTANTS.DSS_HST_REQUESTED]: 'Unsent',
  [DSS_CONSTANTS.DSS_HST_PENDING]: 'Pending',
  [DSS_CONSTANTS.DSS_HST_SCHEDULED]: 'Scheduled',
  [DSS_CONSTANTS.DSS_HST_COMPLETE]: 'Complete',
  [DSS_CONSTANTS.DSS_HST_REJECTED]: 'Rejected',
  [DSS_CONSTANTS.DSS_HST_CONTACTED]: 'Contacted'
}

export const PATIENT_MENU = [
  {
    legacy: false,
    link: 'patient-tracker',
    name: 'Tracker',
    active: 'patient-tracker'
  },
  {
    link: 'manage/dss_summ.php?pid=%d&addtopat=1',
    name: 'Summary Sheet',
    active: 'manage/dss_summ.php'
  },
  {
    link: 'manage/manage_ledger.php?pid=%d&addtopat=1',
    name: 'Ledger',
    active: 'manage/manage_ledger.php'
  },
  {
    link: 'manage/manage_insurance.php?pid=%d&addtopat=1',
    name: 'Insurance',
    active: 'manage/manage_insurance.php'
  },
  {
    link: 'manage/dss_summ.php?sect=notes&pid=%d&addtopat=1',
    name: 'Progress Notes',
    active: 'manage/manage_progress_notes.php'
  },
  {
    link: 'manage/dss_summ.php?sect=letters&pid=%d&addtopat=1',
    name: 'Letters',
    active: 'manage/patient_letters.php'
  },
  {
    link: 'manage/q_image.php?pid=%d',
    name: 'Images',
    active: 'manage/q_image.php'
  },
  {
    link: 'manage/q_page1.php?pid=%d&addtopat=1',
    name: 'Questionnaire',
    activeLike: [
      'q_page',
      'q_sleep'
    ]
  },
  {
    link: 'manage/ex_page4.php?pid=%d&addtopat=1',
    name: 'Clinical Exam',
    activeLike: [
      'ex_page'
    ]
  },
  {
    link: 'manage/add_patient.php?ed=%d&addtopat=1&pid=%d',
    name: 'Patient Info',
    active: 'edit-patient'
  }
]

export const PHONE_FIELDS = [
  'phone1',
  'phone2',
  'fax'
]

export const NOT_ACCEPTED_UPDATE = 'Warning! Patient has updated their %s via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.'
