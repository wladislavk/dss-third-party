export default {
  auth: '/auth',
  companies: {
    billingExclusiveCompany: '/companies/billing-exclusive-company',
    companyByUser: '/companies/by-user',
    homeSleepTest: '/companies/home-sleep-test'
  },
  contacts: {
    corporate: '/contacts/corporate',
    find: '/contacts/find',
    insurance: '/contacts/insurance',
    listContactsAndCompanies: '/contacts/list-contacts-and-companies',
    referredBy: '/contacts/referred-by',
    show: '/contacts',
    store: '/contacts',
    update: '/contacts',
    withContactType: '/contacts/with-contact-type'
  },
  contactTypes: {
    activeNonCorporate: '/contact-types/active-non-corporate',
    physician: '/contact-types/physician',
    show: '/contact-types',
    sorted: '/contact-types/sorted'
  },
  corporateContacts: {
    destroy: '/corporate-contacts'
  },
  displayFile: '/display-file',
  documentCategories: {
    active: '/document-categories/active'
  },
  education: {
    edxCertificates: '/edx-certificates'
  },
  eligible: {
    payers: '/eligible/payers'
  },
  epworthSleepinessScale: {
    index: '/epworth-sleepiness-scale'
  },
  faxes: {
    alerts: '/faxes/alerts'
  },
  guideDevices: {
    withImages: '/guide-devices/with-images'
  },
  guideSettingOptions: {
    settingIds: '/guide-setting-options/setting-ids'
  },
  homeSleepTests: {
    store: '/home-sleep-tests'
  },
  insurances: {
    rejected: '/insurances/rejected'
  },
  insurancePreauth: {
    findVobs: '/insurance-preauth/vobs/find',
    pendingVob: '/insurance-preauth/pending-VOB',
    update: '/insurance-preauth'
  },
  ledgers: {
    list: '/ledgers/list',
    totals: '/ledgers/totals'
  },
  letters: {
    createWelcomeLetter: '/letters/create-welcome-letter',
    deliveredForContact: '/letters/delivered-for-contact',
    generateDateOfIntro: '/letters/gen-date-of-intro',
    notDeliveredForContact: '/letters/not-delivered-for-contact',
    pending: '/letters/pending',
    unmailed: '/letters/unmailed'
  },
  locations: {
    byDoctor: '/locations/by-doctor'
  },
  loginDetails: {
    store: '/login-details'
  },
  logout: '/logout',
  memos: {
    current: '/memos/current'
  },
  notifications: {
    update: '/notifications',
    withFilter: '/notifications/with-filter'
  },
  patients: {
    byContact: '/patients/by-contact',
    checkEmail: '/patients/check-email',
    destroyForDoctor: '/patients-by-doctor',
    edit: '/patients/edit',
    fillingForm: '/patients/filling-form',
    find: '/patients/find',
    list: '/patients/list',
    patientData: '/patients/data',
    referredByContact: '/patients/referred-by-contact',
    referrers: '/patients/referrers',
    resetAccessCode: '/patients/reset-access-code',
    show: '/patients',
    temporaryPinDocument: '/patients/temp-pin-document',
    withFilter: '/patients/with-filter'
  },
  patientSummaries: {
    updateTrackerNotes: '/patient-summaries/update-tracker-notes'
  },
  profileImages: {
    insuranceCardImage: '/profile-images/insurance-card-image',
    photo: '/profile-images/photo'
  },
  qualifiers: {
    active: '/qualifiers/active'
  },
  referredByContacts: {
    destroy: '/referred-by-contacts',
    edit: '/referred-by-contacts/edit',
    show: '/referred-by-contacts'
  },
  screeners: {
    store: '/screeners'
  },
  sleeplabs: {
    destroy: '/sleeplabs',
    edit: '/sleeplabs/edit',
    list: '/sleeplabs/list',
    show: '/sleeplabs'
  },
  tasks: {
    all: '/tasks/all',
    allForPatient: '/tasks/all/pid',
    destroy: '/tasks',
    futureForPatient: '/tasks/future/pid',
    index: '/tasks',
    indexForPatient: '/tasks-for-patient',
    later: '/tasks/later',
    nextWeek: '/tasks/next-week',
    overdue: '/tasks/overdue',
    overdueForPatient: '/tasks/overdue/pid',
    show: '/tasks',
    store: '/tasks',
    thisWeek: '/tasks/this-week',
    today: '/tasks/today',
    todayForPatient: '/tasks/today/pid',
    tomorrow: '/tasks/tomorrow',
    tomorrowForPatient: '/tasks/tomorrow/pid',
    update: '/tasks'
  },
  tmjClinicalExams: {
    updateFlowDevice: '/tmj-clinical-exams/update-flow-device'
  },
  users: {
    check: '/users/check',
    checkLogout: '/users/check-logout',
    current: '/users/current',
    letterInfo: '/users/letter-info',
    responsible: '/users/responsible',
    show: '/users'
  }
}
