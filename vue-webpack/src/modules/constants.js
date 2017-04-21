export default {
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
  DSS_HST_CONTACTED: 5,

  dssPreauthStatusLabels: ['Pending', 'Complete', 'Pre-Auth Pending', 'Rejected'],

  dssHstStatusLabels (status) {
    var labels = [
      'Canceled', 'Unsent', 'Pending', 'Scheduled',
      'Complete', 'Rejected', 'Contacted'
    ]
    var statuses = [
      this.DSS_HST_CANCELED, this.DSS_HST_REQUESTED, this.DSS_HST_PENDING,
      this.DSS_HST_SCHEDULED, this.DSS_HST_COMPLETE, this.DSS_HST_REJECTED,
      this.DSS_HST_CONTACTED
    ]

    var foundIndex = statuses.findIndex((el) => el === status)

    return foundIndex >= 0 ? labels[foundIndex] : null
  },

  DSS_DEVICE_SETTING_TYPE_RANGE: 0,
  DSS_DEVICE_SETTING_TYPE_FLAG: 1,

  DSS_REFERRED_PATIENT: 1,
  DSS_REFERRED_PHYSICIAN: 2,
  DSS_REFERRED_MEDIA: 3,
  DSS_REFERRED_FRANCHISE: 4,
  DSS_REFERRED_DSSOFFICE: 5,
  DSS_REFERRED_OTHER: 6,

  dssReferredLabels: ['', 'Patient', 'Physician', 'Media', 'Internal', 'DSS Office', 'Other'],

  // Transaction Payers (ledger)
  DSS_TRXN_PAYER_PRIMARY: 0,
  DSS_TRXN_PAYER_SECONDARY: 1,
  DSS_TRXN_PAYER_PATIENT: 2,
  DSS_TRXN_PAYER_WRITEOFF: 3,
  DSS_TRXN_PAYER_DISCOUNT: 4,

  // A convenience array to get trxn payment labels
  dssTransactionPayerLabels (status) {
    var propertyNameTemplate = 'DSS_TRXN_PAYER_'
    var labels = [
      'Primary Insurance', 'Secondary Insurance', 'Patient',
      'Write Off', 'Professional Discount'
    ]

    return this.getTitle(propertyNameTemplate, labels, status)
  },

  // Transaction Payment Types (ledger)
  DSS_TRXN_PYMT_CREDIT: 0,
  DSS_TRXN_PYMT_DEBIT: 1,
  DSS_TRXN_PYMT_CHECK: 2,
  DSS_TRXN_PYMT_CASH: 3,
  DSS_TRXN_PYMT_WRITEOFF: 4,
  DSS_TRXN_PYMT_EFT: 5,

  // A convenience array to get trxn payment type labels
  dssTransactionPaymentTypeLabels (status) {
    var propertyNameTemplate = 'DSS_TRXN_PYMT_'
    var labels = [
      'Credit Card', 'Debit', 'Check',
      'Cash', 'Write Off', 'E-Funds Transfer (EFT)'
    ]

    return this.getTitle(propertyNameTemplate, labels, status)
  },

  // Transaction types (ledger)
  DSS_TRXN_TYPE_MED: 1,
  DSS_TRXN_TYPE_PATIENT: 2,
  DSS_TRXN_TYPE_INS: 3,
  DSS_TRXN_TYPE_DIAG: 4,
  DSS_TRXN_TYPE_ADJ: 6,

  // A convenience array to get trxn type labels
  dssTransactionTypeLabels (status) {
    var propertyNameTemplate = 'DSS_TRXN_TYPE_'
    var labels = [
      'Medical Code', 'Patient Payment Code', 'Insurance Payment Code',
      'Dianostic Code', 'Adjustment Code'
    ]

    return this.getTitle(propertyNameTemplate, labels, status)
  },

  getTitle (propertyNameTemplate, labels, status) {
    // get certain integer contants (the object properties) and find a requered status
    var foundIndex = Object.getOwnPropertyNames(this).filter((property) => {
      return property.indexOf(propertyNameTemplate) === 0
    }).map((property) => {
      return this[property]
    }).findIndex((el) => el === status)

    return foundIndex >= 0 ? labels[foundIndex] : null
  }
}
