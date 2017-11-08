import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from './main'
import symbols from '../symbols'

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
