import symbols from './symbols'

export const INITIAL_CONTACT_DATA = [
  {
    name: 'first_name',
    camelName: 'firstName',
    label: 'First Name',
    resultLabel: 'First name',
    mask: '',
    firstPage: true,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'last_name',
    camelName: 'lastName',
    label: 'Last Name',
    resultLabel: 'Last name',
    mask: '',
    firstPage: true,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'dob',
    camelName: 'dob',
    label: 'Date of Birth',
    resultLabel: '',
    mask: '99/99/9999',
    firstPage: false,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'phone',
    camelName: 'phone',
    label: 'Phone Number',
    resultLabel: 'Phone',
    mask: '(999) 999-9999',
    firstPage: true,
    hstColumn: 'right',
    value: ''
  },
  {
    name: 'email',
    camelName: 'email',
    label: 'Email',
    resultLabel: '',
    mask: '',
    firstPage: false,
    hstColumn: 'right',
    value: ''
  }
]

export const EPWORTH_OPTIONS = [
  {
    option: '0',
    label: 'No chance of dozing'
  },
  {
    option: '1',
    label: 'Slight chance of dozing'
  },
  {
    option: '2',
    label: 'Moderate chance of dozing'
  },
  {
    option: '3',
    label: 'High chance of dozing'
  }
]

export const INITIAL_SYMPTOMS = [
  {
    name: 'breathing',
    label: 'Have you ever been told you stop breathing while asleep?',
    weight: 8,
    selected: false
  },
  {
    name: 'driving',
    label: 'Have you ever fallen asleep or nodded off while driving?',
    weight: 6,
    selected: false
  },
  {
    name: 'gasping',
    label: 'Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?',
    weight: 6,
    selected: false
  },
  {
    name: 'sleepy',
    label: 'Do you feel excessively sleepy during the day?',
    weight: 4,
    selected: false
  },
  {
    name: 'snore',
    label: 'Do you snore or have you ever been told that you snore?',
    weight: 4,
    selected: false
  },
  {
    name: 'weight_gain',
    label: 'Have you had weight gain and found it difficult to lose?',
    weight: 2,
    selected: false
  },
  {
    name: 'blood_pressure',
    label: 'Have you taken medication for, or been diagnosed with high blood pressure?',
    weight: 2,
    selected: false
  },
  {
    name: 'jerk',
    label: 'Do you kick or jerk your legs while sleeping?',
    weight: 3,
    selected: false
  },
  {
    name: 'burning',
    label: 'Do you feel burning, tingling or crawling sensations in your legs when you wake up?',
    weight: 3,
    selected: false
  },
  {
    name: 'headaches',
    label: 'Do you wake up with headaches during the night or in the morning?',
    weight: 3,
    selected: false
  },
  {
    name: 'falling_asleep',
    label: 'Do you have trouble falling asleep?',
    weight: 4,
    selected: false
  },
  {
    name: 'staying_asleep',
    label: 'Do you have trouble staying asleep once you fall asleep?',
    weight: 4,
    selected: false
  }
]

export const INITIAL_CO_MORBIDITY = [
  {
    name: 'rx_heart_disease',
    label: 'Heart Failure',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_stroke',
    label: 'Stroke',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_hypertension',
    label: 'Hypertension',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_diabetes',
    label: 'Diabetes',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_metabolic_syndrome',
    label: 'Metabolic Syndrome',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_obesity',
    label: 'Obesity',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_heartburn',
    label: 'Heartburn (Gastroesophageal Reflux)',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_afib',
    label: 'Atrial Fibrillation',
    weight: 2,
    checked: false
  }
]

export const TASK_TYPES = {
  OVERDUE: 'overdue',
  TODAY: 'today',
  TOMORROW: 'tomorrow',
  THIS_WEEK: 'thisWeek',
  NEXT_WEEK: 'nextWeek',
  LATER: 'later',
  FUTURE: 'future'
}

export const LEGACY_URL = 'http://legacy/'

export const NAVIGATION_MENU = [
  {
    name: 'Directory',
    children: [
      {
        name: 'Contacts',
        link: 'manage/manage_contact.php'
      },
      {
        name: 'Referral List',
        link: 'manage/manage_referredby.php'
      },
      {
        name: 'Sleep Labs',
        link: 'manage/manage_sleeplab.php'
      },
      {
        name: 'Corporate Contacts',
        link: 'manage/manage_fcontact.php'
      }
    ]
  },
  {
    name: 'Reports',
    children: [
      {
        name: 'Ledger',
        link: 'manage/ledger_reportfull.php'
      },
      {
        name: 'Claims',
        link: 'manage/manage_claims.php',
        populator: symbols.populators.populateClaims
      },
      {
        name: 'Performance',
        link: 'manage/performance.php'
      },
      {
        name: 'Pt. Screener',
        link: 'manage/manage_screeners.php?contacted=0'
      },
      {
        name: 'VOB History',
        link: 'manage/manage_vobs.php'
      },
      {
        name: 'Invoices',
        link: 'manage/invoice_history.php',
        shouldParse: symbols.getters.shouldShowInvoices
      },
      {
        name: 'Fax History',
        link: 'manage/manage_faxes.php'
      },
      {
        name: 'Home Sleep Tests',
        link: 'manage/manage_hst.php'
      }
    ]
  },
  {
    name: 'Admin',
    children: [
      {
        name: 'Claim Setup',
        link: 'manage/manage_claim_setup.php'
      },
      {
        name: 'Profile',
        link: 'manage/manage_profile.php'
      },
      {
        name: 'Text',
        children: [
          {
            name: 'Custom Text',
            link: 'manage/manage_custom.php'
          },
          {
            name: 'Custom Letters',
            link: 'manage/manage_custom_letters.php'
          }
        ]
      },
      {
        name: 'Change List',
        link: 'manage/change_list.php'
      },
      {
        name: 'Transaction Code',
        link: 'manage/manage_transaction_code.php',
        shouldParse: symbols.getters.shouldShowTransactionCode
      },
      {
        name: 'Staff',
        link: 'manage/manage_staff.php'
      },
      {
        name: 'Scheduler',
        children: [
          {
            name: 'Resources',
            link: 'manage/manage_chairs.php'
          },
          {
            name: 'Appointment Types',
            link: 'manage/manage_appts.php'
          }
        ]
      },
      {
        name: 'Export MD',
        action: symbols.actions.exportMDModal
      },
      {
        name: 'DSS Files',
        link: 'manage/view_documents.php?cat=',
        childrenFrom: symbols.getters.documentCategories,
        childId: 'categoryId',
        childName: 'name'
      },
      {
        name: 'Manage Locations',
        link: 'manage/manage_locations.php'
      },
      {
        name: 'Data Import',
        action: symbols.actions.dataImportModal
      },
      {
        name: 'Enrollments',
        link: 'manage/manage_enrollment.php',
        shouldParse: symbols.getters.shouldShowEnrollments
      }
    ]
  },
  {
    name: 'Pt. Screener App',
    link: '/screener',
    blank: true,
    legacy: false
  },
  {
    name: 'Forms',
    link: 'manage/manage_user_forms.php'
  },
  {
    name: 'Education',
    children: [
      {
        name: 'Dental Sleep Solutions Procedures Manual',
        link: 'manage/manual.php'
      },
      {
        name: 'Dental Sleep Medicine Manual',
        link: 'manage/medicine_manual.php'
      },
      {
        name: 'DSS Franchise Operations Manual',
        link: 'manage/operations_manual.php',
        shouldParse: symbols.getters.shouldShowFranchiseManual
      },
      {
        name: 'Quick Facts Reference',
        link: 'manage/quick_facts.php'
      },
      {
        name: 'Watch Videos',
        link: 'manage/videos.php'
      },
      {
        name: 'Get C.E.',
        link: 'manage/edx_login.php',
        shouldParse: symbols.getters.shouldShowGetCE,
        blank: true
      },
      {
        name: 'Certificates',
        link: 'manage/edx_certificate.php'
      }
    ]
  },
  {
    name: 'SW Tutorials',
    link: 'manage/sw_tutorials.php'
  },
  {
    name: 'Scheduler',
    link: 'manage/calendar.php'
  },
  {
    name: 'Manage Pts',
    link: 'manage/manage_patient.php'
  },
  {
    name: 'Device Selector',
    action: symbols.actions.deviceSelectorModal
  }
]

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
  DSS_HST_CONTACTED: 5
}

export const NOTIFICATIONS = [
  {
    number: NOTIFICATION_NUMBERS.patientNotifications,
    label: 'Web Portal',
    countZero: 'bad_count',
    countNonZero: 'bad_count',
    children: [
      {
        number: NOTIFICATION_NUMBERS.patientContacts,
        label: 'Pt Contacts',
        link: 'manage_patient_contacts.php',
        countZero: 'bad_count',
        countNonZero: 'bad_count'
      },
      {
        number: NOTIFICATION_NUMBERS.patientInsurances,
        label: 'Pt Insurance',
        link: 'manage_patient_insurance.php',
        countZero: 'bad_count',
        countNonZero: 'bad_count'
      },
      {
        number: NOTIFICATION_NUMBERS.patientChanges,
        label: 'Pt Changes',
        link: 'manage_patient_changes.php',
        countZero: 'bad_count',
        countNonZero: 'bad_count'
      }
    ]
  },
  {
    number: NOTIFICATION_NUMBERS.pendingLetters,
    label: 'Letters',
    link: 'letters.php?status=pending',
    shouldParse: symbols.getters.shouldUseLetters,
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.unmailedLetters,
    label: 'Unmailed Letters',
    link: 'letters.php?status=sent&mailed=0',
    shouldParse: symbols.getters.shouldShowUnmailedLettersNumber,
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.preAuth,
    label: 'VOBs',
    link: 'manage_vobs.php?status=' + DSS_CONSTANTS.DSS_PREAUTH_COMPLETE + '&viewed=0',
    countZero: 'good_count',
    countNonZero: 'great_count'
  },
  {
    number: NOTIFICATION_NUMBERS.rejectedPreAuth,
    label: 'Rejected VOBs',
    link: 'manage_vobs.php?status=' + DSS_CONSTANTS.DSS_PREAUTH_REJECTED + '&viewed=0',
    shouldParse: symbols.getters.shouldShowRejectedPreauthNumber,
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.hst,
    label: 'HSTs',
    link: 'manage_hst.php?status=' + DSS_CONSTANTS.DSS_HST_COMPLETE + '&viewed=0',
    countZero: 'good_count',
    countNonZero: 'great_count'
  },
  {
    number: NOTIFICATION_NUMBERS.rejectedHst,
    label: 'Rejected HSTs',
    link: 'manage_hst.php?status=' + DSS_CONSTANTS.DSS_HST_REJECTED + '&viewed=0',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.requestedHst,
    label: 'Unsent HSTs',
    link: 'manage_hst.php?status=' + DSS_CONSTANTS.DSS_HST_REQUESTED + '&viewed=0',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.pendingClaims,
    label: 'Pending Claims',
    link: 'manage_claims.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.unmailedClaims,
    label: 'Unmailed Claims',
    link: 'manage_claims.php?unmailed=1',
    shouldParse: symbols.getters.shouldShowUnmailedClaims,
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.rejectedClaims,
    label: 'Rejected Claims',
    link: 'manage_rejected_claims.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.unsignedNotes,
    label: 'Unsigned Notes',
    link: 'manage_unsigned_notes.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.rejectedPreAuth,
    label: 'Alerts',
    link: 'manage_vobs.php?status=' + DSS_CONSTANTS.DSS_PREAUTH_REJECTED + '&viewed=0',
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.faxAlerts,
    label: 'Failed Faxes',
    link: 'manage_faxes.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.pendingDuplicates,
    label: 'Pending Duplicates',
    link: 'pending_patient.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.emailBounces,
    label: 'Email Bounces',
    link: 'manage_email_bounces.php',
    countZero: 'good_count',
    countNonZero: 'bad_count'
  },
  {
    number: NOTIFICATION_NUMBERS.paymentReports,
    label: 'Payment Reports',
    link: 'payment_reports_list.php?unviewed=1',
    shouldParse: symbols.getters.shouldShowPaymentReportsNumber,
    countZero: 'good_count',
    countNonZero: 'bad_count'
  }
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
    link: 'manage/manage_flowsheet3.php?pid=%d&addtopat=1',
    name: 'Tracker',
    active: 'manage/manage_flowsheet3.php'
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
