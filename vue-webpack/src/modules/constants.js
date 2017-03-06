module.exports = {
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

  dssReferredLabels: ['', 'Patient', 'Physician', 'Media', 'Internal', 'DSS Office', 'Other']
}
