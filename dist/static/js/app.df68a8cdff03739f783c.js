webpackJsonp([0],[
/* 0 */,
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  state: {
    allergen: 'ALLERGEN',
    appointmentSummaries: 'APPOINTMENT_SUMMARIES',
    coMorbidityData: 'CO_MORBIDITY_DATA',
    companyData: 'COMPANY_DATA',
    companyLogo: 'COMPANY_LOGO',
    contact: 'CONTACT',
    contactData: 'CONTACT_DATA',
    cpap: 'CPAP',
    currentTask: 'CURRENT_TASK',
    devices: 'DEVICES',
    displayAlert: 'DISPLAY_ALERT',
    docInfo: 'DOC_INFO',
    doctorName: 'DOCTOR_NAME',
    documentCategories: 'DOCUMENT_CATEGORIES',
    deviceGuideResults: 'DEVICE_GUIDE_RESULTS',
    deviceGuideSettingOptions: 'DEVICE_GUIDE_SETTING_OPTIONS',
    epworthOptions: 'EPWORTH_OPTIONS',
    epworthProps: 'EPWORTH_PROPS',
    hasScheduledAppointment: 'HAS_SCHEDULED_APPOINTMENT',
    headerAlertText: 'HEADER_ALERT_TEXT',
    headerTitle: 'HEADER_TITLE',
    incompleteHomeSleepTests: 'INCOMPLETE_HOME_SLEEP_TESTS',
    isEmailBounced: 'IS_EMAIL_BOUNCED',
    letters: 'LETTERS',
    mainToken: 'MAIN_TOKEN',
    medicare: 'MEDICARE',
    memos: 'MEMOS',
    modal: 'MODAL',
    notificationNumbers: 'NOTIFICATION_NUMBERS',
    patientHomeSleepTestStatus: 'PATIENT_HOME_SLEEP_TEST_STATUS',
    patientId: 'PATIENT_ID',
    patientName: 'PATIENT_NAME',
    patientSearchList: 'PATIENT_SEARCH_LIST',
    popupEdit: 'POPUP_EDIT',
    premedCheck: 'PREMED_CHECK',
    questionnaireStatuses: 'QUESTIONNAIRE_STATUSES',
    rejectedClaimsForCurrentPatient: 'REJECTED_CLAIMS_FOR_CURRENT_PATIENT',
    responsibleUsers: 'RESPONSIBLE_USERS',
    screenerId: 'SCREENER_ID',
    screenerToken: 'SCREENER_TOKEN',
    screenerWeights: 'SCREENER_WEIGHTS',
    showAllWarnings: 'SHOW_ALL_WARNINGS',
    showFancybox: 'SHOW_FANCYBOX',
    showSearchHints: 'SHOW_SEARCH_HINTS',
    sessionData: 'SESSION_DATA',
    symptoms: 'SYMPTOMS',
    tasks: 'TASKS',
    tasksForPatient: 'TASKS_FOR_PATIENT',
    totalPatientContacts: 'TOTAL_PATIENT_CONTACTS',
    totalPatientInsurances: 'TOTAL_PATIENT_INSURANCES',
    totalSubPatients: 'TOTAL_SUB_PATIENTS',
    trackerSteps: 'TRACKER_STEPS',
    userInfo: 'USER_INFO'
  },
  getters: {
    calculateRisk: 'CALCULATE_RISK',
    documentCategories: 'DOCUMENT_CATEGORIES',
    filteredContact: 'FILTERED_CONTACT',
    fullContactData: 'FULL_CONTACT_DATA',
    fullName: 'FULL_NAME',
    isUserDoctor: 'IS_USER_DOCTOR',
    mainToken: 'MAIN_TOKEN',
    notificationsNumber: 'NOTIFICATIONS_NUMBER',
    patientId: 'PATIENT_ID',
    shouldShowEnrollments: 'SHOULD_SHOW_ENROLLMENTS',
    shouldShowFranchiseManual: 'SHOULD_SHOW_FRANCHISE_MANUAL',
    shouldShowGetCE: 'SHOULD_SHOW_GET_CE',
    shouldShowInvoices: 'SHOULD_SHOW_INVOICES',
    shouldShowPaymentReportsNumber: 'SHOULD_SHOW_PAYMENT_REPORTS_NUMBER',
    shouldShowRejectedPreauthNumber: 'SHOULD_SHOW_REJECTED_PREAUTH_NUMBER',
    shouldShowTransactionCode: 'SHOULD_SHOW_TRANSACTION_CODE',
    shouldShowUnmailedClaims: 'SHOULD_SHOW_UNMAILED_CLAIMS',
    shouldShowUnmailedLettersNumber: 'SHOULD_SHOW_UNMAILED_LETTERS_NUMBER',
    shouldUseLetters: 'SHOULD_USE_LETTERS',
    showWarningAboutBouncedEmails: 'SHOW_WARNING_ABOUT_BOUNCED_EMAILS',
    showWarningAboutPatientChanges: 'SHOW_WARNING_ABOUT_PATIENT_CHANGES',
    showWarningAboutQuestionnaireChanges: 'SHOW_WARNING_ABOUT_QUESTIONNAIRE_CHANGES',
    tasksByType: 'TASKS_BY_TYPE',
    tasksNumber: 'TASKS_NUMBER',
    tasksPatientByType: 'TASKS_PATIENT_BY_TYPE',
    tasksPatientNumber: 'TASKS_PATIENT_NUMBER',
    trackerStepSchedule: 'TRACKER_STEP_SCHEDULE',
    trackerStepsFirst: 'TRACKER_STEPS_FIRST',
    trackerStepsSecond: 'TRACKER_STEPS_SECOND'
  },
  mutations: {
    appointmentSummaries: 'APPOINTMENT_SUMMARIES',
    checkGuideSetting: 'CHECK_GUIDE_SETTING',
    clearPatientData: 'CLEAR_PATIENT_DATA',
    coMorbidity: 'CO_MORBIDITY',
    coMorbidityWeight: 'CO_MORBIDITY_WEIGHT',
    companyData: 'COMPANY_DATA',
    companyLogo: 'COMPANY_LOGO',
    contactData: 'CONTACT_DATA',
    cpap: 'CPAP',
    devices: 'DEVICES',
    docInfo: 'DOC_INFO',
    doctorName: 'DOCTOR_NAME',
    documentCategories: 'DOCUMENT_CATEGORIES',
    deviceGuideResults: 'DEVICE_GUIDE_RESULTS',
    deviceGuideSettingOptions: 'DEVICE_GUIDE_SETTING_OPTIONS',
    epworthWeight: 'EPWORTH_WEIGHT',
    getTask: 'GET_TASK',
    hasScheduledAppointment: 'HAS_SCHEDULED_APPOINTMENT',
    hideAllWarnings: 'HIDE_ALL_WARNINGS',
    hideFancybox: 'HIDE_FANCYBOX',
    hideSearchHints: 'HIDE_SEARCH_HINTS',
    insertTrackerStep: 'INSERT_TRACKER_STEP',
    letters: 'LETTERS',
    mainToken: 'MAIN_TOKEN',
    memos: 'MEMOS',
    modal: 'MODAL',
    modifyEpworthProps: 'MODIFY_EPWORTH_PROPS',
    moveGuideSettingSlider: 'MOVE_GUIDE_SETTING_SLIDER',
    notificationNumbers: 'NOTIFICATION_NUMBERS',
    patientData: 'PATIENT_DATA',
    patientId: 'PATIENT_ID',
    patientSearchList: 'PATIENT_SEARCH_LIST',
    popupEdit: 'POPUP_EDIT',
    resetModal: 'RESET_MODAL',
    responsibleUsers: 'RESPONSIBLE_USERS',
    restoreInitialScreener: 'RESTORE_INITIAL_SCREENER',
    restoreInitialScreenerKeepSession: 'RESTORE_INITIAL_SCREENER_KEEP_SESSION',
    resetDeviceGuideSettingOptions: 'RESET_DEVICE_GUIDE_SETTING_OPTIONS',
    screenerId: 'SCREENER_ID',
    screenerToken: 'SCREENER_TOKEN',
    sessionData: 'SESSION_DATA',
    setContact: 'SET_CONTACT',
    setEpworthErrors: 'SET_EPWORTH_ERRORS',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    setTasks: 'SET_TASKS',
    setTasksForPatient: 'SET_TASKS_FOR_PATIENT',
    showAllWarnings: 'SHOW_ALL_WARNINGS',
    showFancybox: 'SHOW_FANCYBOX',
    showSearchHints: 'SHOW_SEARCH_HINTS',
    stepsByRank: 'STEPS_BY_RANK',
    surveyWeight: 'SURVEY_WEIGHT',
    symptoms: 'SYMPTOMS',
    userInfo: 'USER_INFO'
  },
  actions: {
    addTask: 'ADD_TASK',
    appointmentSummariesByPatient: 'APPOINTMENT_SUMMARIES_BY_PATIENT',
    authenticateScreener: 'AUTHENTICATE_SCREENER',
    clearPatientData: 'CLEAR_PATIENT_DATA',
    companyLogo: 'COMPANY_LOGO',
    dataImportModal: 'DATA_IMPORT_MODAL',
    deleteAppointmentSummary: 'DELETE_APPOINTMENT_SUMMARY',
    deleteTask: 'DELETE_TASK',
    deviceSelectorModal: 'DEVICE_SELECTOR_MODAL',
    devicesByStatus: 'DEVICES_BY_STATUS',
    disablePopupEdit: 'DISABLE_POPUP_EDIT',
    documentCategories: 'DOCUMENT_CATEGORIES',
    dualAppLogin: 'DUAL_APP_LOGIN',
    exportMDModal: 'EXPORT_MD_MODAL',
    getCompanyData: 'GET_COMPANY_DATA',
    getDoctorData: 'GET_DOCTOR_DATA',
    getDeviceGuideResults: 'GET_DEVICE_GUIDE_RESULTS',
    getDeviceGuideSettingOptions: 'GET_DEVICE_GUIDE_SETTING_OPTIONS',
    getTask: 'GET_TASK',
    handleErrors: 'HANDLE_ERRORS',
    insertTrackerStep: 'INSERT_TRACKER_STEP',
    lettersByPatientAndInfo: 'LETTERS_BY_PATIENT_AND_INFO',
    mainLogin: 'MAIN_LOGIN',
    memos: 'MEMOS',
    moveGuideSettingSlider: 'MOVE_GUIDE_SETTING_SLIDER',
    parseScreenerResults: 'PARSE_SCREENER_RESULTS',
    patientData: 'PATIENT_DATA',
    patientSearchList: 'PATIENT_SEARCH_LIST',
    responsibleUsers: 'RESPONSIBLE_USERS',
    retrieveTasks: 'RETRIEVE_TASKS',
    retrieveTasksForPatient: 'RETRIEVE_TASKS_FOR_PATIENT',
    setCurrentContact: 'SET_CURRENT_CONTACT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    setSessionData: 'SET_SESSION_DATA',
    stepsByRank: 'STEPS_BY_RANK',
    storeLoginDetails: 'STORE_LOGIN_DETAILS',
    submitScreener: 'SUBMIT_SCREENER',
    submitHst: 'SUBMIT_HST',
    updateAppointmentSummary: 'UPDATE_APPOINTMENT_SUMMARY',
    updateFlowDevice: 'UPDATE_FLOW_DEVICE',
    updateTaskStatus: 'UPDATE_TASK_STATUS',
    userInfo: 'USER_INFO'
  },
  populators: {
    populateClaims: 'POPULATE_CLAIMS'
  }
};

/***/ }),
/* 2 */,
/* 3 */,
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  auth: '/auth',
  appointmentSummaries: {
    byPatient: '/appt-summaries/by-patient',
    destroy: '/appt-summaries',
    stepsByRank: '/appt-summaries/steps-by-rank',
    update: '/appt-summaries'
  },
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
  devices: {
    byStatus: '/devices/by-status'
  },
  displayFile: '/display-file',
  documentCategories: {
    active: '/document-categories/active'
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
    byPatientAndInfo: '/letters/by-patient-and-info',
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
};

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _promise = __webpack_require__(32);

var _promise2 = _interopRequireDefault(_promise);

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  token: '',
  request: function request(method, path, data, config) {
    var _this = this;

    if (!this.hasOwnProperty(method)) {
      throw new Error('HTTP method ' + method + ' not found');
    }
    return new _promise2.default(function (resolve, reject) {
      _this[method](path, data, config).then(function (response) {
        if (response.error) {
          throw new Error(response.error);
        }
        resolve(response);
      }).catch(function (error) {
        reject(new Error(error));
      });
    });
  },
  get: function get(path, data, config) {
    config = config || {};
    this._addToken(config);
    return _axios2.default.get(this.formUrl(path), config);
  },
  post: function post(path, data, config) {
    config = config || {};
    this._addToken(config);
    return _axios2.default.post(this.formUrl(path), data, config);
  },
  put: function put(path, data, config) {
    config = config || {};
    this._addToken(config);
    return _axios2.default.put(this.formUrl(path), data, config);
  },
  delete: function _delete(path, data, config) {
    config = config || {};
    this._addToken(config);
    return _axios2.default.delete(this.formUrl(path), config);
  },
  formUrl: function formUrl(path) {
    var apiPath = _ProcessWrapper2.default.getApiPath();
    if (apiPath.charAt(apiPath.length - 1) === '/' && path.charAt(0) === '/') {
      path = path.substr(1);
    }
    return apiPath + path;
  },
  _addToken: function _addToken(config) {
    config.headers = config.headers || {};
    config.headers.Authorization = 'Bearer ' + this.token;
  }
};

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.NOT_ACCEPTED_UPDATE = exports.PHONE_FIELDS = exports.PATIENT_MENU = exports.HST_STATUSES = exports.STANDARD_META = exports.REFERRED_LABELS = exports.PREAUTH_STATUS_LABELS = exports.TRANSACTION_PAYER_LABELS = exports.PAYMENT_TYPE_LABELS = exports.TRANSACTION_TYPE_LABELS = exports.DSS_CONSTANTS = exports.NOTIFICATION_NUMBERS = exports.TASK_TYPES = undefined;

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _TRANSACTION_TYPE_LAB, _PAYMENT_TYPE_LABELS, _TRANSACTION_PAYER_LA, _PREAUTH_STATUS_LABEL, _HST_STATUSES;

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var TASK_TYPES = exports.TASK_TYPES = {
  OVERDUE: 'overdue',
  TODAY: 'today',
  TOMORROW: 'tomorrow',
  THIS_WEEK: 'thisWeek',
  NEXT_WEEK: 'nextWeek',
  LATER: 'later',
  FUTURE: 'future'
};

var NOTIFICATION_NUMBERS = exports.NOTIFICATION_NUMBERS = {
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
};

var DSS_CONSTANTS = exports.DSS_CONSTANTS = {
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

  DSS_PREAUTH_PENDING: 0,
  DSS_PREAUTH_COMPLETE: 1,
  DSS_PREAUTH_PREAUTH_PENDING: 2,
  DSS_PREAUTH_REJECTED: 3,

  DSS_HST_CANCELED: -1,
  DSS_HST_REQUESTED: 0,
  DSS_HST_PENDING: 1,
  DSS_HST_SCHEDULED: 2,
  DSS_HST_COMPLETE: 3,
  DSS_HST_REJECTED: 4,
  DSS_HST_CONTACTED: 5,

  DSS_TRXN_PAYER_PRIMARY: 0,
  DSS_TRXN_PAYER_SECONDARY: 1,
  DSS_TRXN_PAYER_PATIENT: 2,
  DSS_TRXN_PAYER_WRITEOFF: 3,
  DSS_TRXN_PAYER_DISCOUNT: 4,

  DSS_TRXN_PYMT_CREDIT: 0,
  DSS_TRXN_PYMT_DEBIT: 1,
  DSS_TRXN_PYMT_CHECK: 2,
  DSS_TRXN_PYMT_CASH: 3,
  DSS_TRXN_PYMT_WRITEOFF: 4,
  DSS_TRXN_PYMT_EFT: 5,

  DSS_TRXN_TYPE_MED: 1,
  DSS_TRXN_TYPE_PATIENT: 2,
  DSS_TRXN_TYPE_INS: 3,
  DSS_TRXN_TYPE_DIAG: 4,
  DSS_TRXN_TYPE_ADJ: 6
};

var TRANSACTION_TYPE_LABELS = exports.TRANSACTION_TYPE_LABELS = (_TRANSACTION_TYPE_LAB = {}, (0, _defineProperty3.default)(_TRANSACTION_TYPE_LAB, DSS_CONSTANTS.DSS_TRXN_TYPE_MED, 'Medical Code'), (0, _defineProperty3.default)(_TRANSACTION_TYPE_LAB, DSS_CONSTANTS.DSS_TRXN_TYPE_PATIENT, 'Patient Payment Code'), (0, _defineProperty3.default)(_TRANSACTION_TYPE_LAB, DSS_CONSTANTS.DSS_TRXN_TYPE_INS, 'Insurance Payment Code'), (0, _defineProperty3.default)(_TRANSACTION_TYPE_LAB, DSS_CONSTANTS.DSS_TRXN_TYPE_DIAG, 'Dianostic Code'), (0, _defineProperty3.default)(_TRANSACTION_TYPE_LAB, DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ, 'Adjustment Code'), _TRANSACTION_TYPE_LAB);

var PAYMENT_TYPE_LABELS = exports.PAYMENT_TYPE_LABELS = (_PAYMENT_TYPE_LABELS = {}, (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_CREDIT, 'Credit Card'), (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_DEBIT, 'Debit'), (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_CHECK, 'Check'), (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_CASH, 'Cash'), (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_WRITEOFF, 'Write Off'), (0, _defineProperty3.default)(_PAYMENT_TYPE_LABELS, DSS_CONSTANTS.DSS_TRXN_PYMT_EFT, 'E-Funds Transfer (EFT)'), _PAYMENT_TYPE_LABELS);

var TRANSACTION_PAYER_LABELS = exports.TRANSACTION_PAYER_LABELS = (_TRANSACTION_PAYER_LA = {}, (0, _defineProperty3.default)(_TRANSACTION_PAYER_LA, DSS_CONSTANTS.DSS_TRXN_PAYER_PRIMARY, 'Primary Insurance'), (0, _defineProperty3.default)(_TRANSACTION_PAYER_LA, DSS_CONSTANTS.DSS_TRXN_PAYER_SECONDARY, 'Secondary Insurance'), (0, _defineProperty3.default)(_TRANSACTION_PAYER_LA, DSS_CONSTANTS.DSS_TRXN_PAYER_PATIENT, 'Patient'), (0, _defineProperty3.default)(_TRANSACTION_PAYER_LA, DSS_CONSTANTS.DSS_TRXN_PAYER_WRITEOFF, 'Write Off'), (0, _defineProperty3.default)(_TRANSACTION_PAYER_LA, DSS_CONSTANTS.DSS_TRXN_PAYER_DISCOUNT, 'Professional Discount'), _TRANSACTION_PAYER_LA);

var PREAUTH_STATUS_LABELS = exports.PREAUTH_STATUS_LABELS = (_PREAUTH_STATUS_LABEL = {}, (0, _defineProperty3.default)(_PREAUTH_STATUS_LABEL, DSS_CONSTANTS.DSS_PREAUTH_PENDING, 'Pending'), (0, _defineProperty3.default)(_PREAUTH_STATUS_LABEL, DSS_CONSTANTS.DSS_PREAUTH_COMPLETE, 'Complete'), (0, _defineProperty3.default)(_PREAUTH_STATUS_LABEL, DSS_CONSTANTS.DSS_PREAUTH_PREAUTH_PENDING, 'Pre-Auth Pending'), (0, _defineProperty3.default)(_PREAUTH_STATUS_LABEL, DSS_CONSTANTS.DSS_PREAUTH_REJECTED, 'Rejected'), _PREAUTH_STATUS_LABEL);

var REFERRED_LABELS = exports.REFERRED_LABELS = ['', 'Patient', 'Physician', 'Media', 'Internal', 'DSS Office', 'Other'];

var STANDARD_META = exports.STANDARD_META = {
  requiresAuth: true,
  requiresManageTemplate: true
};

var HST_STATUSES = exports.HST_STATUSES = (_HST_STATUSES = {}, (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_CANCELED, 'Cancelled'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_REQUESTED, 'Unsent'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_PENDING, 'Pending'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_SCHEDULED, 'Scheduled'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_COMPLETE, 'Complete'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_REJECTED, 'Rejected'), (0, _defineProperty3.default)(_HST_STATUSES, DSS_CONSTANTS.DSS_HST_CONTACTED, 'Contacted'), _HST_STATUSES);

var PATIENT_MENU = exports.PATIENT_MENU = [{
  legacy: false,
  link: 'patient-tracker',
  name: 'Tracker',
  active: 'patient-tracker'
}, {
  link: 'manage/dss_summ.php?pid=%d&addtopat=1',
  name: 'Summary Sheet',
  active: 'manage/dss_summ.php'
}, {
  link: 'manage/manage_ledger.php?pid=%d&addtopat=1',
  name: 'Ledger',
  active: 'manage/manage_ledger.php'
}, {
  link: 'manage/manage_insurance.php?pid=%d&addtopat=1',
  name: 'Insurance',
  active: 'manage/manage_insurance.php'
}, {
  link: 'manage/dss_summ.php?sect=notes&pid=%d&addtopat=1',
  name: 'Progress Notes',
  active: 'manage/manage_progress_notes.php'
}, {
  link: 'manage/dss_summ.php?sect=letters&pid=%d&addtopat=1',
  name: 'Letters',
  active: 'manage/patient_letters.php'
}, {
  link: 'manage/q_image.php?pid=%d',
  name: 'Images',
  active: 'manage/q_image.php'
}, {
  link: 'manage/q_page1.php?pid=%d&addtopat=1',
  name: 'Questionnaire',
  activeLike: ['q_page', 'q_sleep']
}, {
  link: 'manage/ex_page4.php?pid=%d&addtopat=1',
  name: 'Clinical Exam',
  activeLike: ['ex_page']
}, {
  link: 'manage/add_patient.php?ed=%d&addtopat=1&pid=%d',
  name: 'Patient Info',
  active: 'edit-patient'
}];

var PHONE_FIELDS = exports.PHONE_FIELDS = ['phone1', 'phone2', 'fax'];

var NOT_ACCEPTED_UPDATE = exports.NOT_ACCEPTED_UPDATE = 'Warning! Patient has updated their %s via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.';

/***/ }),
/* 7 */,
/* 8 */,
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  alert: function alert(text) {
    window.alert(text);
  },
  isConfirmed: function isConfirmed(text) {
    return window.confirm(text);
  }
};

/***/ }),
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  getApiRoot: function getApiRoot() {
    var apiRoot = Object({"KDE_FULL_SESSION":true,"LESSOPEN":| /usr/bin/lesspipe %s,"PROFILEHOME":,"npm_package_devDependencies_webpack_hot_middleware":^2.19.1,"npm_config_cache_lock_stale":60000,"npm_config_ham_it_up":,"GS_LIB":/home/vladislavk/.fonts,"npm_package_devDependencies_babel_core":^6.22.1,"npm_package_devDependencies_chalk":^2.1.0,"npm_package_devDependencies_http_proxy_middleware":^0.17.3,"npm_package_devDependencies_moxios":^0.4.0,"npm_config_legacy_bundling":,"npm_config_sign_git_tag":,"PAM_KWALLET5_LOGIN":/tmp/kwallet5_vladislavk.socket,"USER":vladislavk,"LANGUAGE":en_US,"LC_TIME":en_GB.UTF-8,"npm_package_devDependencies_eslint_plugin_standard":^3.0.1,"npm_package_devDependencies_vue_loader":^13.0.5,"npm_package_devDependencies_webpack_bundle_analyzer":^2.2.1,"npm_config_user_agent":npm/5.6.0 node/v7.4.0 linux x64,"npm_config_always_auth":,"COMP_WORDBREAKS": 	
"'><;|&(:,"XDG_SEAT":seat0,"npm_package_dependencies_vue":^2.4.4,"npm_package_devDependencies_optimize_css_assets_webpack_plugin":^3.2.0,"npm_package_devDependencies_ora":^1.1.0,"npm_config_bin_links":true,"npm_config_key":,"SSH_AGENT_PID":3614,"XDG_SESSION_TYPE":x11,"npm_package_devDependencies_eslint_plugin_node":^5.2.0,"npm_package_devDependencies_file_loader":^0.11.2,"npm_config_allow_same_version":,"npm_config_description":true,"npm_config_fetch_retries":2,"npm_config_heading":npm,"npm_config_if_present":,"npm_config_init_version":1.0.0,"npm_config_user":,"npm_node_execpath":/usr/local/bin/node,"XCURSOR_SIZE":0,"SHLVL":1,"npm_package_devDependencies_babel_preset_es2015":^6.22.0,"npm_package_devDependencies_url_loader":^0.5.7,"npm_config_prefer_online":,"OLDPWD":/home/vladislavk/sites/dss-acceptance,"HOME":/home/vladislavk,"npm_package_scripts_test_components":karma start tests/karma-components.conf.js,"npm_package_dependencies_vuejs_datepicker":^0.9.20,"npm_package_dependencies_vuex":^2.4.1,"npm_package_devDependencies_function_bind":^1.1.1,"npm_config_force":,"DESKTOP_SESSION":plasma,"npm_package_dependencies_awesome_mask":^0.5.4,"npm_config_only":,"npm_config_read_only":,"npm_package_devDependencies_jasmine_core":^2.8.0,"npm_package_engines_node":>= 4.0.0,"npm_config_cache_min":10,"npm_config_init_license":ISC,"QT_LINUX_ACCESSIBILITY_ALWAYS_ON":1,"GTK_RC_FILES":/etc/gtk/gtkrc:/home/vladislavk/.gtkrc:/home/vladislavk/.config/gtkrc,"SHELL_SESSION_ID":aaf2cc43e2f040009da93f963d14f9ac,"GTK_MODULES":gail:atk-bridge,"XDG_SEAT_PATH":/org/freedesktop/DisplayManager/Seat0,"KDE_SESSION_VERSION":5,"npm_package_devDependencies_eslint_loader":^1.9,"npm_config_editor":vi,"npm_config_rollback":true,"npm_config_tag_version_prefix":v,"LC_MONETARY":es_MX.UTF-8,"KONSOLE_DBUS_SESSION":/Sessions/1,"npm_package_devDependencies_karma":^1.7,"npm_package_devDependencies_rimraf":^2.6.2,"npm_config_cache_max":Infinity,"npm_config_timing":,"npm_config_userconfig":/home/vladislavk/.npmrc,"DBUS_SESSION_BUS_ADDRESS":unix:abstract=/tmp/dbus-EhgoFm7n1c,guid=e33d1dce65b3eeb346563d505a56c504,"npm_package_dependencies_moment":^2.17.1,"npm_package_devDependencies_karma_chrome_launcher":^2.2.0,"npm_config_engine_strict":,"npm_config_init_author_name":,"npm_config_init_author_url":,"npm_config_tmp":/tmp,"KONSOLE_DBUS_WINDOW":/Windows/1,"npm_package_description":Vue implementation of Dental Sleep Solutions (FO),"npm_package_dependencies_qs":^6.5.1,"npm_package_devDependencies_babel_loader":^7.1,"npm_config_depth":Infinity,"npm_config_package_lock_only":,"npm_config_save_dev":,"npm_config_usage":,"npm_package_dependencies_jquery_mask_plugin":^1.14.12,"npm_package_dependencies_vue_moment":^2.0.2,"npm_package_devDependencies_eslint_plugin_jasmine":^2.9.1,"npm_package_readmeFilename":README.md,"npm_config_metrics_registry":https://registry.npmjs.org/,"npm_config_cafile":,"npm_config_otp":,"npm_config_package_lock":true,"npm_config_progress":true,"npm_config_https_proxy":,"npm_config_save_prod":,"QT_QPA_PLATFORMTHEME":appmenu-qt5,"MANDATORY_PATH":/usr/share/gconf/plasma.mandatory.path,"npm_package_scripts_dev":node build/dev-server.js,"npm_package_dependencies_sweetalert":^1.1.3,"npm_package_devDependencies_opn":^5.1.0,"npm_config_cidr":,"npm_config_onload_script":,"npm_config_sso_type":oauth,"LOGNAME":vladislavk,"npm_package_devDependencies_connect_history_api_fallback":^1.3.0,"npm_package_devDependencies_eslint_plugin_import":^2.7.0,"npm_package_devDependencies_vue_template_compiler":^2.4.4,"npm_config_rebuild_bundle":true,"npm_config_save_bundle":,"npm_config_shell":/bin/bash,"WINDOWID":115343365,"_":/usr/local/bin/npm,"npm_package_private":true,"npm_package_devDependencies_autoprefixer":^7.1.5,"npm_package_devDependencies_babel_register":^6.26.0,"npm_package_devDependencies_eslint_config_standard":^10.2.1,"npm_config_prefix":/usr/local,"npm_config_dry_run":,"KONSOLE_PROFILE_NAME":Shell,"DEFAULTS_PATH":/usr/share/gconf/plasma.default.path,"COLORFGBG":0;15,"npm_package_scripts_lint":eslint --ext .js,.vue src,"npm_config_scope":,"npm_config_browser":,"npm_config_cache_lock_wait":10000,"npm_config_ignore_prepublish":,"npm_config_registry":https://registry.npmjs.org/,"npm_config_save_optional":,"npm_config_searchopts":,"npm_config_versions":,"XDG_SESSION_ID":c2,"TERM":xterm,"npm_package_dependencies_vue_focus":^2.1.0,"npm_config_cache":/home/vladislavk/.npm,"npm_config_proxy":,"npm_config_send_metrics":,"RBENV_SHELL":bash,"npm_package_devDependencies_eslint_plugin_html":^3.2.2,"npm_package_devDependencies_html_webpack_plugin":^2.28.0,"npm_package_devDependencies_karma_webpack":^2.0.5,"npm_config_global_style":,"npm_config_ignore_scripts":,"npm_config_version":,"GTK2_RC_FILES":/etc/gtk-2.0/gtkrc:/home/vladislavk/.gtkrc-2.0:/home/vladislavk/.config/gtkrc-2.0,"GTK2_MODULES":overlay-scrollbar,"npm_package_dependencies_axios":^0.16.2,"npm_config_local_address":,"npm_config_viewer":man,"npm_config_node_gyp":/usr/local/lib/node_modules/npm/node_modules/node-gyp/bin/node-gyp.js,"PATH":/usr/local/lib/node_modules/npm/node_modules/npm-lifecycle/node-gyp-bin:/home/vladislavk/sites/dss/ds3-private06-Vue/node_modules/.bin:/home/vladislavk/.composer/vendor/bin:/home/vladislavk/.rbenv/shims:/home/vladislavk/.rbenv/bin:/home/vladislavk/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin,"SESSION_MANAGER":local/vladislavk-H81M-S2PV:@/tmp/.ICE-unix/3732,unix/vladislavk-H81M-S2PV:/tmp/.ICE-unix/3732,"GDM_LANG":en_US,"npm_package_name":dentalsleepsolutions,"npm_package_dependencies_vue_slider_component":^2.4.7,"npm_package_devDependencies_eventsource_polyfill":^0.9.6,"npm_config_prefer_offline":,"NODE":/usr/local/bin/node,"LC_ADDRESS":th_TH.UTF-8,"XDG_SESSION_PATH":/org/freedesktop/DisplayManager/Session0,"XCURSOR_THEME":DMZ-White,"XDG_RUNTIME_DIR":/run/user/1000,"npm_config_color":true,"DISPLAY"::0,"npm_package_scripts_test_unit":karma start tests/karma-unit.conf.js,"npm_package_devDependencies_webpack_merge":^4.1,"npm_config_fetch_retry_mintimeout":10000,"npm_config_maxsockets":50,"npm_config_offline":,"npm_config_sso_poll_frequency":500,"LC_TELEPHONE":th_TH.UTF-8,"LANG":en_US.UTF-8,"XDG_CURRENT_DESKTOP":KDE,"npm_package_devDependencies_eslint":^4.8.0,"npm_package_devDependencies_webpack":^3.6.0,"npm_config_umask":0002,"LS_COLORS":rs=0:di=01;34:ln=01;36:mh=00:pi=40;33:so=01;35:do=01;35:bd=40;33;01:cd=40;33;01:or=40;31;01:mi=00:su=37;41:sg=30;43:ca=30;41:tw=30;42:ow=34;42:st=37;44:ex=01;32:*.tar=01;31:*.tgz=01;31:*.arc=01;31:*.arj=01;31:*.taz=01;31:*.lha=01;31:*.lz4=01;31:*.lzh=01;31:*.lzma=01;31:*.tlz=01;31:*.txz=01;31:*.tzo=01;31:*.t7z=01;31:*.zip=01;31:*.z=01;31:*.Z=01;31:*.dz=01;31:*.gz=01;31:*.lrz=01;31:*.lz=01;31:*.lzo=01;31:*.xz=01;31:*.bz2=01;31:*.bz=01;31:*.tbz=01;31:*.tbz2=01;31:*.tz=01;31:*.deb=01;31:*.rpm=01;31:*.jar=01;31:*.war=01;31:*.ear=01;31:*.sar=01;31:*.rar=01;31:*.alz=01;31:*.ace=01;31:*.zoo=01;31:*.cpio=01;31:*.7z=01;31:*.rz=01;31:*.cab=01;31:*.jpg=01;35:*.jpeg=01;35:*.gif=01;35:*.bmp=01;35:*.pbm=01;35:*.pgm=01;35:*.ppm=01;35:*.tga=01;35:*.xbm=01;35:*.xpm=01;35:*.tif=01;35:*.tiff=01;35:*.png=01;35:*.svg=01;35:*.svgz=01;35:*.mng=01;35:*.pcx=01;35:*.mov=01;35:*.mpg=01;35:*.mpeg=01;35:*.m2v=01;35:*.mkv=01;35:*.webm=01;35:*.ogm=01;35:*.mp4=01;35:*.m4v=01;35:*.mp4v=01;35:*.vob=01;35:*.qt=01;35:*.nuv=01;35:*.wmv=01;35:*.asf=01;35:*.rm=01;35:*.rmvb=01;35:*.flc=01;35:*.avi=01;35:*.fli=01;35:*.flv=01;35:*.gl=01;35:*.dl=01;35:*.xcf=01;35:*.xwd=01;35:*.yuv=01;35:*.cgm=01;35:*.emf=01;35:*.ogv=01;35:*.ogx=01;35:*.aac=00;36:*.au=00;36:*.flac=00;36:*.m4a=00;36:*.mid=00;36:*.midi=00;36:*.mka=00;36:*.mp3=00;36:*.mpc=00;36:*.ogg=00;36:*.ra=00;36:*.wav=00;36:*.oga=00;36:*.opus=00;36:*.spx=00;36:*.xspf=00;36:,"XDG_SESSION_DESKTOP":plasma,"XAUTHORITY":/tmp/xauth-1000-_0,"npm_package_devDependencies_copy_webpack_plugin":^4.1.1,"npm_package_gitHead":dc6faac3460ebbcfad4ab9ce88b7bde076bf9d6f,"npm_config_fetch_retry_maxtimeout":60000,"npm_config_loglevel":notice,"npm_config_logs_max":10,"npm_config_message":%s,"npm_lifecycle_script":node build/build.js,"XDG_GREETER_DATA_DIR":/var/lib/lightdm-data/vladislavk,"SSH_AUTH_SOCK":/tmp/ssh-0revauGXh4ce/agent.3490,"npm_config_ca":,"npm_config_cert":,"npm_config_global":,"npm_config_link":,"SHELL":/bin/bash,"NODE_PATH":/usr/local/lib/node_modules,"PAM_KWALLET_LOGIN":/tmp/kwallet_vladislavk.socket,"LC_NAME":th_TH.UTF-8,"npm_package_version":1.0.0,"npm_package_dependencies_jquery":^3.1.1,"npm_package_devDependencies_eslint_friendly_formatter":^3.0.0,"npm_package_devDependencies_semver":^5.3.0,"npm_package_devDependencies_webpack_dev_middleware":^1.10.0,"npm_config_access":,"npm_config_also":,"npm_config_save":true,"npm_config_unicode":,"npm_lifecycle_event":build,"QT_ACCESSIBILITY":1,"GDMSESSION":plasma,"npm_package_scripts_build":node build/build.js,"npm_package_dependencies_source_list_map":^2.0.0,"npm_config_argv":{"remain":[],"cooked":["run","build"],"original":["run","build"]},"npm_config_long":,"npm_config_production":,"npm_config_searchlimit":20,"npm_config_unsafe_perm":true,"LESSCLOSE":/usr/bin/lesspipe %s %s,"npm_package_dependencies_vue_visible":^1.0.2,"npm_package_devDependencies_karma_jasmine":^1.1.0,"npm_config_auth_type":legacy,"npm_config_node_version":7.4.0,"npm_config_tag":latest,"KONSOLE_DBUS_SERVICE"::1.114,"LC_MEASUREMENT":tzm_MA.UTF-8,"npm_package_dependencies_vue_router":^2.2.0,"npm_package_devDependencies_express":^4.16.1,"npm_package_devDependencies_inject_loader":^3.0.1,"npm_config_git_tag_version":true,"npm_config_commit_hooks":true,"npm_config_script_shell":,"npm_config_shrinkwrap":true,"KDE_MULTIHEAD":false,"LC_IDENTIFICATION":th_TH.UTF-8,"npm_config_fetch_retry_factor":10,"npm_config_save_exact":,"npm_config_strict_ssl":true,"XDG_VTNR":7,"QT_IM_MODULE":compose,"npm_package_dependencies_accounting":^0.4.1,"npm_package_dependencies_jquery_ui":1.10.5,"npm_package_devDependencies_babel_preset_stage_2":^6.22.0,"npm_config_globalconfig":/etc/npmrc,"npm_config_dev":,"npm_config_init_module":/home/vladislavk/.npm-init.js,"npm_config_parseable":,"LC_ALL":C,"PWD":/home/vladislavk/sites/dss-vue,"npm_package_dependencies_vue_inject":^1.0.1,"npm_config_globalignorefile":/etc/npmignore,"npm_execpath":/usr/local/lib/node_modules/npm/bin/npm-cli.js,"XDG_CONFIG_DIRS":/etc/xdg/xdg-plasma:/etc/xdg:/usr/share/kubuntu-default-settings/kf5-settings,"XDG_DATA_DIRS":/usr/share/plasma:/usr/local/share:/usr/share:/var/lib/snapd/desktop:/var/lib/snapd/desktop,"npm_package_author_name":Dental Sleep Solutions,"npm_package_devDependencies_css_loader":^0.28.7,"npm_package_devDependencies_vue_style_loader":^3.0.3,"npm_package_engines_npm":>= 3.0.0,"npm_config_cache_lock_retries":10,"npm_config_searchstaleness":900,"LC_NUMERIC":es_MX.UTF-8,"npm_package_devDependencies_extract_text_webpack_plugin":^3.0.1,"npm_config_node_options":,"npm_config_save_prefix":^,"npm_config_scripts_prepend_node_path":warn-only,"LC_PAPER":th_TH.UTF-8,"KDE_SESSION_UID":1000,"npm_package_devDependencies_babel_eslint":^7.1.1,"npm_package_devDependencies_babel_plugin_transform_runtime":^6.22.0,"npm_package_devDependencies_vuenit":^1.1.1,"npm_config_group":1000,"npm_config_init_author_email":,"npm_config_searchexclude":,"npm_package_devDependencies_eslint_plugin_promise":^3.4.0,"npm_package_devDependencies_friendly_errors_webpack_plugin":^1.1.3,"npm_package_devDependencies_sinon":^3.3.0,"npm_config_git":git,"npm_config_optional":true,"npm_config_json":,"INIT_CWD":/home/vladislavk/sites/dss/ds3-private06-Vue,"NODE_ENV":"production","HEADLESS_API_ROOT":"http://api/","HEADLESS_API_PATH":"http://api/api/v1/","HEADLESS_LEGACY_ROOT":"http://loader/"}).API_ROOT;
    if (this._checkForHeadless()) {
      apiRoot = "http://api/";
    }
    return apiRoot;
  },
  getApiPath: function getApiPath() {
    var apiPath = Object({"KDE_FULL_SESSION":true,"LESSOPEN":| /usr/bin/lesspipe %s,"PROFILEHOME":,"npm_package_devDependencies_webpack_hot_middleware":^2.19.1,"npm_config_cache_lock_stale":60000,"npm_config_ham_it_up":,"GS_LIB":/home/vladislavk/.fonts,"npm_package_devDependencies_babel_core":^6.22.1,"npm_package_devDependencies_chalk":^2.1.0,"npm_package_devDependencies_http_proxy_middleware":^0.17.3,"npm_package_devDependencies_moxios":^0.4.0,"npm_config_legacy_bundling":,"npm_config_sign_git_tag":,"PAM_KWALLET5_LOGIN":/tmp/kwallet5_vladislavk.socket,"USER":vladislavk,"LANGUAGE":en_US,"LC_TIME":en_GB.UTF-8,"npm_package_devDependencies_eslint_plugin_standard":^3.0.1,"npm_package_devDependencies_vue_loader":^13.0.5,"npm_package_devDependencies_webpack_bundle_analyzer":^2.2.1,"npm_config_user_agent":npm/5.6.0 node/v7.4.0 linux x64,"npm_config_always_auth":,"COMP_WORDBREAKS": 	
"'><;|&(:,"XDG_SEAT":seat0,"npm_package_dependencies_vue":^2.4.4,"npm_package_devDependencies_optimize_css_assets_webpack_plugin":^3.2.0,"npm_package_devDependencies_ora":^1.1.0,"npm_config_bin_links":true,"npm_config_key":,"SSH_AGENT_PID":3614,"XDG_SESSION_TYPE":x11,"npm_package_devDependencies_eslint_plugin_node":^5.2.0,"npm_package_devDependencies_file_loader":^0.11.2,"npm_config_allow_same_version":,"npm_config_description":true,"npm_config_fetch_retries":2,"npm_config_heading":npm,"npm_config_if_present":,"npm_config_init_version":1.0.0,"npm_config_user":,"npm_node_execpath":/usr/local/bin/node,"XCURSOR_SIZE":0,"SHLVL":1,"npm_package_devDependencies_babel_preset_es2015":^6.22.0,"npm_package_devDependencies_url_loader":^0.5.7,"npm_config_prefer_online":,"OLDPWD":/home/vladislavk/sites/dss-acceptance,"HOME":/home/vladislavk,"npm_package_scripts_test_components":karma start tests/karma-components.conf.js,"npm_package_dependencies_vuejs_datepicker":^0.9.20,"npm_package_dependencies_vuex":^2.4.1,"npm_package_devDependencies_function_bind":^1.1.1,"npm_config_force":,"DESKTOP_SESSION":plasma,"npm_package_dependencies_awesome_mask":^0.5.4,"npm_config_only":,"npm_config_read_only":,"npm_package_devDependencies_jasmine_core":^2.8.0,"npm_package_engines_node":>= 4.0.0,"npm_config_cache_min":10,"npm_config_init_license":ISC,"QT_LINUX_ACCESSIBILITY_ALWAYS_ON":1,"GTK_RC_FILES":/etc/gtk/gtkrc:/home/vladislavk/.gtkrc:/home/vladislavk/.config/gtkrc,"SHELL_SESSION_ID":aaf2cc43e2f040009da93f963d14f9ac,"GTK_MODULES":gail:atk-bridge,"XDG_SEAT_PATH":/org/freedesktop/DisplayManager/Seat0,"KDE_SESSION_VERSION":5,"npm_package_devDependencies_eslint_loader":^1.9,"npm_config_editor":vi,"npm_config_rollback":true,"npm_config_tag_version_prefix":v,"LC_MONETARY":es_MX.UTF-8,"KONSOLE_DBUS_SESSION":/Sessions/1,"npm_package_devDependencies_karma":^1.7,"npm_package_devDependencies_rimraf":^2.6.2,"npm_config_cache_max":Infinity,"npm_config_timing":,"npm_config_userconfig":/home/vladislavk/.npmrc,"DBUS_SESSION_BUS_ADDRESS":unix:abstract=/tmp/dbus-EhgoFm7n1c,guid=e33d1dce65b3eeb346563d505a56c504,"npm_package_dependencies_moment":^2.17.1,"npm_package_devDependencies_karma_chrome_launcher":^2.2.0,"npm_config_engine_strict":,"npm_config_init_author_name":,"npm_config_init_author_url":,"npm_config_tmp":/tmp,"KONSOLE_DBUS_WINDOW":/Windows/1,"npm_package_description":Vue implementation of Dental Sleep Solutions (FO),"npm_package_dependencies_qs":^6.5.1,"npm_package_devDependencies_babel_loader":^7.1,"npm_config_depth":Infinity,"npm_config_package_lock_only":,"npm_config_save_dev":,"npm_config_usage":,"npm_package_dependencies_jquery_mask_plugin":^1.14.12,"npm_package_dependencies_vue_moment":^2.0.2,"npm_package_devDependencies_eslint_plugin_jasmine":^2.9.1,"npm_package_readmeFilename":README.md,"npm_config_metrics_registry":https://registry.npmjs.org/,"npm_config_cafile":,"npm_config_otp":,"npm_config_package_lock":true,"npm_config_progress":true,"npm_config_https_proxy":,"npm_config_save_prod":,"QT_QPA_PLATFORMTHEME":appmenu-qt5,"MANDATORY_PATH":/usr/share/gconf/plasma.mandatory.path,"npm_package_scripts_dev":node build/dev-server.js,"npm_package_dependencies_sweetalert":^1.1.3,"npm_package_devDependencies_opn":^5.1.0,"npm_config_cidr":,"npm_config_onload_script":,"npm_config_sso_type":oauth,"LOGNAME":vladislavk,"npm_package_devDependencies_connect_history_api_fallback":^1.3.0,"npm_package_devDependencies_eslint_plugin_import":^2.7.0,"npm_package_devDependencies_vue_template_compiler":^2.4.4,"npm_config_rebuild_bundle":true,"npm_config_save_bundle":,"npm_config_shell":/bin/bash,"WINDOWID":115343365,"_":/usr/local/bin/npm,"npm_package_private":true,"npm_package_devDependencies_autoprefixer":^7.1.5,"npm_package_devDependencies_babel_register":^6.26.0,"npm_package_devDependencies_eslint_config_standard":^10.2.1,"npm_config_prefix":/usr/local,"npm_config_dry_run":,"KONSOLE_PROFILE_NAME":Shell,"DEFAULTS_PATH":/usr/share/gconf/plasma.default.path,"COLORFGBG":0;15,"npm_package_scripts_lint":eslint --ext .js,.vue src,"npm_config_scope":,"npm_config_browser":,"npm_config_cache_lock_wait":10000,"npm_config_ignore_prepublish":,"npm_config_registry":https://registry.npmjs.org/,"npm_config_save_optional":,"npm_config_searchopts":,"npm_config_versions":,"XDG_SESSION_ID":c2,"TERM":xterm,"npm_package_dependencies_vue_focus":^2.1.0,"npm_config_cache":/home/vladislavk/.npm,"npm_config_proxy":,"npm_config_send_metrics":,"RBENV_SHELL":bash,"npm_package_devDependencies_eslint_plugin_html":^3.2.2,"npm_package_devDependencies_html_webpack_plugin":^2.28.0,"npm_package_devDependencies_karma_webpack":^2.0.5,"npm_config_global_style":,"npm_config_ignore_scripts":,"npm_config_version":,"GTK2_RC_FILES":/etc/gtk-2.0/gtkrc:/home/vladislavk/.gtkrc-2.0:/home/vladislavk/.config/gtkrc-2.0,"GTK2_MODULES":overlay-scrollbar,"npm_package_dependencies_axios":^0.16.2,"npm_config_local_address":,"npm_config_viewer":man,"npm_config_node_gyp":/usr/local/lib/node_modules/npm/node_modules/node-gyp/bin/node-gyp.js,"PATH":/usr/local/lib/node_modules/npm/node_modules/npm-lifecycle/node-gyp-bin:/home/vladislavk/sites/dss/ds3-private06-Vue/node_modules/.bin:/home/vladislavk/.composer/vendor/bin:/home/vladislavk/.rbenv/shims:/home/vladislavk/.rbenv/bin:/home/vladislavk/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin,"SESSION_MANAGER":local/vladislavk-H81M-S2PV:@/tmp/.ICE-unix/3732,unix/vladislavk-H81M-S2PV:/tmp/.ICE-unix/3732,"GDM_LANG":en_US,"npm_package_name":dentalsleepsolutions,"npm_package_dependencies_vue_slider_component":^2.4.7,"npm_package_devDependencies_eventsource_polyfill":^0.9.6,"npm_config_prefer_offline":,"NODE":/usr/local/bin/node,"LC_ADDRESS":th_TH.UTF-8,"XDG_SESSION_PATH":/org/freedesktop/DisplayManager/Session0,"XCURSOR_THEME":DMZ-White,"XDG_RUNTIME_DIR":/run/user/1000,"npm_config_color":true,"DISPLAY"::0,"npm_package_scripts_test_unit":karma start tests/karma-unit.conf.js,"npm_package_devDependencies_webpack_merge":^4.1,"npm_config_fetch_retry_mintimeout":10000,"npm_config_maxsockets":50,"npm_config_offline":,"npm_config_sso_poll_frequency":500,"LC_TELEPHONE":th_TH.UTF-8,"LANG":en_US.UTF-8,"XDG_CURRENT_DESKTOP":KDE,"npm_package_devDependencies_eslint":^4.8.0,"npm_package_devDependencies_webpack":^3.6.0,"npm_config_umask":0002,"LS_COLORS":rs=0:di=01;34:ln=01;36:mh=00:pi=40;33:so=01;35:do=01;35:bd=40;33;01:cd=40;33;01:or=40;31;01:mi=00:su=37;41:sg=30;43:ca=30;41:tw=30;42:ow=34;42:st=37;44:ex=01;32:*.tar=01;31:*.tgz=01;31:*.arc=01;31:*.arj=01;31:*.taz=01;31:*.lha=01;31:*.lz4=01;31:*.lzh=01;31:*.lzma=01;31:*.tlz=01;31:*.txz=01;31:*.tzo=01;31:*.t7z=01;31:*.zip=01;31:*.z=01;31:*.Z=01;31:*.dz=01;31:*.gz=01;31:*.lrz=01;31:*.lz=01;31:*.lzo=01;31:*.xz=01;31:*.bz2=01;31:*.bz=01;31:*.tbz=01;31:*.tbz2=01;31:*.tz=01;31:*.deb=01;31:*.rpm=01;31:*.jar=01;31:*.war=01;31:*.ear=01;31:*.sar=01;31:*.rar=01;31:*.alz=01;31:*.ace=01;31:*.zoo=01;31:*.cpio=01;31:*.7z=01;31:*.rz=01;31:*.cab=01;31:*.jpg=01;35:*.jpeg=01;35:*.gif=01;35:*.bmp=01;35:*.pbm=01;35:*.pgm=01;35:*.ppm=01;35:*.tga=01;35:*.xbm=01;35:*.xpm=01;35:*.tif=01;35:*.tiff=01;35:*.png=01;35:*.svg=01;35:*.svgz=01;35:*.mng=01;35:*.pcx=01;35:*.mov=01;35:*.mpg=01;35:*.mpeg=01;35:*.m2v=01;35:*.mkv=01;35:*.webm=01;35:*.ogm=01;35:*.mp4=01;35:*.m4v=01;35:*.mp4v=01;35:*.vob=01;35:*.qt=01;35:*.nuv=01;35:*.wmv=01;35:*.asf=01;35:*.rm=01;35:*.rmvb=01;35:*.flc=01;35:*.avi=01;35:*.fli=01;35:*.flv=01;35:*.gl=01;35:*.dl=01;35:*.xcf=01;35:*.xwd=01;35:*.yuv=01;35:*.cgm=01;35:*.emf=01;35:*.ogv=01;35:*.ogx=01;35:*.aac=00;36:*.au=00;36:*.flac=00;36:*.m4a=00;36:*.mid=00;36:*.midi=00;36:*.mka=00;36:*.mp3=00;36:*.mpc=00;36:*.ogg=00;36:*.ra=00;36:*.wav=00;36:*.oga=00;36:*.opus=00;36:*.spx=00;36:*.xspf=00;36:,"XDG_SESSION_DESKTOP":plasma,"XAUTHORITY":/tmp/xauth-1000-_0,"npm_package_devDependencies_copy_webpack_plugin":^4.1.1,"npm_package_gitHead":dc6faac3460ebbcfad4ab9ce88b7bde076bf9d6f,"npm_config_fetch_retry_maxtimeout":60000,"npm_config_loglevel":notice,"npm_config_logs_max":10,"npm_config_message":%s,"npm_lifecycle_script":node build/build.js,"XDG_GREETER_DATA_DIR":/var/lib/lightdm-data/vladislavk,"SSH_AUTH_SOCK":/tmp/ssh-0revauGXh4ce/agent.3490,"npm_config_ca":,"npm_config_cert":,"npm_config_global":,"npm_config_link":,"SHELL":/bin/bash,"NODE_PATH":/usr/local/lib/node_modules,"PAM_KWALLET_LOGIN":/tmp/kwallet_vladislavk.socket,"LC_NAME":th_TH.UTF-8,"npm_package_version":1.0.0,"npm_package_dependencies_jquery":^3.1.1,"npm_package_devDependencies_eslint_friendly_formatter":^3.0.0,"npm_package_devDependencies_semver":^5.3.0,"npm_package_devDependencies_webpack_dev_middleware":^1.10.0,"npm_config_access":,"npm_config_also":,"npm_config_save":true,"npm_config_unicode":,"npm_lifecycle_event":build,"QT_ACCESSIBILITY":1,"GDMSESSION":plasma,"npm_package_scripts_build":node build/build.js,"npm_package_dependencies_source_list_map":^2.0.0,"npm_config_argv":{"remain":[],"cooked":["run","build"],"original":["run","build"]},"npm_config_long":,"npm_config_production":,"npm_config_searchlimit":20,"npm_config_unsafe_perm":true,"LESSCLOSE":/usr/bin/lesspipe %s %s,"npm_package_dependencies_vue_visible":^1.0.2,"npm_package_devDependencies_karma_jasmine":^1.1.0,"npm_config_auth_type":legacy,"npm_config_node_version":7.4.0,"npm_config_tag":latest,"KONSOLE_DBUS_SERVICE"::1.114,"LC_MEASUREMENT":tzm_MA.UTF-8,"npm_package_dependencies_vue_router":^2.2.0,"npm_package_devDependencies_express":^4.16.1,"npm_package_devDependencies_inject_loader":^3.0.1,"npm_config_git_tag_version":true,"npm_config_commit_hooks":true,"npm_config_script_shell":,"npm_config_shrinkwrap":true,"KDE_MULTIHEAD":false,"LC_IDENTIFICATION":th_TH.UTF-8,"npm_config_fetch_retry_factor":10,"npm_config_save_exact":,"npm_config_strict_ssl":true,"XDG_VTNR":7,"QT_IM_MODULE":compose,"npm_package_dependencies_accounting":^0.4.1,"npm_package_dependencies_jquery_ui":1.10.5,"npm_package_devDependencies_babel_preset_stage_2":^6.22.0,"npm_config_globalconfig":/etc/npmrc,"npm_config_dev":,"npm_config_init_module":/home/vladislavk/.npm-init.js,"npm_config_parseable":,"LC_ALL":C,"PWD":/home/vladislavk/sites/dss-vue,"npm_package_dependencies_vue_inject":^1.0.1,"npm_config_globalignorefile":/etc/npmignore,"npm_execpath":/usr/local/lib/node_modules/npm/bin/npm-cli.js,"XDG_CONFIG_DIRS":/etc/xdg/xdg-plasma:/etc/xdg:/usr/share/kubuntu-default-settings/kf5-settings,"XDG_DATA_DIRS":/usr/share/plasma:/usr/local/share:/usr/share:/var/lib/snapd/desktop:/var/lib/snapd/desktop,"npm_package_author_name":Dental Sleep Solutions,"npm_package_devDependencies_css_loader":^0.28.7,"npm_package_devDependencies_vue_style_loader":^3.0.3,"npm_package_engines_npm":>= 3.0.0,"npm_config_cache_lock_retries":10,"npm_config_searchstaleness":900,"LC_NUMERIC":es_MX.UTF-8,"npm_package_devDependencies_extract_text_webpack_plugin":^3.0.1,"npm_config_node_options":,"npm_config_save_prefix":^,"npm_config_scripts_prepend_node_path":warn-only,"LC_PAPER":th_TH.UTF-8,"KDE_SESSION_UID":1000,"npm_package_devDependencies_babel_eslint":^7.1.1,"npm_package_devDependencies_babel_plugin_transform_runtime":^6.22.0,"npm_package_devDependencies_vuenit":^1.1.1,"npm_config_group":1000,"npm_config_init_author_email":,"npm_config_searchexclude":,"npm_package_devDependencies_eslint_plugin_promise":^3.4.0,"npm_package_devDependencies_friendly_errors_webpack_plugin":^1.1.3,"npm_package_devDependencies_sinon":^3.3.0,"npm_config_git":git,"npm_config_optional":true,"npm_config_json":,"INIT_CWD":/home/vladislavk/sites/dss/ds3-private06-Vue,"NODE_ENV":"production","HEADLESS_API_ROOT":"http://api/","HEADLESS_API_PATH":"http://api/api/v1/","HEADLESS_LEGACY_ROOT":"http://loader/"}).API_PATH;
    if (this._checkForHeadless()) {
      apiPath = "http://api/api/v1/";
    }
    return apiPath;
  },
  getLegacyRoot: function getLegacyRoot() {
    var legacyRoot = Object({"KDE_FULL_SESSION":true,"LESSOPEN":| /usr/bin/lesspipe %s,"PROFILEHOME":,"npm_package_devDependencies_webpack_hot_middleware":^2.19.1,"npm_config_cache_lock_stale":60000,"npm_config_ham_it_up":,"GS_LIB":/home/vladislavk/.fonts,"npm_package_devDependencies_babel_core":^6.22.1,"npm_package_devDependencies_chalk":^2.1.0,"npm_package_devDependencies_http_proxy_middleware":^0.17.3,"npm_package_devDependencies_moxios":^0.4.0,"npm_config_legacy_bundling":,"npm_config_sign_git_tag":,"PAM_KWALLET5_LOGIN":/tmp/kwallet5_vladislavk.socket,"USER":vladislavk,"LANGUAGE":en_US,"LC_TIME":en_GB.UTF-8,"npm_package_devDependencies_eslint_plugin_standard":^3.0.1,"npm_package_devDependencies_vue_loader":^13.0.5,"npm_package_devDependencies_webpack_bundle_analyzer":^2.2.1,"npm_config_user_agent":npm/5.6.0 node/v7.4.0 linux x64,"npm_config_always_auth":,"COMP_WORDBREAKS": 	
"'><;|&(:,"XDG_SEAT":seat0,"npm_package_dependencies_vue":^2.4.4,"npm_package_devDependencies_optimize_css_assets_webpack_plugin":^3.2.0,"npm_package_devDependencies_ora":^1.1.0,"npm_config_bin_links":true,"npm_config_key":,"SSH_AGENT_PID":3614,"XDG_SESSION_TYPE":x11,"npm_package_devDependencies_eslint_plugin_node":^5.2.0,"npm_package_devDependencies_file_loader":^0.11.2,"npm_config_allow_same_version":,"npm_config_description":true,"npm_config_fetch_retries":2,"npm_config_heading":npm,"npm_config_if_present":,"npm_config_init_version":1.0.0,"npm_config_user":,"npm_node_execpath":/usr/local/bin/node,"XCURSOR_SIZE":0,"SHLVL":1,"npm_package_devDependencies_babel_preset_es2015":^6.22.0,"npm_package_devDependencies_url_loader":^0.5.7,"npm_config_prefer_online":,"OLDPWD":/home/vladislavk/sites/dss-acceptance,"HOME":/home/vladislavk,"npm_package_scripts_test_components":karma start tests/karma-components.conf.js,"npm_package_dependencies_vuejs_datepicker":^0.9.20,"npm_package_dependencies_vuex":^2.4.1,"npm_package_devDependencies_function_bind":^1.1.1,"npm_config_force":,"DESKTOP_SESSION":plasma,"npm_package_dependencies_awesome_mask":^0.5.4,"npm_config_only":,"npm_config_read_only":,"npm_package_devDependencies_jasmine_core":^2.8.0,"npm_package_engines_node":>= 4.0.0,"npm_config_cache_min":10,"npm_config_init_license":ISC,"QT_LINUX_ACCESSIBILITY_ALWAYS_ON":1,"GTK_RC_FILES":/etc/gtk/gtkrc:/home/vladislavk/.gtkrc:/home/vladislavk/.config/gtkrc,"SHELL_SESSION_ID":aaf2cc43e2f040009da93f963d14f9ac,"GTK_MODULES":gail:atk-bridge,"XDG_SEAT_PATH":/org/freedesktop/DisplayManager/Seat0,"KDE_SESSION_VERSION":5,"npm_package_devDependencies_eslint_loader":^1.9,"npm_config_editor":vi,"npm_config_rollback":true,"npm_config_tag_version_prefix":v,"LC_MONETARY":es_MX.UTF-8,"KONSOLE_DBUS_SESSION":/Sessions/1,"npm_package_devDependencies_karma":^1.7,"npm_package_devDependencies_rimraf":^2.6.2,"npm_config_cache_max":Infinity,"npm_config_timing":,"npm_config_userconfig":/home/vladislavk/.npmrc,"DBUS_SESSION_BUS_ADDRESS":unix:abstract=/tmp/dbus-EhgoFm7n1c,guid=e33d1dce65b3eeb346563d505a56c504,"npm_package_dependencies_moment":^2.17.1,"npm_package_devDependencies_karma_chrome_launcher":^2.2.0,"npm_config_engine_strict":,"npm_config_init_author_name":,"npm_config_init_author_url":,"npm_config_tmp":/tmp,"KONSOLE_DBUS_WINDOW":/Windows/1,"npm_package_description":Vue implementation of Dental Sleep Solutions (FO),"npm_package_dependencies_qs":^6.5.1,"npm_package_devDependencies_babel_loader":^7.1,"npm_config_depth":Infinity,"npm_config_package_lock_only":,"npm_config_save_dev":,"npm_config_usage":,"npm_package_dependencies_jquery_mask_plugin":^1.14.12,"npm_package_dependencies_vue_moment":^2.0.2,"npm_package_devDependencies_eslint_plugin_jasmine":^2.9.1,"npm_package_readmeFilename":README.md,"npm_config_metrics_registry":https://registry.npmjs.org/,"npm_config_cafile":,"npm_config_otp":,"npm_config_package_lock":true,"npm_config_progress":true,"npm_config_https_proxy":,"npm_config_save_prod":,"QT_QPA_PLATFORMTHEME":appmenu-qt5,"MANDATORY_PATH":/usr/share/gconf/plasma.mandatory.path,"npm_package_scripts_dev":node build/dev-server.js,"npm_package_dependencies_sweetalert":^1.1.3,"npm_package_devDependencies_opn":^5.1.0,"npm_config_cidr":,"npm_config_onload_script":,"npm_config_sso_type":oauth,"LOGNAME":vladislavk,"npm_package_devDependencies_connect_history_api_fallback":^1.3.0,"npm_package_devDependencies_eslint_plugin_import":^2.7.0,"npm_package_devDependencies_vue_template_compiler":^2.4.4,"npm_config_rebuild_bundle":true,"npm_config_save_bundle":,"npm_config_shell":/bin/bash,"WINDOWID":115343365,"_":/usr/local/bin/npm,"npm_package_private":true,"npm_package_devDependencies_autoprefixer":^7.1.5,"npm_package_devDependencies_babel_register":^6.26.0,"npm_package_devDependencies_eslint_config_standard":^10.2.1,"npm_config_prefix":/usr/local,"npm_config_dry_run":,"KONSOLE_PROFILE_NAME":Shell,"DEFAULTS_PATH":/usr/share/gconf/plasma.default.path,"COLORFGBG":0;15,"npm_package_scripts_lint":eslint --ext .js,.vue src,"npm_config_scope":,"npm_config_browser":,"npm_config_cache_lock_wait":10000,"npm_config_ignore_prepublish":,"npm_config_registry":https://registry.npmjs.org/,"npm_config_save_optional":,"npm_config_searchopts":,"npm_config_versions":,"XDG_SESSION_ID":c2,"TERM":xterm,"npm_package_dependencies_vue_focus":^2.1.0,"npm_config_cache":/home/vladislavk/.npm,"npm_config_proxy":,"npm_config_send_metrics":,"RBENV_SHELL":bash,"npm_package_devDependencies_eslint_plugin_html":^3.2.2,"npm_package_devDependencies_html_webpack_plugin":^2.28.0,"npm_package_devDependencies_karma_webpack":^2.0.5,"npm_config_global_style":,"npm_config_ignore_scripts":,"npm_config_version":,"GTK2_RC_FILES":/etc/gtk-2.0/gtkrc:/home/vladislavk/.gtkrc-2.0:/home/vladislavk/.config/gtkrc-2.0,"GTK2_MODULES":overlay-scrollbar,"npm_package_dependencies_axios":^0.16.2,"npm_config_local_address":,"npm_config_viewer":man,"npm_config_node_gyp":/usr/local/lib/node_modules/npm/node_modules/node-gyp/bin/node-gyp.js,"PATH":/usr/local/lib/node_modules/npm/node_modules/npm-lifecycle/node-gyp-bin:/home/vladislavk/sites/dss/ds3-private06-Vue/node_modules/.bin:/home/vladislavk/.composer/vendor/bin:/home/vladislavk/.rbenv/shims:/home/vladislavk/.rbenv/bin:/home/vladislavk/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin,"SESSION_MANAGER":local/vladislavk-H81M-S2PV:@/tmp/.ICE-unix/3732,unix/vladislavk-H81M-S2PV:/tmp/.ICE-unix/3732,"GDM_LANG":en_US,"npm_package_name":dentalsleepsolutions,"npm_package_dependencies_vue_slider_component":^2.4.7,"npm_package_devDependencies_eventsource_polyfill":^0.9.6,"npm_config_prefer_offline":,"NODE":/usr/local/bin/node,"LC_ADDRESS":th_TH.UTF-8,"XDG_SESSION_PATH":/org/freedesktop/DisplayManager/Session0,"XCURSOR_THEME":DMZ-White,"XDG_RUNTIME_DIR":/run/user/1000,"npm_config_color":true,"DISPLAY"::0,"npm_package_scripts_test_unit":karma start tests/karma-unit.conf.js,"npm_package_devDependencies_webpack_merge":^4.1,"npm_config_fetch_retry_mintimeout":10000,"npm_config_maxsockets":50,"npm_config_offline":,"npm_config_sso_poll_frequency":500,"LC_TELEPHONE":th_TH.UTF-8,"LANG":en_US.UTF-8,"XDG_CURRENT_DESKTOP":KDE,"npm_package_devDependencies_eslint":^4.8.0,"npm_package_devDependencies_webpack":^3.6.0,"npm_config_umask":0002,"LS_COLORS":rs=0:di=01;34:ln=01;36:mh=00:pi=40;33:so=01;35:do=01;35:bd=40;33;01:cd=40;33;01:or=40;31;01:mi=00:su=37;41:sg=30;43:ca=30;41:tw=30;42:ow=34;42:st=37;44:ex=01;32:*.tar=01;31:*.tgz=01;31:*.arc=01;31:*.arj=01;31:*.taz=01;31:*.lha=01;31:*.lz4=01;31:*.lzh=01;31:*.lzma=01;31:*.tlz=01;31:*.txz=01;31:*.tzo=01;31:*.t7z=01;31:*.zip=01;31:*.z=01;31:*.Z=01;31:*.dz=01;31:*.gz=01;31:*.lrz=01;31:*.lz=01;31:*.lzo=01;31:*.xz=01;31:*.bz2=01;31:*.bz=01;31:*.tbz=01;31:*.tbz2=01;31:*.tz=01;31:*.deb=01;31:*.rpm=01;31:*.jar=01;31:*.war=01;31:*.ear=01;31:*.sar=01;31:*.rar=01;31:*.alz=01;31:*.ace=01;31:*.zoo=01;31:*.cpio=01;31:*.7z=01;31:*.rz=01;31:*.cab=01;31:*.jpg=01;35:*.jpeg=01;35:*.gif=01;35:*.bmp=01;35:*.pbm=01;35:*.pgm=01;35:*.ppm=01;35:*.tga=01;35:*.xbm=01;35:*.xpm=01;35:*.tif=01;35:*.tiff=01;35:*.png=01;35:*.svg=01;35:*.svgz=01;35:*.mng=01;35:*.pcx=01;35:*.mov=01;35:*.mpg=01;35:*.mpeg=01;35:*.m2v=01;35:*.mkv=01;35:*.webm=01;35:*.ogm=01;35:*.mp4=01;35:*.m4v=01;35:*.mp4v=01;35:*.vob=01;35:*.qt=01;35:*.nuv=01;35:*.wmv=01;35:*.asf=01;35:*.rm=01;35:*.rmvb=01;35:*.flc=01;35:*.avi=01;35:*.fli=01;35:*.flv=01;35:*.gl=01;35:*.dl=01;35:*.xcf=01;35:*.xwd=01;35:*.yuv=01;35:*.cgm=01;35:*.emf=01;35:*.ogv=01;35:*.ogx=01;35:*.aac=00;36:*.au=00;36:*.flac=00;36:*.m4a=00;36:*.mid=00;36:*.midi=00;36:*.mka=00;36:*.mp3=00;36:*.mpc=00;36:*.ogg=00;36:*.ra=00;36:*.wav=00;36:*.oga=00;36:*.opus=00;36:*.spx=00;36:*.xspf=00;36:,"XDG_SESSION_DESKTOP":plasma,"XAUTHORITY":/tmp/xauth-1000-_0,"npm_package_devDependencies_copy_webpack_plugin":^4.1.1,"npm_package_gitHead":dc6faac3460ebbcfad4ab9ce88b7bde076bf9d6f,"npm_config_fetch_retry_maxtimeout":60000,"npm_config_loglevel":notice,"npm_config_logs_max":10,"npm_config_message":%s,"npm_lifecycle_script":node build/build.js,"XDG_GREETER_DATA_DIR":/var/lib/lightdm-data/vladislavk,"SSH_AUTH_SOCK":/tmp/ssh-0revauGXh4ce/agent.3490,"npm_config_ca":,"npm_config_cert":,"npm_config_global":,"npm_config_link":,"SHELL":/bin/bash,"NODE_PATH":/usr/local/lib/node_modules,"PAM_KWALLET_LOGIN":/tmp/kwallet_vladislavk.socket,"LC_NAME":th_TH.UTF-8,"npm_package_version":1.0.0,"npm_package_dependencies_jquery":^3.1.1,"npm_package_devDependencies_eslint_friendly_formatter":^3.0.0,"npm_package_devDependencies_semver":^5.3.0,"npm_package_devDependencies_webpack_dev_middleware":^1.10.0,"npm_config_access":,"npm_config_also":,"npm_config_save":true,"npm_config_unicode":,"npm_lifecycle_event":build,"QT_ACCESSIBILITY":1,"GDMSESSION":plasma,"npm_package_scripts_build":node build/build.js,"npm_package_dependencies_source_list_map":^2.0.0,"npm_config_argv":{"remain":[],"cooked":["run","build"],"original":["run","build"]},"npm_config_long":,"npm_config_production":,"npm_config_searchlimit":20,"npm_config_unsafe_perm":true,"LESSCLOSE":/usr/bin/lesspipe %s %s,"npm_package_dependencies_vue_visible":^1.0.2,"npm_package_devDependencies_karma_jasmine":^1.1.0,"npm_config_auth_type":legacy,"npm_config_node_version":7.4.0,"npm_config_tag":latest,"KONSOLE_DBUS_SERVICE"::1.114,"LC_MEASUREMENT":tzm_MA.UTF-8,"npm_package_dependencies_vue_router":^2.2.0,"npm_package_devDependencies_express":^4.16.1,"npm_package_devDependencies_inject_loader":^3.0.1,"npm_config_git_tag_version":true,"npm_config_commit_hooks":true,"npm_config_script_shell":,"npm_config_shrinkwrap":true,"KDE_MULTIHEAD":false,"LC_IDENTIFICATION":th_TH.UTF-8,"npm_config_fetch_retry_factor":10,"npm_config_save_exact":,"npm_config_strict_ssl":true,"XDG_VTNR":7,"QT_IM_MODULE":compose,"npm_package_dependencies_accounting":^0.4.1,"npm_package_dependencies_jquery_ui":1.10.5,"npm_package_devDependencies_babel_preset_stage_2":^6.22.0,"npm_config_globalconfig":/etc/npmrc,"npm_config_dev":,"npm_config_init_module":/home/vladislavk/.npm-init.js,"npm_config_parseable":,"LC_ALL":C,"PWD":/home/vladislavk/sites/dss-vue,"npm_package_dependencies_vue_inject":^1.0.1,"npm_config_globalignorefile":/etc/npmignore,"npm_execpath":/usr/local/lib/node_modules/npm/bin/npm-cli.js,"XDG_CONFIG_DIRS":/etc/xdg/xdg-plasma:/etc/xdg:/usr/share/kubuntu-default-settings/kf5-settings,"XDG_DATA_DIRS":/usr/share/plasma:/usr/local/share:/usr/share:/var/lib/snapd/desktop:/var/lib/snapd/desktop,"npm_package_author_name":Dental Sleep Solutions,"npm_package_devDependencies_css_loader":^0.28.7,"npm_package_devDependencies_vue_style_loader":^3.0.3,"npm_package_engines_npm":>= 3.0.0,"npm_config_cache_lock_retries":10,"npm_config_searchstaleness":900,"LC_NUMERIC":es_MX.UTF-8,"npm_package_devDependencies_extract_text_webpack_plugin":^3.0.1,"npm_config_node_options":,"npm_config_save_prefix":^,"npm_config_scripts_prepend_node_path":warn-only,"LC_PAPER":th_TH.UTF-8,"KDE_SESSION_UID":1000,"npm_package_devDependencies_babel_eslint":^7.1.1,"npm_package_devDependencies_babel_plugin_transform_runtime":^6.22.0,"npm_package_devDependencies_vuenit":^1.1.1,"npm_config_group":1000,"npm_config_init_author_email":,"npm_config_searchexclude":,"npm_package_devDependencies_eslint_plugin_promise":^3.4.0,"npm_package_devDependencies_friendly_errors_webpack_plugin":^1.1.3,"npm_package_devDependencies_sinon":^3.3.0,"npm_config_git":git,"npm_config_optional":true,"npm_config_json":,"INIT_CWD":/home/vladislavk/sites/dss/ds3-private06-Vue,"NODE_ENV":"production","HEADLESS_API_ROOT":"http://api/","HEADLESS_API_PATH":"http://api/api/v1/","HEADLESS_LEGACY_ROOT":"http://loader/"}).LEGACY_ROOT;
    if (this._checkForHeadless()) {
      legacyRoot = "http://loader/";
    }
    return legacyRoot;
  },
  getImagePath: function getImagePath() {
    return Object({"KDE_FULL_SESSION":true,"LESSOPEN":| /usr/bin/lesspipe %s,"PROFILEHOME":,"npm_package_devDependencies_webpack_hot_middleware":^2.19.1,"npm_config_cache_lock_stale":60000,"npm_config_ham_it_up":,"GS_LIB":/home/vladislavk/.fonts,"npm_package_devDependencies_babel_core":^6.22.1,"npm_package_devDependencies_chalk":^2.1.0,"npm_package_devDependencies_http_proxy_middleware":^0.17.3,"npm_package_devDependencies_moxios":^0.4.0,"npm_config_legacy_bundling":,"npm_config_sign_git_tag":,"PAM_KWALLET5_LOGIN":/tmp/kwallet5_vladislavk.socket,"USER":vladislavk,"LANGUAGE":en_US,"LC_TIME":en_GB.UTF-8,"npm_package_devDependencies_eslint_plugin_standard":^3.0.1,"npm_package_devDependencies_vue_loader":^13.0.5,"npm_package_devDependencies_webpack_bundle_analyzer":^2.2.1,"npm_config_user_agent":npm/5.6.0 node/v7.4.0 linux x64,"npm_config_always_auth":,"COMP_WORDBREAKS": 	
"'><;|&(:,"XDG_SEAT":seat0,"npm_package_dependencies_vue":^2.4.4,"npm_package_devDependencies_optimize_css_assets_webpack_plugin":^3.2.0,"npm_package_devDependencies_ora":^1.1.0,"npm_config_bin_links":true,"npm_config_key":,"SSH_AGENT_PID":3614,"XDG_SESSION_TYPE":x11,"npm_package_devDependencies_eslint_plugin_node":^5.2.0,"npm_package_devDependencies_file_loader":^0.11.2,"npm_config_allow_same_version":,"npm_config_description":true,"npm_config_fetch_retries":2,"npm_config_heading":npm,"npm_config_if_present":,"npm_config_init_version":1.0.0,"npm_config_user":,"npm_node_execpath":/usr/local/bin/node,"XCURSOR_SIZE":0,"SHLVL":1,"npm_package_devDependencies_babel_preset_es2015":^6.22.0,"npm_package_devDependencies_url_loader":^0.5.7,"npm_config_prefer_online":,"OLDPWD":/home/vladislavk/sites/dss-acceptance,"HOME":/home/vladislavk,"npm_package_scripts_test_components":karma start tests/karma-components.conf.js,"npm_package_dependencies_vuejs_datepicker":^0.9.20,"npm_package_dependencies_vuex":^2.4.1,"npm_package_devDependencies_function_bind":^1.1.1,"npm_config_force":,"DESKTOP_SESSION":plasma,"npm_package_dependencies_awesome_mask":^0.5.4,"npm_config_only":,"npm_config_read_only":,"npm_package_devDependencies_jasmine_core":^2.8.0,"npm_package_engines_node":>= 4.0.0,"npm_config_cache_min":10,"npm_config_init_license":ISC,"QT_LINUX_ACCESSIBILITY_ALWAYS_ON":1,"GTK_RC_FILES":/etc/gtk/gtkrc:/home/vladislavk/.gtkrc:/home/vladislavk/.config/gtkrc,"SHELL_SESSION_ID":aaf2cc43e2f040009da93f963d14f9ac,"GTK_MODULES":gail:atk-bridge,"XDG_SEAT_PATH":/org/freedesktop/DisplayManager/Seat0,"KDE_SESSION_VERSION":5,"npm_package_devDependencies_eslint_loader":^1.9,"npm_config_editor":vi,"npm_config_rollback":true,"npm_config_tag_version_prefix":v,"LC_MONETARY":es_MX.UTF-8,"KONSOLE_DBUS_SESSION":/Sessions/1,"npm_package_devDependencies_karma":^1.7,"npm_package_devDependencies_rimraf":^2.6.2,"npm_config_cache_max":Infinity,"npm_config_timing":,"npm_config_userconfig":/home/vladislavk/.npmrc,"DBUS_SESSION_BUS_ADDRESS":unix:abstract=/tmp/dbus-EhgoFm7n1c,guid=e33d1dce65b3eeb346563d505a56c504,"npm_package_dependencies_moment":^2.17.1,"npm_package_devDependencies_karma_chrome_launcher":^2.2.0,"npm_config_engine_strict":,"npm_config_init_author_name":,"npm_config_init_author_url":,"npm_config_tmp":/tmp,"KONSOLE_DBUS_WINDOW":/Windows/1,"npm_package_description":Vue implementation of Dental Sleep Solutions (FO),"npm_package_dependencies_qs":^6.5.1,"npm_package_devDependencies_babel_loader":^7.1,"npm_config_depth":Infinity,"npm_config_package_lock_only":,"npm_config_save_dev":,"npm_config_usage":,"npm_package_dependencies_jquery_mask_plugin":^1.14.12,"npm_package_dependencies_vue_moment":^2.0.2,"npm_package_devDependencies_eslint_plugin_jasmine":^2.9.1,"npm_package_readmeFilename":README.md,"npm_config_metrics_registry":https://registry.npmjs.org/,"npm_config_cafile":,"npm_config_otp":,"npm_config_package_lock":true,"npm_config_progress":true,"npm_config_https_proxy":,"npm_config_save_prod":,"QT_QPA_PLATFORMTHEME":appmenu-qt5,"MANDATORY_PATH":/usr/share/gconf/plasma.mandatory.path,"npm_package_scripts_dev":node build/dev-server.js,"npm_package_dependencies_sweetalert":^1.1.3,"npm_package_devDependencies_opn":^5.1.0,"npm_config_cidr":,"npm_config_onload_script":,"npm_config_sso_type":oauth,"LOGNAME":vladislavk,"npm_package_devDependencies_connect_history_api_fallback":^1.3.0,"npm_package_devDependencies_eslint_plugin_import":^2.7.0,"npm_package_devDependencies_vue_template_compiler":^2.4.4,"npm_config_rebuild_bundle":true,"npm_config_save_bundle":,"npm_config_shell":/bin/bash,"WINDOWID":115343365,"_":/usr/local/bin/npm,"npm_package_private":true,"npm_package_devDependencies_autoprefixer":^7.1.5,"npm_package_devDependencies_babel_register":^6.26.0,"npm_package_devDependencies_eslint_config_standard":^10.2.1,"npm_config_prefix":/usr/local,"npm_config_dry_run":,"KONSOLE_PROFILE_NAME":Shell,"DEFAULTS_PATH":/usr/share/gconf/plasma.default.path,"COLORFGBG":0;15,"npm_package_scripts_lint":eslint --ext .js,.vue src,"npm_config_scope":,"npm_config_browser":,"npm_config_cache_lock_wait":10000,"npm_config_ignore_prepublish":,"npm_config_registry":https://registry.npmjs.org/,"npm_config_save_optional":,"npm_config_searchopts":,"npm_config_versions":,"XDG_SESSION_ID":c2,"TERM":xterm,"npm_package_dependencies_vue_focus":^2.1.0,"npm_config_cache":/home/vladislavk/.npm,"npm_config_proxy":,"npm_config_send_metrics":,"RBENV_SHELL":bash,"npm_package_devDependencies_eslint_plugin_html":^3.2.2,"npm_package_devDependencies_html_webpack_plugin":^2.28.0,"npm_package_devDependencies_karma_webpack":^2.0.5,"npm_config_global_style":,"npm_config_ignore_scripts":,"npm_config_version":,"GTK2_RC_FILES":/etc/gtk-2.0/gtkrc:/home/vladislavk/.gtkrc-2.0:/home/vladislavk/.config/gtkrc-2.0,"GTK2_MODULES":overlay-scrollbar,"npm_package_dependencies_axios":^0.16.2,"npm_config_local_address":,"npm_config_viewer":man,"npm_config_node_gyp":/usr/local/lib/node_modules/npm/node_modules/node-gyp/bin/node-gyp.js,"PATH":/usr/local/lib/node_modules/npm/node_modules/npm-lifecycle/node-gyp-bin:/home/vladislavk/sites/dss/ds3-private06-Vue/node_modules/.bin:/home/vladislavk/.composer/vendor/bin:/home/vladislavk/.rbenv/shims:/home/vladislavk/.rbenv/bin:/home/vladislavk/bin:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin,"SESSION_MANAGER":local/vladislavk-H81M-S2PV:@/tmp/.ICE-unix/3732,unix/vladislavk-H81M-S2PV:/tmp/.ICE-unix/3732,"GDM_LANG":en_US,"npm_package_name":dentalsleepsolutions,"npm_package_dependencies_vue_slider_component":^2.4.7,"npm_package_devDependencies_eventsource_polyfill":^0.9.6,"npm_config_prefer_offline":,"NODE":/usr/local/bin/node,"LC_ADDRESS":th_TH.UTF-8,"XDG_SESSION_PATH":/org/freedesktop/DisplayManager/Session0,"XCURSOR_THEME":DMZ-White,"XDG_RUNTIME_DIR":/run/user/1000,"npm_config_color":true,"DISPLAY"::0,"npm_package_scripts_test_unit":karma start tests/karma-unit.conf.js,"npm_package_devDependencies_webpack_merge":^4.1,"npm_config_fetch_retry_mintimeout":10000,"npm_config_maxsockets":50,"npm_config_offline":,"npm_config_sso_poll_frequency":500,"LC_TELEPHONE":th_TH.UTF-8,"LANG":en_US.UTF-8,"XDG_CURRENT_DESKTOP":KDE,"npm_package_devDependencies_eslint":^4.8.0,"npm_package_devDependencies_webpack":^3.6.0,"npm_config_umask":0002,"LS_COLORS":rs=0:di=01;34:ln=01;36:mh=00:pi=40;33:so=01;35:do=01;35:bd=40;33;01:cd=40;33;01:or=40;31;01:mi=00:su=37;41:sg=30;43:ca=30;41:tw=30;42:ow=34;42:st=37;44:ex=01;32:*.tar=01;31:*.tgz=01;31:*.arc=01;31:*.arj=01;31:*.taz=01;31:*.lha=01;31:*.lz4=01;31:*.lzh=01;31:*.lzma=01;31:*.tlz=01;31:*.txz=01;31:*.tzo=01;31:*.t7z=01;31:*.zip=01;31:*.z=01;31:*.Z=01;31:*.dz=01;31:*.gz=01;31:*.lrz=01;31:*.lz=01;31:*.lzo=01;31:*.xz=01;31:*.bz2=01;31:*.bz=01;31:*.tbz=01;31:*.tbz2=01;31:*.tz=01;31:*.deb=01;31:*.rpm=01;31:*.jar=01;31:*.war=01;31:*.ear=01;31:*.sar=01;31:*.rar=01;31:*.alz=01;31:*.ace=01;31:*.zoo=01;31:*.cpio=01;31:*.7z=01;31:*.rz=01;31:*.cab=01;31:*.jpg=01;35:*.jpeg=01;35:*.gif=01;35:*.bmp=01;35:*.pbm=01;35:*.pgm=01;35:*.ppm=01;35:*.tga=01;35:*.xbm=01;35:*.xpm=01;35:*.tif=01;35:*.tiff=01;35:*.png=01;35:*.svg=01;35:*.svgz=01;35:*.mng=01;35:*.pcx=01;35:*.mov=01;35:*.mpg=01;35:*.mpeg=01;35:*.m2v=01;35:*.mkv=01;35:*.webm=01;35:*.ogm=01;35:*.mp4=01;35:*.m4v=01;35:*.mp4v=01;35:*.vob=01;35:*.qt=01;35:*.nuv=01;35:*.wmv=01;35:*.asf=01;35:*.rm=01;35:*.rmvb=01;35:*.flc=01;35:*.avi=01;35:*.fli=01;35:*.flv=01;35:*.gl=01;35:*.dl=01;35:*.xcf=01;35:*.xwd=01;35:*.yuv=01;35:*.cgm=01;35:*.emf=01;35:*.ogv=01;35:*.ogx=01;35:*.aac=00;36:*.au=00;36:*.flac=00;36:*.m4a=00;36:*.mid=00;36:*.midi=00;36:*.mka=00;36:*.mp3=00;36:*.mpc=00;36:*.ogg=00;36:*.ra=00;36:*.wav=00;36:*.oga=00;36:*.opus=00;36:*.spx=00;36:*.xspf=00;36:,"XDG_SESSION_DESKTOP":plasma,"XAUTHORITY":/tmp/xauth-1000-_0,"npm_package_devDependencies_copy_webpack_plugin":^4.1.1,"npm_package_gitHead":dc6faac3460ebbcfad4ab9ce88b7bde076bf9d6f,"npm_config_fetch_retry_maxtimeout":60000,"npm_config_loglevel":notice,"npm_config_logs_max":10,"npm_config_message":%s,"npm_lifecycle_script":node build/build.js,"XDG_GREETER_DATA_DIR":/var/lib/lightdm-data/vladislavk,"SSH_AUTH_SOCK":/tmp/ssh-0revauGXh4ce/agent.3490,"npm_config_ca":,"npm_config_cert":,"npm_config_global":,"npm_config_link":,"SHELL":/bin/bash,"NODE_PATH":/usr/local/lib/node_modules,"PAM_KWALLET_LOGIN":/tmp/kwallet_vladislavk.socket,"LC_NAME":th_TH.UTF-8,"npm_package_version":1.0.0,"npm_package_dependencies_jquery":^3.1.1,"npm_package_devDependencies_eslint_friendly_formatter":^3.0.0,"npm_package_devDependencies_semver":^5.3.0,"npm_package_devDependencies_webpack_dev_middleware":^1.10.0,"npm_config_access":,"npm_config_also":,"npm_config_save":true,"npm_config_unicode":,"npm_lifecycle_event":build,"QT_ACCESSIBILITY":1,"GDMSESSION":plasma,"npm_package_scripts_build":node build/build.js,"npm_package_dependencies_source_list_map":^2.0.0,"npm_config_argv":{"remain":[],"cooked":["run","build"],"original":["run","build"]},"npm_config_long":,"npm_config_production":,"npm_config_searchlimit":20,"npm_config_unsafe_perm":true,"LESSCLOSE":/usr/bin/lesspipe %s %s,"npm_package_dependencies_vue_visible":^1.0.2,"npm_package_devDependencies_karma_jasmine":^1.1.0,"npm_config_auth_type":legacy,"npm_config_node_version":7.4.0,"npm_config_tag":latest,"KONSOLE_DBUS_SERVICE"::1.114,"LC_MEASUREMENT":tzm_MA.UTF-8,"npm_package_dependencies_vue_router":^2.2.0,"npm_package_devDependencies_express":^4.16.1,"npm_package_devDependencies_inject_loader":^3.0.1,"npm_config_git_tag_version":true,"npm_config_commit_hooks":true,"npm_config_script_shell":,"npm_config_shrinkwrap":true,"KDE_MULTIHEAD":false,"LC_IDENTIFICATION":th_TH.UTF-8,"npm_config_fetch_retry_factor":10,"npm_config_save_exact":,"npm_config_strict_ssl":true,"XDG_VTNR":7,"QT_IM_MODULE":compose,"npm_package_dependencies_accounting":^0.4.1,"npm_package_dependencies_jquery_ui":1.10.5,"npm_package_devDependencies_babel_preset_stage_2":^6.22.0,"npm_config_globalconfig":/etc/npmrc,"npm_config_dev":,"npm_config_init_module":/home/vladislavk/.npm-init.js,"npm_config_parseable":,"LC_ALL":C,"PWD":/home/vladislavk/sites/dss-vue,"npm_package_dependencies_vue_inject":^1.0.1,"npm_config_globalignorefile":/etc/npmignore,"npm_execpath":/usr/local/lib/node_modules/npm/bin/npm-cli.js,"XDG_CONFIG_DIRS":/etc/xdg/xdg-plasma:/etc/xdg:/usr/share/kubuntu-default-settings/kf5-settings,"XDG_DATA_DIRS":/usr/share/plasma:/usr/local/share:/usr/share:/var/lib/snapd/desktop:/var/lib/snapd/desktop,"npm_package_author_name":Dental Sleep Solutions,"npm_package_devDependencies_css_loader":^0.28.7,"npm_package_devDependencies_vue_style_loader":^3.0.3,"npm_package_engines_npm":>= 3.0.0,"npm_config_cache_lock_retries":10,"npm_config_searchstaleness":900,"LC_NUMERIC":es_MX.UTF-8,"npm_package_devDependencies_extract_text_webpack_plugin":^3.0.1,"npm_config_node_options":,"npm_config_save_prefix":^,"npm_config_scripts_prepend_node_path":warn-only,"LC_PAPER":th_TH.UTF-8,"KDE_SESSION_UID":1000,"npm_package_devDependencies_babel_eslint":^7.1.1,"npm_package_devDependencies_babel_plugin_transform_runtime":^6.22.0,"npm_package_devDependencies_vuenit":^1.1.1,"npm_config_group":1000,"npm_config_init_author_email":,"npm_config_searchexclude":,"npm_package_devDependencies_eslint_plugin_promise":^3.4.0,"npm_package_devDependencies_friendly_errors_webpack_plugin":^1.1.3,"npm_package_devDependencies_sinon":^3.3.0,"npm_config_git":git,"npm_config_optional":true,"npm_config_json":,"INIT_CWD":/home/vladislavk/sites/dss/ds3-private06-Vue,"NODE_ENV":"production","HEADLESS_API_ROOT":"http://api/","HEADLESS_API_PATH":"http://api/api/v1/","HEADLESS_LEGACY_ROOT":"http://loader/"}).IMAGE_PATH;
  },
  getNodeEnv: function getNodeEnv() {
    return "production";
  },
  _checkForHeadless: function _checkForHeadless() {
    return window.location.protocol === 'http:';
  }
};

/***/ }),
/* 16 */,
/* 17 */,
/* 18 */,
/* 19 */,
/* 20 */,
/* 21 */,
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_HealthAssessment_js__ = __webpack_require__(581);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_HealthAssessment_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_HealthAssessment_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38eb2066_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_HealthAssessment_vue__ = __webpack_require__(582);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_HealthAssessment_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38eb2066_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_HealthAssessment_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
  get: function get(key) {
    if (localStorage.getItem(key)) {
      return localStorage.getItem(key);
    }
    return null;
  },
  save: function save(key, value) {
    localStorage.setItem(key, value);
  },
  remove: function remove(key) {
    if (localStorage.getItem(key)) {
      localStorage.removeItem(key);
    }
  }
};

/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _LegacyModifier = __webpack_require__(61);

var _LegacyModifier2 = _interopRequireDefault(_LegacyModifier);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  goToPage: function goToPage(url) {
    window.location.href = url;
  },
  goToLegacyPage: function goToLegacyPage(url, token) {
    window.location.href = _LegacyModifier2.default.modifyLegacyLink(url, token);
  }
};

/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  modifyLegacyLink: function modifyLegacyLink(currentHref, token) {
    if (currentHref === '#') {
      return currentHref;
    }
    var newHref = _ProcessWrapper2.default.getLegacyRoot() + currentHref;
    var separator = '?';
    if (currentHref.indexOf('?') > -1) {
      separator = '&';
    }
    if (token) {
      newHref += separator + 'token=' + token;
    }
    return newHref;
  }
};

/***/ }),
/* 62 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskData_js__ = __webpack_require__(404);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskData_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskData_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_29190150_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskData_vue__ = __webpack_require__(409);
function injectStyle (ssrContext) {
  __webpack_require__(403)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-29190150"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskData_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_29190150_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskData_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 63 */,
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _moment = __webpack_require__(0);

var _moment2 = _interopRequireDefault(_moment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  create: function create(dateString) {
    return (0, _moment2.default)(dateString);
  }
};

/***/ }),
/* 65 */,
/* 66 */,
/* 67 */,
/* 68 */,
/* 69 */,
/* 70 */,
/* 71 */,
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  router: null,
  setRouter: function setRouter(router) {
    this.router = router;
  },
  getRouter: function getRouter() {
    return this.router;
  }
};

/***/ }),
/* 73 */,
/* 74 */,
/* 75 */,
/* 76 */,
/* 77 */,
/* 78 */,
/* 79 */,
/* 80 */,
/* 81 */,
/* 82 */,
/* 83 */,
/* 84 */
/***/ (function(module, exports) {

module.exports = "data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="

/***/ }),
/* 85 */,
/* 86 */,
/* 87 */,
/* 88 */,
/* 89 */,
/* 90 */,
/* 91 */,
/* 92 */,
/* 93 */,
/* 94 */,
/* 95 */,
/* 96 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _sweetalert = __webpack_require__(325);

var _sweetalert2 = _interopRequireDefault(_sweetalert);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  callSwal: function callSwal(object, method) {
    (0, _sweetalert2.default)(object, method);
  },
  close: function close() {
    _sweetalert2.default.close();
  },
  showInputError: function showInputError(text) {
    _sweetalert2.default.showInputError(text);
  }
};

/***/ }),
/* 97 */,
/* 98 */,
/* 99 */,
/* 100 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_SiteSeal_js__ = __webpack_require__(372);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_SiteSeal_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_SiteSeal_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2afc105e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_SiteSeal_vue__ = __webpack_require__(374);
function injectStyle (ssrContext) {
  __webpack_require__(371)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-2afc105e"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_SiteSeal_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2afc105e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_SiteSeal_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 101 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_WelcomeText_js__ = __webpack_require__(412);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_WelcomeText_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_WelcomeText_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4cc36e2a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_WelcomeText_vue__ = __webpack_require__(413);
function injectStyle (ssrContext) {
  __webpack_require__(411)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4cc36e2a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_WelcomeText_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4cc36e2a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_WelcomeText_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 102 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.NOTIFICATIONS = exports.NAVIGATION_MENU = undefined;

var _main = __webpack_require__(6);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var NAVIGATION_MENU = exports.NAVIGATION_MENU = [{
  name: 'Directory',
  children: [{
    name: 'Contacts',
    link: 'manage/manage_contact.php'
  }, {
    name: 'Referral List',
    link: 'manage/manage_referredby.php'
  }, {
    name: 'Sleep Labs',
    link: 'manage/manage_sleeplab.php'
  }, {
    name: 'Corporate Contacts',
    link: 'manage/manage_fcontact.php'
  }]
}, {
  name: 'Reports',
  children: [{
    name: 'Ledger',
    link: 'manage/ledger_reportfull.php'
  }, {
    name: 'Claims',
    link: 'manage/manage_claims.php',
    populator: _symbols2.default.populators.populateClaims
  }, {
    name: 'Performance',
    link: 'manage/performance.php'
  }, {
    name: 'Pt. Screener',
    link: 'manage/manage_screeners.php?contacted=0'
  }, {
    name: 'VOB History',
    link: 'manage/manage_vobs.php'
  }, {
    name: 'Invoices',
    link: 'manage/invoice_history.php',
    shouldParse: _symbols2.default.getters.shouldShowInvoices
  }, {
    name: 'Fax History',
    link: 'manage/manage_faxes.php'
  }, {
    name: 'Home Sleep Tests',
    link: 'manage/manage_hst.php'
  }]
}, {
  name: 'Admin',
  children: [{
    name: 'Claim Setup',
    link: 'manage/manage_claim_setup.php'
  }, {
    name: 'Profile',
    link: 'manage/manage_profile.php'
  }, {
    name: 'Text',
    children: [{
      name: 'Custom Text',
      link: 'manage/manage_custom.php'
    }, {
      name: 'Custom Letters',
      link: 'manage/manage_custom_letters.php'
    }]
  }, {
    name: 'Change List',
    link: 'manage/change_list.php'
  }, {
    name: 'Transaction Code',
    link: 'manage/manage_transaction_code.php',
    shouldParse: _symbols2.default.getters.shouldShowTransactionCode
  }, {
    name: 'Staff',
    link: 'manage/manage_staff.php'
  }, {
    name: 'Scheduler',
    children: [{
      name: 'Resources',
      link: 'manage/manage_chairs.php'
    }, {
      name: 'Appointment Types',
      link: 'manage/manage_appts.php'
    }]
  }, {
    name: 'Export MD',
    action: _symbols2.default.actions.exportMDModal
  }, {
    name: 'DSS Files',
    link: 'manage/view_documents.php?cat=',
    childrenFrom: _symbols2.default.getters.documentCategories,
    childId: 'id',
    childName: 'name'
  }, {
    name: 'Manage Locations',
    link: 'manage/manage_locations.php'
  }, {
    name: 'Data Import',
    action: _symbols2.default.actions.dataImportModal
  }, {
    name: 'Enrollments',
    link: 'manage/manage_enrollment.php',
    shouldParse: _symbols2.default.getters.shouldShowEnrollments
  }]
}, {
  name: 'Pt. Screener App',
  link: '/screener',
  blank: true,
  legacy: false
}, {
  name: 'Forms',
  link: 'manage/manage_user_forms.php'
}, {
  name: 'Education',
  children: [{
    name: 'Dental Sleep Solutions Procedures Manual',
    link: 'manage/manual.php'
  }, {
    name: 'Dental Sleep Medicine Manual',
    link: 'manage/medicine_manual.php'
  }, {
    name: 'DSS Franchise Operations Manual',
    link: 'manage/operations_manual.php',
    shouldParse: _symbols2.default.getters.shouldShowFranchiseManual
  }, {
    name: 'Quick Facts Reference',
    link: 'manage/quick_facts.php'
  }, {
    name: 'Watch Videos',
    link: 'manage/videos.php'
  }, {
    name: 'Get C.E.',
    link: 'manage/edx_login.php',
    shouldParse: _symbols2.default.getters.shouldShowGetCE,
    blank: true
  }, {
    name: 'Certificates',
    link: 'manage/edx_certificate.php'
  }]
}, {
  name: 'SW Tutorials',
  route: 'sw-tutorials'
}, {
  name: 'Scheduler',
  link: 'manage/calendar.php'
}, {
  name: 'Manage Pts',
  link: 'manage/manage_patient.php'
}, {
  name: 'Device Selector',
  action: _symbols2.default.actions.deviceSelectorModal
}];

var NOTIFICATIONS = exports.NOTIFICATIONS = [{
  number: _main.NOTIFICATION_NUMBERS.patientNotifications,
  label: 'Web Portal',
  countZero: 'bad_count',
  countNonZero: 'bad_count',
  children: [{
    number: _main.NOTIFICATION_NUMBERS.patientContacts,
    label: 'Pt Contacts',
    link: 'manage/manage_patient_contacts.php',
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  }, {
    number: _main.NOTIFICATION_NUMBERS.patientInsurances,
    label: 'Pt Insurance',
    link: 'manage/manage_patient_insurance.php',
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  }, {
    number: _main.NOTIFICATION_NUMBERS.patientChanges,
    label: 'Pt Changes',
    link: 'manage/manage_patient_changes.php',
    countZero: 'bad_count',
    countNonZero: 'bad_count'
  }]
}, {
  number: _main.NOTIFICATION_NUMBERS.pendingLetters,
  label: 'Letters',
  link: 'manage/letters.php?status=pending',
  shouldParse: _symbols2.default.getters.shouldUseLetters,
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.unmailedLetters,
  label: 'Unmailed Letters',
  link: 'manage/letters.php?status=sent&mailed=0',
  shouldParse: _symbols2.default.getters.shouldShowUnmailedLettersNumber,
  countZero: 'bad_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.preAuth,
  label: 'VOBs',
  link: 'manage/manage_vobs.php?status=' + _main.DSS_CONSTANTS.DSS_PREAUTH_COMPLETE + '&viewed=0',
  countZero: 'good_count',
  countNonZero: 'great_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.rejectedPreAuth,
  label: 'Rejected VOBs',
  link: 'manage/manage_vobs.php?status=' + _main.DSS_CONSTANTS.DSS_PREAUTH_REJECTED + '&viewed=0',
  shouldParse: _symbols2.default.getters.shouldShowRejectedPreauthNumber,
  countZero: 'bad_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.hst,
  label: 'HSTs',
  link: 'manage/manage_hst.php?status=' + _main.DSS_CONSTANTS.DSS_HST_COMPLETE + '&viewed=0',
  countZero: 'good_count',
  countNonZero: 'great_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.rejectedHst,
  label: 'Rejected HSTs',
  link: 'manage/manage_hst.php?status=' + _main.DSS_CONSTANTS.DSS_HST_REJECTED + '&viewed=0',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.requestedHst,
  label: 'Unsent HSTs',
  link: 'manage/manage_hst.php?status=' + _main.DSS_CONSTANTS.DSS_HST_REQUESTED + '&viewed=0',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.pendingClaims,
  label: 'Pending Claims',
  link: 'manage/manage_claims.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.unmailedClaims,
  label: 'Unmailed Claims',
  link: 'manage/manage_claims.php?unmailed=1',
  shouldParse: _symbols2.default.getters.shouldShowUnmailedClaims,
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.rejectedClaims,
  label: 'Rejected Claims',
  link: 'manage/manage_rejected_claims.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.unsignedNotes,
  label: 'Unsigned Notes',
  link: 'manage/manage_unsigned_notes.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.rejectedPreAuth,
  label: 'Alerts',
  link: 'manage/manage_vobs.php?status=' + _main.DSS_CONSTANTS.DSS_PREAUTH_REJECTED + '&viewed=0',
  countZero: 'bad_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.faxAlerts,
  label: 'Failed Faxes',
  link: 'manage/manage_faxes.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.pendingDuplicates,
  label: 'Pending Duplicates',
  link: 'manage/pending_patient.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.emailBounces,
  label: 'Email Bounces',
  link: 'manage/manage_email_bounces.php',
  countZero: 'good_count',
  countNonZero: 'bad_count'
}, {
  number: _main.NOTIFICATION_NUMBERS.paymentReports,
  label: 'Payment Reports',
  link: 'manage/payment_reports_list.php?unviewed=1',
  shouldParse: _symbols2.default.getters.shouldShowPaymentReportsNumber,
  countZero: 'good_count',
  countNonZero: 'bad_count'
}];

/***/ }),
/* 103 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationLink_js__ = __webpack_require__(457);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationLink_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationLink_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2e83ea80_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NotificationLink_vue__ = __webpack_require__(458);
function injectStyle (ssrContext) {
  __webpack_require__(456)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-2e83ea80"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationLink_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2e83ea80_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NotificationLink_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 104 */,
/* 105 */,
/* 106 */,
/* 107 */,
/* 108 */,
/* 109 */,
/* 110 */,
/* 111 */,
/* 112 */,
/* 113 */,
/* 114 */,
/* 115 */,
/* 116 */,
/* 117 */,
/* 118 */,
/* 119 */,
/* 120 */,
/* 121 */,
/* 122 */,
/* 123 */,
/* 124 */,
/* 125 */,
/* 126 */,
/* 127 */,
/* 128 */,
/* 129 */,
/* 130 */,
/* 131 */,
/* 132 */,
/* 133 */,
/* 134 */,
/* 135 */,
/* 136 */,
/* 137 */,
/* 138 */,
/* 139 */,
/* 140 */,
/* 141 */,
/* 142 */,
/* 143 */,
/* 144 */,
/* 145 */,
/* 146 */,
/* 147 */,
/* 148 */,
/* 149 */,
/* 150 */,
/* 151 */,
/* 152 */,
/* 153 */,
/* 154 */,
/* 155 */,
/* 156 */,
/* 157 */,
/* 158 */,
/* 159 */,
/* 160 */,
/* 161 */,
/* 162 */,
/* 163 */,
/* 164 */,
/* 165 */,
/* 166 */,
/* 167 */,
/* 168 */,
/* 169 */,
/* 170 */,
/* 171 */,
/* 172 */,
/* 173 */,
/* 174 */,
/* 175 */,
/* 176 */,
/* 177 */,
/* 178 */,
/* 179 */,
/* 180 */,
/* 181 */,
/* 182 */,
/* 183 */,
/* 184 */,
/* 185 */,
/* 186 */,
/* 187 */,
/* 188 */,
/* 189 */,
/* 190 */,
/* 191 */,
/* 192 */,
/* 193 */,
/* 194 */,
/* 195 */,
/* 196 */,
/* 197 */,
/* 198 */,
/* 199 */,
/* 200 */,
/* 201 */,
/* 202 */,
/* 203 */,
/* 204 */,
/* 205 */,
/* 206 */,
/* 207 */,
/* 208 */,
/* 209 */,
/* 210 */,
/* 211 */,
/* 212 */,
/* 213 */,
/* 214 */,
/* 215 */,
/* 216 */,
/* 217 */,
/* 218 */,
/* 219 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  arrayAddUnique: function arrayAddUnique(array, value) {
    if (array.indexOf(value) === -1) {
      array.push(value);
    }
    return array;
  },
  arrayRemove: function arrayRemove(array, value) {
    var index = array.indexOf(value);
    if (index > -1) {
      array.splice(index, 1);
    }
    return array;
  }
};

/***/ }),
/* 220 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/screener-low_risk.cf2235e.png";

/***/ }),
/* 221 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/screener-moderate_risk.5cf4509.png";

/***/ }),
/* 222 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/screener-high_risk.ca9386d.png";

/***/ }),
/* 223 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/screener-severe_risk.daf906c.png";

/***/ }),
/* 224 */,
/* 225 */,
/* 226 */,
/* 227 */,
/* 228 */,
/* 229 */,
/* 230 */,
/* 231 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$sessio;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _screener = __webpack_require__(655);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$sessio = {}, (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.sessionData, {
  docId: 0,
  userId: 0
}), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.companyData, []), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.doctorName, ''), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.screenerWeights, {
  coMorbidity: 0,
  epworth: 0,
  survey: 0
}), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.contactData, _screener.INITIAL_CONTACT_DATA), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.epworthProps, []), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.epworthOptions, _screener.EPWORTH_OPTIONS), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.symptoms, _screener.INITIAL_SYMPTOMS), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.coMorbidityData, _screener.INITIAL_CO_MORBIDITY), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.cpap, {
  name: 'rx_cpap',
  label: 'Have you ever used CPAP before?',
  weight: 4,
  selected: 0
}), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.screenerToken, ''), (0, _defineProperty3.default)(_symbols$state$sessio, _symbols2.default.state.showFancybox, false), _symbols$state$sessio);

/***/ }),
/* 232 */,
/* 233 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _vue = __webpack_require__(28);

var _vue2 = _interopRequireDefault(_vue);

var _App = __webpack_require__(235);

var _App2 = _interopRequireDefault(_App);

var _router = __webpack_require__(238);

var _router2 = _interopRequireDefault(_router);

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _store = __webpack_require__(600);

var _store2 = _interopRequireDefault(_store);

var _jquery = __webpack_require__(27);

var _jquery2 = _interopRequireDefault(_jquery);

var _vueMoment = __webpack_require__(669);

var _vueMoment2 = _interopRequireDefault(_vueMoment);

var _vueVisible = __webpack_require__(670);

var _vueVisible2 = _interopRequireDefault(_vueVisible);

var _LegacyHref = __webpack_require__(671);

var _LegacyHref2 = _interopRequireDefault(_LegacyHref);

var _Unescape = __webpack_require__(672);

var _Unescape2 = _interopRequireDefault(_Unescape);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

window.$ = _jquery2.default;
window.jQuery = _jquery2.default;
var buttonUI = __webpack_require__(673);
var sliderUI = __webpack_require__(674);
window.$.fn.extend = buttonUI;
window.$.fn.extend = sliderUI;

window.eventHub = new _vue2.default();

_vue2.default.prototype.$http = _axios2.default;

_vue2.default.use(_vueMoment2.default);
_vue2.default.use(_vueVisible2.default);
_vue2.default.directive('legacy-href', _LegacyHref2.default);
_vue2.default.filter('unescape', _Unescape2.default);

new _vue2.default({
  el: '#app',
  router: _router2.default,
  store: _store2.default,
  template: '<App></App>',
  components: {
    App: _App2.default
  }
});

/***/ }),
/* 234 */,
/* 235 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_App_js__ = __webpack_require__(236);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_App_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_App_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_62e54517_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__ = __webpack_require__(237);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_App_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_62e54517_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_App_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 236 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _RouterKeeper = __webpack_require__(72);

var _RouterKeeper2 = _interopRequireDefault(_RouterKeeper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'app',
  beforeCreate: function beforeCreate() {
    var body = document.body;
    body.style.marginTop = '0';
    body.style.marginLeft = '0';
    body.style.marginRight = '0';
    body.style.marginBottom = '0';
  },
  created: function created() {
    _RouterKeeper2.default.setRouter(this.$router);
  }
};

/***/ }),
/* 237 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"id":"app"}},[_c('router-view')],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 238 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _vue = __webpack_require__(28);

var _vue2 = _interopRequireDefault(_vue);

var _vueRouter = __webpack_require__(239);

var _vueRouter2 = _interopRequireDefault(_vueRouter);

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _ManageRoot = __webpack_require__(259);

var _ManageRoot2 = _interopRequireDefault(_ManageRoot);

var _ScreenerRoot = __webpack_require__(357);

var _ScreenerRoot2 = _interopRequireDefault(_ScreenerRoot);

var _PageNotFound = __webpack_require__(360);

var _PageNotFound2 = _interopRequireDefault(_PageNotFound);

var _LocalStorageManager = __webpack_require__(59);

var _LocalStorageManager2 = _interopRequireDefault(_LocalStorageManager);

var _main = __webpack_require__(363);

var _main2 = _interopRequireDefault(_main);

var _screener = __webpack_require__(561);

var _screener2 = _interopRequireDefault(_screener);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_vue2.default.use(_vueRouter2.default);

exports.default = new _vueRouter2.default({
  mode: 'history',
  routes: [{
    path: '/manage',
    name: 'manage-root',
    component: _ManageRoot2.default,
    children: _main2.default
  }, {
    path: '/screener',
    name: 'screener-root',
    component: _ScreenerRoot2.default,
    children: _screener2.default
  }, {
    path: '*',
    component: _PageNotFound2.default
  }],
  beforeEach: function beforeEach(to, from, next) {
    if (to.matched.some(function (record) {
      return record.meta.requiresAuth;
    })) {
      var token = this.$store.state.main[_symbols2.default.state.mainToken];
      if (!token && !_LocalStorageManager2.default.get('token')) {
        next({ name: 'main-login' });
        return;
      }

      next();
      return;
    }
    _axios2.default.defaults.headers.common['Authorization'] = 'Bearer ' + _LocalStorageManager2.default.get('token');
    next();
  }
});

/***/ }),
/* 239 */,
/* 240 */,
/* 241 */,
/* 242 */,
/* 243 */,
/* 244 */,
/* 245 */,
/* 246 */,
/* 247 */,
/* 248 */,
/* 249 */,
/* 250 */,
/* 251 */,
/* 252 */,
/* 253 */,
/* 254 */,
/* 255 */,
/* 256 */,
/* 257 */,
/* 258 */,
/* 259 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageRoot_js__ = __webpack_require__(262);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageRoot_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageRoot_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4d6a3d87_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ManageRoot_vue__ = __webpack_require__(356);
function injectStyle (ssrContext) {
  __webpack_require__(260)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageRoot_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4d6a3d87_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ManageRoot_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 260 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 261 */,
/* 262 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _ModalRoot = __webpack_require__(263);

var _ModalRoot2 = _interopRequireDefault(_ModalRoot);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  components: {
    modalRoot: _ModalRoot2.default
  },
  created: function created() {
    document.body.className += ' main-template';
  },
  mounted: function mounted() {
    var _this = this;

    if (this.$route.query.hasOwnProperty('token')) {
      this.$store.dispatch(_symbols2.default.actions.dualAppLogin, this.$route.query.token).then(function () {}).catch(function () {
        _this.$router.push({ name: 'main-login' });
      });
      return;
    }
    if (!this.$store.state.main[_symbols2.default.state.mainToken]) {
      this.$router.push({ name: 'main-login' });
      return;
    }
    this.$router.push({ name: 'dashboard' });
  },

  methods: {
    hideSearchHints: function hideSearchHints() {
      this.$store.commit(_symbols2.default.mutations.hideSearchHints);
    }
  }
};

/***/ }),
/* 263 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ModalRoot_js__ = __webpack_require__(266);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ModalRoot_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ModalRoot_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_35a54246_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ModalRoot_vue__ = __webpack_require__(355);
function injectStyle (ssrContext) {
  __webpack_require__(264)
  __webpack_require__(265)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-35a54246"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ModalRoot_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_35a54246_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ModalRoot_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 264 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 265 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 266 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _keys = __webpack_require__(34);

var _keys2 = _interopRequireDefault(_keys);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _AddTask = __webpack_require__(271);

var _AddTask2 = _interopRequireDefault(_AddTask);

var _DeviceSelector = __webpack_require__(275);

var _DeviceSelector2 = _interopRequireDefault(_DeviceSelector);

var _ViewContact = __webpack_require__(288);

var _ViewContact2 = _interopRequireDefault(_ViewContact);

var _PatientAccessCode = __webpack_require__(297);

var _PatientAccessCode2 = _interopRequireDefault(_PatientAccessCode);

var _EditContact = __webpack_require__(320);

var _EditContact2 = _interopRequireDefault(_EditContact);

var _editReferredByContacts = __webpack_require__(331);

var _editReferredByContacts2 = _interopRequireDefault(_editReferredByContacts);

var _viewSleeplab = __webpack_require__(336);

var _viewSleeplab2 = _interopRequireDefault(_viewSleeplab);

var _editSleeplab = __webpack_require__(342);

var _editSleeplab2 = _interopRequireDefault(_editSleeplab);

var _viewCorporateContact = __webpack_require__(350);

var _viewCorporateContact2 = _interopRequireDefault(_viewCorporateContact);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      topPosition: 0,
      leftPosition: 0
    };
  },

  computed: {
    currentView: function currentView() {
      var componentName = this.$store.state.main[_symbols2.default.state.modal].name;
      if (this.hasComponent(componentName)) {
        return componentName;
      }

      return '';
    },
    currentProperties: function currentProperties() {
      var component = this.$store.state.main[_symbols2.default.state.modal];
      return component.params;
    },
    popupEnabled: function popupEnabled() {
      return !!this.currentView;
    }
  },
  created: function created() {
    window.addEventListener('keyup', this.onKeyUp);
    this.centering();
  },
  beforeDestroy: function beforeDestroy() {
    this.$off('keyup');
  },

  components: {
    addTask: _AddTask2.default,
    deviceSelector: _DeviceSelector2.default,

    viewContact: _ViewContact2.default,
    patientAccessCode: _PatientAccessCode2.default,
    editContact: _EditContact2.default,
    editReferredByContact: _editReferredByContacts2.default,
    viewSleeplab: _viewSleeplab2.default,
    editSleeplab: _editSleeplab2.default,
    viewCorporateContact: _viewCorporateContact2.default
  },
  methods: {
    centering: function centering() {
      var windowWidth = window.innerWidth;
      var windowHeight = window.innerHeight;
      var popupHeight = 400;
      var popupWidth = 750;
      var topPos = windowHeight / 2 - popupHeight / 2 + window.pageYOffset;
      var leftPos = windowWidth / 2 - popupWidth / 2;
      if (leftPos < 0) {
        leftPos = 10;
      }
      this.topPosition = topPos + 'px';
      this.leftPosition = leftPos + 'px';
    },
    disable: function disable() {
      if (!this.popupEnabled) {
        return;
      }
      if (this.$store.state.main[_symbols2.default.state.popupEdit]) {
        var confirmText = 'Are you sure you want to exit without saving?';
        if (!_Alerter2.default.isConfirmed(confirmText)) {
          return;
        }
      }
      this.$store.commit(_symbols2.default.mutations.resetModal);
    },
    onKeyUp: function onKeyUp(e) {
      if (!this.popupEnabled) {
        return;
      }
      var escapeCode = 27;
      if (e.keyCode === escapeCode && this.popupEnabled) {
        this.disable();
      }
    },
    hasComponent: function hasComponent(componentName) {
      var existedComponents = (0, _keys2.default)(this.$options.components);
      return existedComponents.indexOf(componentName) > -1;
    }
  }
};

/***/ }),
/* 267 */,
/* 268 */,
/* 269 */,
/* 270 */,
/* 271 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_AddTask_js__ = __webpack_require__(273);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_AddTask_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_AddTask_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_d295fd18_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_AddTask_vue__ = __webpack_require__(274);
function injectStyle (ssrContext) {
  __webpack_require__(272)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-d295fd18"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_AddTask_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_d295fd18_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_AddTask_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 272 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 273 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _vuejsDatepicker = __webpack_require__(83);

var _vuejsDatepicker2 = _interopRequireDefault(_vuejsDatepicker);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      currentTask: {
        id: 0,
        task: '',
        dueDate: null,
        status: false,
        responsible: this.$store.state.main[_symbols2.default.state.userInfo].plainUserId,
        patientId: 0,
        patientName: ''
      },
      validationError: ''
    };
  },

  computed: {
    task: function task() {
      return this.$store.state.tasks[_symbols2.default.state.currentTask];
    },
    patientId: function patientId() {
      return this.$store.state.main[_symbols2.default.state.modal].params.patientId;
    },
    userList: function userList() {
      return this.$store.state.tasks[_symbols2.default.state.responsibleUsers];
    }
  },
  components: {
    datepicker: _vuejsDatepicker2.default
  },
  created: function created() {
    var _this = this;

    this.$store.dispatch(_symbols2.default.actions.responsibleUsers);
    var taskId = this.$store.state.main[_symbols2.default.state.modal].params.id;
    if (taskId) {
      this.$store.dispatch(_symbols2.default.actions.getTask, taskId).then(function () {
        _this.currentTask = _this.task;
      });
    }
  },

  methods: {
    onSubmit: function onSubmit() {
      var _this2 = this;

      this.$store.dispatch(_symbols2.default.actions.addTask, this.currentTask).then(function () {
        _this2.$store.commit(_symbols2.default.mutations.resetModal);
      }).catch(function (response) {
        if (response.hasOwnProperty('message')) {
          _this2.validationError = response.message;
        }
      });
    },
    onDelete: function onDelete() {
      var _this3 = this;

      var confirmText = 'Are you sure you want to delete this task?';
      if (!_Alerter2.default.isConfirmed(confirmText)) {
        return;
      }
      this.$store.dispatch(_symbols2.default.actions.deleteTask, this.currentTask.id).then(function () {
        _this3.$store.commit(_symbols2.default.mutations.resetModal);
      });
    }
  }
};

/***/ }),
/* 274 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{attrs:{"name":"notesfrm","method":"post"}},[_c('table',{attrs:{"width":"700","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',{staticClass:"cat_head"},[_c('span',[_vm._v("Add new task")]),_vm._v(" "),(_vm.currentTask.patientName)?_c('span',[_vm._v("("+_vm._s(_vm.currentTask.patientName)+")")]):_vm._e()])]),_vm._v(" "),_c('tr',{directives:[{name:"show",rawName:"v-show",value:(_vm.validationError),expression:"validationError"}],attrs:{"id":"validation-error"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('span',{staticClass:"red"},[_vm._v(_vm._s(_vm.validationError))])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('label',{attrs:{"for":"task"}},[_vm._v("Task")]),_vm._v(" "),_c('span',{staticClass:"red"},[_vm._v("*")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.currentTask.task),expression:"currentTask.task"}],staticClass:"wide-input",attrs:{"type":"text","name":"task","id":"task"},domProps:{"value":(_vm.currentTask.task)},on:{"change":function($event){_vm.currentTask.task=$event.target.value},"input":function($event){if($event.target.composing){ return; }_vm.currentTask.task=$event.target.value}}})])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('label',[_vm._v("Due Date")]),_vm._v(" "),_c('span',{staticClass:"red"},[_vm._v("*")]),_vm._v(" "),_c('datepicker',{attrs:{"name":"due_date","id":"due_date","input-class":"calendar","wrapper-class":"calendar-wrapper","format":"MM/dd/yyyy"},model:{value:(_vm.currentTask.dueDate),callback:function ($$v) {_vm.currentTask.dueDate=$$v},expression:"currentTask.dueDate"}})],1)]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('label',{attrs:{"for":"responsibleid"}},[_vm._v("Assigned To:")]),_vm._v(" "),_c('span',{staticClass:"red"},[_vm._v("*")]),_vm._v(" "),_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.currentTask.responsible),expression:"currentTask.responsible"}],attrs:{"name":"responsibleid","id":"responsibleid"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.currentTask.responsible=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},_vm._l((_vm.userList),function(user){return _c('option',{domProps:{"value":user.id}},[_vm._v(_vm._s(user.fullName))])}))])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('label',{attrs:{"for":"status"}},[_vm._v("Completed:")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.currentTask.status),expression:"currentTask.status"}],attrs:{"type":"checkbox","value":"1","name":"status","id":"status"},domProps:{"checked":Array.isArray(_vm.currentTask.status)?_vm._i(_vm.currentTask.status,"1")>-1:(_vm.currentTask.status)},on:{"__c":function($event){var $$a=_vm.currentTask.status,$$el=$event.target,$$c=$$el.checked?(true):(false);if(Array.isArray($$a)){var $$v="1",$$i=_vm._i($$a,$$v);if($$el.checked){$$i<0&&(_vm.currentTask.status=$$a.concat([$$v]))}else{$$i>-1&&(_vm.currentTask.status=$$a.slice(0,$$i).concat($$a.slice($$i+1)))}}else{_vm.currentTask.status=$$c}}}})])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[(_vm.currentTask.id)?_c('a',{staticClass:"delete-task",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onDelete()}}},[_vm._v("Delete")]):_vm._e(),_vm._v(" "),_c('input',{staticClass:"addButton",attrs:{"type":"submit","value":"Add Task"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}})])])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 275 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSelector_js__ = __webpack_require__(277);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSelector_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSelector_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_259418d0_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceSelector_vue__ = __webpack_require__(287);
function injectStyle (ssrContext) {
  __webpack_require__(276)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-259418d0"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSelector_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_259418d0_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceSelector_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 276 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 277 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _DeviceSlider = __webpack_require__(278);

var _DeviceSlider2 = _interopRequireDefault(_DeviceSlider);

var _DeviceResults = __webpack_require__(283);

var _DeviceResults2 = _interopRequireDefault(_DeviceResults);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      showInstructions: false
    };
  },

  computed: {
    deviceGuideSettingOptions: function deviceGuideSettingOptions() {
      return this.$store.state.dashboard[_symbols2.default.state.deviceGuideSettingOptions];
    },
    patientName: function patientName() {
      if (this.$store.state.main[_symbols2.default.state.modal].params.hasOwnProperty('patientName')) {
        return this.$store.state.main[_symbols2.default.state.modal].params.patientName;
      }
      return '';
    }
  },
  components: {
    deviceSlider: _DeviceSlider2.default,
    deviceResults: _DeviceResults2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.getDeviceGuideSettingOptions);
  }
};

/***/ }),
/* 278 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSlider_js__ = __webpack_require__(280);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSlider_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSlider_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6816ef12_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceSlider_vue__ = __webpack_require__(282);
function injectStyle (ssrContext) {
  __webpack_require__(279)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6816ef12"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceSlider_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6816ef12_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceSlider_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 279 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 280 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _vueSliderComponent = __webpack_require__(281);

var _vueSliderComponent2 = _interopRequireDefault(_vueSliderComponent);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    labels: {
      type: Array,
      required: true
    },
    checked: {
      type: Boolean,
      default: false
    },
    checkedOption: {
      type: Number,
      required: true
    }
  },
  data: function data() {
    return {
      checkedOptionData: this.checkedOption
    };
  },

  computed: {
    checkedOptionName: function checkedOptionName() {
      if (this.labels.length >= this.checkedOption) {
        return this.labels[this.checkedOption];
      }
      return '';
    }
  },
  components: {
    vueSlider: _vueSliderComponent2.default
  },
  methods: {
    checkSetting: function checkSetting(event) {
      var data = {
        id: this.id,
        isChecked: event.target.checked
      };
      this.$store.commit(_symbols2.default.mutations.checkGuideSetting, data);
      this.$store.commit(_symbols2.default.mutations.deviceGuideResults, []);
    },
    moveSlider: function moveSlider(value) {
      var data = {
        id: this.id,
        value: value,
        labels: this.labels
      };
      this.$store.dispatch(_symbols2.default.actions.moveGuideSettingSlider, data);
      this.$store.commit(_symbols2.default.mutations.deviceGuideResults, []);
    }
  }
};

/***/ }),
/* 281 */,
/* 282 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"setting",attrs:{"id":'setting_' + _vm.id}},[_c('strong',{staticClass:"device-guide-setting-name"},[_vm._v(_vm._s(_vm.name))]),_vm._v(" "),_c('div',{staticClass:"slider-wrapper"},[_c('vue-slider',{ref:"slider",attrs:{"width":"80%","tooltip":false,"lazy":true,"piecewise":true,"data":_vm.labels},on:{"callback":function($event){_vm.moveSlider($event)}},model:{value:(_vm.checkedOptionData),callback:function ($$v) {_vm.checkedOptionData=$$v},expression:"checkedOptionData"}}),_vm._v(" "),_c('input',{staticClass:"imp_chk",attrs:{"type":"checkbox","id":'setting_imp_' + _vm.id,"name":'setting_imp_' + _vm.id,"value":"1"},domProps:{"checked":_vm.checked},on:{"change":function($event){_vm.checkSetting($event)}}})],1),_vm._v(" "),_c('div',{staticClass:"label",attrs:{"id":'label_' + _vm.id}},[_vm._v(_vm._s(_vm.checkedOptionName))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 283 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceResults_js__ = __webpack_require__(285);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceResults_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceResults_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fc3d2ad6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceResults_vue__ = __webpack_require__(286);
function injectStyle (ssrContext) {
  __webpack_require__(284)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-fc3d2ad6"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DeviceResults_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_fc3d2ad6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DeviceResults_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 284 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 285 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientName: String,
    required: true
  },
  computed: {
    deviceGuideResults: function deviceGuideResults() {
      return this.$store.state.dashboard[_symbols2.default.state.deviceGuideResults];
    }
  },
  methods: {
    updateDevice: function updateDevice(deviceId, name) {
      if (!this.patientName.length) {
        return;
      }
      var CONFIRM_TEXT = 'Do you want to select ' + name + ' for ' + this.patientName;
      if (!_Alerter2.default.isConfirmed(CONFIRM_TEXT)) {
        return;
      }
      this.$store.dispatch(_symbols2.default.actions.updateFlowDevice, deviceId);
    },
    onClickReset: function onClickReset() {
      this.$store.commit(_symbols2.default.mutations.resetDeviceGuideSettingOptions);
      this.$store.commit(_symbols2.default.mutations.deviceGuideResults, []);
    },
    onDeviceSubmit: function onDeviceSubmit() {
      this.$store.dispatch(_symbols2.default.actions.getDeviceGuideResults);
    }
  }
};

/***/ }),
/* 286 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('div',{staticClass:"sort-devices-button",attrs:{"id":"sort-devices-button"}},[_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onDeviceSubmit()}}},[_vm._v("Sort Devices")])]),_vm._v(" "),_c('div',{staticClass:"device-results-div",attrs:{"id":"device-results-div"}},[_c('ul',{attrs:{"id":"results"}},_vm._l((_vm.deviceGuideResults),function(deviceResult){return _c('li',{class:{ 'box_go': deviceResult.image_path }},[(_vm.patientName)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.updateDevice(deviceResult.id, deviceResult.name)}}},[_vm._v(_vm._s(deviceResult.name)+" ("+_vm._s(deviceResult.value)+")")]):_c('span',[_vm._v(_vm._s(deviceResult.name)+" ("+_vm._s(deviceResult.value)+")")])])})),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"id":"reset-link","href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickReset()}}},[_vm._v("Reset")])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 287 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"device-selector",attrs:{"id":"device-selector"}},[_c('div',{staticClass:"instructions"},[_c('a',{directives:[{name:"show",rawName:"v-show",value:(!_vm.showInstructions),expression:"!showInstructions"}],attrs:{"id":"ins_show","href":"#"},on:{"click":function($event){$event.preventDefault();_vm.showInstructions = true}}},[_vm._v("Instructions")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.showInstructions),expression:"showInstructions"}],attrs:{"id":"instructions"}},[_c('strong',[_vm._v("Instructions")]),_vm._v(" "),_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.showInstructions = false}}},[_vm._v("hide")]),_vm._v(" "),_vm._m(0)])]),_vm._v(" "),_c('h2',{staticClass:"device-selector-title",attrs:{"id":"device-selector-title"}},[_c('span',[_vm._v("Device C-Lect")]),(_vm.patientName)?_c('span',[_vm._v(" for "+_vm._s(_vm.patientName)+"?")]):_vm._e()]),_vm._v(" "),_c('form',{attrs:{"id":"device_form"}},_vm._l((_vm.deviceGuideSettingOptions),function(deviceGuideSetting){return _c('device-slider',{key:deviceGuideSetting.id,attrs:{"id":deviceGuideSetting.id,"name":deviceGuideSetting.name,"labels":deviceGuideSetting.labels,"checked":deviceGuideSetting.checked,"checked-option":deviceGuideSetting.checkedOption}})})),_vm._v(" "),_c('device-results',{attrs:{"patient-name":_vm.patientName}}),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})],1)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('ol',[_c('li',[_vm._v("Evaluate pt for each category using sliding bar")]),_vm._v(" "),_c('li',[_vm._v("Choose the three most important categories (if needed)")]),_vm._v(" "),_c('li',[_vm._v("Click on Sort Devices")]),_vm._v(" "),_c('li',[_vm._v("Click the device to add to Pt chart, or click \"Reset\" to start over.")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 288 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ViewContact_js__ = __webpack_require__(292);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ViewContact_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ViewContact_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1164295f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ViewContact_vue__ = __webpack_require__(296);
function injectStyle (ssrContext) {
  __webpack_require__(289)
  __webpack_require__(290)
  __webpack_require__(291)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1164295f"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ViewContact_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1164295f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ViewContact_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 289 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 290 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 291 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 292 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends2 = __webpack_require__(85);

var _extends3 = _interopRequireDefault(_extends2);

var _vuex = __webpack_require__(55);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: ['contactid'],
  data: function data() {
    return {
      legacyUrl: _ProcessWrapper2.default.getLegacyRoot()
    };
  },

  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({
    filteredContact: _symbols2.default.getters.filteredContact
  })),
  created: function created() {
    var contact = this.$store.state.contacts[_symbols2.default.state.contact];
    if (!contact.contactId && this.contactid) {
      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: this.contactid });
    }
  }
};

/***/ }),
/* 293 */,
/* 294 */,
/* 295 */,
/* 296 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"id":"view-contact"}},[_c('div',{staticStyle:{"padding-top":"10px","background":"#fff","width":"98%","height":"380px","margin-left":"1%"}},[_c('div',{staticClass:"info"},[_c('label',[_vm._v("Name: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v("\n                "+_vm._s(_vm.filteredContact.salutation)+" "+_vm._s(_vm.filteredContact.firstname)+" "+_vm._s(_vm.filteredContact.middlename)+" "+_vm._s(_vm.filteredContact.lastname)+"\n            ")])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Company: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.company))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Contact Type: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.contacttype))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Address: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.add1))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v(" ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.add2))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v(" ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v("\n                "+_vm._s(_vm.filteredContact.city)+" "+_vm._s(_vm.filteredContact.state)+" "+_vm._s(_vm.filteredContact.zip)+"\n            ")])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Phone: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.phone1))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Phone 2: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.phone2))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Fax: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.fax))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Email: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.email))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Notes: ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.filteredContact.notes))])]),_vm._v(" "),(_vm.filteredContact.corporate == '1')?_c('a',{staticStyle:{"margin-right":"10px","float":"right"},attrs:{"href":_vm.legacyUrl + 'view_fcontact.php?ed=' + _vm.filteredContact.contactid}},[_vm._v("View Full")]):_c('a',{staticStyle:{"margin-right":"10px","float":"right"},attrs:{"href":_vm.legacyUrl + 'add_contact.php?ed=' + _vm.filteredContact.contactid}},[_vm._v("Edit")])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 297 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientAccessCode_js__ = __webpack_require__(299);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientAccessCode_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientAccessCode_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_24740848_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientAccessCode_vue__ = __webpack_require__(319);
function injectStyle (ssrContext) {
  __webpack_require__(298)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-24740848"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientAccessCode_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_24740848_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientAccessCode_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 298 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 299 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      componentParams: {
        patientId: 0
      },
      patient: {},
      isResetAccessCode: false
    };
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },

  methods: {
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      var _this = this;

      this.componentParams = parameters;

      this.getPatientById(this.componentParams.patientId).then(function (response) {
        var data = response.data.data;

        if (data) {
          _this.patient = data;

          var accessCode = data.hasOwnProperty('access_code') && data.access_code > 0;
          if (!accessCode) {
            _this.resetPinCode(_this.componentParams.patientId);
          }
        }
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getPatientById', response: response });
      });

      this.$parent.popupEdit = false;
    },
    resetPinCode: function resetPinCode(patientId) {
      var _this2 = this;

      patientId = patientId || 0;

      this.resetPatientAccessCode(patientId).then(function (response) {
        var data = response.data.data;

        if (data.hasOwnProperty('access_code') && data.access_code > 0) {
          _this2.$set(_this2.patient, 'access_code', data.access_code);
          _this2.isResetAccessCode = true;
        }
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'resetPatientAccessCode', response: response });
      });
    },
    onClickReset: function onClickReset() {
      this.resetPinCode(this.componentParams.patientId);
    },
    onSubmit: function onSubmit() {
      var _this3 = this;

      this.createTempPinDocument(this.componentParams.patientId).then(function (response) {
        var data = response.data.data;

        if (data.hasOwnProperty('path_to_pdf') && data.path_to_pdf.length > 0) {
          alert('Temporary PIN document created and email sent to patient.');
          window.open(data.path_to_pdf);

          _this3.$parent.updateParentData(_this3.patient);

          _this3.$parent.disable();
        }
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'createTempPinDocument', response: response });
      });
    },
    getPatientById: function getPatientById(patientId) {
      patientId = patientId || 0;

      return _http2.default.get(_endpoints2.default.patients.show + '/' + patientId);
    },
    resetPatientAccessCode: function resetPatientAccessCode(patientId) {
      patientId = patientId || 0;

      return _http2.default.post(_endpoints2.default.patients.resetAccessCode + '/' + patientId);
    },
    createTempPinDocument: function createTempPinDocument(patientId) {
      patientId = patientId || 0;

      return _http2.default.post(_endpoints2.default.patients.temporaryPinDocument + '/' + patientId);
    }
  }
};

/***/ }),
/* 300 */,
/* 301 */,
/* 302 */,
/* 303 */,
/* 304 */,
/* 305 */,
/* 306 */,
/* 307 */,
/* 308 */,
/* 309 */,
/* 310 */,
/* 311 */,
/* 312 */,
/* 313 */,
/* 314 */,
/* 315 */,
/* 316 */,
/* 317 */,
/* 318 */,
/* 319 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('br'),_vm._v(" "),_c('h3',[_vm._v("Online Patient Registration Without Text Messaging:")]),_vm._v(" "),(_vm.isResetAccessCode)?[_c('p',[_vm._v("\n            Is this patient unable or unwilling to receive text messages?\n            If so you can generate a temporary PIN that will allow the user to register without receiving a text message activation code.\n        ")]),_vm._v(" "),_c('p',[_vm._v("Temporary PIN: "+_vm._s(_vm.patient.access_code))]),_vm._v(" "),_c('form',[_c('input',{attrs:{"type":"submit","name":"email_but","value":"Email Patient and Print PIN"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit($event)}}})])]:[_vm._v("\n        A temporary PIN was created for this patient on "+_vm._s(_vm._f("moment")(_vm.patient.access_code_date,"MM/DD/YYYY"))+" and is valid until "+_vm._s(_vm._f("moment")(_vm.patient.access_code_date,"add", "5 days", "MM/DD/YYYY"))+".\n        The temporary PIN is: "+_vm._s(_vm.patient.access_code)+".\n        "),_c('br'),_c('br'),_vm._v(" "),_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickReset($event)}}},[_vm._v("Generate New PIN")])]],2)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 320 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_EditContact_js__ = __webpack_require__(324);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_EditContact_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_EditContact_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_537454da_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_EditContact_vue__ = __webpack_require__(330);
function injectStyle (ssrContext) {
  __webpack_require__(321)
  __webpack_require__(322)
  __webpack_require__(323)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-537454da"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_EditContact_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_537454da_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_EditContact_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 321 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 322 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 323 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 324 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _SwalWrapper = __webpack_require__(96);

var _SwalWrapper2 = _interopRequireDefault(_SwalWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      componentParams: {},
      contactTypesOfPhysician: [],
      contact: {
        email: '',
        phone1: '',
        phone2: '',
        fax: '',
        preferredcontact: 'default',
        contacttypeid: 0
      },
      activeNonCorporateContactTypes: [],
      activeQualifiers: [],
      pendingVOB: {},
      contactSentLetters: [],
      contactPendingLetters: [],
      message: '',
      wasContactDataReceived: false,
      showNationalProviderId: true,
      showName: true
    };
  },

  computed: {
    googleLink: function googleLink() {
      var _this = this;

      var link = 'http://google.com/search?q=';
      var requiredFields = ['firstname', 'lastname', 'company', 'add1', 'city', 'state', 'zip'];

      var notEmptyRequiredFields = [];
      requiredFields.forEach(function (el) {
        if (_this.contact[el]) {
          notEmptyRequiredFields.push(_this.contact[el]);
        }
      });

      return link + notEmptyRequiredFields.join('+');
    }
  },
  watch: {
    pendingVOB: function pendingVOB() {
      var _this2 = this;

      if (!this.pendingVOB.length) {
        this.getContactSentLetters(this.contact.contactid).then(function (response) {
          var data = response.data.data;

          if (data.length) {
            _this2.contactSentLetters = data;
          }
        }).catch(function (response) {
          _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactSentLetters', response: response });
        });

        this.getContactPendingLetters(this.contact.contactid).then(function (response) {
          var data = response.data.data;

          if (data.length) {
            _this2.contactPendingLetters = data;
          }
        }).catch(function (response) {
          _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactPendingLetters', response: response });
        });
      }
    },
    'contact.contacttypeid': function contactContacttypeid() {
      if (this.contactTypesOfPhysician.indexOf(this.contact.contacttypeid) > -1) {
        this.$set(this.contact, 'salutation', 'Dr.');
        this.showName = true;
        this.showNationalProviderId = true;
      } else if (this.contact.contacttypeid === 11) {
        this.$set(this.contact, 'firstname', '');
        this.$set(this.contact, 'lastname', '');
        this.showName = false;
        this.showNationalProviderId = false;
      } else if (this.contact.contacttypeid > 0) {
        this.showName = true;
        this.showNationalProviderId = false;
      }
    },
    'contact.phone1': function contactPhone1() {
      var phone1 = this.contact.phone1.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
      this.$set(this.contact, 'phone1', phone1);
    },
    'contact.phone2': function contactPhone2() {
      var phone2 = this.contact.phone2.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
      this.$set(this.contact, 'phone2', phone2);
    },
    'contact.fax': function contactFax() {
      var fax = this.contact.fax.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
      this.$set(this.contact, 'fax', fax);
    },
    'contact': {
      handler: function handler() {
        if (this.wasContactDataReceived) {
          this.$parent.$parent.$refs.modal.popupEdit = true;
        }
      },
      deep: true
    }
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },
  mounted: function mounted() {
    var _this3 = this;

    _http2.default.post(_endpoints2.default.contactTypes.physician).then(function (response) {
      var data = response.data.data;

      if (data.physician_types) {
        _this3.$set(_this3, 'contactTypesOfPhysician', data.physician_types.split(','));
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactTypesOfPhysician', response: response });
    });

    _http2.default.post(_endpoints2.default.contactTypes.activeNonCorporate).then(function (response) {
      var data = response.data.data;

      if (data.length) {
        _this3.activeNonCorporateContactTypes = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getActiveNonCorporateContactTypes', response: response });
    });

    _http2.default.post(_endpoints2.default.qualifiers.active).then(function (response) {
      var data = response.data.data;

      if (data.length) {
        _this3.activeQualifiers = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getActiveQualifiers', response: response });
    });
  },

  methods: {
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      var _this4 = this;

      this.componentParams = parameters;

      if (this.componentParams.contactId > 0) {
        this.getContact(this.componentParams.contactId).then(function (response) {
          var data = response.data.data;

          if (data) {
            _this4.contact = data;

            _this4.$nextTick(function () {
              _this4.wasContactDataReceived = true;
            });
          }
        }).catch(function (response) {
          _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContact', response: response });
        });

        this.getPendingVOBsByContactId(this.componentParams.contactId).then(function (response) {
          var data = response.data.data;

          if (data.length) {
            _this4.pendingVOB = data;
          }
        }).catch(function (response) {
          _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getPendingVOBsByContactId', response: response });
        });
      }
    },
    onClickSubmit: function onClickSubmit() {
      var _this5 = this;

      this.message = '';

      if (this.componentParams.contactId > 0) {
        this.updateContact(this.contact).then(function () {
          _this5.$parent.updateParentData({ message: 'Edited Successfully' });
          _this5.$parent.$parent.$refs.modal.popupEdit = false;
          _this5.$parent.$parent.$refs.modal.disable();
          _this5.$router.push('/manage/contacts');
        }).catch(function (response) {
          if (response.status === 422) {
            _this5.displayErrorResponseFromAPI(response.data.data);
            return;
          }
          _this5.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'updateContact', response: response });
        });
      } else {
        this.insertContact(this.contact).then(function (response) {
          var data = response.data.data;

          if (data) {
            _this5.createWelcomeLetter(data.contactid, _this5.contact.contacttypeid).then(function (response) {
              var data = response.data.data;

              if (data.message) {
                _SwalWrapper2.default.callSwal({
                  title: '',
                  text: data.message,
                  type: 'info'
                });
              }
            }).catch(function (response) {
              _this5.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'createWelcomeLetter', response: response });
            });

            if (_this5.componentParams.activePat) {
              _this5.$router.push({
                path: '/add/patient',
                query: {
                  ed: _this5.componentParams.activePat,
                  preview: 1,
                  addtopat: 1,
                  pid: _this5.componentParams.activePat
                }
              });
            } else {
              _this5.$parent.passDataToComponents({ message: 'Added Successfully' });
              _this5.$router.push('/manage/contacts');
            }

            _this5.$parent.$parent.$refs.modal.popupEdit = false;
            _this5.$parent.$parent.$refs.modal.disable();
          }
        }).catch(function (response) {
          if (response.status === 422) {
            _this5.displayErrorResponseFromAPI(response.data.data);
            return;
          }
          _this5.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'updateContact', response: response });
        });
      }
    },
    displayErrorResponseFromAPI: function displayErrorResponseFromAPI(data) {
      var message = '<ul style="text-align: left">';

      for (var key in data.errors) {
        if (data.errors.hasOwnProperty(key)) {
          message += '<li>' + key + ': ' + data.errors[key].join(' ') + '</li>';
        }
      }

      message += '</ul>';

      _SwalWrapper2.default.callSwal({
        title: 'Wrong data!',
        text: message,
        html: true,
        type: 'error'
      });
    },
    onClickConfirm: function onClickConfirm(type, contactId) {
      var message = '';
      var query = {};
      contactId = contactId || 0;

      switch (type) {
        case 'delete-pending-vobs':
          message = 'Warning! There is currently a patient with this insurance company that has a pending VOB. Deleting this insurance company will cause the VOB to fail. Do you want to proceed?';
          query = { delid: contactId };
          break;
        case 'inactive':
          message = 'Letters have previously been sent to this contact therefore, for medical record purposes the contact cannot be deleted. This contact now will be marked as INACTIVE in your software and will no longer display in search results. Any pending letters associated with this contact will be deleted.';
          query = { inactiveid: contactId };
          break;
        case 'delete':
          message = 'Do Your Really want to Delete?.';
          query = { delid: contactId };
          break;
        case 'delete-pending-letters':
          message = 'Warning: There are pending letters associated with this contact.  When you delete the contact the pending letters will also be deleted. Proceed?';
          query = { delid: contactId };
          break;
      }

      if (confirm(message)) {
        this.$router.push({
          path: '/manage/contacts',
          query: query
        });
      }
    },
    onPreferredContactChange: function onPreferredContactChange() {
      var alertText = void 0;
      if (this.contact.preferredcontact === 'email' && this.contact.email.length === 0) {
        alertText = 'You must enter an email address to use email as the preferred contact method.';
        _Alerter2.default.alert(alertText);

        this.$set(this.contact, 'preferredcontact', '');
        this.$refs.email.focus();
      } else if (this.contact.preferredcontact === 'fax' && this.contact.fax.length === 0) {
        alertText = 'You must enter a fax number to use email as the preferred contact method.';
        _Alerter2.default.alert(alertText);

        this.$set(this.contact, 'preferredcontact', '');
        this.$refs.fax.focus();
      }
    },
    getContactPendingLetters: function getContactPendingLetters(contactId) {
      var data = { contact_id: contactId };

      return _http2.default.post(_endpoints2.default.letters.notDeliveredForContact, data);
    },
    getContactSentLetters: function getContactSentLetters(contactId) {
      var data = { contact_id: contactId };

      return _http2.default.post(_endpoints2.default.letters.deliveredForContact, data);
    },
    getFullName: function getFullName(contact) {
      var middlename = contact.middlename ? contact.middlename + ' ' : '';
      var fullname = contact.firstname + ' ' + middlename + contact.lastname;

      return fullname;
    },
    updateContact: function updateContact(contact) {
      var _this6 = this;

      var phoneFields = ['phone1', 'phone2', 'fax'];

      phoneFields.forEach(function (el) {
        if (_this6.contact.hasOwnProperty(el)) {
          _this6.contact[el] = _this6.contact[el].replace(/[^0-9]/g, '');
        }
      });

      return _http2.default.put(_endpoints2.default.contacts.update + '/' + contact.contactid, contact);
    },
    insertContact: function insertContact(contact) {
      var _this7 = this;

      var phoneFields = ['phone1', 'phone2', 'fax'];

      phoneFields.forEach(function (el) {
        if (_this7.contact.hasOwnProperty(el)) {
          _this7.contact[el] = _this7.contact[el].replace(/[^0-9]/g, '');
        }
      });

      return _http2.default.post(_endpoints2.default.contacts.store, contact);
    },
    getLetterInfoByDocId: function getLetterInfoByDocId() {
      return _http2.default.post(_endpoints2.default.users.letterInfo);
    },
    getContactType: function getContactType(contactTypeId) {
      return _http2.default.get(_endpoints2.default.contactTypes.show + '/' + contactTypeId);
    },
    getContact: function getContact(contactId) {
      return _http2.default.get(_endpoints2.default.contacts.show + '/' + contactId);
    },
    getPendingVOBsByContactId: function getPendingVOBsByContactId(contactId) {
      var data = { contact_id: contactId };

      return _http2.default.post(_endpoints2.default.insurancePreauth.pendingVob, data);
    },
    createWelcomeLetter: function createWelcomeLetter(templateId, contactTypeId) {
      var data = {
        template_id: templateId,
        contact_type_id: contactTypeId
      };

      return _http2.default.post(_endpoints2.default.letters.createWelcomeLetter, data);
    }
  }
};

/***/ }),
/* 325 */,
/* 326 */,
/* 327 */,
/* 328 */,
/* 329 */,
/* 330 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"id":"edit-contact"}},[(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_vm._v(_vm._s(_vm.message))]):_vm._e(),_vm._v(" "),_c('form',{staticStyle:{"width":"99%"},attrs:{"name":"contactfrm"}},[_c('table',{staticStyle:{"margin-left":"11px"},attrs:{"width":"99%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',{staticClass:"cat_head",attrs:{"colspan":"2"}},[(_vm.componentParams.ctype == 'ins')?_c('span',[_vm._v("Add Insurance Company")]):_c('span',[_vm._v("\n                        "+_vm._s((_vm.contact.contactid && _vm.contact.contactid > 0) ? 'Edit' : 'Add')+" "+_vm._s(_vm.componentParams.heading)+" Contact\n                        "),(_vm.contact.firstname && _vm.contact.lastname)?[_vm._v("\""+_vm._s(_vm.getFullName(_vm.contact))+"\"")]:_vm._e()],2)])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.contacttypeid),expression:"contact.contacttypeid"}],staticClass:"field text addr tbox",attrs:{"id":"contacttypeid","name":"contacttypeid","tabindex":"20"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.contacttypeid=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"0","disabled":""}},[_vm._v("Select a contact type")]),_vm._v(" "),_vm._l((_vm.activeNonCorporateContactTypes),function(type){return _c('option',{domProps:{"value":type.contacttypeid,"selected":type.contacttypeid == _vm.componentParams.type}},[_vm._v(_vm._s(type.contacttype))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"contacttype"}},[_vm._v("Contact Type")])])])])])])]),_vm._v(" "),(_vm.contact.contacttypeid && _vm.contact.contacttypeid > 0)?[(_vm.showName)?_c('tr',{staticClass:"content physician other"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                    Name\n                                    "),(_vm.componentParams.ctype && _vm.componentParams.ctype != 'ins')?_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]):_vm._e()]),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.salutation),expression:"contact.salutation"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"name":"salutation","id":"salutation","tabindex":"1"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.salutation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":""}}),_vm._v(" "),_c('option',{attrs:{"value":"Dr."}},[_vm._v("Dr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mr."}},[_vm._v("Mr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mrs."}},[_vm._v("Mrs.")]),_vm._v(" "),_c('option',{attrs:{"value":"Miss."}},[_vm._v("Miss.")])]),_vm._v(" "),_c('label',{attrs:{"for":"salutation"}},[_vm._v("Salutation")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.firstname),expression:"contact.firstname"}],staticClass:"field text addr tbox",attrs:{"id":"firstname","name":"firstname","type":"text","tabindex":"2","maxlength":"255"},domProps:{"value":(_vm.contact.firstname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.firstname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"firstname"}},[_vm._v("First Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.lastname),expression:"contact.lastname"}],staticClass:"field text addr tbox",attrs:{"id":"lastname","name":"lastname","type":"text","tabindex":"3","maxlength":"255"},domProps:{"value":(_vm.contact.lastname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.lastname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"lastname"}},[_vm._v("Last Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.middlename),expression:"contact.middlename"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"middlename","name":"middlename","type":"text","tabindex":"4","maxlength":"1"},domProps:{"value":(_vm.contact.middlename)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.middlename=$event.target.value}}}),_vm._v(" "),_vm._m(0)])])])])])]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_c('span',[_c('span',{staticStyle:{"color":"#000000"}},[_vm._v("Company\n                                            "),(_vm.componentParams.ctype == 'ins')?_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]):_vm._e()]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.company),expression:"contact.company"}],staticClass:"field text addr tbox",staticStyle:{"width":"575px"},attrs:{"id":"company","name":"company","type":"text","tabindex":"5","maxlength":"255"},domProps:{"value":(_vm.contact.company)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.company=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(1),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add1),expression:"contact.add1"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add1","name":"add1","type":"text","tabindex":"6","maxlength":"255"},domProps:{"value":(_vm.contact.add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add2),expression:"contact.add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add2","name":"add2","type":"text","tabindex":"7","maxlength":"255"},domProps:{"value":(_vm.contact.add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add2"}},[_vm._v("Address2")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.city),expression:"contact.city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"city","name":"city","type":"text","tabindex":"8","maxlength":"255"},domProps:{"value":(_vm.contact.city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.state),expression:"contact.state"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"state","name":"state","type":"text","tabindex":"9","maxlength":"255"},domProps:{"value":(_vm.contact.state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.zip),expression:"contact.zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"zip","name":"zip","type":"text","tabindex":"10","maxlength":"255"},domProps:{"value":(_vm.contact.zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"zip"}},[_vm._v("Zip / Post Code ")])])])])])])]),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone1),expression:"contact.phone1"}],staticClass:"extphonemask field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone1","name":"phone1","type":"text","tabindex":"11","maxlength":"255"},domProps:{"value":(_vm.contact.phone1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone1"}},[_vm._v("Phone 1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone2),expression:"contact.phone2"}],staticClass:"extphonemask field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone2","name":"phone2","type":"text","tabindex":"12","maxlength":"255"},domProps:{"value":(_vm.contact.phone2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone2"}},[_vm._v("Phone 2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.fax),expression:"contact.fax"}],ref:"fax",staticClass:"phonemask field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"fax","name":"fax","type":"text","tabindex":"13","maxlength":"255"},domProps:{"value":(_vm.contact.fax)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.fax=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"fax"}},[_vm._v("Fax")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.email),expression:"contact.email"}],ref:"email",staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"email","name":"email","type":"text","tabindex":"14","maxlength":"255"},domProps:{"value":(_vm.contact.email)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.email=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"email"}},[_vm._v("Email")])])])])])])]),_vm._v(" "),(_vm.showNationalProviderId)?_c('tr',{staticClass:"content physician"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',{staticStyle:{"font-size":"10px"}},[_vm._v("These fields required for Medicare referring physicians.")]),_c('br'),_vm._v(" "),_c('span',[_vm._v("\n                                        National Provider ID (NPI)\n                                        "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.national_provider_id),expression:"contact.national_provider_id"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"national_provider_id","name":"national_provider_id","type":"text","tabindex":"15","maxlength":"255"},domProps:{"value":(_vm.contact.national_provider_id)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.national_provider_id=$event.target.value}}})])])]),_vm._v(" "),_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("Other ID For Claim Forms")]),_vm._v(" "),_c('div',[_c('span',[_c('select',{staticClass:"field text addr tbox",attrs:{"id":"qualifier","name":"qualifier","tabindex":"16"}},[_c('option',{attrs:{"value":"0"}}),_vm._v(" "),_vm._l((_vm.activeQualifiers),function(qualifier){return _c('option',{domProps:{"value":qualifier.qualifierid}},[_vm._v("\n                                                "+_vm._s(qualifier.qualifier)+"\n                                            ")])})],2),_vm._v(" "),_c('label',{attrs:{"for":"qualifier"}},[_vm._v("Qualifier")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.qualifierid),expression:"contact.qualifierid"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"qualifierid","name":"qualifierid","type":"text","tabindex":"17","maxlength":"255"},domProps:{"value":(_vm.contact.qualifierid)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.qualifierid=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"qualifierid"}},[_vm._v("ID")])])])])])])]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other"},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("Notes:")]),_vm._v(" "),_c('div',[_c('span',{staticClass:"full"},[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.notes),expression:"contact.notes"}],staticClass:"field text addr tbox",staticStyle:{"width":"600px","height":"150px"},attrs:{"name":"notes","id":"notes","tabindex":"21"},domProps:{"value":(_vm.contact.notes)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.notes=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other",attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("Preferred Contact Method")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.preferredcontact),expression:"contact.preferredcontact"}],staticClass:"tbox",attrs:{"id":"preferredcontact","name":"preferredcontact","tabindex":"22"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.preferredcontact=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},_vm.onPreferredContactChange]}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select a method")]),_vm._v(" "),_c('option',{attrs:{"value":"fax"}},[_vm._v("Fax")]),_vm._v(" "),_c('option',{attrs:{"value":"paper"}},[_vm._v("Paper Mail")]),_vm._v(" "),_c('option',{attrs:{"value":"email"}},[_vm._v("Email")])]),_vm._v(" "),_c('br'),_vm._v(" \n                    ")])]),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other",attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("Status")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.status),expression:"contact.status"}],staticClass:"tbox",attrs:{"name":"status","id":"status","tabindex":"22"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.status=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"1"}},[_vm._v("Active")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("In-Active")])]),_vm._v(" "),_c('br'),_vm._v(" \n                    ")])]),_vm._v(" "),_c('tr',{staticClass:"content physician insurance other"},[_c('td',{attrs:{"colspan":"2","align":"center"}},[_c('span',{staticClass:"red"},[_vm._v("* Required Fields")]),_c('br'),_vm._v(" "),_c('a',{staticStyle:{"float":"left"},attrs:{"href":_vm.googleLink ? _vm.googleLink : '#',"id":"google_link","target":"_blank"}},[_vm._v("Google")]),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit"},domProps:{"value":((_vm.contact.contactid && _vm.contact.contactid > 0) ? 'Edit' : 'Add') + 'Contact'},on:{"click":function($event){$event.preventDefault();_vm.onClickSubmit($event)}}}),_vm._v(" "),(_vm.contact.contactid > 0)?[_c('a',{staticStyle:{"float":"right"},attrs:{"href":_vm.legacyUrl + 'duplicate_contact.php?winner=' + _vm.contact.contactid,"title":"Duplicate"}},[_vm._v("Is This a Duplicate?")]),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.pendingVOB.length)?_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickConfirm('delete-pending-vobs', _vm.contact.contactid)}}},[_vm._v("Delete")]):[(_vm.contactSentLetters.length > 0)?[_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickConfirm('inactive', _vm.contact.contactid)}}}),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit"},domProps:{"value":((_vm.contact.contactid && _vm.contact.contactid > 0) ? 'Edit' : 'Add') + 'Contact'},on:{"click":function($event){$event.preventDefault();_vm.onClickSubmit($event)}}}),_vm._v(" "),(_vm.contact.contactid > 0)?_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickConfirm('delete', _vm.contact.contactid)}}},[_vm._v("Delete ")]):[(_vm.contactPendingLetters.length > 0)?_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickConfirm('delete-pending-letters', _vm.contact.contactid)}}},[_vm._v("Delete ")]):_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickConfirm('delete', _vm.contact.contactid)}}},[_vm._v("Delete")])]]:_vm._e()]]:_vm._e()],2)])]:_vm._e()],2)])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{attrs:{"for":"middlename"}},[_vm._v("Middle "),_c('br'),_vm._v("Init")])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                    Address\n                                    "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 331 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editReferredByContacts_js__ = __webpack_require__(334);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editReferredByContacts_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_editReferredByContacts_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_823867ba_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editReferredByContacts_vue__ = __webpack_require__(335);
function injectStyle (ssrContext) {
  __webpack_require__(332)
  __webpack_require__(333)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-823867ba"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_editReferredByContacts_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_823867ba_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editReferredByContacts_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 332 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 333 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 334 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _keys = __webpack_require__(34);

var _keys2 = _interopRequireDefault(_keys);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'edit-referred-by-contacts',
  data: function data() {
    return {
      message: '',
      componentParams: {
        contactId: 0,
        addToPatient: 0,
        from: ''
      },
      contact: {
        salutation: '',
        preferredcontact: 'paper',
        qualifier: 0,
        status: 1
      },
      contactFullName: '',
      qualifiers: [],
      isContactDataFetched: false
    };
  },

  watch: {
    'contact': {
      handler: function handler() {
        if (this.componentParams.contactId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false;
          this.$parent.popupEdit = true;
        } else if (this.componentParams.contactId === 0) {
          this.$parent.popupEdit = true;
        }

        if (!this.isContactDataFetched) {
          this.isContactDataFetched = true;
        }
      },
      deep: true
    }
  },
  computed: {
    buttonText: function buttonText() {
      return this.componentParams.contactId > 0 ? 'Edit' : 'Add';
    }
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);

    this.$store.dispatch(_symbols2.default.actions.disablePopupEdit);
  },
  mounted: function mounted() {
    var _this = this;

    _http2.default.post(_endpoints2.default.qualifiers.active).then(function (response) {
      var data = response.data.data;

      if (data.length) {
        _this.qualifiers = data;
      }
    }).catch(function (response) {
      _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getActiveQualifiers', response: response });
    });
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },

  methods: {
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      var _this2 = this;

      this.componentParams = parameters;

      this.getReferredByContact(this.componentParams.contactId).then(function (response) {
        var data = response.data.data;

        if (data) {
          _this2.contactFullName = (data.firstname ? data.firstname + ' ' : '') + (data.middlename ? data.middlename + ' ' : '') + (data.lastname || '');

          _this2.contact = response.data.data;
        }
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getReferredByContact', response: response });
      });
    },
    onSubmit: function onSubmit() {
      var _this3 = this;

      if (this.validateContactData(this.contact)) {
        this.editContact(this.componentParams.contactId, this.contact).then(function (response) {
          var data = response.data.data;

          _this3.$parent.popupEdit = false;

          if (_this3.componentParams.addToPatient) {
            _this3.$router.push({
              name: 'edit-patient',
              query: { pid: _this3.componentParams.addToPatient }
            });
          } else {
            if (data.status) {
              _this3.$parent.updateParentData({ message: data.status });
              _this3.$parent.disable();
            }
          }

          if (_this3.componentParams.from === 'flowsheet3') {}
        }).catch(function (response) {
          _this3.parseFailedResponseOnEditingContact(response.data.data);

          _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'editContact', response: response });
        });
      }
    },
    parseFailedResponseOnEditingContact: function parseFailedResponseOnEditingContact(data) {
      var errors = data.errors.shift();

      if (errors !== undefined) {
        var objKeys = (0, _keys2.default)(errors);

        var arrOfMessages = objKeys.map(function (el) {
          return el + ':' + errors[el].join('|').toLowerCase();
        });

        alert(arrOfMessages.join('\n'));
      }
    },
    getReferredByContact: function getReferredByContact(id) {
      return _http2.default.get(_endpoints2.default.referredByContacts.show + '/' + id);
    },
    editContact: function editContact(contactId, contactFormData) {
      contactId = contactId || 0;

      var data = {
        contact_form_data: contactFormData
      };

      return _http2.default.post(_endpoints2.default.referredByContacts.edit + '/' + contactId, data);
    },
    isEmail: function isEmail(email) {
      return email && email.match(/^[\w.+-]+@\w+\.\w+$/);
    },
    walkThroughMessages: function walkThroughMessages(messages, contact) {
      for (var property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (contact[property] === undefined || contact[property].trim() === '') {
            alert(messages[property]);
            this.$refs[property].focus();
            return false;
          }
        }
      }
      return true;
    },
    validateContactData: function validateContactData(contact) {
      var messages = {
        firstname: 'First Name is Required',
        lastname: 'Last Name is Required'
      };

      if (!this.walkThroughMessages(messages, contact)) {
        return false;
      }

      if (!this.isEmail(contact.email)) {
        var alertText = 'In-Valid Email';
        alert(alertText);
        this.$refs.email.focus();
        return false;
      }

      if (contact.preferredcontact === 'fax' && contact.fax === '') {
        var _alertText = 'A fax number must be entered if preferred contact method is fax.';
        alert(_alertText);
        return false;
      }

      if (!contact.add1 && !contact.city && !contact.state && !contact.zip) {
        var confirmText = 'Warning! You have not entered an address for this contact. This contact will NOT receive correspondence from DSS. Are you sure you want to save without an address?';
        return confirm(confirmText);
      }

      return true;
    }
  }
};

/***/ }),
/* 335 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_vm._v(_vm._s(_vm.message))]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"referredbyfrm"}},[_c('table',{attrs:{"width":"700","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',{staticClass:"cat_head",attrs:{"colspan":"2"}},[_vm._v("\n                    "+_vm._s(_vm.buttonText)+" Referred By"+_vm._s(_vm.contactFullName ? (' "' + _vm.contactFullName + '"') : '')+"\n                ")])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(0),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.salutation),expression:"contact.salutation"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"name":"salutation","id":"salutation","tabindex":"1"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.salutation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"","disabled":""}}),_vm._v(" "),_c('option',{attrs:{"value":"Dr."}},[_vm._v("Dr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mr."}},[_vm._v("Mr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mrs."}},[_vm._v("Mrs.")]),_vm._v(" "),_c('option',{attrs:{"value":"Ms."}},[_vm._v("Ms.")]),_vm._v(" "),_c('option',{attrs:{"value":"Miss."}},[_vm._v("Miss.")])]),_vm._v(" "),_c('label',{attrs:{"for":"salutation"}},[_vm._v("Salutation")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.firstname),expression:"contact.firstname"}],ref:"firstname",staticClass:"field text addr tbox",attrs:{"id":"firstname","name":"firstname","type":"text","tabindex":"2","maxlength":"255","placeholder":"Firstname"},domProps:{"value":(_vm.contact.firstname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.firstname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"firstname"}},[_vm._v("First Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.lastname),expression:"contact.lastname"}],ref:"lastname",staticClass:"field text addr tbox",attrs:{"id":"lastname","name":"lastname","type":"text","tabindex":"3","maxlength":"255","placeholder":"Lastname"},domProps:{"value":(_vm.contact.lastname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.lastname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"lastname"}},[_vm._v("Last Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.middlename),expression:"contact.middlename"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"middlename","name":"middlename","type":"text","tabindex":"4","maxlength":"1","placeholder":"Middle"},domProps:{"value":(_vm.contact.middlename)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.middlename=$event.target.value}}}),_vm._v(" "),_vm._m(1)])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_c('span',[_c('span',{staticStyle:{"color":"#000000"}},[_vm._v("Company")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.company),expression:"contact.company"}],staticClass:"field text addr tbox",staticStyle:{"width":"575px"},attrs:{"id":"company","name":"company","type":"text","tabindex":"5","maxlength":"255","placeholder":"Company"},domProps:{"value":(_vm.contact.company)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.company=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(2),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add1),expression:"contact.add1"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add1","name":"add1","type":"text","tabindex":"6","maxlength":"255","placeholder":"1st Address"},domProps:{"value":(_vm.contact.add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add2),expression:"contact.add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add2","name":"add2","type":"text","tabindex":"7","maxlength":"255","placeholder":"2nd Address"},domProps:{"value":(_vm.contact.add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add2"}},[_vm._v("Address2")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.city),expression:"contact.city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"city","name":"city","type":"text","tabindex":"8","maxlength":"255","placeholder":"City"},domProps:{"value":(_vm.contact.city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.state),expression:"contact.state"}],staticClass:"field text addr tbox",staticStyle:{"width":"26px"},attrs:{"id":"state","name":"state","type":"text","tabindex":"9","maxlength":"2"},domProps:{"value":(_vm.contact.state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.zip),expression:"contact.zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"zip","name":"zip","type":"text","tabindex":"10","maxlength":"255","placeholder":"Zip Code"},domProps:{"value":(_vm.contact.zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"zip"}},[_vm._v("Zip / Post Code ")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone1),expression:"contact.phone1"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone1","name":"phone1","type":"text","tabindex":"11","maxlength":"255","placeholder":"1st Phone Number"},domProps:{"value":(_vm.contact.phone1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone1"}},[_vm._v("Phone 1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone2),expression:"contact.phone2"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone2","name":"phone2","type":"text","tabindex":"12","maxlength":"255","placeholder":"2nd Phone Number"},domProps:{"value":(_vm.contact.phone2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone2"}},[_vm._v("Phone 2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.fax),expression:"contact.fax"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"fax","name":"fax","type":"text","tabindex":"13","maxlength":"255","placeholder":"Fax"},domProps:{"value":(_vm.contact.fax)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.fax=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"fax"}},[_vm._v("Fax")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.email),expression:"contact.email"}],ref:"email",staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"email","name":"email","type":"text","tabindex":"14","maxlength":"255","placeholder":"Email"},domProps:{"value":(_vm.contact.email)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.email=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"email"}},[_vm._v("Email")])])])])])])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","width":"30%"}},[_vm._v("\n                    Preferred Contact Method\n                ")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top","width":"70%"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.preferredcontact),expression:"contact.preferredcontact"}],staticClass:"tbox",attrs:{"id":"preferredcontact","name":"preferredcontact","tabindex":"22"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.preferredcontact=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"paper"}},[_vm._v("Paper Mail")]),_vm._v(" "),_c('option',{attrs:{"value":"fax"}},[_vm._v("Fax")]),_vm._v(" "),_c('option',{attrs:{"value":"email"}},[_vm._v("Email")])]),_vm._v(" "),_c('br'),_vm._v(" \n                ")])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_vm._v("\n                                    National Provider ID\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.national_provider_id),expression:"contact.national_provider_id"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"national_provider_id","name":"national_provider_id","type":"text","tabindex":"15","maxlength":"255","placeholder":"National Provider Id"},domProps:{"value":(_vm.contact.national_provider_id)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.national_provider_id=$event.target.value}}})])])]),_vm._v(" "),_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("Other ID For Claim Forms")]),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.qualifier),expression:"contact.qualifier"}],staticClass:"field text addr tbox",attrs:{"id":"qualifier","name":"qualifier","tabindex":"16"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.qualifier=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"0","disabled":""}}),_vm._v(" "),_vm._l((_vm.qualifiers),function(qualifier){return _c('option',{domProps:{"value":qualifier.qualifierid}},[_vm._v("\n                                            "+_vm._s(qualifier.qualifier)+"\n                                        ")])})],2),_vm._v(" "),_c('label',{attrs:{"for":"qualifier"}},[_vm._v("Qualifier")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.qualifierid),expression:"contact.qualifierid"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"qualifierid","name":"qualifierid","type":"text","tabindex":"17","maxlength":"255","placeholder":"Qualifier"},domProps:{"value":(_vm.contact.qualifierid)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.qualifierid=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"qualifierid"}},[_vm._v("ID")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Notes:\n                            ")]),_vm._v(" "),_c('div',[_c('span',{staticClass:"full"},[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.notes),expression:"contact.notes"}],staticClass:"field text addr tbox",staticStyle:{"width":"600px","height":"150px"},attrs:{"name":"notes","id":"notes","tabindex":"21"},domProps:{"value":(_vm.contact.notes)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.notes=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("\n                    Status\n                ")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.status),expression:"contact.status"}],staticClass:"tbox",attrs:{"name":"status","tabindex":"22"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.status=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"1"}},[_vm._v("Active")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("In-Active")])]),_vm._v(" "),_c('br'),_vm._v(" \n                ")])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2","align":"center"}},[_c('span',{staticClass:"red"},[_vm._v("\n                        * Required Fields\n                    ")]),_c('br'),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit"},domProps:{"value":_vm.buttonText + ' Referred By'},on:{"click":function($event){$event.preventDefault();_vm.onSubmit($event)}}})])])])])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Name\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{attrs:{"for":"middlename"}},[_vm._v("Middle "),_c('br'),_vm._v("Init")])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Address\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 336 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewSleeplab_js__ = __webpack_require__(340);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewSleeplab_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_viewSleeplab_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_916bfb7a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_viewSleeplab_vue__ = __webpack_require__(341);
function injectStyle (ssrContext) {
  __webpack_require__(337)
  __webpack_require__(338)
  __webpack_require__(339)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-916bfb7a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewSleeplab_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_916bfb7a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_viewSleeplab_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 337 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 338 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 339 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 340 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      componentParam: {
        sleeplabId: 0
      },
      sleeplab: {}
    };
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);

    this.$parent.popupEdit = false;
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },

  methods: {
    onClickEditSleeplab: function onClickEditSleeplab() {
      this.$parent.display('edit-sleeplab');
      this.$parent.setComponentParameters({ sleeplabId: this.componentParams.sleeplabId || 0 });
    },
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      this.componentParams = parameters;

      this.fetchSleeplab(this.componentParams.sleeplabId);
    },
    fetchSleeplab: function fetchSleeplab(id) {
      var _this = this;

      this.getSleeplab(id).then(function (response) {
        var data = response.data.data;

        if (data) {
          data['name'] = data.salutation + ' ' + data.firstname + ' ' + data.middlename + ' ' + data.lastname;

          var phoneFields = ['phone1', 'phone2', 'fax'];

          phoneFields.forEach(function (el) {
            if (data.hasOwnProperty(el)) {
              data[el] = data[el].replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            }
          });

          _this.sleeplab = data;
        }
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getSleeplab', response: response });
      });
    },
    getSleeplab: function getSleeplab(id) {
      return _http2.default.get(_endpoints2.default.sleeplabs.show + '/' + id);
    }
  }
};

/***/ }),
/* 341 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticStyle:{"margin-top":"3px","padding-top":"10px","background":"#fff","width":"98%","height":"380px","margin-left":"1%"}},[_c('div',{staticClass:"info"},[_c('label',[_vm._v("Name:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.name))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Company:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.company))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Address:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.add1))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v(" ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.add2))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v(" ")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.city)+" "+_vm._s(_vm.sleeplab.state)+" "+_vm._s(_vm.sleeplab.zip))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Phone:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.phone1))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Phone 2:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.phone2))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Fax:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.fax))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Email:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.email))])]),_vm._v(" "),_c('div',{staticClass:"info"},[_c('label',[_vm._v("Notes:")]),_vm._v(" "),_c('span',{staticClass:"value"},[_vm._v(_vm._s(_vm.sleeplab.notes))])]),_vm._v(" "),_c('a',{staticStyle:{"margin-right":"10px","float":"right"},attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickEditSleeplab($event)}}},[_vm._v("Edit")])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 342 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editSleeplab_js__ = __webpack_require__(345);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editSleeplab_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_editSleeplab_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_43e1a963_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editSleeplab_vue__ = __webpack_require__(349);
function injectStyle (ssrContext) {
  __webpack_require__(343)
  __webpack_require__(344)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-43e1a963"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_editSleeplab_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_43e1a963_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editSleeplab_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 343 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 344 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 345 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _keys = __webpack_require__(34);

var _keys2 = _interopRequireDefault(_keys);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _PhoneFormatter = __webpack_require__(346);

var _PhoneFormatter2 = _interopRequireDefault(_PhoneFormatter);

var _awesomeMask = __webpack_require__(98);

var _awesomeMask2 = _interopRequireDefault(_awesomeMask);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'edit-sleeplab',
  data: function data() {
    return {
      phoneMask: '(999) 999-9999',
      componentParams: {
        sleeplabId: 0
      },
      sleeplab: {
        salutation: '',
        status: 1
      },
      message: '',
      fullName: '',
      isContactDataFetched: false,
      phoneFields: ['phone1', 'phone2', 'fax']
    };
  },

  directives: {
    mask: _awesomeMask2.default
  },
  watch: {
    'sleeplab': {
      handler: function handler() {
        if (this.componentParams.sleeplabId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false;
          this.$parent.popupEdit = true;
        } else if (this.componentParams.sleeplabId === 0) {
          this.$parent.popupEdit = true;
        }

        if (!this.isContactDataFetched) {
          this.isContactDataFetched = true;
        }
      },
      deep: true
    }
  },
  computed: {
    buttonText: function buttonText() {
      return this.sleeplab.sleeplabid > 0 ? 'Edit' : 'Add';
    },
    googleLink: function googleLink() {
      var _this = this;

      var link = 'http://google.com/search?q=';
      var requiredFields = ['firstname', 'lastname', 'company', 'add1', 'city', 'state', 'zip'];

      var notEmptyRequiredFields = [];
      requiredFields.forEach(function (el) {
        if (_this.sleeplab[el]) {
          notEmptyRequiredFields.push(_this.sleeplab[el]);
        }
      });

      return link + notEmptyRequiredFields.join('+');
    }
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);

    this.$parent.popupEdit = false;
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },

  methods: {
    onClickDeleteSleeplab: function onClickDeleteSleeplab(sleeplabId) {
      var confirmText = 'Do Your Really want to Delete?';
      if (confirm(confirmText)) {
        this.$parent.disable();

        this.$router.push({
          name: 'sleeplabs',
          query: {
            delid: sleeplabId
          }
        });
      }
    },
    onSubmit: function onSubmit() {
      var _this2 = this;

      if (this.validateSleeplabData(this.sleeplab)) {
        this.editSleeplab(this.componentParams.sleeplabId, this.sleeplab).then(function (response) {
          var data = response.data.data;

          _this2.$parent.popupEdit = false;

          if (data.status) {
            _this2.$parent.updateParentData({ message: data.status });
            _this2.$parent.disable();
          }
        }).catch(function (response) {
          _this2.parseFailedResponseOnEditingSleeplab(response.data.data);

          _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'editSleeplab', response: response });
        });
      }
    },
    parseFailedResponseOnEditingSleeplab: function parseFailedResponseOnEditingSleeplab(data) {
      var errors = data.errors.shift();

      if (errors !== undefined) {
        var objKeys = (0, _keys2.default)(errors);

        var arrOfMessages = objKeys.map(function (el) {
          return el + ':' + errors[el].join('|').toLowerCase();
        });

        _Alerter2.default.alert(arrOfMessages.join('\n'));
      }
    },
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      this.componentParams = parameters;

      this.fetchSleeplab(this.componentParams.sleeplabId);
    },
    fetchSleeplab: function fetchSleeplab(id) {
      var _this3 = this;

      this.getSleeplab(id).then(function (response) {
        var data = response.data.data;

        if (data) {
          _this3.fullName = (data.firstname ? data.firstname + ' ' : '') + (data.middlename ? data.middlename + ' ' : '') + (data.lastname || '');

          _this3.phoneFields.forEach(function (el) {
            if (data.hasOwnProperty(el)) {
              data[el] = _PhoneFormatter2.default.phoneForDisplaying(data[el]);
            }
          });

          _this3.sleeplab = data;
        }
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getSleeplab', response: response });
      });
    },
    getSleeplab: function getSleeplab(id) {
      id = id || 0;

      return _http2.default.get(_endpoints2.default.sleeplabs.show + '/' + id);
    },
    editSleeplab: function editSleeplab(sleeplabId, sleeplabFormData) {
      this.phoneFields.forEach(function (el) {
        if (sleeplabFormData.hasOwnProperty(el)) {
          sleeplabFormData[el] = _PhoneFormatter2.default.phoneForStoring(sleeplabFormData[el]);
        }
      });

      var data = {
        sleeplab_form_data: sleeplabFormData
      };

      return _http2.default.post(_endpoints2.default.sleeplabs.edit + '/' + sleeplabId, data);
    },
    isEmail: function isEmail(email) {
      return email && email.match(/^[\w.+-]+@\w+\.\w+$/);
    },
    walkThroughMessages: function walkThroughMessages(messages, contact) {
      for (var property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (contact[property] === undefined || contact[property].trim() === '') {
            alert(messages[property]);
            this.$refs[property].focus();
            return false;
          }
        }
      }

      return true;
    },
    validateSleeplabData: function validateSleeplabData(sleeplab) {
      var messages = {
        company: 'Lab Name is Required',
        firstname: 'Firstname is Required',
        lastname: 'Lastname is Required',
        add1: 'Address1 is Required',
        city: 'City is Required',
        state: 'State is Required',
        zip: 'Zip is Required'
      };

      if (!this.walkThroughMessages(messages, sleeplab)) {
        return false;
      }

      if (!this.isEmail(sleeplab.email)) {
        var alertText = 'In-Valid Email';
        alert(alertText);
        this.$refs.email.focus();
        return false;
      }

      return true;
    }
  }
};

/***/ }),
/* 346 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  methods: {
    phoneForDisplaying: function phoneForDisplaying(phone) {
      phone = phone || '';
      return phone.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    },
    phoneForStoring: function phoneForStoring(phone) {
      phone = phone || '';
      return phone.replace(/[^0-9]/g, '');
    }
  }
};

/***/ }),
/* 347 */,
/* 348 */,
/* 349 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_vm._v(_vm._s(_vm.message))]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"sleeplabfrm","onSubmit":"return sleeplababc(this)"}},[_c('table',{attrs:{"width":"700","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',{staticClass:"cat_head",attrs:{"colspan":"2"}},[_vm._v("\n                   "+_vm._s(_vm.buttonText)+" Sleep Lab"+_vm._s(_vm.fullName ? (' "' + _vm.fullName + '"') : '')+"\n                ")])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_c('span',[_c('span',{staticStyle:{"color":"#000000"}},[_vm._v("Lab Name")]),_vm._v(" "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.company),expression:"sleeplab.company"}],ref:"company",staticClass:"field text addr tbox",staticStyle:{"width":"575px"},attrs:{"id":"company","name":"company","type":"text","tabindex":"1","maxlength":"255"},domProps:{"value":(_vm.sleeplab.company)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.company=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("Name")]),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.salutation),expression:"sleeplab.salutation"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"name":"salutation","id":"salutation","tabindex":"1"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.sleeplab.salutation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":""}}),_vm._v(" "),_c('option',{attrs:{"value":"Dr."}},[_vm._v("Dr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mr."}},[_vm._v("Mr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mrs."}},[_vm._v("Mrs.")]),_vm._v(" "),_c('option',{attrs:{"value":"Ms."}},[_vm._v("Ms.")]),_vm._v(" "),_c('option',{attrs:{"value":"Miss."}},[_vm._v("Miss.")])]),_vm._v(" "),_c('label',{attrs:{"for":"salutation"}},[_vm._v("Salutation")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.firstname),expression:"sleeplab.firstname"}],ref:"firstname",staticClass:"field text addr tbox",attrs:{"id":"firstname","name":"firstname","type":"text","tabindex":"2","maxlength":"255"},domProps:{"value":(_vm.sleeplab.firstname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.firstname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"firstname"}},[_vm._v("First Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.lastname),expression:"sleeplab.lastname"}],ref:"lastname",staticClass:"field text addr tbox",attrs:{"id":"lastname","name":"lastname","type":"text","tabindex":"3","maxlength":"255"},domProps:{"value":(_vm.sleeplab.lastname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.lastname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"lastname"}},[_vm._v("Last Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.middlename),expression:"sleeplab.middlename"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"middlename","name":"middlename","type":"text","tabindex":"4","maxlength":"1"},domProps:{"value":(_vm.sleeplab.middlename)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.middlename=$event.target.value}}}),_vm._v(" "),_vm._m(0)])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(1),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.add1),expression:"sleeplab.add1"}],ref:"add1",staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add1","name":"add1","type":"text","tabindex":"6","maxlength":"255"},domProps:{"value":(_vm.sleeplab.add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.add2),expression:"sleeplab.add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add2","name":"add2","type":"text","tabindex":"7","maxlength":"255"},domProps:{"value":(_vm.sleeplab.add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add2"}},[_vm._v("Address2")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.city),expression:"sleeplab.city"}],ref:"city",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"city","name":"city","type":"text","tabindex":"8","maxlength":"255"},domProps:{"value":(_vm.sleeplab.city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.state),expression:"sleeplab.state"}],ref:"state",staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"state","name":"state","type":"text","tabindex":"9","maxlength":"255"},domProps:{"value":(_vm.sleeplab.state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.zip),expression:"sleeplab.zip"}],ref:"zip",staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"zip","name":"zip","type":"text","tabindex":"10","maxlength":"255"},domProps:{"value":(_vm.sleeplab.zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"zip"}},[_vm._v("Zip / Post Code ")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.phone1),expression:"sleeplab.phone1"},{name:"mask",rawName:"v-mask",value:(_vm.phoneMask),expression:"phoneMask"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone1","name":"phone1","type":"text","tabindex":"11","maxlength":"255"},domProps:{"value":(_vm.sleeplab.phone1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.phone1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone1"}},[_vm._v("Phone 1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.phone2),expression:"sleeplab.phone2"},{name:"mask",rawName:"v-mask",value:(_vm.phoneMask),expression:"phoneMask"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone2","name":"phone2","type":"text","tabindex":"12","maxlength":"255"},domProps:{"value":(_vm.sleeplab.phone2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.phone2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone2"}},[_vm._v("Phone 2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.fax),expression:"sleeplab.fax"},{name:"mask",rawName:"v-mask",value:(_vm.phoneMask),expression:"phoneMask"}],staticClass:"phonemask field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"fax","name":"fax","type":"text","tabindex":"13","maxlength":"255"},domProps:{"value":(_vm.sleeplab.fax)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.fax=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"fax"}},[_vm._v("Fax")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.email),expression:"sleeplab.email"}],ref:"email",staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"email","name":"email","type":"text","tabindex":"14","maxlength":"255"},domProps:{"value":(_vm.sleeplab.email)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.email=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"email"}},[_vm._v("Email")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Notes:\n                            ")]),_vm._v(" "),_c('div',[_c('span',{staticClass:"full"},[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.notes),expression:"sleeplab.notes"}],staticClass:"field text addr tbox",staticStyle:{"width":"600px","height":"150px"},attrs:{"name":"notes","id":"notes","tabindex":"21"},domProps:{"value":(_vm.sleeplab.notes)},on:{"input":function($event){if($event.target.composing){ return; }_vm.sleeplab.notes=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("\n                    Status\n                ")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.sleeplab.status),expression:"sleeplab.status"}],staticClass:"tbox",attrs:{"name":"status","tabindex":"22"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.sleeplab.status=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"1"}},[_vm._v("Active")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("In-Active")])]),_vm._v(" "),_c('br'),_vm._v(" \n                ")])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2","align":"center"}},[_c('span',{staticClass:"red"},[_vm._v("\n                        * Required Fields\n                    ")]),_c('br'),_vm._v(" "),_c('a',{staticStyle:{"float":"left"},attrs:{"href":_vm.googleLink ? _vm.googleLink : '#',"id":"google_link","target":"_blank"}},[_vm._v("Google")]),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit"},domProps:{"value":_vm.buttonText + ' Sleep Lab'},on:{"click":function($event){$event.preventDefault();_vm.onSubmit($event)}}}),_vm._v(" "),_c('a',{staticClass:"dellink",staticStyle:{"float":"right"},attrs:{"href":"#","target":"_parent","title":"DELETE"},on:{"click":function($event){$event.preventDefault();_vm.onClickDeleteSleeplab(_vm.sleeplab.sleeplabid)}}},[_vm._v("Delete")])])])])])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{attrs:{"for":"middlename"}},[_vm._v("Middle "),_c('br'),_vm._v("Init")])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Address\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 350 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewCorporateContact_js__ = __webpack_require__(353);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewCorporateContact_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_viewCorporateContact_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_de632cd4_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_viewCorporateContact_vue__ = __webpack_require__(354);
function injectStyle (ssrContext) {
  __webpack_require__(351)
  __webpack_require__(352)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-de632cd4"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_viewCorporateContact_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_de632cd4_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_viewCorporateContact_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 351 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 352 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 353 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'view-corporate-contact',
  data: function data() {
    return {
      message: '',
      contact: {},
      componentParams: {},
      contactTypes: []
    };
  },
  created: function created() {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);

    this.$parent.popupEdit = false;
  },
  mounted: function mounted() {
    window.$('form :input').attr('readonly', true);
    window.$('form select').attr('disabled', 'disabled');
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
  },

  methods: {
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      var _this = this;

      this.componentParams = parameters;

      this.getContactType().then(function (response) {
        _this.contactTypes = response.data.data;

        _this.fetchContact(_this.componentParams.contactId);
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactById', response: response });
      });
    },
    fetchContact: function fetchContact(contactId) {
      var _this2 = this;

      this.getContactById(contactId).then(function (response) {
        var data = response.data.data;

        data['name'] = (data['firstname'] ? data['firstname'] + ' ' : '') + (data['middlename'] ? data['middlename'] + ' ' : '') + (data['lastname'] || '');

        _this2.contact = data;
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactById', response: response });
      });
    },
    getContactById: function getContactById(contactId) {
      contactId = contactId || 0;

      return _http2.default.get(_endpoints2.default.contacts.show + '/' + contactId);
    },
    getContactType: function getContactType() {
      return _http2.default.post(_endpoints2.default.contactTypes.sorted);
    }
  }
};

/***/ }),
/* 354 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_vm._v("\n        "+_vm._s(_vm.message)+"\n    ")]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"contactfrm","onSubmit":"return contactabc(this)"}},[_c('table',{attrs:{"width":"700","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',{staticClass:"cat_head",attrs:{"colspan":"2"}},[_vm._v("\n                   "+_vm._s('Contact' + (_vm.contact.name ? ' "' + _vm.contact.name + '"': ''))+"\n                ")])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(0),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.salutation),expression:"contact.salutation"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"name":"salutation","id":"salutation","tabindex":"1"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.salutation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":""}}),_vm._v(" "),_c('option',{attrs:{"value":"Dr."}},[_vm._v("Dr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mr."}},[_vm._v("Mr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mrs."}},[_vm._v("Mrs.")]),_vm._v(" "),_c('option',{attrs:{"value":"Ms."}},[_vm._v("Ms.")]),_vm._v(" "),_c('option',{attrs:{"value":"Miss."}},[_vm._v("Miss.")])]),_vm._v(" "),_c('label',{attrs:{"for":"salutation"}},[_vm._v("Salutation")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.firstname),expression:"contact.firstname"}],staticClass:"field text addr tbox",attrs:{"id":"firstname","name":"firstname","type":"text","tabindex":"2","maxlength":"255"},domProps:{"value":(_vm.contact.firstname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.firstname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"firstname"}},[_vm._v("First Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.lastname),expression:"contact.lastname"}],staticClass:"field text addr tbox",attrs:{"id":"lastname","name":"lastname","type":"text","tabindex":"3","maxlength":"255"},domProps:{"value":(_vm.contact.lastname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.lastname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"lastname"}},[_vm._v("Last Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.middlename),expression:"contact.middlename"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"middlename","name":"middlename","type":"text","tabindex":"4","maxlength":"1"},domProps:{"value":(_vm.contact.middlename)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.middlename=$event.target.value}}}),_vm._v(" "),_vm._m(1)])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_c('span',[_c('span',{staticStyle:{"color":"#000000"}},[_vm._v("Company")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.company),expression:"contact.company"}],staticClass:"field text addr tbox",staticStyle:{"width":"575px"},attrs:{"id":"company","name":"company","type":"text","tabindex":"5","maxlength":"255"},domProps:{"value":(_vm.contact.company)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.company=$event.target.value}}})])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(2),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add1),expression:"contact.add1"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add1","name":"add1","type":"text","tabindex":"6","maxlength":"255"},domProps:{"value":(_vm.contact.add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.add2),expression:"contact.add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"add2","name":"add2","type":"text","tabindex":"7","maxlength":"255"},domProps:{"value":(_vm.contact.add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add2"}},[_vm._v("Address2")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.city),expression:"contact.city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"city","name":"city","type":"text","tabindex":"8","maxlength":"255"},domProps:{"value":(_vm.contact.city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.state),expression:"contact.state"}],staticClass:"field text addr tbox",staticStyle:{"width":"26px"},attrs:{"id":"state","name":"state","type":"text","tabindex":"9","maxlength":"2"},domProps:{"value":(_vm.contact.state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.zip),expression:"contact.zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"zip","name":"zip","type":"text","tabindex":"10","maxlength":"255"},domProps:{"value":(_vm.contact.zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"zip"}},[_vm._v("Zip / Post Code ")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone1),expression:"contact.phone1"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone1","name":"phone1","type":"text","tabindex":"11","maxlength":"255"},domProps:{"value":(_vm.contact.phone1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone1"}},[_vm._v("Phone 1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.phone2),expression:"contact.phone2"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"phone2","name":"phone2","type":"text","tabindex":"12","maxlength":"255"},domProps:{"value":(_vm.contact.phone2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.phone2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"phone2"}},[_vm._v("Phone 2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.fax),expression:"contact.fax"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"fax","name":"fax","type":"text","tabindex":"13","maxlength":"255"},domProps:{"value":(_vm.contact.fax)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.fax=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"fax"}},[_vm._v("Fax")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.email),expression:"contact.email"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"email","name":"email","type":"text","tabindex":"14","maxlength":"255"},domProps:{"value":(_vm.contact.email)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.email=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"email"}},[_vm._v("Email")])])])])])])]),_vm._v(" "),_c('tr'),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.greeting),expression:"contact.greeting"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"greeting","name":"greeting","type":"text","tabindex":"18","maxlength":"255"},domProps:{"value":(_vm.contact.greeting)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.greeting=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"greeting"}},[_vm._v("Greeting")])])]),_vm._v(" "),_c('div',[_c('span',[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.sincerely),expression:"contact.sincerely"}],staticClass:"field text addr tbox",attrs:{"name":"sincerely","id":"sincerely","tabindex":"19"},domProps:{"value":(_vm.contact.sincerely)},on:{"input":function($event){if($event.target.composing){ return; }_vm.contact.sincerely=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"sincerely"}},[_vm._v("Sincerely")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.contact.contacttypeid),expression:"contact.contacttypeid"}],staticClass:"field text addr tbox",attrs:{"id":"contacttypeid","name":"contacttypeid","tabindex":"20"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.contact.contacttypeid=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"0"}}),_vm._v(" "),_vm._l((_vm.contactTypes),function(type){return _c('option',{domProps:{"value":type.contacttypeid}},[_vm._v("\n                                            "+_vm._s(type.contacttype)+"\n                                        ")])})],2),_vm._v(" "),_c('label',{attrs:{"for":"contacttype"}},[_vm._v("Contact Type")])])])])])])]),_vm._v(" "),_vm._m(3),_vm._v(" "),_vm._m(4)])])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Name\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{attrs:{"for":"middlename"}},[_vm._v("Middle "),_c('br'),_vm._v("Init")])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Address\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Notes:\n                            ")]),_vm._v(" "),_c('div',[_c('span',{staticClass:"full"},[_c('textarea',{staticClass:"field text addr tbox",staticStyle:{"width":"600px","height":"150px"},attrs:{"name":"notes","id":"notes","tabindex":"21"}})])])])])])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('td',{attrs:{"colspan":"2","align":"center"}},[_c('span',{staticClass:"red"},[_vm._v("\n                        * Required Fields\n                    ")]),_c('br')])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 355 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('transition',[_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.popupEnabled),expression:"popupEnabled"}],staticClass:"modal",attrs:{"id":"modal"}},[_c('div',{staticClass:"popup-contact",style:({'top': _vm.topPosition, 'left': _vm.leftPosition}),attrs:{"id":"popupContact"}},[_c('a',{attrs:{"id":"popupContactClose"},on:{"click":function($event){_vm.disable()}}},[_c('button',[_vm._v("X")])]),_vm._v(" "),_c('div',{class:{'modal-content-white': _vm.currentProperties.white, 'modal-content': !_vm.currentProperties.white},attrs:{"id":"modal-content"}},[_c(_vm.currentView,_vm._b({tag:"component"},'component',_vm.currentProperties,false))],1)]),_vm._v(" "),_c('div',{staticClass:"background-popup",attrs:{"id":"backgroundPopup"},on:{"click":function($event){_vm.disable()}}})])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 356 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{on:{"click":function($event){_vm.hideSearchHints()}}},[_c('modal-root'),_vm._v(" "),_c('router-view')],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 357 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerRoot_js__ = __webpack_require__(358);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerRoot_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerRoot_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5c96fe87_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerRoot_vue__ = __webpack_require__(359);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerRoot_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_5c96fe87_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerRoot_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 358 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  mounted: function mounted() {
    document.title = 'Dental Sleep Solutions :: Screener';
    if (!this.$store.state.screener[_symbols2.default.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' });
      return;
    }
    this.$router.push({ name: 'screener-main' });
  }
};

/***/ }),
/* 359 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('router-view')],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 360 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_PageNotFound_vue__ = __webpack_require__(361);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_PageNotFound_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_PageNotFound_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_42c0baf8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PageNotFound_vue__ = __webpack_require__(362);
var normalizeComponent = __webpack_require__(2)
/* script */

/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_node_modules_vue_loader_lib_selector_type_script_index_0_PageNotFound_vue___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_42c0baf8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PageNotFound_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 361 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = {
  created: function created() {
    this.$router.push({ name: 'main-login' });
  }
};

/***/ }),
/* 362 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c("div")}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 363 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

var _ManageLogin = __webpack_require__(367);

var _ManageLogin2 = _interopRequireDefault(_ManageLogin);

var _ManageApp = __webpack_require__(376);

var _ManageApp2 = _interopRequireDefault(_ManageApp);

var _DashboardRoot = __webpack_require__(437);

var _DashboardRoot2 = _interopRequireDefault(_DashboardRoot);

var _PatientRoot = __webpack_require__(470);

var _PatientRoot2 = _interopRequireDefault(_PatientRoot);

var _patients = __webpack_require__(484);

var _patients2 = _interopRequireDefault(_patients);

var _contacts = __webpack_require__(491);

var _contacts2 = _interopRequireDefault(_contacts);

var _editingPatients = __webpack_require__(497);

var _editingPatients2 = _interopRequireDefault(_editingPatients);

var _vobs = __webpack_require__(504);

var _vobs2 = _interopRequireDefault(_vobs);

var _referredby = __webpack_require__(512);

var _referredby2 = _interopRequireDefault(_referredby);

var _printReferredByContact = __webpack_require__(517);

var _printReferredByContact2 = _interopRequireDefault(_printReferredByContact);

var _sleeplabs = __webpack_require__(520);

var _sleeplabs2 = _interopRequireDefault(_sleeplabs);

var _corporateContacts = __webpack_require__(525);

var _corporateContacts2 = _interopRequireDefault(_corporateContacts);

var _ledgerReportFull = __webpack_require__(530);

var _ledgerReportFull2 = _interopRequireDefault(_ledgerReportFull);

var _SoftwareTutorials = __webpack_require__(539);

var _SoftwareTutorials2 = _interopRequireDefault(_SoftwareTutorials);

var _PatientTracker = __webpack_require__(542);

var _PatientTracker2 = _interopRequireDefault(_PatientTracker);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = [{
  path: 'login',
  name: 'main-login',
  component: _ManageLogin2.default
}, {
  path: 'main',
  name: 'manage-main',
  component: _ManageApp2.default,
  children: [{
    path: 'index',
    name: 'dashboard',
    component: _DashboardRoot2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'patients',
    name: 'patients',
    component: _PatientRoot2.default,
    children: [{
      path: 'tracker',
      name: 'patient-tracker',
      component: _PatientTracker2.default,
      meta: _main.STANDARD_META
    }, {
      path: 'manage',
      name: 'manage-patients',
      component: _patients2.default,
      meta: _main.STANDARD_META
    }, {
      path: 'edit-patient',
      name: 'edit-patient',
      component: _editingPatients2.default,
      meta: _main.STANDARD_META
    }]
  }, {
    path: 'contacts',
    name: 'contacts',
    component: _contacts2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'vobs',
    name: 'vobs',
    component: _vobs2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'referredby',
    name: 'referredby',
    component: _referredby2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'sleeplabs',
    name: 'sleeplabs',
    component: _sleeplabs2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'corporate-contacts',
    name: 'corporate-contacts',
    component: _corporateContacts2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'ledger-report-full',
    name: 'ledger-report-full',
    component: _ledgerReportFull2.default,
    meta: _main.STANDARD_META
  }, {
    path: 'print-referred-by-contact',
    name: 'print-referred-by-contact',
    component: _printReferredByContact2.default,
    meta: {
      requiresAuth: true
    }
  }, {
    path: 'sw-tutorials',
    name: 'sw-tutorials',
    component: _SoftwareTutorials2.default,
    meta: _main.STANDARD_META
  }]
}];

/***/ }),
/* 364 */,
/* 365 */,
/* 366 */,
/* 367 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageLogin_js__ = __webpack_require__(369);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageLogin_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageLogin_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2fb0dc14_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ManageLogin_vue__ = __webpack_require__(375);
function injectStyle (ssrContext) {
  __webpack_require__(368)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-2fb0dc14"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageLogin_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2fb0dc14_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ManageLogin_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 368 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 369 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _vueFocus = __webpack_require__(370);

var _SiteSeal = __webpack_require__(100);

var _SiteSeal2 = _interopRequireDefault(_SiteSeal);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'main-login',
  data: function data() {
    return {
      focusUser: false,
      focusPassword: false,
      legacyUrl: _ProcessWrapper2.default.getLegacyRoot(),
      message: '',
      credentials: {
        username: '',
        password: ''
      }
    };
  },

  components: {
    siteSeal: _SiteSeal2.default
  },
  directives: {
    focus: _vueFocus.focus
  },
  mounted: function mounted() {
    var token = this.$store.state.main[_symbols2.default.state.mainToken];
    if (token) {
      var data = {
        cur_page: this.$route.path
      };
      _http2.default.token = token;
      _http2.default.post(_endpoints2.default.loginDetails.store, data);
      this.$router.push({ name: 'dashboard' });
    }
  },

  methods: {
    setUsername: function setUsername(event) {
      this.credentials.username = event.target.value;
    },
    setPassword: function setPassword(event) {
      this.credentials.password = event.target.value;
    },
    submitForm: function submitForm() {
      var _this = this;

      var alertText = void 0;
      if (this.credentials.username.trim() === '') {
        alertText = 'Username is Required';
        _Alerter2.default.alert(alertText);
        this.focusUser = true;
        return;
      }
      this.focusUser = false;

      if (this.credentials.password.trim() === '') {
        alertText = 'Password is Required';
        _Alerter2.default.alert(alertText);
        this.focusPassword = true;
        return;
      }
      this.focusPassword = false;

      this.$store.dispatch(_symbols2.default.actions.mainLogin, this.credentials).then(function () {
        _this.$router.push({ name: 'dashboard' });
      }).catch(function (response) {
        _this.message = response.message;
      });
    }
  }
};

/***/ }),
/* 370 */,
/* 371 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 372 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _ScriptLoader = __webpack_require__(373);

var _ScriptLoader2 = _interopRequireDefault(_ScriptLoader);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  mounted: function mounted() {
    var sealUrl = 'https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf';
    _ScriptLoader2.default.loadScriptFrom(sealUrl, 'siteseal');
  }
};

/***/ }),
/* 373 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  loadScriptFrom: function loadScriptFrom(path, toElement) {
    var targetElement = document.getElementById(toElement);
    if (!targetElement) {
      return;
    }
    var scriptElement = document.createElement('script');
    scriptElement.src = path;
    scriptElement.async = true;

    targetElement.append(scriptElement);
  }
};

/***/ }),
/* 374 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"siteseal_div"},[_c('span',{staticClass:"siteseal"},[_c('span',{ref:"siteseal",attrs:{"id":"siteseal"}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('a',{staticClass:"siteseal_link",attrs:{"href":"http://www.godaddy.com/ssl/ssl-certificates.aspx","target":"_blank"}},[_vm._v("secure website")])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 375 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('div',{staticClass:"login_container",attrs:{"id":"login_container"}},[_c('form',{attrs:{"name":"loginfrm","id":"loginForm"}},[_c('table',{attrs:{"border":"0","cellpadding":"3","cellspacing":"1","bgcolor":"#00457C","width":"40%"}},[_vm._m(0),_vm._v(" "),(_vm.message)?_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{attrs:{"colspan":"2"}},[_c('span',{staticClass:"red"},[_vm._v(_vm._s(_vm.message))])])]):_vm._e(),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_vm._m(1),_vm._v(" "),_c('td',{staticClass:"t_data"},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.credentials.username),expression:"credentials.username"},{name:"focus",rawName:"v-focus",value:(_vm.focusUser),expression:"focusUser"}],attrs:{"id":"username","name":"username","type":"text","autofocus":""},domProps:{"value":(_vm.credentials.username)},on:{"focus":function($event){_vm.focusUser = true},"blur":function($event){_vm.focusUser = false},"change":function($event){_vm.setUsername($event)},"input":function($event){if($event.target.composing){ return; }_vm.credentials.username=$event.target.value}}})])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_vm._m(2),_vm._v(" "),_c('td',{staticClass:"t_data"},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.credentials.password),expression:"credentials.password"},{name:"focus",rawName:"v-focus",value:(_vm.focusPassword),expression:"focusPassword"}],attrs:{"id":"password","name":"password","type":"password"},domProps:{"value":(_vm.credentials.password)},on:{"focus":function($event){_vm.focusPassword = true},"blur":function($event){_vm.focusPassword = false},"change":function($event){_vm.setPassword($event)},"input":function($event){if($event.target.composing){ return; }_vm.credentials.password=$event.target.value}}})])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{attrs:{"colspan":"2","align":"center"}},[_c('input',{staticClass:"addButton",attrs:{"type":"submit","name":"btnsubmit","id":"btnsubmit","value":" Login "},on:{"click":function($event){$event.preventDefault();_vm.submitForm()}}}),_vm._v(" "),_c('span',{staticClass:"registration_links"},[_c('a',{attrs:{"href":_vm.legacyUrl + 'manage/register/new.php'}},[_vm._v("Register")]),_vm._v("\n                            |\n                            "),_c('a',{attrs:{"href":_vm.legacyUrl + 'manage/forgot_password.php'}},[_vm._v("Forgot Password")])])])])]),_vm._v(" "),_c('span',{staticClass:"screener"},[_vm._v("Looking for the screener? "),_c('router-link',{attrs:{"to":{name: 'screener-root'}}},[_vm._v("Click Here")])],1)])]),_vm._v(" "),_c('site-seal'),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})],1)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"t_head",attrs:{"colspan":"2"}},[_vm._v("Please Enter Your Login Information")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{staticClass:"t_data"},[_c('label',{attrs:{"for":"username"}},[_vm._v("User name")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{staticClass:"t_data"},[_c('label',{attrs:{"for":"password"}},[_vm._v("Password")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 376 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageApp_js__ = __webpack_require__(378);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageApp_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageApp_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2602d38c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ManageApp_vue__ = __webpack_require__(436);
function injectStyle (ssrContext) {
  __webpack_require__(377)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-2602d38c"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ManageApp_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_2602d38c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ManageApp_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 377 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 378 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _CommonHeader = __webpack_require__(379);

var _CommonHeader2 = _interopRequireDefault(_CommonHeader);

var _CommonFooter = __webpack_require__(433);

var _CommonFooter2 = _interopRequireDefault(_CommonFooter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  components: {
    commonHeader: _CommonHeader2.default,
    commonFooter: _CommonFooter2.default
  }
};

/***/ }),
/* 379 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_CommonHeader_js__ = __webpack_require__(381);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_CommonHeader_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_CommonHeader_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_59f5754c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_CommonHeader_vue__ = __webpack_require__(432);
function injectStyle (ssrContext) {
  __webpack_require__(380)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-59f5754c"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_CommonHeader_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_59f5754c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_CommonHeader_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 380 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 381 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _LocationWrapper = __webpack_require__(60);

var _LocationWrapper2 = _interopRequireDefault(_LocationWrapper);

var _PatientHeader = __webpack_require__(382);

var _PatientHeader2 = _interopRequireDefault(_PatientHeader);

var _PatientSearch = __webpack_require__(415);

var _PatientSearch2 = _interopRequireDefault(_PatientSearch);

var _TaskMenu = __webpack_require__(419);

var _TaskMenu2 = _interopRequireDefault(_TaskMenu);

var _WelcomeText = __webpack_require__(101);

var _WelcomeText2 = _interopRequireDefault(_WelcomeText);

var _RightTopMenu = __webpack_require__(423);

var _RightTopMenu2 = _interopRequireDefault(_RightTopMenu);

var _LeftTopMenu = __webpack_require__(427);

var _LeftTopMenu2 = _interopRequireDefault(_LeftTopMenu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    patientId: function patientId() {
      return this.$store.state.patients[_symbols2.default.state.patientId];
    },
    companyLogo: function companyLogo() {
      return this.$store.state.main[_symbols2.default.state.companyLogo];
    }
  },
  components: {
    rightTopMenu: _RightTopMenu2.default,
    leftTopMenu: _LeftTopMenu2.default,
    taskMenu: _TaskMenu2.default,
    patientHeader: _PatientHeader2.default,
    patientSearch: _PatientSearch2.default,
    welcomeText: _WelcomeText2.default
  },
  created: function created() {},

  methods: {
    goToAddPatient: function goToAddPatient() {
      _LocationWrapper2.default.goToLegacyPage('manage/add_patient.php');
    },
    addTaskPopup: function addTaskPopup() {
      var props = {
        id: 0,
        patientId: this.patientId
      };
      this.$store.commit(_symbols2.default.mutations.modal, { name: 'addTask', params: props });
    }
  }
};

/***/ }),
/* 382 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientHeader_js__ = __webpack_require__(384);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientHeader_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientHeader_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_33057411_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientHeader_vue__ = __webpack_require__(414);
function injectStyle (ssrContext) {
  __webpack_require__(383)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-33057411"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientHeader_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_33057411_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientHeader_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 383 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 384 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _PatientMenu = __webpack_require__(385);

var _PatientMenu2 = _interopRequireDefault(_PatientMenu);

var _PatientInnerMenu = __webpack_require__(395);

var _PatientInnerMenu2 = _interopRequireDefault(_PatientInnerMenu);

var _PatientTaskMenu = __webpack_require__(400);

var _PatientTaskMenu2 = _interopRequireDefault(_PatientTaskMenu);

var _WelcomeText = __webpack_require__(101);

var _WelcomeText2 = _interopRequireDefault(_WelcomeText);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    showAllWarnings: function showAllWarnings() {
      return this.$store.state.patients[_symbols2.default.state.showAllWarnings];
    }
  },
  components: {
    patientMenu: _PatientMenu2.default,
    patientInnerMenu: _PatientInnerMenu2.default,
    patientTaskMenu: _PatientTaskMenu2.default,
    welcomeText: _WelcomeText2.default
  },
  methods: {
    showWarnings: function showWarnings() {
      this.$store.commit(_symbols2.default.mutations.showAllWarnings);
    },
    hideWarnings: function hideWarnings() {
      this.$store.commit(_symbols2.default.mutations.hideAllWarnings);
    }
  }
};

/***/ }),
/* 385 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenu_js__ = __webpack_require__(387);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ba434e3a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientMenu_vue__ = __webpack_require__(394);
function injectStyle (ssrContext) {
  __webpack_require__(386)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-ba434e3a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ba434e3a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 386 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 387 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _main = __webpack_require__(6);

var _PatientMenuElement = __webpack_require__(390);

var _PatientMenuElement2 = _interopRequireDefault(_PatientMenuElement);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    menuElements: function menuElements() {
      var elements = [];
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(_main.PATIENT_MENU), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var menuElement = _step.value;

          var newElement = menuElement;
          if (!menuElement.hasOwnProperty('active')) {
            newElement.active = '';
          }
          if (!menuElement.hasOwnProperty('activeLike')) {
            newElement.activeLike = [];
          }
          if (!menuElement.hasOwnProperty('legacy')) {
            newElement.legacy = true;
          }
          elements.push(newElement);
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return elements;
    }
  },
  components: {
    patientMenuElement: _PatientMenuElement2.default
  }
};

/***/ }),
/* 388 */,
/* 389 */,
/* 390 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenuElement_js__ = __webpack_require__(392);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenuElement_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenuElement_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_06254a6e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientMenuElement_vue__ = __webpack_require__(393);
function injectStyle (ssrContext) {
  __webpack_require__(391)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-06254a6e"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientMenuElement_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_06254a6e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientMenuElement_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 391 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 392 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    elementLegacy: {
      type: Boolean,
      default: true
    },
    elementLink: {
      type: String,
      required: true
    },
    elementName: {
      type: String,
      required: true
    },
    elementActive: {
      type: String,
      default: ''
    },
    elementActiveLike: {
      type: Array,
      default: function _default() {
        return [];
      }
    },
    wildcard: {
      type: String,
      default: _symbols2.default.getters.patientId
    },
    lastElement: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    isActive: function isActive() {
      if (this.elementActive) {
        if (this.$route && this.$route.name === this.elementActive) {
          return true;
        }
        return false;
      }
      if (this.elementActiveLike.length) {
        return this.checkPattern();
      }
      return false;
    },
    parsedLink: function parsedLink() {
      var wildcardData = this.$store.getters[this.wildcard];
      var link = this.elementLink.replace('%d', wildcardData);
      return _ProcessWrapper2.default.getLegacyRoot() + link;
    }
  },
  methods: {
    checkPattern: function checkPattern() {
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.elementActiveLike), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var pattern = _step.value;

          if (this.$route && this.$route.name && this.$route.name.indexOf(pattern) > -1) {
            return true;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return false;
    }
  }
};

/***/ }),
/* 393 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('li',{class:{ 'last': _vm.lastElement }},[(_vm.elementLegacy)?_c('a',{class:{ 'nav_active': _vm.isActive },attrs:{"href":_vm.parsedLink}},[_vm._v(_vm._s(_vm.elementName))]):_c('router-link',{class:{ 'nav_active': _vm.isActive },attrs:{"to":{ name: _vm.elementLink }}},[_vm._v(_vm._s(_vm.elementName))])],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 394 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"patient_nav",attrs:{"id":"patient_nav"}},[_c('ul',_vm._l((_vm.menuElements),function(menuElement,loopIndex){return _c('patient-menu-element',{key:loopIndex,attrs:{"element-link":menuElement.link,"element-name":menuElement.name,"element-active":menuElement.active,"element-active-like":menuElement.activeLike,"element-legacy":menuElement.legacy,"last-element":(loopIndex === _vm.menuElements.length - 1)}})}))])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 395 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientInnerMenu_js__ = __webpack_require__(397);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientInnerMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientInnerMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1a25effe_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientInnerMenu_vue__ = __webpack_require__(398);
function injectStyle (ssrContext) {
  __webpack_require__(396)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1a25effe"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientInnerMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1a25effe_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientInnerMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 396 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 397 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    longPatientName: function longPatientName() {
      if (this.patientName.length > 20) {
        return true;
      }
      return false;
    },
    displayNotes: function displayNotes() {
      var displayAlert = this.$store.state.patients[_symbols2.default.state.displayAlert];
      if (displayAlert && this.alertText) {
        return true;
      }
      return false;
    },
    displayMed: function displayMed() {
      var allergen = this.$store.state.patients[_symbols2.default.state.allergen];
      var premedCheck = this.$store.state.patients[_symbols2.default.state.premedCheck];
      if (premedCheck === 1) {
        return true;
      }
      if (allergen) {
        return true;
      }
      return false;
    },
    patientName: function patientName() {
      return this.$store.state.patients[_symbols2.default.state.patientName];
    },
    medicare: function medicare() {
      return this.$store.state.patients[_symbols2.default.state.medicare];
    },
    alertText: function alertText() {
      return this.$store.state.patients[_symbols2.default.state.headerAlertText];
    },
    headerTitle: function headerTitle() {
      return this.$store.state.patients[_symbols2.default.state.headerTitle];
    }
  }
};

/***/ }),
/* 398 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"patient_name_div",class:{ 'long-patient': _vm.longPatientName },attrs:{"id":"patient_name_div"}},[_c('div',{attrs:{"id":"patient_name_inner"}},[(_vm.medicare)?_c('img',{attrs:{"src":__webpack_require__(399)}}):_vm._e(),_vm._v(" "),_c('span',{staticClass:"patient_name",class:{ 'medicare_name': _vm.medicare, 'name': !_vm.medicare }},[_c('span',[_vm._v(_vm._s(_vm.patientName))]),_vm._v(" "),(_vm.displayNotes)?_c('a',{attrs:{"href":"#","title":_vm._f("unescape")('Notes: ' + _vm.alertText)},on:{"click":function($event){$event.preventDefault();}}},[_vm._v("Notes")]):_vm._e(),_vm._v(" "),(_vm.displayMed)?_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/q_page3.php?pid=' + _vm.patientId),expression:"'manage/q_page3.php?pid=' + patientId"}],attrs:{"title":_vm.headerTitle}},[_vm._v("*Med")]):_vm._e()])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 399 */
/***/ (function(module, exports) {

module.exports = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAAWCAIAAAATqWh1AAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAACXVJREFUeNrUV3lwVtUVP/fet3z7l30lHzErYIAkuBCthkpZXFisS61Vqu3U1hnc2s7gtGOdalNmsC3amU5nBKy1MEJbFwSxKCSaoEAEDZBNyZ4v8CUkJF++9b377j3942XTdsb+ad9fb+47757fOef+fucegojw//YoAHD5/aahPfuo7gBCvr5IpZScz3vwe6k11yoAEDnbOrDzz4x6CKVfW8wohMREWs3VU6AJU3Tq1v0eCYRzAQiMUVWlUqLJhapQymaDQURuCmXOomVJISQAUEI0jXEuhEQAYIw6HSoiJpJcytlDaG/O+dRfAKBrCkzXWFjSsnejRFXZXNBmlABjAEAQMdraPnL0A0mpojKFKYSAkJJzixCiqQq3LClnIyYEVFWxLCGlBCAA4HbrBMA0JaLkXCgqZZQxRoFA/+CoqrCC/DRhSTGNG1Ga3FIVhVIKAAjITcv+hoBul4NRYppCSGlZYk6qJQPMWnWTq7xMAQBPxaJXPjH2/vNcbe0VTz1+g8bgQGPf9uePLVyY+ae6Ndtfaj58uNvpUgEhaVj5+d7n69a8+NdTR5r6dE0RQhYVpz/60DVFed72wfATPz/wiydvqq3Ki5ly+47mNxpNTaV3371o8wPVKptK5pv1vc/9/v0fP7R804aFAJAEeGzLOxcvRhklFhfzAilbHqkpzPO1tIee3tYIklBKACCR5A//sHpDedkUEQGgp23oo3c7STQW3lSVmek59X7nsXc6rPGIafHzn/YfP9LpcikAEI/zoit8RuzGntah4+91Oh2KQPnem0Z/W//ul++NjYwfP9Ix8p0lUJW388XGbU/X+306Ijyzpc9PzB88UGP7qj/QcvLI58WZ+n3rFlBKzEiy5VhXX+8EZYASjkaM5Oj4X3bcMz4abj7aKSWhFBAhFjXW1ebBqvJZ0JqmZGd5uGWFw4nMTM/IpVh2ttvlVAkAZbSkOPWpp1ZSApaFHo+Wmuri3CorTXtyywrGyOtvtB081HniZH9ursfj1lxOdSIc3/XSJ6UlaXXPrOaW/PUzR3fsOnXXnVVejyNpWF3dY1lZ3oHBiUg06fc5CQAgrlxZ/MCm6kTSfGX3p/UNPUNDE05dVVTyk4dqqirzOBeWkEsW585Knq0nWdku3cFGx+IFBVY4HC8s8iJBQBBC+v36xnWL53I5aVgpKc71t1UwRhctyKmv7z5+YnDjxgVAQNOUM2cv9PeP/27bLWvXLAKA8+cv1W1taGsPLb+mMBicCIWilUuzBofCXd2XllUFANA0RUlx+upVCwBACGxo6B66GKaUWlyuqC25vqZwrooAEDoNGlJSHGmpzlBoMhxOJBN8fsCHEhGAEEgkRU/fpWBwrH/g0tjliE1HYUnDsAAgPd19RWFad88oNyUBoAQ62kdS/M5l1fPsze+/76o3X99UWpwOAGfODHFTrFu/AICcOXPB5jYAzMgL55IR4vM6EJBS0ts7GhqZGBwcGwyOcW7ZxjOZRodDycr0DAbDwaEJBMjM8IYuJG09Cg6EN9z+MgGIRIw771ry3Nb1lJIZDdN05vdrE2HDFhyJOHo56vU5fD6nbZCZ4c3M8NrvzacGPF7tG9cX/W13S0vLxSnJ01l7x8irf/80keR7dn9y1dX5ZaWZH53ocTjV3/y2YdtzDVKiptO9e+4vK82eBY2Iqsry8v3dvWPZOR6fz+n3O6xpHQVCGFMJIFME+48GRAAIJYCAAAQIAjFNripEUb7cXyXK1tbh0pKMxVfmzQ+knGsNJQ1TYdTl0k6cHDxa3wWIukP94wu3UUotSxJJGKVMocRCxihMi/ksaEpIoCClo2O4s3M4O8vjdmlCSAJgGFZBwLd3z72qyoSQbrduV2YGEecyEuX5eU5FZRIlIehy6NyUnMvZfsQtTVODwfDQUCQQSO0dGPF41FAo2tc3XlSUbhiivCyjpmbe+ETi3Xe7mpr67rmrmlKSMMxnn1296ltlhikIQGaG50ugAREDBSkTE0bLmYsrv1nCrak2hgCaRgMFqTOBzskwAMBkxBgcGK9ZXqCpDAEoITl5/vFw4vLluG145OhnO3ad2Fp364ULkUTCOnCgY/9brYwqmsa6e8YWlGXF4+aK2qK6Z29GxIc3v9bU1GtywRiViFlZ3ox0z5cqNltrKTA3xxeLGa1tI4Xz0wAJIgKgHdLcPmyvEEIVRgHg4KG2S6Pxq5cVKIwAgmXhkoqceJwf+leHbfyP1842NQ1kpLu7e8YScbO8PKOyMr+sPCNpWD09Y0CAUmKXhRCSne0zuZBSzMjaF/3iHCIimlxkZLg0VZ0MG7m53o6OkJQIQFSFBoOTD/7oVUqAc+FwKr/65eoUv/PkyYuP/2y/aVqHD3fPn5+ybNm8y+NRKdEwrIqK3KWVOTt3fqzraiLJ97/V+e2Ni/x+1+nTwdQ0x55Xvuty65OR5Npbdp09FzIMTgiZuSFLgYBAgACgrijPv3Bs777TUmI8zteuKXvw+9fNgjYNKxJN+nxOn0+nRObmeuNJHk+aEtCyxMhI7ODBLgAwDMvtUTc/XEsohEKRffvO2Sr+6ObrCualBofGYvFkMsk1VfnpYzdsfmR/XV09IBSXpD7x+I2jY9HGY92Fhak5OX4A8Hr1woC/ubl/6OKExS3T5DYSh4MOj0yOjEQBIWnw4ycGCSEAMDmZyMlJmTqYdojNH/eNT8TWrLryxMne4eHJDeuXnjk3GAxO3Hrz4lOn+853jdoXMSGkqrKbVpR9dn64p2fMpmZxcWZ1ZQEAhCdjh95pX3FjaW5uCgA0fXj+7UOdqsbuvmPp4or8ycnE4ffaiouyqqsCtu9Tp/t6esdWr1r44Uc9ebn+qsoCAOjrH21s6lq7ZiGltOGDzwlQ++7BuSgvy6pcWjAFurGx9623290uNRblLpeqKCwSSeq6omosEjGcDlXT6ex8gxCLmZqmqNpMY8J4zBQCFZV53FosYXLDYow6XSrnkhBCKU3EDUqJ26NbAhMxw/7R5dYZI7GY6XZrFpfxhAkIDqfqcCiRiEGBuDyaTSqbRdGYecftFcuvDSgA0NY+vP0Px9xejRKwa4HTSoH4X6YZRCRzVucMbISQaeYCEEIYIwgghLRdE2K3JJxCQgiZ4wIRgQDgtNkXvQghE0lrcUXOFOhAwL92bbGuK3YhpuQMv6hu//sk+ZXGcw2+0hGZSqEUyLnIz/NNHQ/TtBJJTr728ywCOJ2aprJ/DwAwE+WQS4fgjwAAAABJRU5ErkJggg=="

/***/ }),
/* 400 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTaskMenu_js__ = __webpack_require__(402);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTaskMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTaskMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_56b1ad38_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientTaskMenu_vue__ = __webpack_require__(410);
function injectStyle (ssrContext) {
  __webpack_require__(401)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-56b1ad38"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTaskMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_56b1ad38_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientTaskMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 401 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 402 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

var _TaskData = __webpack_require__(62);

var _TaskData2 = _interopRequireDefault(_TaskData);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data: function data() {
    return {
      showTaskList: false
    };
  },

  computed: {
    tasksNumber: function tasksNumber() {
      return this.$store.getters[_symbols2.default.getters.tasksPatientNumber];
    },
    overdueTasks: function overdueTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksPatientByType](_main.TASK_TYPES.OVERDUE);
    },
    todayTasks: function todayTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksPatientByType](_main.TASK_TYPES.TODAY);
    },
    tomorrowTasks: function tomorrowTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksPatientByType](_main.TASK_TYPES.TOMORROW);
    },
    futureTasks: function futureTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksPatientByType](_main.TASK_TYPES.FUTURE);
    }
  },
  components: {
    taskData: _TaskData2.default
  }
};

/***/ }),
/* 403 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 404 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _TaskElement = __webpack_require__(405);

var _TaskElement2 = _interopRequireDefault(_TaskElement);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    tasks: {
      type: Array,
      required: true
    },
    taskCode: {
      type: String,
      required: true
    },
    taskType: {
      type: String,
      required: true
    },
    redHeader: {
      type: Boolean,
      default: false
    },
    dueDate: {
      type: Boolean,
      default: false
    },
    isPatient: {
      type: Boolean,
      required: true
    }
  },
  components: {
    taskElement: _TaskElement2.default
  }
};

/***/ }),
/* 405 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskElement_js__ = __webpack_require__(407);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskElement_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskElement_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_27228cc6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskElement_vue__ = __webpack_require__(408);
function injectStyle (ssrContext) {
  __webpack_require__(406)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-27228cc6"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskElement_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_27228cc6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskElement_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 406 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 407 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    task: {
      type: Object,
      required: true
    },
    dueDate: {
      type: Boolean,
      required: true
    },
    isPatient: {
      type: Boolean,
      required: true
    }
  },
  data: function data() {
    return {
      isVisible: false
    };
  },

  methods: {
    onMouseEnterTaskItem: function onMouseEnterTaskItem() {
      this.isVisible = true;
    },
    onMouseLeaveTaskItem: function onMouseLeaveTaskItem() {
      this.isVisible = false;
    },
    onClickTaskStatus: function onClickTaskStatus(event) {
      if (!event.target.checked) {
        event.target.checked = true;
        return;
      }
      var checkbox = event.target;
      this.$store.dispatch(_symbols2.default.actions.updateTaskStatus, this.task.id).then(function () {}).catch(function () {
        checkbox.checked = false;
      });
    },
    onClickDeleteTask: function onClickDeleteTask() {
      var confirmText = 'Are you sure you want to delete this task?';
      if (!_Alerter2.default.isConfirmed(confirmText)) {
        return;
      }
      this.$store.dispatch(_symbols2.default.actions.deleteTask, this.task.id);
    },
    onClickTaskPopup: function onClickTaskPopup(taskId) {
      var modalData = {
        name: 'addTask',
        params: {
          id: taskId,
          patientId: 0
        }
      };
      this.$store.commit(_symbols2.default.mutations.modal, modalData);
    }
  }
};

/***/ }),
/* 408 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('li',{class:'task_item task_' + _vm.task.id,on:{"mouseenter":function($event){_vm.onMouseEnterTaskItem()},"mouseleave":function($event){_vm.onMouseLeaveTaskItem()}}},[_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.isVisible),expression:"isVisible"}],staticClass:"task_extra",attrs:{"id":'task_extra_' + _vm.task.id}},[_c('a',{staticClass:"task_delete",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickDeleteTask()}}}),_vm._v(" "),_c('a',{staticClass:"task_edit",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickTaskPopup(_vm.task.id)}}},[_vm._v("Edit")])]),_vm._v(" "),_c('input',{class:'task_status' + (_vm.isPatient ? '' : ' task_status_general'),attrs:{"type":"checkbox","id":'task_checkbox_' + _vm.task.id},domProps:{"value":_vm.task.id},on:{"click":function($event){_vm.onClickTaskStatus($event)}}}),_vm._v(" "),_c('div',{class:'task_content ' + (_vm.isPatient ? 'task_content_patient' : 'task_content_general')},[(_vm.dueDate && _vm.task.due_date)?_c('span',{staticClass:"task_due_date"},[_vm._v(_vm._s(_vm._f("moment")(_vm.task.due_date,"MM DD"))+" - ")]):_vm._e(),_vm._v("\n        "+_vm._s(_vm.task.task)+"\n        "),(_vm.task.firstname && _vm.task.lastname)?_c('span',{staticClass:"task_name"},[_vm._v("\n            ("),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/add_patient.php?ed=' + _vm.task.patientid + '&addtopat=1&pid=' + _vm.task.patientid),expression:"'manage/add_patient.php?ed=' + task.patientid + '&addtopat=1&pid=' + task.patientid"}],staticClass:"task_name_link"},[_vm._v(_vm._s(_vm.task.firstname)+" "+_vm._s(_vm.task.lastname))]),_vm._v(")\n        ")]):_vm._e()])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 409 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[(_vm.tasks.length > 0)?_c('h4',{class:'task_' + _vm.taskCode + '_header' + (_vm.redHeader ? ' task_header_red' : ''),attrs:{"id":(_vm.isPatient ? 'pat_' : '') + 'task_' + _vm.taskCode + '_header'}},[_vm._v(_vm._s(_vm.taskType))]):_vm._e(),_vm._v(" "),(_vm.tasks.length > 0)?_c('ul',{attrs:{"id":(_vm.isPatient ? 'pat_' : '') + 'task_' + _vm.taskCode + '_list'}},_vm._l((_vm.tasks),function(task){return _c('task-element',{key:task.id,attrs:{"task":task,"due-date":_vm.dueDate,"is-patient":_vm.isPatient}})})):_vm._e()])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 410 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.tasksNumber),expression:"tasksNumber"}],staticClass:"task_menu task_menu_patient",attrs:{"id":"pat_task_menu"},on:{"mouseenter":function($event){_vm.showTaskList = true},"mouseleave":function($event){_vm.showTaskList = false}}},[_c('span',{staticClass:"task_header_patient",attrs:{"id":"pat_task_header"}},[_vm._v("Tasks("+_vm._s(_vm.tasksNumber)+")")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.showTaskList),expression:"showTaskList"}],staticClass:"task_list",attrs:{"id":"pat_task_list"}},[_c('task-data',{attrs:{"tasks":_vm.overdueTasks,"task-code":"od","task-type":"Overdue","red-header":true,"is-patient":true}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.todayTasks,"task-code":"tod","task-type":"Today","is-patient":true}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.tomorrowTasks,"task-code":"tom","task-type":"Tomorrow","is-patient":true}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.futureTasks,"task-code":"fut","task-type":"Future","is-patient":true}})],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 411 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 412 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    username: function username() {
      return this.$store.state.main[_symbols2.default.state.userInfo].username;
    }
  }
};

/***/ }),
/* 413 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"suckertreemenu"},[_c('span',{staticClass:"welcome-text"},[_vm._v("Welcome "+_vm._s(_vm.username))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 414 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"body-image"},[_c('div',{staticClass:"patient-menus"},[_c('patient-inner-menu',{attrs:{"patient-id":_vm.patientId}}),_vm._v(" "),_c('patient-task-menu',{attrs:{"patient-id":_vm.patientId}}),_vm._v(" "),_c('span',[_c('a',{directives:[{name:"show",rawName:"v-show",value:(!_vm.showAllWarnings),expression:"!showAllWarnings"}],staticClass:"button",attrs:{"href":"#","id":"show_patient_warnings"},on:{"click":function($event){$event.preventDefault();_vm.showWarnings()}}},[_vm._v("Show Warnings")]),_vm._v(" "),_c('a',{directives:[{name:"show",rawName:"v-show",value:(_vm.showAllWarnings),expression:"showAllWarnings"}],staticClass:"button",attrs:{"href":"#","id":"hide_patient_warnings"},on:{"click":function($event){$event.preventDefault();_vm.hideWarnings()}}},[_vm._v("Hide Warnings")])]),_vm._v(" "),_c('welcome-text'),_vm._v(" "),_c('patient-menu')],1),_vm._v(" "),_c('div',{staticClass:"clear"})])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 415 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientSearch_js__ = __webpack_require__(417);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientSearch_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientSearch_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6085c249_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientSearch_vue__ = __webpack_require__(418);
function injectStyle (ssrContext) {
  __webpack_require__(416)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6085c249"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientSearch_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6085c249_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientSearch_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 416 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 417 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      searchListHover: -1,
      searchTimeout: 0,
      inputValue: '',
      cursor: 'auto'
    };
  },

  computed: {
    patientList: function patientList() {
      return this.$store.state.main[_symbols2.default.state.patientSearchList];
    },
    showSearchHints: function showSearchHints() {
      return this.$store.state.main[_symbols2.default.state.showSearchHints];
    }
  },
  methods: {
    patientNameKeyPress: function patientNameKeyPress(event) {
      var enterCode = 13;
      if (event.keyCode === enterCode) {
        return false;
      }
      return true;
    },
    patientNameKeyUp: function patientNameKeyUp(event) {
      var asciiValue = event.which;
      var currentInputValue = event.target.value;

      if (currentInputValue.trim() === '') {
        this.$store.commit(_symbols2.default.mutations.hideSearchHints);
        this.$store.commit(_symbols2.default.mutations.patientSearchList, []);
        return;
      }
      if (!this.checkAsciiCode(asciiValue)) {
        return;
      }
      if (currentInputValue.length > 1 || this.patientList.length > 1) {
        this.$store.commit(_symbols2.default.mutations.showSearchHints);
        this.sendValue(currentInputValue);
        if (currentInputValue.length > 2) {
          this.inputValue.replace(/(\s+)?.$/, '');
        }
      }
    },
    checkAsciiCode: function checkAsciiCode(asciiValue) {
      if (!asciiValue) {
        return true;
      }
      var apostropheCode = 39;
      var aCapitalCode = 41;
      var zCode = 122;
      var backspaceCode = 8;
      if (asciiValue === backspaceCode) {
        return true;
      }
      if (asciiValue === apostropheCode) {
        return true;
      }
      if (asciiValue >= aCapitalCode && asciiValue <= zCode) {
        return true;
      }
      return false;
    },
    sendValue: function sendValue(searchTerm) {
      var _this = this;

      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      var searchBounce = 600;
      this.searchTimeout = setTimeout(function () {
        _this.$store.dispatch(_symbols2.default.actions.patientSearchList, searchTerm);
        _this.searchTimeout = 0;
      }, searchBounce);
    },
    patientListMouseOver: function patientListMouseOver(index, patientType) {
      if (patientType !== 'no') {
        this.cursor = 'pointer';
      }
      this.searchListHover = index;
    },
    patientListMouseOut: function patientListMouseOut(patientType) {
      if (patientType !== 'no') {
        this.cursor = 'auto';
      }
      this.searchListHover = -1;
      this.selectedUrl = '';
    },
    patientListClick: function patientListClick(listElement) {
      if (listElement.patientType === 'no') {
        return;
      }
      if (listElement.link) {
        this.inputValue = '';
        this.$store.commit(_symbols2.default.mutations.patientId, listElement.id);
        var query = {
          pid: listElement.id
        };
        this.$router.push({ name: 'patient-tracker', query: query });
        return;
      }
      this.inputValue = listElement.name;
      this.sendValue(listElement.name);
    }
  }
};

/***/ }),
/* 418 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',[_c('div',{staticClass:"patient_search_div",attrs:{"id":"patient_search_div"}},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.inputValue),expression:"inputValue"}],staticClass:"patient_search",attrs:{"type":"text","id":"patient_search","placeholder":"Patient Search","name":"q","autocomplete":"off"},domProps:{"value":(_vm.inputValue)},on:{"keypress":function($event){_vm.patientNameKeyPress($event)},"keyup":function($event){_vm.patientNameKeyUp($event)},"input":function($event){if($event.target.composing){ return; }_vm.inputValue=$event.target.value}}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.showSearchHints),expression:"showSearchHints"}],staticClass:"search_hints",attrs:{"id":"search_hints"}},[_c('ul',{directives:[{name:"show",rawName:"v-show",value:(_vm.patientList.length),expression:"patientList.length"}],staticClass:"search_list",attrs:{"id":"patient_list"}},_vm._l((_vm.patientList),function(patient,index){return _c('li',{staticClass:"template",class:{
                       'no_matches': patient.patientType === 'no',
                       'create_new': patient.patientType === 'new',
                       'json_patient': patient.patientType === 'json',
                       'list_hover': index === _vm.searchListHover
                    },style:({ 'cursor': _vm.cursor }),on:{"mouseover":function($event){_vm.patientListMouseOver(index, patient.patientType)},"mouseout":function($event){_vm.patientListMouseOut(patient.patientType)},"click":function($event){_vm.patientListClick(patient)}}},[_vm._v(_vm._s(patient.name))])}))])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 419 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskMenu_js__ = __webpack_require__(421);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cb0d76f6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskMenu_vue__ = __webpack_require__(422);
function injectStyle (ssrContext) {
  __webpack_require__(420)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-cb0d76f6"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TaskMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cb0d76f6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_TaskMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 420 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 421 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _TaskData = __webpack_require__(62);

var _TaskData2 = _interopRequireDefault(_TaskData);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      showTaskList: false
    };
  },

  computed: {
    tasksNumber: function tasksNumber() {
      return this.$store.getters[_symbols2.default.getters.tasksNumber];
    },
    overdueTasks: function overdueTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.OVERDUE);
    },
    todayTasks: function todayTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.TODAY);
    },
    tomorrowTasks: function tomorrowTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.TOMORROW);
    },
    thisWeekTasks: function thisWeekTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.THIS_WEEK);
    },
    nextWeekTasks: function nextWeekTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.NEXT_WEEK);
    },
    laterTasks: function laterTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.LATER);
    }
  },
  components: {
    taskData: _TaskData2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.retrieveTasks);
  }
};

/***/ }),
/* 422 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"task_menu task_menu_general",attrs:{"id":"task_menu"},on:{"mouseenter":function($event){_vm.showTaskList = true},"mouseleave":function($event){_vm.showTaskList = false}}},[_c('span',{attrs:{"id":"task_header"}},[_vm._v("\n        My Tasks ("),_c('span',{attrs:{"id":"task_count"}},[_vm._v(_vm._s(_vm.tasksNumber))]),_vm._v(")\n    ")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.showTaskList),expression:"showTaskList"}],staticClass:"task_list_general",attrs:{"id":"task_list"}},[_c('task-data',{attrs:{"tasks":_vm.overdueTasks,"task-code":"od","task-type":"Overdue","red-header":true,"is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.todayTasks,"task-code":"tod","task-type":"Today","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.tomorrowTasks,"task-code":"tom","task-type":"Tomorrow","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.thisWeekTasks,"task-code":"tw","task-type":"This Week","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.nextWeekTasks,"task-code":"nw","task-type":"Next Week","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.laterTasks,"task-code":"lat","task-type":"Later","due-date":true,"is-patient":false}}),_vm._v(" "),_c('br'),_c('br'),_vm._v(" "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/manage_tasks.php'),expression:"'manage/manage_tasks.php'"}],staticClass:"button task_view_all"},[_vm._v("View All")])],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 423 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_RightTopMenu_js__ = __webpack_require__(425);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_RightTopMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_RightTopMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_46cecf8c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_RightTopMenu_vue__ = __webpack_require__(426);
function injectStyle (ssrContext) {
  __webpack_require__(424)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-46cecf8c"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_RightTopMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_46cecf8c_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_RightTopMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 424 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 425 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    supportTicketsNumber: function supportTicketsNumber() {
      return this.$store.state.main[_symbols2.default.state.notificationNumbers][_main.NOTIFICATION_NUMBERS.supportTickets];
    },
    notificationsNumber: function notificationsNumber() {
      return this.$store.getters[_symbols2.default.getters.notificationsNumber];
    }
  },
  methods: {
    logout: function logout() {
      this.$store.commit(_symbols2.default.mutations.mainToken, '');
      _Alerter2.default.alert('Logout successfully');
      this.$router.push({ name: 'main-login' });
    }
  }
};

/***/ }),
/* 426 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"suckertreemenu2"},[_c('ul',{attrs:{"id":"topmenu2"}},[_c('li',[_c('router-link',{attrs:{"to":{name: 'dashboard'}}},[_vm._v("Notifications("+_vm._s(_vm.notificationsNumber)+")")])],1),_vm._v(" "),_c('li',{staticClass:"header_support",class:{'pending': _vm.supportTicketsNumber}},[_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/support.php'),expression:"'manage/support.php'"}]},[_vm._v("\n                Support "),(_vm.supportTicketsNumber)?_c('span',[_vm._v("("+_vm._s(_vm.supportTicketsNumber)+")")]):_vm._e()])]),_vm._v(" "),_c('li',[_c('a',{attrs:{"href":"#","id":"logout"},on:{"click":function($event){$event.preventDefault();_vm.logout()}}},[_vm._v("Sign Out")])])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 427 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_LeftTopMenu_js__ = __webpack_require__(429);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_LeftTopMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_LeftTopMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_d7b67eee_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_LeftTopMenu_vue__ = __webpack_require__(431);
function injectStyle (ssrContext) {
  __webpack_require__(428)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-d7b67eee"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_LeftTopMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_d7b67eee_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_LeftTopMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 428 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 429 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _CookieManager = __webpack_require__(430);

var _CookieManager2 = _interopRequireDefault(_CookieManager);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    showOnlineCEAndSnoozleHelp: function showOnlineCEAndSnoozleHelp() {
      return this.$store.getters[_symbols2.default.getters.shouldShowGetCE];
    }
  },
  methods: {
    removeCECookies: function removeCECookies() {
      _CookieManager2.default.removeCookie('edxloggin');
      _CookieManager2.default.removeCookie('sessionid');
    }
  }
};

/***/ }),
/* 430 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  removeCookie: function removeCookie(name) {
    document.cookie = encodeURIComponent(name) + '=; domain=dentalsleepsolutions.com; path=/; max-age=0; expires=Mon, 03 Jul 2006 21:44:38 GMT';
  }
};

/***/ }),
/* 431 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('span',{staticClass:"left-top-menu"},[(_vm.showOnlineCEAndSnoozleHelp)?_c('span',[_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/edx_login.php'),expression:"'manage/edx_login.php'"}],attrs:{"target":"_blank"},on:{"click":function($event){_vm.removeCECookies()}}},[_vm._v("Online CE")]),_vm._v(" "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/help_login.php'),expression:"'manage/help_login.php'"}],attrs:{"target":"_blank"},on:{"click":function($event){_vm.removeCECookies()}}},[_vm._v("Snoozle/Help")])]):_vm._e(),_vm._v(" "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/calendar.php'),expression:"'manage/calendar.php'"}]},[_vm._v("Scheduler")])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 432 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('right-top-menu'),_vm._v(" "),_c('task-menu'),_vm._v(" "),_c('left-top-menu'),_vm._v(" "),_c('div',{staticClass:"bottom-image"},[_c('div',{staticClass:"dashboard-link"},[_c('router-link',{staticClass:"logo-link",attrs:{"to":{name: 'dashboard'}}},[_vm._v("Dashboard")])],1),_vm._v(" "),_c('div',{staticClass:"patient-search"},[_c('patient-search'),_vm._v(" "),_c('button',{attrs:{"id":"add_patient_button"},on:{"click":function($event){_vm.goToAddPatient()}}},[_vm._v("+ Add Patient")]),_vm._v(" "),_c('button',{attrs:{"id":"add_task_button"},on:{"click":function($event){_vm.addTaskPopup()}}},[_vm._v("+ Add Task")])],1),_vm._v(" "),_c('div',{staticClass:"clear"})]),_vm._v(" "),(_vm.patientId)?_c('patient-header',{attrs:{"patient-id":_vm.patientId}}):_c('div',{staticClass:"body-image"},[_c('div',{staticClass:"patient-menus"},[_c('welcome-text'),_vm._v(" "),_c('div',{staticClass:"clear"})],1)])],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 433 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38c3115a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_CommonFooter_vue__ = __webpack_require__(435);
function injectStyle (ssrContext) {
  __webpack_require__(434)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = null
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-38c3115a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __WEBPACK_IMPORTED_MODULE_0__node_modules_vue_loader_lib_template_compiler_index_id_data_v_38c3115a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_CommonFooter_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 434 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 435 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"footer-image"})}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 436 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('table',{attrs:{"width":"980","border":"0","cellpadding":"0","cellspacing":"0","align":"center"}},[_vm._m(0),_vm._v(" "),_c('tr',[_c('td',{attrs:{"valign":"top","height":"400"}},[_c('common-header'),_vm._v(" "),_c('div',{attrs:{"id":"contentMain"}},[_c('div',{staticStyle:{"clear":"both"}}),_vm._v(" "),_c('router-view')],1),_vm._v(" "),_c('common-footer')],1)])])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('td',{attrs:{"colspan":"2","align":"right"}})])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 437 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardRoot_js__ = __webpack_require__(439);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardRoot_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardRoot_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6f3694eb_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardRoot_vue__ = __webpack_require__(469);
function injectStyle (ssrContext) {
  __webpack_require__(438)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6f3694eb"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardRoot_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6f3694eb_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardRoot_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 438 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 439 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _DashboardMessages = __webpack_require__(440);

var _DashboardMessages2 = _interopRequireDefault(_DashboardMessages);

var _DashboardNavigation = __webpack_require__(444);

var _DashboardNavigation2 = _interopRequireDefault(_DashboardNavigation);

var _DashboardNotifications = __webpack_require__(453);

var _DashboardNotifications2 = _interopRequireDefault(_DashboardNotifications);

var _DashboardTaskMenu = __webpack_require__(464);

var _DashboardTaskMenu2 = _interopRequireDefault(_DashboardTaskMenu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    homepage: function homepage() {
      return parseInt(this.$store.state.main[_symbols2.default.state.docInfo].homepage);
    }
  },
  components: {
    dashboardTaskMenu: _DashboardTaskMenu2.default,
    dashboardMessages: _DashboardMessages2.default,
    dashboardNavigation: _DashboardNavigation2.default,
    dashboardNotifications: _DashboardNotifications2.default
  }
};

/***/ }),
/* 440 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardMessages_js__ = __webpack_require__(442);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardMessages_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardMessages_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4bb9a056_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardMessages_vue__ = __webpack_require__(443);
function injectStyle (ssrContext) {
  __webpack_require__(441)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4bb9a056"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardMessages_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4bb9a056_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardMessages_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 441 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 442 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    memos: function memos() {
      return this.$store.state.dashboard[_symbols2.default.state.memos];
    }
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.memos);
  }
};

/***/ }),
/* 443 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('h3',[_vm._v("Messages")]),_vm._v(" "),_c('div',{staticClass:"task_menu index_task"},[_c('ul',_vm._l((_vm.memos),function(memo){return _c('li',{key:memo.id,domProps:{"innerHTML":_vm._s(memo.memo)}})}))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 444 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNavigation_js__ = __webpack_require__(446);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNavigation_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNavigation_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_008c4746_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardNavigation_vue__ = __webpack_require__(452);
function injectStyle (ssrContext) {
  __webpack_require__(445)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-008c4746"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNavigation_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_008c4746_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardNavigation_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 445 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 446 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _dashboard = __webpack_require__(102);

var _NavigationElement = __webpack_require__(447);

var _NavigationElement2 = _interopRequireDefault(_NavigationElement);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      menu: _dashboard.NAVIGATION_MENU,
      documentCategories: []
    };
  },

  components: {
    navigationElement: _NavigationElement2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.documentCategories);
  },

  methods: {
    resolveCondition: function resolveCondition(getterName) {
      if (!getterName) {
        return true;
      }
      return this.$store.getters[getterName];
    }
  }
};

/***/ }),
/* 447 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NavigationElement_js__ = __webpack_require__(449);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NavigationElement_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_NavigationElement_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4e4383c6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NavigationElement_vue__ = __webpack_require__(451);
function injectStyle (ssrContext) {
  __webpack_require__(448)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4e4383c6"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_NavigationElement_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4e4383c6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NavigationElement_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 448 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 449 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _populators = __webpack_require__(450);

var _populators2 = _interopRequireDefault(_populators);

var _LegacyModifier = __webpack_require__(61);

var _LegacyModifier2 = _interopRequireDefault(_LegacyModifier);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'navigation-element',
  props: {
    menuItem: {
      type: Object,
      required: true
    },
    firstLevel: {
      type: Boolean,
      default: true
    }
  },
  data: function data() {
    return {
      showChildren: false,
      elementName: ''
    };
  },

  computed: {
    menuItemLink: function menuItemLink() {
      if (this.menuItem.hasOwnProperty('link') && this.menuItem.link) {
        if (this.menuItem.hasOwnProperty('legacy') && !this.menuItem.legacy) {
          return this.menuItem.link;
        }
        return _LegacyModifier2.default.modifyLegacyLink(this.menuItem.link);
      }
      return '#';
    },
    menuItemChildren: function menuItemChildren() {
      if (this.menuItem.hasOwnProperty('children')) {
        return this.menuItem.children;
      }
      return [];
    },
    menuItemBlank: function menuItemBlank() {
      if (this.menuItem.hasOwnProperty('blank')) {
        return this.menuItem.blank;
      }
      return false;
    },
    linkClass: function linkClass() {
      if (this.menuItemChildren.length && this.firstLevel) {
        return 'mainfoldericon';
      }
      if ((this.menuItemChildren.length || this.menuItem.childrenFrom) && !this.firstLevel) {
        return 'subfoldericon';
      }
      return '';
    }
  },
  created: function created() {
    var elementName = this.menuItem.name;
    if (this.menuItem.hasOwnProperty('populator') && this.menuItem.populator) {
      elementName = _populators2.default[this.menuItem.populator](this.$store.state, elementName);
    }
    this.elementName = elementName;
  },

  methods: {
    clickLink: function clickLink(event) {
      if (this.menuItem.hasOwnProperty('action') && this.menuItem.action) {
        event.preventDefault();
        this.$store.dispatch(this.menuItem.action);
      }
    },
    resolveCondition: function resolveCondition(getterName) {
      if (!getterName) {
        return true;
      }
      return this.$store.getters[getterName];
    },
    getChildrenFrom: function getChildrenFrom(getterName) {
      return this.$store.getters[getterName];
    }
  }
};

/***/ }),
/* 450 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (0, _defineProperty3.default)({}, _symbols2.default.populators.populateClaims, function (state, elementName) {
  var newName = elementName;
  var pendingClaimsNumber = state.main[_symbols2.default.state.notificationNumbers][_main.NOTIFICATION_NUMBERS.pendingClaims];
  newName += ' (' + pendingClaimsNumber + ')';
  return newName;
});

/***/ }),
/* 451 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('li',{on:{"mouseover":function($event){_vm.showChildren = true},"mouseout":function($event){_vm.showChildren = false}}},[(_vm.menuItem.route)?_c('router-link',{class:_vm.linkClass,attrs:{"to":{name: _vm.menuItem.route}}},[_vm._v(_vm._s(_vm.elementName))]):_c('a',{class:_vm.linkClass,attrs:{"href":_vm.menuItem.childrenFrom ? '#' : _vm.menuItemLink,"target":_vm.menuItemBlank ? '_blank' : '_self'},on:{"click":function($event){_vm.clickLink($event)}}},[_vm._v(_vm._s(_vm.elementName))]),_vm._v(" "),(_vm.menuItemChildren.length)?_c('ul',{directives:[{name:"visible",rawName:"v-visible",value:(_vm.showChildren),expression:"showChildren"}]},_vm._l((_vm.menuItemChildren),function(childItem){return (_vm.resolveCondition(childItem.shouldParse))?_c('navigation-element',{key:childItem.name,attrs:{"menu-item":childItem,"first-level":false}}):_vm._e()})):(_vm.menuItem.childrenFrom)?_c('ul',{directives:[{name:"visible",rawName:"v-visible",value:(_vm.showChildren),expression:"showChildren"}]},_vm._l((_vm.getChildrenFrom(_vm.menuItem.childrenFrom)),function(childFrom){return _c('li',[_c('a',{staticClass:"submenu_item",attrs:{"href":_vm.menuItemLink + childFrom[_vm.menuItem.childId]}},[_vm._v(_vm._s(childFrom[_vm.menuItem.childName]))])])})):_vm._e()],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 452 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('h3',[_vm._v("Navigation")]),_vm._v(" "),_c('div',{staticClass:"homesuckertreemenu"},[_c('ul',{attrs:{"id":"homemenu"}},_vm._l((_vm.menu),function(menuItem){return (_vm.resolveCondition(menuItem.shouldParse))?_c('navigation-element',{key:menuItem.name,attrs:{"menu-item":menuItem}}):_vm._e()}))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 453 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNotifications_js__ = __webpack_require__(455);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNotifications_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNotifications_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6f9fbfa2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardNotifications_vue__ = __webpack_require__(463);
function injectStyle (ssrContext) {
  __webpack_require__(454)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6f9fbfa2"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardNotifications_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6f9fbfa2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardNotifications_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 454 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 455 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _dashboard = __webpack_require__(102);

var _NotificationLink = __webpack_require__(103);

var _NotificationLink2 = _interopRequireDefault(_NotificationLink);

var _NotificationBranch = __webpack_require__(459);

var _NotificationBranch2 = _interopRequireDefault(_NotificationBranch);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      notifications: _dashboard.NOTIFICATIONS,
      showAll: false
    };
  },

  components: {
    notificationBranch: _NotificationBranch2.default,
    notificationLink: _NotificationLink2.default
  },
  methods: {
    showAllNotifications: function showAllNotifications() {
      this.showAll = true;
    },
    showActiveNotifications: function showActiveNotifications() {
      this.showAll = false;
    },
    resolveCondition: function resolveCondition(getterName) {
      if (!getterName) {
        return true;
      }
      return this.$store.getters[getterName];
    }
  }
};

/***/ }),
/* 456 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 457 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    linkCount: {
      type: String,
      required: true
    },
    linkLabel: {
      type: String,
      required: true
    },
    linkUrl: {
      type: String,
      default: ''
    },
    countZeroClass: {
      type: String,
      default: 'good_count'
    },
    countNonZeroClass: {
      type: String,
      default: 'bad_count'
    },
    hasChildren: {
      type: Boolean,
      default: false
    },
    showAll: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    linkNumber: function linkNumber() {
      return this.$store.state.main[_symbols2.default.state.notificationNumbers][this.linkCount];
    }
  }
};

/***/ }),
/* 458 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('a',{directives:[{name:"show",rawName:"v-show",value:(_vm.showAll || _vm.linkNumber),expression:"showAll || linkNumber"},{name:"legacy-href",rawName:"v-legacy-href",value:(_vm.hasChildren ? '#' : _vm.linkUrl),expression:"hasChildren ? '#' : linkUrl"}],class:'notification count_' + _vm.linkNumber + ' ' + (_vm.linkNumber === 0 ? _vm.countZeroClass : _vm.countNonZeroClass)},[_c('span',{staticClass:"count"},[_vm._v(_vm._s(_vm.linkNumber))]),_vm._v(" "),_c('span',{staticClass:"label"},[_vm._v(_vm._s(_vm.linkLabel))]),_vm._v(" "),(_vm.hasChildren)?_c('div',{staticClass:"arrow_right"}):_vm._e()])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 459 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationBranch_js__ = __webpack_require__(461);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationBranch_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationBranch_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0ebed8e8_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NotificationBranch_vue__ = __webpack_require__(462);
function injectStyle (ssrContext) {
  __webpack_require__(460)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-0ebed8e8"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_NotificationBranch_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0ebed8e8_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_NotificationBranch_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 460 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 461 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _NotificationLink = __webpack_require__(103);

var _NotificationLink2 = _interopRequireDefault(_NotificationLink);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    notification: {
      type: Object,
      required: true
    },
    showAll: {
      type: Boolean,
      required: true
    }
  },
  data: function data() {
    return {
      childrenShown: false
    };
  },

  components: {
    notificationLink: _NotificationLink2.default
  },
  methods: {
    showChildren: function showChildren() {
      this.childrenShown = true;
    },
    hideChildren: function hideChildren() {
      this.childrenShown = false;
    },
    resolveCondition: function resolveCondition(getterName) {
      if (!getterName) {
        return true;
      }
      return this.$store.getters[getterName];
    }
  }
};

/***/ }),
/* 462 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"notsuckertreemenu"},[_c('ul',{attrs:{"id":"notmenu"}},[_c('li',{on:{"mouseover":function($event){_vm.showChildren()},"mouseout":function($event){_vm.hideChildren()}}},[_c('notification-link',{key:_vm.notification.label,attrs:{"link-count":_vm.notification.number,"link-label":_vm.notification.label,"link-url":_vm.notification.link,"count-zero-class":_vm.notification.countZero,"count-non-zero-class":_vm.notification.countNonZero,"has-children":true}}),_vm._v(" "),_c('ul',{directives:[{name:"visible",rawName:"v-visible",value:(_vm.childrenShown),expression:"childrenShown"}],staticClass:"children-links"},_vm._l((_vm.notification.children),function(notificationChild){return (_vm.resolveCondition(notificationChild.shouldParse))?_c('li',[_c('notification-link',{key:notificationChild.label,attrs:{"link-count":notificationChild.number,"link-label":notificationChild.label,"link-url":notificationChild.link,"count-zero-class":notificationChild.countZero,"count-non-zero-class":notificationChild.countNonZero,"show-all":_vm.showAll}})],1):_vm._e()}))],1)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 463 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('h3',[_vm._v("Notifications")]),_vm._v(" "),_vm._l((_vm.notifications),function(notification){return (_vm.resolveCondition(notification.shouldParse))?[(notification.hasOwnProperty('children') && notification.children.length)?_c('notification-branch',{attrs:{"notification":notification,"show-all":_vm.showAll}}):_c('notification-link',{key:notification.label,attrs:{"link-count":notification.number,"link-label":notification.label,"link-url":notification.link,"count-zero-class":notification.countZero,"count-non-zero-class":notification.countNonZero,"show-all":_vm.showAll}})]:_vm._e()}),_vm._v(" "),_c('a',{directives:[{name:"show",rawName:"v-show",value:(!_vm.showAll),expression:"!showAll"}],attrs:{"href":"#","id":"not_show_all"},on:{"click":function($event){$event.preventDefault();_vm.showAllNotifications()}}},[_vm._v("Show All")]),_vm._v(" "),_c('a',{directives:[{name:"show",rawName:"v-show",value:(_vm.showAll),expression:"showAll"}],attrs:{"href":"#","id":"not_show_active"},on:{"click":function($event){$event.preventDefault();_vm.showActiveNotifications()}}},[_vm._v("Show Active")])],2)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 464 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardTaskMenu_js__ = __webpack_require__(466);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardTaskMenu_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardTaskMenu_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_bb4771e6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardTaskMenu_vue__ = __webpack_require__(468);
function injectStyle (ssrContext) {
  __webpack_require__(465)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-bb4771e6"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_DashboardTaskMenu_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_bb4771e6_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_DashboardTaskMenu_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 465 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 466 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _TaskMenu = __webpack_require__(467);

var _TaskMenu2 = _interopRequireDefault(_TaskMenu);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _TaskMenu2.default;

/***/ }),
/* 467 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _TaskData = __webpack_require__(62);

var _TaskData2 = _interopRequireDefault(_TaskData);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      showTaskList: false
    };
  },

  computed: {
    tasksNumber: function tasksNumber() {
      return this.$store.getters[_symbols2.default.getters.tasksNumber];
    },
    overdueTasks: function overdueTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.OVERDUE);
    },
    todayTasks: function todayTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.TODAY);
    },
    tomorrowTasks: function tomorrowTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.TOMORROW);
    },
    thisWeekTasks: function thisWeekTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.THIS_WEEK);
    },
    nextWeekTasks: function nextWeekTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.NEXT_WEEK);
    },
    laterTasks: function laterTasks() {
      return this.$store.getters[_symbols2.default.getters.tasksByType](_main.TASK_TYPES.LATER);
    }
  },
  components: {
    taskData: _TaskData2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.retrieveTasks);
  }
};

/***/ }),
/* 468 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"task_menu index_task",attrs:{"id":"index_task_list"}},[_c('h4',[_vm._v("My Tasks")]),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.overdueTasks,"task-code":"od","task-type":"Overdue","red-header":true,"is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.todayTasks,"task-code":"tod","task-type":"Today","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.tomorrowTasks,"task-code":"tom","task-type":"Tomorrow","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.thisWeekTasks,"task-code":"tw","task-type":"This Week","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.nextWeekTasks,"task-code":"nw","task-type":"Next Week","is-patient":false}}),_vm._v(" "),_c('task-data',{attrs:{"tasks":_vm.laterTasks,"task-code":"lat","task-type":"Later","due-date":true,"is-patient":false}}),_vm._v(" "),_c('br'),_c('br'),_vm._v(" "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/manage_tasks.php'),expression:"'manage/manage_tasks.php'"}],staticClass:"button task_view_all"},[_vm._v("View All")])],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 469 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('br'),_vm._v(" "),(_vm.homepage === 1)?_c('table',{attrs:{"id":"dashboard"}},[_c('tr',[_c('td',{staticClass:"main_cell",attrs:{"valign":"top"}},[_c('div',{staticClass:"home_third first"},[_c('dashboard-navigation')],1),_vm._v(" "),_c('div',{staticClass:"home_third"},[_c('dashboard-notifications')],1),_vm._v(" "),_c('div',{staticClass:"home_third"},[_c('h3',[_vm._v("Tasks")]),_vm._v(" "),_c('dashboard-task-menu'),_vm._v(" "),_c('br'),_c('br'),_vm._v(" "),_c('dashboard-messages')],1)])])]):_vm._e(),_vm._v(" "),_c('br'),_c('br')])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 470 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientRoot_js__ = __webpack_require__(471);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientRoot_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientRoot_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_862d6a34_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PatientRoot_vue__ = __webpack_require__(483);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientRoot_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_862d6a34_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PatientRoot_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 471 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _PatientData = __webpack_require__(472);

var _PatientData2 = _interopRequireDefault(_PatientData);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      patientId: this.$store.state.patients[_symbols2.default.state.patientId]
    };
  },

  components: {
    patientData: _PatientData2.default
  },
  created: function created() {
    if (this.$route.query.hasOwnProperty('pid')) {
      var patientId = parseInt(this.$route.query.pid);
      this.updatePatientData(patientId);
    }
  },
  beforeRouteUpdate: function beforeRouteUpdate(to, from, next) {
    var toPatientId = 0;
    if (to.query.hasOwnProperty('pid')) {
      toPatientId = parseInt(to.query.pid);
    }
    if (!toPatientId) {
      this.clearPatientData();
      next();
      return;
    }
    var fromPatientId = 0;
    if (from.query.hasOwnProperty('pid')) {
      fromPatientId = parseInt(from.query.pid);
    }
    if (toPatientId !== fromPatientId) {
      this.updatePatientData(toPatientId);
    }
    next();
  },
  beforeRouteLeave: function beforeRouteLeave(to, from, next) {
    this.clearPatientData();
    next();
  },

  methods: {
    updatePatientData: function updatePatientData(patientId) {
      this.$store.dispatch(_symbols2.default.actions.patientData, patientId);
      this.$store.dispatch(_symbols2.default.actions.retrieveTasksForPatient, this.patientId);
    },
    clearPatientData: function clearPatientData() {
      this.$store.dispatch(_symbols2.default.actions.clearPatientData);
      this.$store.commit(_symbols2.default.mutations.setTasksForPatient, []);
    }
  }
};

/***/ }),
/* 472 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientData_js__ = __webpack_require__(474);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientData_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientData_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_317e15ae_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientData_vue__ = __webpack_require__(482);
function injectStyle (ssrContext) {
  __webpack_require__(473)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-317e15ae"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientData_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_317e15ae_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientData_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 473 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 474 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _PatientWarnings = __webpack_require__(475);

var _PatientWarnings2 = _interopRequireDefault(_PatientWarnings);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    showAllWarnings: function showAllWarnings() {
      return this.$store.state.patients[_symbols2.default.state.showAllWarnings];
    }
  },
  components: {
    patientWarnings: _PatientWarnings2.default
  }
};

/***/ }),
/* 475 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientWarnings_js__ = __webpack_require__(477);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientWarnings_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientWarnings_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_507d944a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientWarnings_vue__ = __webpack_require__(481);
function injectStyle (ssrContext) {
  __webpack_require__(476)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-507d944a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientWarnings_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_507d944a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientWarnings_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 476 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 477 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

var _PatientIncompleteHst = __webpack_require__(478);

var _PatientIncompleteHst2 = _interopRequireDefault(_PatientIncompleteHst);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data: function data() {
    return {
      profileUpdateText: this.getUpdateText('profile'),
      questionnaireUpdateText: this.getUpdateText('questionnaire')
    };
  },

  computed: {
    incompleteHomeSleepTests: function incompleteHomeSleepTests() {
      return this.$store.state.patients[_symbols2.default.state.incompleteHomeSleepTests];
    },
    showWarningAboutPatientChanges: function showWarningAboutPatientChanges() {
      return this.$store.getters[_symbols2.default.getters.showWarningAboutPatientChanges];
    },
    showWarningAboutQuestionnaireChanges: function showWarningAboutQuestionnaireChanges() {
      return this.$store.getters[_symbols2.default.getters.showWarningAboutQuestionnaireChanges];
    },
    showWarningAboutBouncedEmails: function showWarningAboutBouncedEmails() {
      return this.$store.getters[_symbols2.default.getters.showWarningAboutBouncedEmails];
    },
    rejectedClaimsForCurrentPatient: function rejectedClaimsForCurrentPatient() {
      return this.$store.state.patients[_symbols2.default.state.rejectedClaimsForCurrentPatient];
    }
  },
  components: {
    patientIncompleteHst: _PatientIncompleteHst2.default
  },
  methods: {
    getUpdateText: function getUpdateText(replacement) {
      return _main.NOT_ACCEPTED_UPDATE.replace('%s', replacement.toUpperCase());
    }
  }
};

/***/ }),
/* 478 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientIncompleteHst_js__ = __webpack_require__(479);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientIncompleteHst_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientIncompleteHst_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3517c4b7_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PatientIncompleteHst_vue__ = __webpack_require__(480);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientIncompleteHst_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3517c4b7_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_PatientIncompleteHst_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 479 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

exports.default = {
  props: {
    status: {
      type: Number,
      required: true
    },
    hstId: {
      type: Number,
      required: true
    },
    patientId: {
      type: Number,
      required: true
    },
    dateAdded: {
      validator: function validator(value) {
        return value instanceof Date;
      }
    },
    dateRejected: {
      validator: function validator(value) {
        if (!value) {
          return true;
        }
        return value instanceof Date;
      }
    },
    officeNotes: {
      type: String,
      required: true
    },
    rejectedReason: {
      type: String,
      required: true
    }
  },
  data: function data() {
    return {
      scheduledHst: _main.DSS_CONSTANTS.DSS_HST_SCHEDULED,
      rejectedHst: _main.DSS_CONSTANTS.DSS_HST_REJECTED
    };
  },

  computed: {
    hstStatusLabel: function hstStatusLabel() {
      if (_main.HST_STATUSES.hasOwnProperty(this.status)) {
        return _main.HST_STATUSES[this.status];
      }
      return '';
    },
    rejectedWithDate: function rejectedWithDate() {
      if (this.status !== this.rejectedHst) {
        return false;
      }
      if (!this.dateRejected) {
        return false;
      }
      return true;
    }
  }
};

/***/ }),
/* 480 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('span',[_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/hst_request.php?pid=' + _vm.patientId + '&hst_id=' + _vm.hstId),expression:"'manage/hst_request.php?pid=' + patientId + '&hst_id=' + hstId"}]},[_vm._v("HST was requested "+_vm._s(_vm._f("moment")(_vm.dateAdded,"MM/DD/YYYY")))]),_vm._v(" "),_c('span',[_vm._v("and is currently")]),_vm._v(" "),_c('span',[(_vm.status === _vm.rejectedHst)?_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage_hst.php?status=4&viewed=0'),expression:"'manage_hst.php?status=4&viewed=0'"}]},[_vm._v(_vm._s(_vm.hstStatusLabel))]):_c('span',[_vm._v(_vm._s(_vm.hstStatusLabel))])]),_vm._v(" "),(_vm.status === _vm.scheduledHst)?_c('span',[_vm._v(" - "+_vm._s(_vm.officeNotes))]):_vm._e(),_vm._v(" "),(_vm.status === _vm.rejectedHst)?_c('span',[_vm._v(" - "+_vm._s(_vm.rejectedReason))]):_vm._e(),_vm._v(" "),(_vm.rejectedWithDate)?_c('span',[_vm._v(" - "+_vm._s(_vm._f("moment")(_vm.dateRejected,"MM/DD/YYYY hh:mm a")))]):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.status === _vm.rejectedHst)?_c('span',[_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage_hst.php?status=4&viewed=0'),expression:"'manage_hst.php?status=4&viewed=0'"}]},[_vm._v("Click here")]),_vm._v("\n        to remove this error\n    ")]):_vm._e()])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 481 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"warning-div",attrs:{"id":"patient_warnings"}},[(_vm.showWarningAboutPatientChanges)?_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('patient_changes.php?pid=' + _vm.patientId),expression:"'patient_changes.php?pid=' + patientId"}]},[_c('span',[_vm._v(_vm._s(_vm.profileUpdateText))])]):_vm._e(),_vm._v(" "),(_vm.showWarningAboutQuestionnaireChanges)?_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('q_page1.php?pid=' + _vm.patientId + '&addtopat=1'),expression:"'q_page1.php?pid=' + patientId + '&addtopat=1'"}]},[_c('span',[_vm._v(_vm._s(_vm.questionnaireUpdateText))])]):_vm._e(),_vm._v(" "),(_vm.showWarningAboutBouncedEmails)?_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('add_patient.php?ed=' + _vm.patientId + '&pid=' + _vm.patientId + '&addtopat=1'),expression:"'add_patient.php?ed=' + patientId + '&pid=' + patientId + '&addtopat=1'"}]},[_c('span',[_vm._v("Warning! Email sent to this patient has bounced. Please click to check patients email.")])]):_vm._e(),_vm._v(" "),(_vm.rejectedClaimsForCurrentPatient.length)?_c('span',{staticClass:"warning"},[_vm._v("\n        Warning! Patient has the following rejected claims:\n        "),_c('br'),_vm._v(" "),_vm._l((_vm.rejectedClaimsForCurrentPatient),function(claim){return _c('span',[_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('view_claim.php?claimid=' + claim.insuranceId + '&pid=' + _vm.patientId),expression:"'view_claim.php?claimid=' + claim.insuranceId + '&pid=' + patientId"}]},[_vm._v(_vm._s(claim.insuranceId)+" - "+_vm._s(_vm._f("moment")(claim.addDate,"MM/DD/YYYY")))]),_vm._v(" "),_c('br')])})],2):_vm._e(),_vm._v(" "),(_vm.incompleteHomeSleepTests.length)?_c('span',{staticClass:"warning"},[_vm._v("\n        Patient has the following Home Sleep Tests:\n        "),_c('br'),_vm._v(" "),_vm._l((_vm.incompleteHomeSleepTests),function(incompleteTest){return _c('patient-incomplete-hst',{key:incompleteTest.id,attrs:{"status":incompleteTest.status,"hst-id":incompleteTest.id,"patient-id":incompleteTest.patientId,"date-added":incompleteTest.addDate,"date-rejected":incompleteTest.rejectedDate,"office-notes":incompleteTest.officeNotes,"rejected-reason":incompleteTest.rejectedReason}})})],2):_vm._e()])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 482 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[(false)?_c('div',{staticClass:"patient-chart"},[_vm._v("\n        You are currently in a patient chart -\n        "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage_patient.php'),expression:"'manage_patient.php'"}],staticClass:"back-to-list"},[_vm._v("Back to patient list")])]):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('patient-warnings',{directives:[{name:"show",rawName:"v-show",value:(_vm.showAllWarnings),expression:"showAllWarnings"}],attrs:{"patient-id":_vm.patientId}})],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 483 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('patient-data',{attrs:{"patient-id":_vm.patientId}}),_vm._v(" "),_c('router-view')],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 484 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_patients_js__ = __webpack_require__(487);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_patients_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_patients_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1f2f3c9f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_patients_vue__ = __webpack_require__(490);
function injectStyle (ssrContext) {
  __webpack_require__(485)
  __webpack_require__(486)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1f2f3c9f"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_patients_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1f2f3c9f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_patients_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 485 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 486 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 487 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _accounting = __webpack_require__(63);

var _accounting2 = _interopRequireDefault(_accounting);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

var _MomentWrapper = __webpack_require__(64);

var _MomentWrapper2 = _interopRequireDefault(_MomentWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      patientInfo: '',
      routeParameters: {
        patientId: null,
        currentPageNumber: 0,
        sortDirection: 'asc',
        selectedPatientType: '1',
        sortColumn: 'name',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      patientsTotalNumber: 0,
      patientsPerPage: 30,
      patientTypeSelect: [{ text: 'Active Patients', value: '1' }, { text: 'All Patients', value: '2' }, { text: 'In-active Patients', value: '3' }],
      patients: [],
      tableHeaders: {
        'name': 'Name',
        'tx': 'Ready for Tx',
        'next-visit': 'Next Visit',
        'last-visit': 'Last Visit',
        'last-treatment': 'Last Treatment',
        'appliance': 'Appliance',
        'appliance-since': 'Appliance Since',
        'vob': 'VOB',
        'rx-lomn': 'Rx./L.O.M.N.',
        'ledger': 'Ledger'
      },
      segments: ['', 'Initial Contact', 'Consult', 'Sleep Study', 'Impressions', 'Delaying Tx / Waiting', 'Refused Treatment', 'Device Delivery', 'Check / Follow Up', 'Pt. Non-Compliant', 'Home Sleep Test', 'Treatment Complete', 'Annual Recall', 'Termination', 'Not a Candidate', 'Baseline Sleep Test'],
      preauthLabels: _main.PREAUTH_STATUS_LABELS
    };
  },

  watch: {
    '$route.query.sh': function $routeQuerySh() {
      var _this = this;

      if (this.$route.query.sh) {
        var foundOption = this.patientTypeSelect.find(function (el) {
          return el.value === _this.$route.query.sh;
        });

        if (foundOption) {
          this.$set(this.routeParameters, 'selectedPatientType', this.$route.query.sh);
        } else {
          this.$set(this.routeParameters, 'selectedPatientType', 1);
        }
      }
    },
    '$route.query.page': function $routeQueryPage() {
      if (this.$route.query.page) {
        if (this.$route.query.page <= this.totalPages) {
          this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page);
        }
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort);
        } else {
          this.$set(this.routeParameters, 'sortColumn', null);
        }
      }
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase());
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc');
        }
      }
    },
    '$route.query.pid': function $routeQueryPid() {
      var queryPatientId = this.$route.query.pid;
      var patientId = null;
      if (queryPatientId > 0) {
        patientId = queryPatientId;
      }
      this.$set(this.routeParameters, 'patientId', patientId);
    },
    '$route.query.letter': function $routeQueryLetter() {
      var queryLetter = this.$route.query.letter;
      var letter = null;
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter;
      }
      this.$set(this.routeParameters, 'currentLetter', letter);
    },
    '$route.query.delid': function $routeQueryDelid() {
      if (this.$route.query.delid > 0) {
        this.onDeletePatient(this.$route.query.delid);
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getPatients();
      },
      deep: true
    }
  },
  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.patientsTotalNumber / this.patientsPerPage);
    }
  },
  created: function created() {
    this.getPatients();
  },

  methods: {
    onChangePatientTypeSelect: function onChangePatientTypeSelect() {
      this.$router.push({
        name: this.$route.name,
        query: {
          sh: this.routeParameters.selectedPatientType
        }
      });
    },
    onDeletePatient: function onDeletePatient(patientId) {
      var _this2 = this;

      this.deletePatient(patientId).then(function () {
        _this2.message = 'Deleted Successfully';
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'deletePatient', response: response });
      });
    },
    getRxLomn: function getRxLomn(value) {
      switch (+value) {
        case 3:
          return 'Yes';
        case 2:
          return 'Yes/No';
        case 1:
          return 'No/Yes';
      }
      return 'No';
    },
    formatLedger: function formatLedger(value) {
      return _accounting2.default.formatMoney(value, '$');
    },
    checkIfThisWeek: function checkIfThisWeek(value) {
      var totalDays = _MomentWrapper2.default.create(value).diff(_MomentWrapper2.default.create(), 'days');
      var negative = _MomentWrapper2.default.create(value) - _MomentWrapper2.default.create() < 0;

      return totalDays >= 0 && totalDays <= 7 && !negative;
    },
    isNegativeTime: function isNegativeTime(value) {
      return _MomentWrapper2.default.create(value) - _MomentWrapper2.default.create() < 0;
    },
    readyForTx: function readyForTx(insuranceNoError, numSleepStudy) {
      return +insuranceNoError && numSleepStudy !== 0;
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      }
      return sort === 'name' ? 'asc' : 'desc';
    },
    getPatients: function getPatients() {
      var _this3 = this;

      this.findPatients(this.routeParameters.patientId, this.routeParameters.selectedPatientType, this.routeParameters.currentPageNumber, this.patientsPerPage, this.routeParameters.currentLetter, this.routeParameters.sortColumn, this.routeParameters.sortDirection).then(function (response) {
        var data = response.data.data;

        var totalCount = data.count[0].total;
        var patients = data.results;

        _this3.patientsTotalNumber = totalCount;
        _this3.patients = patients;
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'findPatients', response: response });
      });
    },
    deletePatient: function deletePatient(patientId) {
      patientId = patientId || 0;

      return _http2.default.delete(_endpoints2.default.patients.destroyForDoctor + '/' + patientId);
    },
    findPatients: function findPatients(patientId, type, pageNumber, patientsPerPage, letter, sortColumn, sortDir) {
      var data = {
        patientId: patientId || 0,
        type: type || 0,
        page: pageNumber || 0,
        patientsPerPage: patientsPerPage || 0,
        letter: letter || '',
        sortColumn: sortColumn || '',
        sortDir: sortDir || ''
      };

      return _http2.default.post(_endpoints2.default.patients.find, data);
    }
  }
};

/***/ }),
/* 488 */,
/* 489 */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./af": 104,
	"./af.js": 104,
	"./ar": 105,
	"./ar-dz": 106,
	"./ar-dz.js": 106,
	"./ar-kw": 107,
	"./ar-kw.js": 107,
	"./ar-ly": 108,
	"./ar-ly.js": 108,
	"./ar-ma": 109,
	"./ar-ma.js": 109,
	"./ar-sa": 110,
	"./ar-sa.js": 110,
	"./ar-tn": 111,
	"./ar-tn.js": 111,
	"./ar.js": 105,
	"./az": 112,
	"./az.js": 112,
	"./be": 113,
	"./be.js": 113,
	"./bg": 114,
	"./bg.js": 114,
	"./bn": 115,
	"./bn.js": 115,
	"./bo": 116,
	"./bo.js": 116,
	"./br": 117,
	"./br.js": 117,
	"./bs": 118,
	"./bs.js": 118,
	"./ca": 119,
	"./ca.js": 119,
	"./cs": 120,
	"./cs.js": 120,
	"./cv": 121,
	"./cv.js": 121,
	"./cy": 122,
	"./cy.js": 122,
	"./da": 123,
	"./da.js": 123,
	"./de": 124,
	"./de-at": 125,
	"./de-at.js": 125,
	"./de-ch": 126,
	"./de-ch.js": 126,
	"./de.js": 124,
	"./dv": 127,
	"./dv.js": 127,
	"./el": 128,
	"./el.js": 128,
	"./en-au": 129,
	"./en-au.js": 129,
	"./en-ca": 130,
	"./en-ca.js": 130,
	"./en-gb": 131,
	"./en-gb.js": 131,
	"./en-ie": 132,
	"./en-ie.js": 132,
	"./en-nz": 133,
	"./en-nz.js": 133,
	"./eo": 134,
	"./eo.js": 134,
	"./es": 135,
	"./es-do": 136,
	"./es-do.js": 136,
	"./es.js": 135,
	"./et": 137,
	"./et.js": 137,
	"./eu": 138,
	"./eu.js": 138,
	"./fa": 139,
	"./fa.js": 139,
	"./fi": 140,
	"./fi.js": 140,
	"./fo": 141,
	"./fo.js": 141,
	"./fr": 142,
	"./fr-ca": 143,
	"./fr-ca.js": 143,
	"./fr-ch": 144,
	"./fr-ch.js": 144,
	"./fr.js": 142,
	"./fy": 145,
	"./fy.js": 145,
	"./gd": 146,
	"./gd.js": 146,
	"./gl": 147,
	"./gl.js": 147,
	"./gom-latn": 148,
	"./gom-latn.js": 148,
	"./he": 149,
	"./he.js": 149,
	"./hi": 150,
	"./hi.js": 150,
	"./hr": 151,
	"./hr.js": 151,
	"./hu": 152,
	"./hu.js": 152,
	"./hy-am": 153,
	"./hy-am.js": 153,
	"./id": 154,
	"./id.js": 154,
	"./is": 155,
	"./is.js": 155,
	"./it": 156,
	"./it.js": 156,
	"./ja": 157,
	"./ja.js": 157,
	"./jv": 158,
	"./jv.js": 158,
	"./ka": 159,
	"./ka.js": 159,
	"./kk": 160,
	"./kk.js": 160,
	"./km": 161,
	"./km.js": 161,
	"./kn": 162,
	"./kn.js": 162,
	"./ko": 163,
	"./ko.js": 163,
	"./ky": 164,
	"./ky.js": 164,
	"./lb": 165,
	"./lb.js": 165,
	"./lo": 166,
	"./lo.js": 166,
	"./lt": 167,
	"./lt.js": 167,
	"./lv": 168,
	"./lv.js": 168,
	"./me": 169,
	"./me.js": 169,
	"./mi": 170,
	"./mi.js": 170,
	"./mk": 171,
	"./mk.js": 171,
	"./ml": 172,
	"./ml.js": 172,
	"./mr": 173,
	"./mr.js": 173,
	"./ms": 174,
	"./ms-my": 175,
	"./ms-my.js": 175,
	"./ms.js": 174,
	"./my": 176,
	"./my.js": 176,
	"./nb": 177,
	"./nb.js": 177,
	"./ne": 178,
	"./ne.js": 178,
	"./nl": 179,
	"./nl-be": 180,
	"./nl-be.js": 180,
	"./nl.js": 179,
	"./nn": 181,
	"./nn.js": 181,
	"./pa-in": 182,
	"./pa-in.js": 182,
	"./pl": 183,
	"./pl.js": 183,
	"./pt": 184,
	"./pt-br": 185,
	"./pt-br.js": 185,
	"./pt.js": 184,
	"./ro": 186,
	"./ro.js": 186,
	"./ru": 187,
	"./ru.js": 187,
	"./sd": 188,
	"./sd.js": 188,
	"./se": 189,
	"./se.js": 189,
	"./si": 190,
	"./si.js": 190,
	"./sk": 191,
	"./sk.js": 191,
	"./sl": 192,
	"./sl.js": 192,
	"./sq": 193,
	"./sq.js": 193,
	"./sr": 194,
	"./sr-cyrl": 195,
	"./sr-cyrl.js": 195,
	"./sr.js": 194,
	"./ss": 196,
	"./ss.js": 196,
	"./sv": 197,
	"./sv.js": 197,
	"./sw": 198,
	"./sw.js": 198,
	"./ta": 199,
	"./ta.js": 199,
	"./te": 200,
	"./te.js": 200,
	"./tet": 201,
	"./tet.js": 201,
	"./th": 202,
	"./th.js": 202,
	"./tl-ph": 203,
	"./tl-ph.js": 203,
	"./tlh": 204,
	"./tlh.js": 204,
	"./tr": 205,
	"./tr.js": 205,
	"./tzl": 206,
	"./tzl.js": 206,
	"./tzm": 207,
	"./tzm-latn": 208,
	"./tzm-latn.js": 208,
	"./tzm.js": 207,
	"./uk": 209,
	"./uk.js": 209,
	"./ur": 210,
	"./ur.js": 210,
	"./uz": 211,
	"./uz-latn": 212,
	"./uz-latn.js": 212,
	"./uz.js": 211,
	"./vi": 213,
	"./vi.js": 213,
	"./x-pseudo": 214,
	"./x-pseudo.js": 214,
	"./yo": 215,
	"./yo.js": 215,
	"./zh-cn": 216,
	"./zh-cn.js": 216,
	"./zh-hk": 217,
	"./zh-hk.js": 217,
	"./zh-tw": 218,
	"./zh-tw.js": 218
};
function webpackContext(req) {
	return __webpack_require__(webpackContextResolve(req));
};
function webpackContextResolve(req) {
	var id = map[req];
	if(!(id + 1)) // check for number or string
		throw new Error("Cannot find module '" + req + "'.");
	return id;
};
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = 489;

/***/ }),
/* 490 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"id":"patients"}},[_c('div',{staticStyle:{"clear":"both"}},[_c('span',{staticClass:"admin_head"},[_vm._v("\n            Manage Patient "+_vm._s(_vm.patientInfo)+"\n            -\n            "),_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.routeParameters.selectedPatientType),expression:"routeParameters.selectedPatientType"}],attrs:{"name":"show"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.routeParameters.selectedPatientType=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},_vm.onChangePatientTypeSelect]}},_vm._l((_vm.patientTypeSelect),function(option){return _c('option',{domProps:{"value":option.value}},[_vm._v("\n                    "+_vm._s(option.text)+"\n                ")])}))]),_vm._v(" "),_c('div',{staticClass:"letter_select"},[_vm._l((_vm.letters),function(letter){return _c('router-link',{key:letter.id,class:'letters ' + (letter === _vm.routeParameters.currentLetter ? 'selected_letter' : ''),attrs:{"to":{ name: _vm.$route.name, query: { letter: letter, sh: _vm.routeParameters.selectedPatientType }}}},[_vm._v(_vm._s(letter))])}),_vm._v(" "),(_vm.routeParameters.currentLetter)?_c('router-link',{attrs:{"to":{ name: _vm.$route.name, query: { sh: _vm.routeParameters.selectedPatientType }}}},[_vm._v("View All")]):_vm._e()],2),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e()]),_vm._v(" "),_c('form',{staticStyle:{"clear":"both"},attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"id":"patients","width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.patientsTotalNumber > _vm.patientsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber === (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                                name: _vm.$route.name,
                                query: {
                                    page: index - 1,
                                    letter: _vm.routeParameters.currentLetter,
                                    sort: _vm.routeParameters.sortColumn,
                                    sortdir: _vm.routeParameters.sortDirection,
                                    sh: _vm.routeParameters.selectedPatientType
                                }
                            }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(label,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":"10%"}},[_c('router-link',{attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                pid: _vm.routeParameters.patientId,
                                letter: _vm.routeParameters.currentLetter,
                                sh: _vm.routeParameters.selectedPatientType,
                                sort: sort,
                                sortdir: _vm.getCurrentDirection(sort)
                            }
                        }}},[_vm._v(_vm._s(label))])],1)})),_vm._v(" "),_vm._m(0),_vm._v(" "),(_vm.patients.length === 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.patients),function(patient){return _c('tr',{class:(patient.status === 1 ? 'tr_active' : 'tr_inactive') + ' initial_list'},[_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                            path: '/manage/edit-patient',
                            query: { pid: patient.patientid }
                        }}},[_vm._v("\n                        "+_vm._s(patient.lastname)+", \n                        "+_vm._s(patient.firstname)+" \n                        "+_vm._s(patient.middlename)+"\n                    ")]),_vm._v(" "),(patient.premedcheck === 1 || patient.allergenscheck === 1)?_c('span',[_vm._v("\n                           "),_c('span',{staticStyle:{"font-weight":"bold","color":"#ff0000"}},[_vm._v("*Med")])]):_vm._e()],1),_vm._v(" "),(patient.patient_info !== 1)?[_c('td',{staticClass:"pat_incomplete",attrs:{"colspan":"9","align":"center"}},[_vm._v("-- Patient Incomplete --")])]:[_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(_vm.readyForTx(patient.insurance_no_error, patient.numsleepstudy))?_c('span',[_vm._v("Yes")]):_c('span',{staticClass:"red"},[_vm._v("No")])])],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(!patient.date_scheduled || patient.date_scheduled === '0000-00-00')?[_c('span',[_vm._v("N/A")])]:[(_vm.isNegativeTime(patient.date_scheduled))?[_c('span',{staticClass:"red"},[_vm._v("\n                                        "+_vm._s(_vm._f("moment")(patient.date_scheduled,"from"))+"\n                                    ")])]:[(_vm.checkIfThisWeek(patient.date_scheduled))?_c('span',{staticClass:"green"},[_vm._v(_vm._s(_vm._f("moment")(patient.date_scheduled,"from")))]):_c('span',[_vm._v(_vm._s(_vm._f("moment")(patient.date_scheduled,"from")))])]]],2)],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(!patient.date_completed || patient.date_completed === '0000-00-00')?[_c('span',[_vm._v("N/A")])]:[(_vm.checkIfThisWeek(patient.date_completed) &&
                                          !_vm.isNegativeTime(patient.date_completed))?[_c('span',{staticClass:"green"},[_vm._v("\n                                        "+_vm._s(_vm._f("moment")(patient.date_completed,"from"))+"\n                                    ")])]:[_c('span',[_vm._v(_vm._s(_vm._f("moment")(patient.date_completed,"from")))])]]],2)],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[_vm._v(_vm._s(!patient.segmentid ? 'N/A' : _vm.segments[patient.segmentid]))])],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'dss_summ',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[_vm._v(_vm._s(patient.device))])],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'flowsheet3',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(!patient.dentaldevice_date || patient.dentaldevice_date === '0000-00-00')?[_c('span',[_vm._v("N/A")])]:[(_vm.checkIfThisWeek(patient.dentaldevice_date) &&
                                          !_vm.isNegativeTime(patient.dentaldevice_date))?[_c('span',{staticClass:"green"},[_vm._v("\n                                        "+_vm._s(_vm._f("moment")(patient.dentaldevice_date,"from"))+"\n                                    ")])]:[_c('span',[_vm._v(_vm._s(_vm._f("moment")(patient.dentaldevice_date,"from")))])]]],2)],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'insurance',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(patient.vob === null || patient.vob === '')?[_c('span',[_vm._v("No")])]:[(patient.vob == 1)?_c('span',[_vm._v("Yes")]):_c('span',[_vm._v(_vm._s(_vm.preauthLabels[patient.vob]))])]],2)],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'insurance',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[_vm._v("\n                            "+_vm._s(_vm.getRxLomn(patient.rx_lomn))+"\n                        ")])],1),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                                path: 'ledger',
                                query: {
                                    pid: patient.patientId
                                }
                            }}},[(patient.ledger === null)?_c('span',[_vm._v("N/A")]):[(patient.total > 0)?_c('span',{staticClass:"red"},[_vm._v("\n                                    ("+_vm._s(_vm.formatLedger(patient.total))+")\n                                ")]):_c('span',{staticClass:"green"},[_vm._v(_vm._s(_vm.formatLedger(patient.total)))])]],2)],1)]],2)})],2)])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',{staticClass:"template",staticStyle:{"display":"none"}},[_c('td',{staticClass:"patient_name"},[_vm._v("John Smith")]),_vm._v(" "),_c('td',{staticClass:"flowsheet"},[_vm._v("No")]),_vm._v(" "),_c('td',{staticClass:"next_visit"},[_vm._v("(4 days)")]),_vm._v(" "),_c('td',{staticClass:"last_visit"},[_vm._v("1 yr 2 mo")]),_vm._v(" "),_c('td',{staticClass:"last_treatment"},[_vm._v("Consult")]),_vm._v(" "),_c('td',{staticClass:"appliance"},[_vm._v("TAP 3")]),_vm._v(" "),_c('td',{staticClass:"appliance_since"},[_vm._v("63 days")]),_vm._v(" "),_c('td',{staticClass:"vob"},[_vm._v("Complete")]),_vm._v(" "),_c('td',{staticClass:"rxlomn"},[_vm._v("N/A")]),_vm._v(" "),_c('td',{staticClass:"ledger"},[_vm._v("($435.75)")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 491 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_contacts_js__ = __webpack_require__(495);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_contacts_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_contacts_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_52ea2a3f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_contacts_vue__ = __webpack_require__(496);
function injectStyle (ssrContext) {
  __webpack_require__(492)
  __webpack_require__(493)
  __webpack_require__(494)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-52ea2a3f"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_contacts_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_52ea2a3f_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_contacts_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 492 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 493 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 494 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 495 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _assign = __webpack_require__(53);

var _assign2 = _interopRequireDefault(_assign);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      contactTypes: [],
      routeParameters: {
        status: 0,
        currentPageNumber: 0,
        sortDirection: 'asc',
        selectedContactType: 0,
        sortColumn: 'name',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      tableHeaders: {
        'name': 'Name',
        'company': 'Company',
        'type': 'Contact Type'
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 50,
      showActions: false,
      requiredContactName: '',
      foundContactsByName: [],
      typingTimer: null,
      doneTypingInterval: 600
    };
  },
  watch: {
    '$route.query.contacttype': function $routeQueryContacttype() {
      var queryContactType = this.$route.query.contacttype;
      var selectedContactType = 0;
      if (queryContactType) {
        var foundOption = this.contactTypes.find(function (el) {
          return el.contacttypeid === queryContactType;
        });
        if (foundOption) {
          selectedContactType = queryContactType;
        }
      }
      this.$set(this.routeParameters, 'selectedContactType', selectedContactType);
    },
    '$route.query.page': function $routeQueryPage() {
      var queryPage = this.$route.query.page;
      if (queryPage && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', queryPage);
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      var querySort = this.$route.query.sort;
      var sortColumn = 'name';
      if (querySort) {
        sortColumn = null;
        if (querySort in this.tableHeaders) {
          sortColumn = querySort;
        }
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn);
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      var querySortDir = this.$route.query.sortdir;
      var sortDir = 'asc';
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc';
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir);
    },
    '$route.query.letter': function $routeQueryLetter() {
      var queryLetter = this.$route.query.letter;
      var letter = null;
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter;
      }
      this.$set(this.routeParameters, 'currentLetter', letter);
    },
    '$route.query.delid': function $routeQueryDelid() {
      var queryDelId = this.$route.query.delid;
      if (queryDelId > 0) {
        this.onDeleteContact(queryDelId);
      }
    },
    '$route.query.inactiveid': function $routeQueryInactiveid() {
      var queryInactiveId = this.$route.query.inactiveid;
      if (queryInactiveId > 0) {
        this.onInactiveContact(queryInactiveId);
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getContacts();
      },
      deep: true
    }
  },
  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage);
    }
  },
  created: function created() {
    var _this = this;

    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal);

    _http2.default.post(_endpoints2.default.contactTypes.activeNonCorporate).then(function (response) {
      var data = response.data.data;

      if (data) {
        _this.contactTypes = data;
      }
    }).catch(function (response) {
      _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getActiveNonCorporateContactTypes', response: response });
    });

    this.getContacts();
  },
  mounted: function mounted() {
    this.showActions = true;
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal);
  },

  methods: {
    onSettingDataFromModal: function onSettingDataFromModal(data) {
      var _this2 = this;

      this.message = data.message;
      this.$nextTick(function () {
        setTimeout(function () {
          _this2.message = '';
        }, 3000);
      });
    },
    onKeyUpSearchContacts: function onKeyUpSearchContacts() {
      var _this3 = this;

      clearTimeout(this.typingTimer);

      this.typingTimer = setTimeout(function () {
        if (_this3.requiredContactName.trim() !== '') {
          if (_this3.requiredContactName.trim().length > 1) {
            _this3.getListContactsAndCompanies(_this3.requiredContactName.trim()).then(function (response) {
              var data = response.data.data;

              if (data.length) {
                _this3.foundContactsByName = data;
                window.$('#contact_hints').show();
              } else if (data.error) {
                _this3.foundContactsByName = [];
                alert(data.error);
              }
            }).catch(function (response) {
              _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getListContactsAndCompanies', response: response });
            });
          } else {
            window.$('#contact_hints').hide();
          }
        } else {
          _this3.foundContactsByName = [];
        }
      }, this.doneTypingInterval);
    },
    onClickPatients: function onClickPatients(contactId) {
      window.$('#ref_pat_' + contactId).toggle();
    },
    onClickAddNewContact: function onClickAddNewContact() {
      this.$parent.$refs.modal.display('edit-contact');
    },
    onClickQuickView: function onClickQuickView(contactId) {
      this.$parent.$refs.modal.display('view-contact');
      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: contactId });
    },
    onClickEditContact: function onClickEditContact(contactId) {
      this.$parent.$refs.modal.display('edit-contact');
      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: contactId });
    },
    onClickInActive: function onClickInActive() {
      this.$router.push({
        name: this.$route.name,
        query: {
          status: 2
        }
      });
    },
    onChangeContactType: function onChangeContactType() {
      this.$router.push({
        name: this.$route.name,
        query: {
          contacttype: this.routeParameters.selectedContactType
        }
      });
    },
    getContacts: function getContacts() {
      var _this4 = this;

      this.findContacts(this.routeParameters.selectedContactType, this.routeParameters.status, this.routeParameters.currentLetter, this.routeParameters.sortColumn, this.routeParameters.sortDirection, this.routeParameters.currentPageNumber, this.contactsPerPage).then(function (response) {
        var data = response.data.data;

        if (data) {
          _this4.contactsTotalNumber = data.totalCount;
          _this4.contacts = data.result;
        }
      }).then(function () {
        var contactsHaveReferrers = _this4.contacts.map(function (el) {
          return el.referrers > 0 ? el.contactid : 0;
        });
        var contactsHavePatients = _this4.contacts.map(function (el) {
          return el.patients > 0 ? el.contactid : 0;
        });

        contactsHaveReferrers.forEach(function (contactId, index) {
          if (contactId > 0) {
            _this4.findReferrersByContactId(contactId).then(function (response) {
              var data = response.data.data;

              if (data.length) {
                var updatedContact = (0, _assign2.default)({
                  referrers_data: data
                }, _this4.contacts[index]);

                _this4.$set(_this4.contacts, index, updatedContact);
              }
            }).catch(function (response) {
              _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'findReferrersByContactId', response: response });
            });
          }
        });

        contactsHavePatients.forEach(function (contactId, index) {
          if (contactId > 0) {
            _this4.findPatientsByContactId(contactId).then(function (response) {
              var data = response.data.data;

              if (data.length) {
                var updatedContact = (0, _assign2.default)({
                  patients_data: data
                }, _this4.contacts[index]);

                _this4.$set(_this4.contacts, index, updatedContact);
              }
            }).catch(function (response) {
              _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'findPatientsByContactId', response: response });
            });
          }
        });
      }).catch(function (response) {
        _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'findContacts', response: response });
      });
    },
    findReferrersByContactId: function findReferrersByContactId(contactId) {
      var data = { contact_id: contactId };

      return _http2.default.post(_endpoints2.default.patients.referredByContact, data);
    },
    findPatientsByContactId: function findPatientsByContactId(contactId) {
      var data = { contact_id: contactId };

      return _http2.default.post(_endpoints2.default.patients.byContact, data);
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      }
      return 'asc';
    },
    findContacts: function findContacts(contactType, status, currentLetter, sortColumn, sortDirection, pageNumber, contactsPerPage) {
      var data = {
        contacttype: contactType,
        status: status,
        letter: currentLetter,
        sort_column: sortColumn,
        sort_direction: sortDirection,
        page: pageNumber,
        contacts_per_page: contactsPerPage
      };

      return _http2.default.post(_endpoints2.default.contacts.find, data);
    },
    getListContactsAndCompanies: function getListContactsAndCompanies(requestedName) {
      var data = { partial_name: requestedName };

      return _http2.default.post(_endpoints2.default.contacts.listContactsAndCompanies, data);
    }
  }
};

/***/ }),
/* 496 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v("Manage Contact")]),_vm._v(" "),_c('br'),_c('br'),_vm._v(" \n    "),_c('div',{staticStyle:{"margin-left":"10px","margin-right":"10px"}},[_c('form',{staticStyle:{"float":"left","width":"350px"},attrs:{"name":"jump1"}},[_vm._v("\n            Filter by type:\n            "),_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.routeParameters.selectedContactType),expression:"routeParameters.selectedContactType"}],on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.routeParameters.selectedContactType=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},_vm.onChangeContactType]}},[_c('option',{attrs:{"value":"0"}},[_vm._v("Display All")]),_vm._v(" "),_vm._l((_vm.contactTypes),function(option){return _c('option',{domProps:{"value":option.contacttypeid}},[_vm._v("\n                    "+_vm._s(option.contacttype)+"\n                ")])}),_vm._v(" "),_c('option',{domProps:{"value":0},on:{"click":_vm.onClickInActive}},[_vm._v("In-active")])],2)]),_vm._v(" "),_c('br'),_c('br'),_vm._v("\n        Search Contacts:\n        "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.requiredContactName),expression:"requiredContactName"}],staticStyle:{"width":"300px"},attrs:{"placeholder":"Type contact name","id":"contact_name","autocomplete":"off"},domProps:{"value":(_vm.requiredContactName)},on:{"keyup":_vm.onKeyUpSearchContacts,"input":function($event){if($event.target.composing){ return; }_vm.requiredContactName=$event.target.value}}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundContactsByName.length > 0),expression:"foundContactsByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"contact_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"contact_list"}},_vm._l((_vm.foundContactsByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.loadPopup('view_contact.php?ed=' + contact.id)}}},[_vm._v(_vm._s(contact.name))])}))]),_vm._v(" "),_c('button',{staticClass:"addButton",staticStyle:{"margin-right":"10px","float":"right"},on:{"click":function($event){$event.preventDefault();_vm.onClickAddNewContact($event)}}},[_vm._v("Add New Contact")])]),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{attrs:{"colspan":"2"}},[_c('div',{staticClass:"letter_select"},[_vm._l((_vm.letters),function(letter){return _c('router-link',{key:letter.id,staticClass:"letters",class:{ 'selected_letter': letter == _vm.routeParameters.currentLetter },attrs:{"to":{
                              name: _vm.$route.name,
                              query: {
                                letter: letter,
                                status: _vm.routeParameters.status,
                                sort: _vm.routeParameters.sortColumn,
                                sortdir: _vm.routeParameters.sortDirection,
                                contacttype: _vm.routeParameters.selectedContactType
                              }
                            }}},[_vm._v(_vm._s(letter))])}),_vm._v(" "),(_vm.routeParameters.currentLetter)?_c('router-link',{attrs:{"to":{
                              name: _vm.$route.name,
                              query: {
                                status: _vm.routeParameters.status,
                                sort: _vm.routeParameters.sortColumn,
                                sortdir: _vm.routeParameters.sortDirection,
                                contacttype: _vm.routeParameters.selectedContactType
                              }
                            }}},[_vm._v("Show All")]):_vm._e()],2)]),_vm._v(" "),(_vm.contactsTotalNumber > _vm.contactsPerPage)?_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber == (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                              name: _vm.$route.name,
                              query: {
                                page: index - 1,
                                letter: _vm.routeParameters.currentLetter,
                                sort: _vm.routeParameters.sortColumn,
                                sortdir: _vm.routeParameters.sortDirection,
                                contacttype: _vm.routeParameters.selectedContactType
                              }
                            }}},[_vm._v(_vm._s(index))])],1)})],2):_vm._e()]),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},[_vm._l((_vm.tableHeaders),function(label,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : '') + ' ' + sort,attrs:{"valign":"top"}},[_c('router-link',{attrs:{"to":{
                          name: _vm.$route.name,
                          query: {
                            letter: _vm.routeParameters.currentLetter,
                            sort: sort,
                            sortdir: _vm.getCurrentDirection(sort)
                          }
                        }}},[_vm._v(_vm._s(label))])],1)}),_vm._v(" "),_c('td',{staticClass:"col_head",attrs:{"valign":"top","width":"10%"}},[_vm._v("\n                    Referrer\n                ")]),_vm._v(" "),_c('td',{staticClass:"col_head",attrs:{"valign":"top","width":"10%"}},[_vm._v("\n                    Patients\n                ")]),_vm._v(" "),_c('td',{staticClass:"col_head",attrs:{"valign":"top","width":"20%"}},[_vm._v("\n                    Action\n                ")])],2),_vm._v(" "),(!_vm.contacts.length)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.contacts),function(contact){return _c('tbody',[_c('tr',{class:contact.status == 1 ? 'tr_active' : 'tr_inactive'},[_c('td',{attrs:{"valign":"top","width":"20%"}},[(!contact.firstname && !contact.middlename && !contact.lastname)?_c('i',{staticClass:"name-empty"},[_vm._v("Empty name")]):_c('span',[(!contact.lastname)?_c('i',{staticClass:"name-empty"},[_vm._v("Empty last name")]):[_vm._v("\n                                "+_vm._s(contact.lastname)+_vm._s(!contact.middlename ? ',' : '')+"\n                            ")],_vm._v(" "),(contact.middlename)?[_vm._v(_vm._s(contact.middlename)+",")]:_vm._e(),_vm._v(" "),(!contact.firstname)?_c('i',{staticClass:"name-empty"},[_vm._v("empty first name")]):[_vm._v(_vm._s(contact.firstname))]],2)]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"25%"}},[_vm._v("\n                        "+_vm._s(contact.company)+"\n                    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"25%"}},[_vm._v("\n                        "+_vm._s(contact.contacttype ? contact.contacttype : 'Contact Type Not Set')+"\n                    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[(contact.referrers > 0)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickPatients(contact.contactid)}}},[_vm._v(_vm._s(contact.referrers))]):_vm._e()]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[(contact.patients > 0)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickPatients(contact.contactid)}}},[_vm._v(_vm._s(contact.patients))]):_vm._e()]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"20%"}},[_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.showActions),expression:"showActions"}],staticClass:"actions"},[_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"EDIT"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickView(contact.contactid)}}},[_vm._v("Quick View")]),_vm._v(" |\n                            "),_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"EDIT"},on:{"click":function($event){$event.preventDefault();_vm.onClickEditContact(contact.contactid)}}},[_vm._v("Edit")])])])]),_vm._v(" "),(contact.referrers > 0 || contact.patients > 0)?_c('tr',{staticStyle:{"display":"none"},attrs:{"id":'ref_pat_' + contact.contactid}},[_c('td',{attrs:{"colspan":"2","valign":"top"}},[_c('strong',[_vm._v("REFERRED")]),_c('br'),_vm._v(" "),_vm._l((contact.referrers_data),function(referrer){return [_c('a',{attrs:{"href":_vm.legacyUrl + 'add_patient.php?pid=' + referrer.patientid + '&ed=' + referrer.patientid}},[_vm._v(_vm._s(referrer.firstname)+" "+_vm._s(referrer.lastname))]),_c('br')]})],2),_vm._v(" "),_c('td',{attrs:{"colspan":"4","valign":"top"}},[_c('strong',[_vm._v("PATIENTS")]),_c('br'),_vm._v(" "),_vm._l((contact.patients_data),function(patient){return [_c('a',{attrs:{"href":_vm.legacyUrl + 'add_patient.php?pid=' + patient.patientid  + '&ed=' + patient.patientid}},[_vm._v(_vm._s(patient.firstname)+" "+_vm._s(patient.lastname))]),_c('br')]})],2)]):_vm._e()])})],2)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 497 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editingPatients_js__ = __webpack_require__(501);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_editingPatients_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_editingPatients_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3c34704e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editingPatients_vue__ = __webpack_require__(502);
function injectStyle (ssrContext) {
  __webpack_require__(498)
  __webpack_require__(499)
  __webpack_require__(500)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-3c34704e"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_editingPatients_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3c34704e_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_editingPatients_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 498 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 499 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 500 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 501 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _assign = __webpack_require__(53);

var _assign2 = _interopRequireDefault(_assign);

var _keys = __webpack_require__(34);

var _keys2 = _interopRequireDefault(_keys);

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _LocalStorageManager = __webpack_require__(59);

var _LocalStorageManager2 = _interopRequireDefault(_LocalStorageManager);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _main = __webpack_require__(6);

var _MomentWrapper = __webpack_require__(64);

var _MomentWrapper2 = _interopRequireDefault(_MomentWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      routeParameters: {
        patientId: this.$route.query.pid > 0 ? this.$route.query.pid : null
      },
      billingCompany: {
        exclusive: 0,
        name: 'DSS'
      },
      pressedButtons: {
        send_pin_code: false,
        send_hst: false
      },
      requestedEmails: {
        registration: false,
        reminder: false
      },
      componentParams: {},
      patientNotifications: [],
      homeSleepTestCompanies: [],
      patient: {
        salutation: 'Mr.',
        best_time: 'default',
        best_number: 'default',
        preferredcontact: 'paper',
        gender: 'default',
        feet: '0',
        inches: '-1',
        weight: '0',
        marital_status: 'default',
        display_alert: '0',
        p_m_same_address: '1',
        p_m_relation: 'default',
        p_m_gender: 'default',
        p_m_ins_type: 'default',
        p_m_ins_co: 'default',
        has_s_m_ins: 'No',
        s_m_relation: 'default',
        s_m_gender: 'default',
        s_m_ins_type: 'default',
        s_m_ins_co: 'default'
      },
      profilePhoto: null,
      insuranceCardImage: {},
      docLocations: [],
      insuranceContacts: [],
      introLetter: {},
      uncompletedHomeSleepTests: [],
      formedFullNames: {},
      pendingVob: {},
      patientLocation: 'default',
      message: '',
      eligiblePayerId: 0,
      eligiblePayerName: '',
      sendPin: '',
      showReferredNotes: false,
      showReferredbyHints: false,
      isReferredByChanged: false,
      isInsuranceInfoChanged: false,
      foundReferrersByName: [],
      foundPrimaryCareMdByName: [],
      foundEntByName: [],
      foundSleepMdByName: [],
      foundDentistContactsByName: [],
      foundOtherMdByName: [],
      foundOtherMd2ByName: [],
      foundOtherMd3ByName: [],
      typingTimer: null,
      doneTypingInterval: 600,
      autoCompleteSearchValue: '',
      eligiblePayerSource: [],
      eligiblePayers: [],
      secondaryEligiblePayers: [],
      docInfo: this.$store.state.main[_symbols2.default.state.docInfo]
    };
  },
  watch: {
    '$route.query.pid': function $routeQueryPid() {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid);

        var message = _LocalStorageManager2.default.get('message');
        if (message && message.length > 0) {
          this.message = message;
          _LocalStorageManager2.default.remove('message');
        }

        this.fillForm(this.$route.query.pid);
      } else {
        this.$set(this.routeParameters, 'patientId', null);
        this.cleanPatientData();
      }
    },
    'patient.home_phone': function patientHome_phone() {
      this.$set(this.patient, 'home_phone', this.phone(this.patient.home_phone));
    },
    'patient.cell_phone': function patientCell_phone() {
      this.$set(this.patient, 'cell_phone', this.phone(this.patient.cell_phone));
    },
    'patient.work_phone': function patientWork_phone() {
      this.$set(this.patient, 'work_phone', this.phone(this.patient.work_phone));
    },
    'patient.emergency_number': function patientEmergency_number() {
      this.$set(this.patient, 'emergency_number', this.phone(this.patient.emergency_number));
    },
    'patient.ssn': function patientSsn() {
      this.$set(this.patient, 'ssn', this.ssn(this.patient.ssn));
    },
    'patient.dob': function patientDob() {
      this.$set(this.patient, 'dob', this.date(this.patient.dob));
    },
    'patient.feet': function patientFeet() {
      this.calculateBmi();
    },
    'patient.inches': function patientInches() {
      this.calculateBmi();
    },
    'patient.weight': function patientWeight() {
      this.calculateBmi();
    }
  },
  computed: {
    showSendingEmails: function showSendingEmails() {
      return this.$store.state.main[_symbols2.default.state.docInfo].use_patient_portal && this.patient.use_patient_portal;
    },
    inches: function inches() {
      var result = [];

      for (var i = 0; i < 12; i++) {
        result.push(i);
      }

      return result;
    },
    weight: function weight() {
      var result = [];

      for (var i = 80; i <= 500; i++) {
        result.push(i);
      }

      return result;
    },
    buttonText: function buttonText() {
      return this.patient.userid > 0 ? 'Save/Update ' : 'Add ';
    },
    portalStatus: function portalStatus() {
      var status = 'Patient Portal In-active';

      if (this.patient.use_patient_portal === 1) {
        status = '';
        switch (+this.patient.registration_status) {
          case 0:
            status = 'Unregistered';
            break;
          case 1:
            status = 'Registration Emailed ' + _MomentWrapper2.default.create(this.patient.registration_senton).format('MM/DD/YYYY hh:mm a') + ' ET';
            break;
          case 2:
            status = 'Registered';
            break;
        }
      }

      return status;
    },
    showReferredPerson: function showReferredPerson() {
      if (this.patient.referred_source === _main.DSS_CONSTANTS.DSS_REFERRED_PATIENT || this.patient.referred_source === _main.DSS_CONSTANTS.DSS_REFERRED_PHYSICIAN) {
        return true;
      } else {
        return false;
      }
    },
    insCompanyContactInfo: function insCompanyContactInfo() {
      var _this = this;

      var foundCompany = this.insuranceContacts.find(function (el) {
        return el.contactid === _this.patient.p_m_ins_co;
      });

      if (foundCompany) {
        return foundCompany.add1 + '\n' + (foundCompany.add2 ? foundCompany.add2 + '\n' : '') + foundCompany.city + ' ' + foundCompany.state + ' ' + foundCompany.zip + '\n' + this.phone(foundCompany.phone1);
      } else {
        return '';
      }
    },
    secondaryInsCompanyContactInfo: function secondaryInsCompanyContactInfo() {
      var _this2 = this;

      var foundCompany = this.insuranceContacts.find(function (el) {
        return el.contactid === _this2.patient.s_m_ins_co;
      });

      if (foundCompany) {
        return foundCompany.add1 + '\n' + (foundCompany.add2 ? foundCompany.add2 + '\n' : '') + foundCompany.city + ' ' + foundCompany.state + ' ' + foundCompany.zip + '\n' + this.phone(foundCompany.phone1);
      } else {
        return '';
      }
    }
  },
  created: function created() {
    var _this3 = this;

    window.eventHub.$on('setting-component-params', this.onSettingComponentParams);
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal);

    this.fillForm(this.routeParameters.patientId);

    _http2.default.post(_endpoints2.default.companies.homeSleepTest).then(function (response) {
      var data = response.data.data;

      if (data) {
        _this3.homeSleepTestCompanies = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getHomeSleepTestCompanies', response: response });
    });

    _http2.default.post(_endpoints2.default.locations.byDoctor).then(function (response) {
      var data = response.data.data;

      if (data) {
        _this3.docLocations = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getDocLocations', response: response });
    });

    _http2.default.post(_endpoints2.default.companies.billingExclusiveCompany).then(function (response) {
      var data = response.data.data;

      if (data) {
        _this3.billingCompany = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getBillingCompany', response: response });
    });

    this.getEligiblePayerSource().then(function (response) {
      var data = response.data.data;

      if (data.length) {
        data = _this3.populateEligiblePayerSource(data);
        _this3.eligiblePayerSource = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getEligiblePayerSource', response: response });

      _http2.default.get(_endpoints2.default.eligible.payers).then(function (response) {
        var data = response.data.data;

        if (data.length) {
          data = _this3.populateEligiblePayerSource(data);
          _this3.eligiblePayerSource = data;
        }
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getStaticEligiblePayerSource', response: response });
      });
    });

    _http2.default.post(_endpoints2.default.contacts.insurance).then(function (response) {
      var data = response.data.data;

      if (data.length) {
        _this3.insuranceContacts = data;
      }
    }).catch(function (response) {
      _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getInsuranceContacts', response: response });
    });
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams);
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal);
  },

  methods: {
    onSettingDataFromModal: function onSettingDataFromModal(data) {
      this.patient = data;
    },
    onSettingComponentParams: function onSettingComponentParams(parameters) {
      this.componentParams = parameters;
    },

    checkMedicare: function checkMedicare() {
      if (this.patient.s_m_ins_type === 1) {
        var alertText = 'Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.';
        _Alerter2.default.alert(alertText);
      }
    },
    onClickQuickViewContact: function onClickQuickViewContact(id) {},
    onClickDisplayFile: function onClickDisplayFile() {},
    onClickCreateNewContact: function onClickCreateNewContact() {},
    validateDate: function validateDate(el) {
      if (!this.isValidDate(this.patient[el])) {
        var alertText = 'Invalid Day, Month, or Year range detected. Please correct.';
        _Alerter2.default.alert(alertText);
        this.$refs[el].focus();
      }
    },
    calculateBmi: function calculateBmi() {
      if (this.patient.feet !== 0 && this.patient.inches !== -1 && this.patient.weight !== 0) {
        var inc = this.patient.feet * 12 + this.patient.inches;
        var incSqr = inc * inc;

        var wei = this.patient.weight * 703;
        var bmi = wei / incSqr;

        this.$set(this.patient, 'bmi', bmi.toFixed(1));
      } else {
        this.$set(this.patient, 'bmi', '');
      }
    },
    onClickAddImage: function onClickAddImage(type) {

      switch (type) {
        case 'profile':
          break;
        case 'primary-insurance-card-image':
          break;
        case 'secondary-insurance-card-image':
          break;
      }
    },
    onClickOrderHst: function onClickOrderHst() {
      var alertText = 'Patient has existing HST with status %s. Only one HST can be requested at a time.';
      _Alerter2.default.alert(alertText.replace('%s', this.$store.state.main[_symbols2.default.state.patientHomeSleepTestStatus]));
    },
    searchItemById: function searchItemById(data, id) {
      id = id || 0;
      var removeId = data.findIndex(function (el) {
        return el.id === id;
      });

      return removeId >= 0 ? data[removeId] : null;
    },
    removeNotification: function removeNotification(id) {
      var _this4 = this;

      this.removeNotificationInDb(id).then(function () {
        _this4.patientNotifications.$remove(_this4.searchItemById(_this4.patientNotifications, id));
      }).catch(function (response) {
        _this4.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'removeNotificationInDb', response: response });
      });
    },
    onClickCreatingNewInsuranceCompany: function onClickCreatingNewInsuranceCompany(fromId) {},
    handleChangingInsuranceInfo: function handleChangingInsuranceInfo() {
      this.isInsuranceInfoChanged = true;
    },
    parseFailedResponseOnEditingPatient: function parseFailedResponseOnEditingPatient(data) {
      var errors = data.errors.shift();

      if (errors !== undefined) {
        var objKeys = (0, _keys2.default)(errors);

        var arrOfMessages = objKeys.map(function (el) {
          return el + ':' + errors[el].join('|').toLowerCase();
        });

        _Alerter2.default.alert(arrOfMessages.join('\n'));
      }
    },
    parseSuccessfulResponseOnEditingPatient: function parseSuccessfulResponseOnEditingPatient(data) {
      if (data.hasOwnProperty('redirect_to') && data.redirect_to.length > 0) {
        this.$router.push(data.redirect_to);
      }

      if (data.hasOwnProperty('created_patient_id') && data.created_patient_id > 0) {
        _LocalStorageManager2.default.save('message', data.status);
        this.$router.push(this.$route.path + '?pid=' + data.created_patient_id);
      }

      if (data.hasOwnProperty('status') && data.status.length > 0) {
        this.message = data.status;
      }

      if (data.hasOwnProperty('mails')) {
        var mails = data.mails;

        mails.forEach(function (el) {
          if (mails[el] && mails[el].length > 0) {
            _Alerter2.default.alert(mails[el]);
          }
        });
      }

      if (data.send_pin_code) {
        this.$store.commit(_symbols2.default.mutations.modal, 'patient-access-code');
        this.$parent.$refs.modal.setComponentParameters({ patientId: this.routeParameters.patientId });
      }

      this.fillForm(this.routeParameters.patientId);
    },
    submitAddingOrEditingPatient: function submitAddingOrEditingPatient() {
      var _this5 = this;

      if (this.validatePatientData(this.patient, null, this.formedFullNames.referred_name)) {
        this.checkEmail(this.patient.email, this.routeParameters.patientId).then(function (response) {
          var data = response.data.data;

          var isReadyForProcessing = false;
          if (data.confirm_message.length > 0) {
            isReadyForProcessing = confirm(data.confirm_message);
          } else {
            isReadyForProcessing = true;
          }

          if (isReadyForProcessing) {
            _this5.editPatient(_this5.routeParameters.patientId, _this5.patient, _this5.formedFullNames).then(function (response) {
              _this5.parseSuccessfulResponseOnEditingPatient(response.data.data);
            }).catch(function (response) {
              _this5.parseFailedResponseOnEditingPatient(response.data.data);

              _this5.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'editPatient', response: response });
            });
          }
        }).catch(function (response) {
          _Alerter2.default.alert(response.data.message);
          _this5.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'checkEmail', response: response });
        });
      }
    },
    submitSendingPinCode: function submitSendingPinCode() {
      var _this6 = this;

      if (this.validatePatientData(this.patient)) {
        this.pressedButtons.send_pin_code = true;

        this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames, this.pressedButtons).then(function (response) {
          _this6.parseSuccessfulResponseOnEditingPatient(response.data.data);
        }).catch(function (response) {
          _this6.parseFailedResponseOnEditingPatient(response.data.data);

          _this6.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'editPatient', response: response });
        });
      }
    },
    submitSendingRegistrationEmail: function submitSendingRegistrationEmail() {
      var _this7 = this;

      this.requestedEmails.registration = true;

      if (this.validatePatientData(this.patient, this.requestedEmails)) {
        this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames, null, this.requestedEmails).then(function (response) {
          _this7.parseSuccessfulResponseOnEditingPatient(response.data.data);
        }).catch(function (response) {
          _this7.parseFailedResponseOnEditingPatient(response.data.data);

          _this7.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'editPatient', response: response });
        });
      }
    },
    submitSendingReminderEmail: function submitSendingReminderEmail() {
      this.requestedEmails.reminder = true;

      if (this.validatePatientData(this.patient, this.requestedEmails)) {
        this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames, null, this.requestedEmails);
      }
    },
    submitSendingHst: function submitSendingHst() {
      if (confirm('Click OK to initiate a Home Sleep Test request. ' + 'The HST request must be electronically signed by an authorized ' + 'provider before it can be transmitted. You can view and save/update ' + 'the request on the next screen.') && this.validatePatientData(this.patient)) {
        this.pressedButtons.send_hst = true;

        this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames, this.pressedButtons);
      }
    },
    setContact: function setContact(type, id) {
      this.$set(this.patient, type, id);
    },
    onKeyUpSearchContacts: function onKeyUpSearchContacts(type) {
      var _this8 = this;

      clearTimeout(this.typingTimer);

      var requiredName = this.formedFullNames[type + '_name'].trim();

      this.typingTimer = setTimeout(function () {
        if (requiredName.length > 1) {
          if (_this8.autoCompleteSearchValue !== requiredName) {
            _this8.autoCompleteSearchValue = requiredName;

            _this8.getListContactsAndCompanies(requiredName).then(function (response) {
              var data = response.data.data;

              if (data.length) {
                _this8.arrName = data;
              } else if (data.error) {
                _this8.arrName = [];
                alert(data.error);
              }
            }).catch(function (response) {
              _this8.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getListContactsAndCompanies', response: response });
            });
          }
        } else {
          _this8.arrName = [];
        }
      }, this.doneTypingInterval);
    },
    setEligiblePayer: function setEligiblePayer(id, name, type) {
      var idField = void 0,
          nameField = void 0,
          fullNameField = void 0;

      if (type === 'primary') {
        idField = 'p_m_eligible_payer_id';
        nameField = 'p_m_eligible_payer_name';
        fullNameField = 'ins_payer_name';
      } else {
        idField = 's_m_eligible_payer_id';
        nameField = 's_m_eligible_payer_name';
        fullNameField = 's_m_ins_payer_name';
      }

      this.$set(this.patient, idField, id);
      this.$set(this.patient, nameField, name);
      this.$set(this.formedFullNames, fullNameField, id + ' - ' + name);
    },
    searchEligiblePayersByName: function searchEligiblePayersByName(name) {
      var LIMIT_RECORDS_TO_DISPLAY = 5;
      var partsOfRequiredName = name.toLowerCase().split(' ');

      var regRequiredName = new RegExp('(?=.*\\b.*' + partsOfRequiredName.join('.*\\b)(?=.*\\b.*') + '.*\\b).*', 'i');

      var foundPayers = [];
      var recordsToDisplay = 0;
      this.eligiblePayerSource.some(function (el) {
        var payerId = el.payer_id.replace(/(\r\n|\n|\r)/gm, '');

        var foundPayerId = foundPayers.find(function (el) {
          return el.id === payerId;
        });

        if (el.payer_name.toLowerCase().search(regRequiredName) !== -1 && !foundPayerId) {
          foundPayers.push({
            id: payerId,
            name: el.payer_name.replace(/(\r\n|\n|\r)/gm, '')
          });

          if (++recordsToDisplay === LIMIT_RECORDS_TO_DISPLAY) {
            return true;
          }
        }
      });

      return foundPayers;
    },
    populateEligiblePayerSource: function populateEligiblePayerSource(source) {
      var data = [];

      source.forEach(function (el) {
        if (typeof el['names'] === 'undefined' || el['names'].length === 0) {
          return;
        }

        el['names'].forEach(function (name) {
          data.push({
            payer_id: el['payer_id'],
            payer_name: name,
            enrollment_required: el['enrollment_required'],
            enrollment_mandatory_fields: el['enrollment_mandatory_fields']
          });
        });
      });

      return data;
    },
    onKeyUpSearchEligiblePayers: function onKeyUpSearchEligiblePayers(type) {
      var _this9 = this;

      clearTimeout(this.typingTimer);

      var insPayerName = void 0,
          elementName = void 0;


      if (type === 'primary') {
        insPayerName = this.formedFullNames.ins_payer_name.trim();

        elementName = 'insPayerName';
      } else {
        insPayerName = this.formedFullNames.s_m_ins_payer_name.trim();

        elementName = 'secondaryInsPayerName';
      }

      this.typingTimer = setTimeout(function () {
        if (insPayerName.length > 1) {
          if (_this9.autoCompleteSearchValue !== insPayerName) {
            _this9.autoCompleteSearchValue = insPayerName;
            var foundPayers = _this9.searchEligiblePayersByName(insPayerName);

            if (foundPayers.length > 0) {
              _this9.arrName = foundPayers;
            } else {
              _this9.arrName = [];
              _this9.$refs[elementName].focus();

              alert('Error: No match found for this criteria.');
            }
          }
        } else {
          _this9.arrName = [];
        }
      }, this.doneTypingInterval);
    },
    setReferredBy: function setReferredBy(id, referredType) {
      if (this.patient.referred_by !== id || this.patient.referred_source !== referredType) {
        this.isReferredByChanged = true;
      }

      this.$set(this.patient, 'referred_by', id);
      this.$set(this.patient, 'referred_source', referredType);
    },
    onKeyUpSearchReferrers: function onKeyUpSearchReferrers() {
      var _this10 = this;

      clearTimeout(this.typingTimer);

      this.typingTimer = setTimeout(function () {
        if (_this10.formedFullNames.referred_name.trim() !== '') {
          if (_this10.formedFullNames.referred_name.trim().length > 1) {
            _this10.getReferrers(_this10.formedFullNames.referred_name.trim()).then(function (response) {
              var data = response.data.data;

              if (data.length) {
                _this10.foundReferrersByName = data;
                _this10.showReferredbyHints = true;
              } else if (data.error) {
                _this10.foundReferrersByName = [];
                alert(data.error);
              }
            }).catch(function (response) {
              _this10.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getReferrers', response: response });
            });
          } else {
            _this10.showReferredbyHints = false;
          }
        }
      }, this.doneTypingInterval);
    },
    showReferredBy: function showReferredBy(type, referredSource) {
      if (type === 'person') {
        this.showReferredNotes = false;
        this.showReferredPerson = true;
      } else {
        this.showReferredNotes = true;
        this.showReferredPerson = false;
      }
      this.$set(this.patient, 'referred_source', referredSource);
    },
    updateTrackerNotes: function updateTrackerNotes(patientId, notes) {
      var data = {
        patient_id: patientId || 0,
        tracker_notes: notes
      };

      return _http2.default.post(_endpoints2.default.patientSummaries.updateTrackerNotes, data);
    },
    cleanPatientData: function cleanPatientData() {
      var patient = {};

      this.setDefaultValues(patient);

      this.patient = patient;
      this.profilePhoto = null;
      this.introLetter = {};
      this.insuranceCardImage = {};
      this.uncompletedHomeSleepTests = [];
      this.patientNotifications = [];
      this.formedFullNames = {};
      this.pendingVob = {};
      this.patientLocation = '';

      window.eventHub.$emit('update-from-child', {
        patientName: '',
        medicare: 0,
        premedCheck: 0,
        title: '',
        alertText: '',
        displayAlert: false
      });
    },
    fillForm: function fillForm(patientId) {
      var _this11 = this;

      this.getDataForFillingPatientForm(patientId).then(function (response) {
        var data = response.data.data;

        if (data.length !== 0) {
          _this11.filterPhoneFields(data.patient);
          _this11.filterSsnField(data.patient);
          _this11.setDefaultValues(data.patient);

          _this11.patient = data.patient;
          _this11.profilePhoto = data.profile_photo;
          _this11.introLetter = data.intro_letter;
          _this11.insuranceCardImage = data.insurance_card_image;
          _this11.uncompletedHomeSleepTests = data.uncompleted_home_sleep_test;
          _this11.patientNotifications = data.patient_notification;
          _this11.formedFullNames = data.formed_full_names;
          _this11.pendingVob = data.pending_vob;
          _this11.patientLocation = data.patient_location;

          window.eventHub.$emit('update-from-child', {
            patientName: data.patient.firstname + ' ' + data.patient.lastname,
            medicare: data.patient.p_m_ins_type === 1,
            premedCheck: data.patient.premedcheck,
            title: 'Pre-medication: ' + data.patient.premed + '\n',
            alertText: data.patient.alert_text,
            displayAlert: data.patient.display_alert
          });
        }
      }).catch(function (response) {
        _this11.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getDataForFillingPatientForm', response: response });
      });
    },
    onChangeRelations: function onChangeRelations(type) {
      var _this12 = this;

      if (this.value !== 'Self') {
        return;
      }

      var resultFields = [];
      var sourceFields = [this.patient.dob, this.patient.firstname, this.patient.middlename, this.patient.lastname, this.patient.gender];

      if (type === 'primary_insurance') {
        resultFields = ['ins_dob', 'p_m_partyfname', 'p_m_partymname', 'p_m_partylname', 'p_m_gender'];
      } else if (type === 'secondary_insurance') {
        resultFields = ['ins2_dob', 's_m_partyfname', 's_m_partymname', 's_m_partylname', 's_m_gender'];
      }

      resultFields.forEach(function (el, index) {
        _this12.$set(_this12.patient, el, sourceFields[index]);
      });
    },
    onPreferredContactChange: function onPreferredContactChange() {
      if (this.patient.preferredcontact === 'email' && this.patient.email.length === 0) {
        alert('You must enter an email address to use email as the preferred contact method.');

        this.$set(this.patient, 'preferredcontact', '');
        this.$refs.email.focus();
      } else if (this.patient.preferredcontact === 'fax' && this.patient.fax.length === 0) {
        alert('You must enter a fax number to use email as the preferred contact method.');

        this.$set(this.patient, 'preferredcontact', '');
        this.$refs.fax.focus();
      }
    },
    filterPhoneFields: function filterPhoneFields(patient) {
      var _this13 = this;

      var fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number'];

      fields.forEach(function (el) {
        patient[el] = _this13.phone(patient[el]);
      });
    },
    filterSsnField: function filterSsnField(patient) {
      patient.ssn = this.ssn(patient.ssn);
    },
    setDefaultValues: function setDefaultValues(patient) {
      var values = {
        copyreqdate: _MomentWrapper2.default.create().format('DD/MM/YYYY'),
        salutation: 'Mr.',
        preferredcontact: 'paper',
        display_alert: 0,
        p_m_same_address: 1,
        has_s_m_ins: 'No'
      };

      var fields = (0, _keys2.default)(values);

      fields.forEach(function (el) {
        if (!patient[el]) {
          patient[el] = values[el];
        }
      });
    },
    phone: function phone(value) {
      value = value || '';
      return value.replace(/\D/g, '').replace(/^(\d{3})(\d{3})(\d{4})$/, '($1) $2-$3');
    },
    ssn: function ssn(value) {
      value = value || '';
      return value.replace(/\D/g, '').replace(/^(\d{3})(\d{2})(\d{4})$/, '$1-$2-$3');
    },
    date: function date(value) {
      value = value || '';
      return value.replace(/\D/g, '').replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3');
    },
    number: function number(value) {
      value = value || '';
      return value.replace(/\D/g, '');
    },
    getUncompletedHomeSleepTests: function getUncompletedHomeSleepTests(patientId) {
      var data = { patientId: patientId || 0 };

      return _http2.default.post(_endpoints2.default.homeSleepTests.uncompleted, data);
    },
    getGeneratedDateOfIntroLetter: function getGeneratedDateOfIntroLetter(patientId) {
      var data = { patient_id: patientId || 0 };

      return _http2.default.post(_endpoints2.default.letters.generateDateOfIntro, data);
    },
    getProfilePhoto: function getProfilePhoto(patientId) {
      var data = { patient_id: patientId || 0 };

      return _http2.default.post(_endpoints2.default.profileImages.photo, data);
    },
    getInsuranceCardImage: function getInsuranceCardImage(patientId) {
      var data = { patient_id: patientId || 0 };

      return _http2.default.post(_endpoints2.default.profileImages.insuranceCardImage, data);
    },
    getPatientById: function getPatientById(patientId) {
      patientId = patientId || 0;

      return _http2.default.get(_endpoints2.default.patients.show + '/' + patientId);
    },
    findPatientNotifications: function findPatientNotifications(patientId) {
      var data = {
        where: {
          patientid: patientId || 0,
          status: 1
        }
      };

      return _http2.default.post(_endpoints2.default.notifications.withFilter, data);
    },
    addNewPatient: function addNewPatient() {
      var data = {};

      return _http2.default.post('/patients/add-new-patient', data);
    },
    getDataForFillingPatientForm: function getDataForFillingPatientForm(patientId) {
      var data = { 'patient_id': patientId || 0 };

      return _http2.default.post(_endpoints2.default.patients.fillingForm, data);
    },
    getReferrers: function getReferrers(requestedName) {
      var data = { partial_name: requestedName };

      return _http2.default.post(_endpoints2.default.patients.referrers, data);
    },
    getEligiblePayerSource: function getEligiblePayerSource() {
      return _axios2.default.get('https://eligibleapi.com/resources/payers/claims/medical.json');
    },
    getListContactsAndCompanies: function getListContactsAndCompanies(requestedName) {
      var data = {
        partial_name: requestedName,
        without_companies: true
      };

      return _http2.default.post(_endpoints2.default.contacts.listContactsAndCompanies, data);
    },
    editPatient: function editPatient(patientId, patientFormData, formedFullNames, pressedButtons, requestedEmails, trackerNotes) {
      var _this14 = this;

      patientId = patientId || 0;
      patientFormData = (0, _assign2.default)(patientFormData, {
        location: this.patientLocation
      });

      var fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number', 'ssn'];

      fields.forEach(function (el) {
        patientFormData[el] = _this14.number(patientFormData[el]);
      });

      var data = {
        patient_form_data: patientFormData,
        pressed_buttons: pressedButtons || undefined,
        requested_emails: requestedEmails || undefined,
        tracker_notes: trackerNotes || undefined
      };

      return _http2.default.post(_endpoints2.default.patients.edit + '/' + patientId, data);
    },
    checkEmail: function checkEmail(email, patientId) {
      var data = {
        email: email || '',
        patient_id: patientId || 0
      };

      return _http2.default.post(_endpoints2.default.patients.checkEmail, data);
    },
    removeNotificationInDb: function removeNotificationInDb(id) {
      id = id || 0;
      var data = { status: 2 };

      return _http2.default.put(_endpoints2.default.notifications.update + '/' + id, data);
    },
    walkThroughMessages: function walkThroughMessages(messages, patient) {
      for (var property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (patient[property] === undefined || patient[property].trim() === '') {
            alert(messages[property]);
            this.$refs[property].focus();
            return false;
          }
        }
      }
      return true;
    },
    walkThroughComplexMessages: function walkThroughComplexMessages(messages, patient) {
      for (var property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (patient.hasOwnProperty(property) && patient[property].length > 0 && patient[messages[property].connect_to] === '') {
            alert(messages[property].message);
            this.$refs[property].focus();

            return false;
          }
        }
      }

      return true;
    },
    validatePatientData: function validatePatientData(patient, requestedEmails, referredName) {
      referredName = referredName || '';

      var messages = {
        firstname: 'First Name is Required',
        lastname: 'Last Name is Required',
        email: 'Email is Required',
        add1: 'Address is Required',
        city: 'City is Required',
        state: 'State is Required',
        zip: 'Zip is Required',
        gender: 'Gender is Required',
        cell_phone: 'Cell phone is Required'
      };

      if (!this.walkThroughMessages(messages, patient)) {
        return false;
      }

      if (referredName.length > 0 && !patient.referred_by) {
        alert('Invalid referred by.');
        this.$refs.referred_by_name.focus();

        return false;
      }

      if (!this.isValidDate(patient.dob)) {
        alert('Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format');
        this.$refs.dob.focus();

        return false;
      }

      if (patient.home_phone.trim() === '' && patient.work_phone.trim() === '' && patient.cell_phone.trim() === '') {
        alert('Phone Number is required');

        return false;
      }

      if (patient.p_m_ins_ass === 'No' || patient.s_m_ins_ass === 'No') {
        return confirm('Selecting "Payment to Patient" means NO payment will go to your' + 'office (payment will be mailed to patient). Select "Accept Assignment ' + 'of Benefits" to have the insurance check go to your office instead. ' + '"Accept Assignment" is recommended in nearly all cases, so make sure ' + 'you choose correctly.');
      }

      if (parseInt(patient.p_m_dss_file) === 1) {
        messages = {
          p_m_partyfname: 'Insured Party First Name is a Required Field',
          p_m_partylname: 'Insured Party Last Name is a Required Field',
          p_m_relation: 'Relationship to insured party is a Required Field',
          ins_dob: 'Insured Date of Birth is a Required Field',
          p_m_gender: 'Insured Gender is a Required Field',
          p_m_ins_co: 'Insurance Company is a Required Field',
          p_m_party: 'Insurance ID. is a Required Field',
          p_m_ins_grp: 'Group # is a Required Field',
          p_m_ins_type: 'Insurance Type is a Required Field'
        };

        if (!this.walkThroughMessages(messages, patient)) {
          return false;
        }

        if (parseInt(patient.dss_file_radio) === 2) {
          return confirm('You indicated that ' + this.billingCompany.name + ' will file Primary insurance claims but NOT Secondary insurance claims. ' + 'Normally patients expect claims to be filed in both cases please select ' + '"Yes" for Secondary unless you are sure of your choice.');
        }

        if (patient.p_m_ins_plan.trim() === '' && parseInt(patient.p_m_ins_type.value) !== 1) {
          alert('Plan Name is a Required Field');
          this.$refs.p_m_ins_plan.focus();

          return false;
        }

        if (patient.has_s_m_ins === 'Yes' && parseInt(patient.s_m_dss_file) === 1) {
          messages = {
            s_m_partyfname: 'Secondary Insured Party First Name is a Required Field',
            s_m_partylname: 'Secondary Insured Party Last Name is a Required Field',
            s_m_relation: 'Secondary Relationship to insured party is a Required Field',
            ins2_dob: 'Secondary Insured Date of Birth is a Required Field',
            s_m_gender: 'Secondary Insured Gender is a Required Field',
            s_m_ins_co: 'Secondary Insurance Company is a Required Field',
            s_m_party: 'Secondary Insurance ID. is a Required Field',
            s_m_ins_grp: 'Secondary Group # is a Required Field',
            s_m_ins_type: 'Secondary Insurance Type is a Required Field'
          };

          if (!this.walkThroughMessages(messages, patient)) {
            return false;
          }

          if (patient.s_m_ins_plan.trim() === '' && parseInt(patient.p_m_ins_type.value) !== 1) {
            alert('Secondary Plan Name is a Required Field');
            this.$refs.s_m_ins_plan.focus();

            return false;
          }
        }

        if (patient.s_m_ins_ass !== 'Yes' && patient.s_m_ins_ass !== 'No') {
          alert('You must choose \'Accept Assignment of Benefits\' or \'Payment to Patient\'');
          this.$refs.s_m_ins_ass.focus();

          return false;
        }
      } else if (parseInt(patient.p_m_dss_file) === 2 && parseInt(patient.dss_file_radio) === 1) {
        alert(this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.');
        return false;
      }

      if (patient.patientid > 0) {
        messages = {
          docsleep_name: {
            connect_to: 'docsleep',
            message: 'Invalid sleep md.'
          },
          docpcp_name: {
            connect_to: 'docpcp',
            message: 'Invalid primary care md.'
          },
          docdentist_name: {
            connect_to: 'docdentist',
            message: 'Invalid dentist'
          },
          docent_name: {
            connect_to: 'docent',
            message: 'Invalid ENT.'
          },
          docmdother_name: {
            connect_to: 'docmdother',
            message: 'Invalid other md.'
          }
        };

        if (!this.walkThroughComplexMessages(messages, patient)) {
          return false;
        }
      }

      var messageAboutChangingReferredBy = 'The referrer has been updated. Existing pending letters to the referrer may be updated or deleted and previous changes lost. Proceed?';

      if (this.isReferredByChanged && !confirm(messageAboutChangingReferredBy)) {
        return false;
      }

      if (this.pendingVob && this.isInsuranceInfoChanged) {
        if (parseInt(this.pendingVob.status) === _main.DSS_CONSTANTS.DSS_PREAUTH_PREAUTH_PENDING) {
          if (!confirm("Warning! This patient has a Verification of Benefits (VOB) that is currently awaiting pre-authorization from the insurance company. You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {}
        } else {
          if (!confirm("Warning! This patient has a pending Verification of Benefits (VOB). You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
            return false;
          }
        }
      }

      if (requestedEmails && requestedEmails.registration && !confirm('You are about to send the patient a registration email. ' + 'The patient will receive a text message activation code by clicking ' + 'a link contained in this email, and the patient can complete his/her ' + 'forms online. Are you sure you want to continue?')) {
        return false;
      }

      if (requestedEmails && requestedEmails.reminder && !confirm('You are about to send the patient an email. ' + 'Are you sure you want to continue?')) {
        return false;
      }

      var alertText = void 0;
      if (parseInt(patient.s_m_dss_file) === 1 && parseInt(patient.p_m_dss_file) !== 1) {
        alertText = this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.';
        _Alerter2.default.alert(alertText);
        return false;
      }

      if (parseInt(patient.s_m_ins_type) === 1) {
        alertText = 'Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.';
        _Alerter2.default.alert(alertText);
      }

      return true;
    },
    isValidDate: function isValidDate(date) {
      var dateObject = new Date(date);
      return dateObject instanceof Date && !isNaN(dateObject.valueOf());
    }
  }
};

/***/ }),
/* 502 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_vm._v("\n        "+_vm._s(_vm.message)+"\n    ")]):_vm._e(),_vm._v(" "),_vm._l((_vm.patientNotifications),function(notification){return _c('div',{class:'warning ' + notification.notification_type,attrs:{"id":'not_' + notification.id}},[_c('span',[_vm._v(_vm._s(notification.notification)+" "+_vm._s(notification.notification_date))]),_vm._v(" "),_c('a',{staticClass:"close_but",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.removeNotification(notification.id)}}},[_vm._v("X")])])}),_vm._v(" "),_c('form',{attrs:{"name":"patientfrm","id":"patientfrm"}},[_c('table',{staticStyle:{"margin-left":"11px"},attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',[_c('td',[_c('font',{staticStyle:{"color":"#0a5da0","font-weight":"bold","font-size":"16px"}},[_vm._v("GENERAL INFORMATION")])],1),_vm._v(" "),_c('td',{attrs:{"align":"right"}},[_c('input',{staticClass:"button",staticStyle:{"float":"right","margin-left":"5px"},attrs:{"type":"submit"},domProps:{"value":_vm.buttonText + 'Patient'},on:{"click":function($event){$event.preventDefault();_vm.submitAddingOrEditingPatient($event)}}}),_vm._v(" "),(_vm.showSendingEmails)?[(_vm.patient.registration_status == 1 || _vm.patient.registration_status == 0)?_c('input',{staticClass:"button",attrs:{"type":"submit","name":"sendReg","value":"Send Registration Email"},on:{"click":_vm.submitSendingRegistrationEmail}}):_c('input',{staticClass:"button",attrs:{"type":"submit","name":"sendRem","value":"Send Reminder Email"},on:{"click":function($event){$event.preventDefault();_vm.submitSendingReminderEmail($event)}}})]:_vm._e(),_vm._v(" "),(_vm.homeSleepTestCompanies.length > 0)?[(_vm.uncompletedHomeSleepTests.length > 0)?_c('a',{staticClass:"button",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickOrderHst($event)}}},[_vm._v("Order HST")]):_c('input',{staticClass:"button",attrs:{"type":"submit","name":"sendHST","value":"Order HST"},on:{"click":function($event){$event.preventDefault();_vm.submitSendingHst($event)}}})]:_vm._e()],2)]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',{staticStyle:{"float":"right","width":"270px"},attrs:{"id":"profile_image"}},[_c('span',{staticStyle:{"float":"right"}},[(!_vm.profilePhoto)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickAddImage('profile')}}},[_c('img',{attrs:{"src":__webpack_require__(503)}})]):_c('img',{staticStyle:{"max-height":"150px","max-width":"200px","float":"right"},attrs:{"src":_vm.profilePhoto.image_file}})])]),_vm._v(" "),_vm._m(0),_vm._v(" "),_c('div',{staticStyle:{"float":"left","clear":"left"}},[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.salutation),expression:"patient.salutation"}],staticStyle:{"width":"80px"},attrs:{"name":"salutation"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.salutation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"Mr."}},[_vm._v("Mr.")]),_vm._v(" "),_c('option',{attrs:{"value":"Mrs."}},[_vm._v("Mrs.")]),_vm._v(" "),_c('option',{attrs:{"value":"Ms."}},[_vm._v("Ms.")]),_vm._v(" "),_c('option',{attrs:{"value":"Dr."}},[_vm._v("Dr.")])]),_vm._v(" "),_c('label',{attrs:{"for":"salutation"}},[_vm._v("Salutation")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.firstname),expression:"patient.firstname"}],ref:"firstname",staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"firstname","name":"firstname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.firstname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.firstname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"firstname"}},[_vm._v("First Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.lastname),expression:"patient.lastname"}],ref:"lastname",staticClass:"field text addr tbox",staticStyle:{"width":"190px"},attrs:{"id":"lastname","name":"lastname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.lastname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.lastname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"lastname"}},[_vm._v("Last Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.middlename),expression:"patient.middlename"}],staticClass:"field text addr tbox",staticStyle:{"width":"30px"},attrs:{"id":"middlename","name":"middlename","type":"text","maxlength":"1"},domProps:{"value":(_vm.patient.middlename)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.middlename=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"middlename"}},[_vm._v("MI")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.preferred_name),expression:"patient.preferred_name"}],staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"preferred_name","name":"preferred_name","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.preferred_name)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.preferred_name=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"preferred_name"}},[_vm._v("Preferred Name")])])]),_vm._v(" "),_c('div',{staticStyle:{"float":"left"}},[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.home_phone),expression:"patient.home_phone"}],staticClass:"phonemask field text addr tbox",staticStyle:{"width":"100px"},attrs:{"id":"home_phone","name":"home_phone","type":"text","maxlength":"14"},domProps:{"value":(_vm.patient.home_phone)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.home_phone=$event.target.value}}}),_vm._v(" "),_vm._m(1)]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.cell_phone),expression:"patient.cell_phone"}],ref:"cell_phone",staticClass:"phonemask field text addr tbox",staticStyle:{"width":"100px"},attrs:{"id":"cell_phone","name":"cell_phone","type":"text","maxlength":"14"},domProps:{"value":(_vm.patient.cell_phone)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.cell_phone=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"cell_phone"}},[_vm._v("Cell Phone")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.work_phone),expression:"patient.work_phone"}],staticClass:"extphonemask field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"work_phone","name":"work_phone","type":"text","maxlength":"14"},domProps:{"value":(_vm.patient.work_phone)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.work_phone=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"work_phone"}},[_vm._v("Work Phone")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.email),expression:"patient.email"}],ref:"email",staticClass:"field text addr tbox",staticStyle:{"width":"275px"},attrs:{"id":"email","name":"email","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.email)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.email=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"email"}},[_vm._v("Email/Pt. Portal Login")])])]),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}},[_c('span',{staticStyle:{"width":"140px"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.best_time),expression:"patient.best_time"}],attrs:{"id":"best_time","name":"best_time"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.best_time=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Please Select")]),_vm._v(" "),_c('option',{attrs:{"value":"morning"}},[_vm._v("Morning")]),_vm._v(" "),_c('option',{attrs:{"value":"midday"}},[_vm._v("Mid-Day")]),_vm._v(" "),_c('option',{attrs:{"value":"evening"}},[_vm._v("Evening")])]),_vm._v(" "),_c('label',{attrs:{"for":"best_time"}},[_vm._v("Best time to contact")])]),_vm._v(" "),_c('span',{staticStyle:{"width":"150px"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.best_number),expression:"patient.best_number"}],attrs:{"id":"best_number","name":"best_number"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.best_number=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Please Select")]),_vm._v(" "),_c('option',{attrs:{"value":"home"}},[_vm._v("Home Phone")]),_vm._v(" "),_c('option',{attrs:{"value":"work"}},[_vm._v("Work Phone")]),_vm._v(" "),_c('option',{attrs:{"value":"cell"}},[_vm._v("Cell Phone")])]),_vm._v(" "),_c('label',{attrs:{"for":"best_number"}},[_vm._v("Best number to contact")])]),_vm._v(" "),_c('span',{staticStyle:{"width":"160px"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.preferredcontact),expression:"patient.preferredcontact"}],attrs:{"id":"preferredcontact","name":"preferredcontact"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.preferredcontact=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"paper"}},[_vm._v("Paper Mail")]),_vm._v(" "),_c('option',{attrs:{"value":"email"}},[_vm._v("Email")])]),_vm._v(" "),_c('label',[_vm._v("Preferred Contact Method")])]),_vm._v(" "),_c('div',[_vm._v("Portal:\n                                    "),_c('span',{staticStyle:{"color":"#933","float":"none"}},[_vm._v("\n                                        "+_vm._s(_vm.portalStatus)+"\n                                    ")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit","name":"sendPin","value":"Patient can't receive text message?"},on:{"click":function($event){$event.preventDefault();_vm.submitSendingPinCode($event)}}}),_vm._v(" "),(_vm.patient.registration_status == 1)?[_vm._v("\n                                        PIN Code: "+_vm._s(_vm.patient.access_code)+"\n                                    ")]:_vm._e()],2)])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_vm._m(2),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.add1),expression:"patient.add1"}],ref:"add1",staticClass:"field text addr tbox",staticStyle:{"width":"225px"},attrs:{"id":"add1","name":"add1","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.add2),expression:"patient.add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"175px"},attrs:{"id":"add2","name":"add2","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"add2"}},[_vm._v("Address2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.city),expression:"patient.city"}],ref:"city",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"city","name":"city","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.state),expression:"patient.state"}],ref:"state",staticClass:"field text addr tbox",staticStyle:{"width":"25px"},attrs:{"id":"state","name":"state","type":"text","maxlength":"2"},domProps:{"value":(_vm.patient.state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.zip),expression:"patient.zip"}],ref:"zip",staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"zip","name":"zip","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"zip"}},[_vm._v("Zip / Post Code ")])]),_vm._v(" "),(_vm.docLocations.length >= 1)?_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patientLocation),expression:"patientLocation"}],attrs:{"name":"location"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patientLocation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select")]),_vm._v(" "),_vm._l((_vm.docLocations),function(location){return _c('option',{domProps:{"selected":location.default_location == 1 && !_vm.routeParameters.patientId,"value":location.id}},[_vm._v(_vm._s(location.location))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"location"}},[_vm._v("Office Site")])]):_vm._e()])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.dob),expression:"patient.dob"}],ref:"dob",staticClass:"field text addr tbox calendar",staticStyle:{"width":"100px"},attrs:{"id":"dob","name":"dob","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.dob)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.dob=$event.target.value}}}),_vm._v(" "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]),_vm._v(" "),_c('label',{attrs:{"for":"dob"}},[_vm._v("Birthday")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.gender),expression:"patient.gender"}],ref:"gender",staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"gender","id":"gender"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.gender=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select")]),_vm._v(" "),_c('option',{attrs:{"value":"Male"}},[_vm._v("Male")]),_vm._v(" "),_c('option',{attrs:{"value":"Female"}},[_vm._v("Female")])]),_vm._v(" "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]),_vm._v(" "),_c('label',{attrs:{"for":"gender"}},[_vm._v("Gender")])]),_vm._v(" "),_c('span',{staticStyle:{"width":"150px"}},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.ssn),expression:"patient.ssn"}],staticClass:"ssnmask field text addr tbox",staticStyle:{"width":"100px"},attrs:{"id":"ssn","name":"ssn","type":"text","maxlength":"11"},domProps:{"value":(_vm.patient.ssn)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.ssn=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"ssn"}},[_vm._v("Social Security No.")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.feet),expression:"patient.feet"}],staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"feet","id":"feet","tabindex":"5"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.feet=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"0","disabled":""}},[_vm._v("Feet")]),_vm._v(" "),_vm._l((9),function(i){return _c('option',{domProps:{"value":i}},[_vm._v(_vm._s(i))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"feet"}},[_vm._v("Height: Feet")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.inches),expression:"patient.inches"}],staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"inches","id":"inches","tabindex":"6"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.inches=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"-1","disabled":""}},[_vm._v("Inches")]),_vm._v(" "),_vm._l((_vm.inches),function(i){return _c('option',{domProps:{"value":i}},[_vm._v(_vm._s(i))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"inches"}},[_vm._v("Inches")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.weight),expression:"patient.weight"}],staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"weight","id":"weight","tabindex":"7"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.weight=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"0","disabled":""}},[_vm._v("Weight")]),_vm._v(" "),_vm._l((_vm.weight),function(i){return _c('option',{domProps:{"value":i}},[_vm._v(_vm._s(i))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"weight"}},[_vm._v("Weight in Pounds    ")])]),_vm._v(" "),_c('span',[_c('span',{staticStyle:{"color":"#000000","padding-top":"2px"}},[_vm._v("BMI")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.bmi),expression:"patient.bmi"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"bmi","name":"bmi","type":"text","tabindex":"8","maxlength":"255","readonly":"readonly"},domProps:{"value":(_vm.patient.bmi)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.bmi=$event.target.value}}})]),_vm._v(" "),_vm._m(3)])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead"},[_c('ul',[_c('li',[_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.marital_status),expression:"patient.marital_status"}],staticClass:"field text addr tbox",staticStyle:{"width":"130px"},attrs:{"name":"marital_status","id":"marital_status"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.marital_status=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select")]),_vm._v(" "),_c('option',{attrs:{"value":"Married"}},[_vm._v("Married")]),_vm._v(" "),_c('option',{attrs:{"value":"Single"}},[_vm._v("Single")]),_vm._v(" "),_c('option',{attrs:{"value":"Life Partner"}},[_vm._v("Life Partner")]),_vm._v(" "),_c('option',{attrs:{"value":"Minor"}},[_vm._v("Minor")])]),_vm._v(" "),_c('label',{attrs:{"for":"marital_status"}},[_vm._v("Marital Status")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.partner_name),expression:"patient.partner_name"}],staticClass:"field text addr tbox",attrs:{"id":"partner_name","name":"partner_name","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.partner_name)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.partner_name=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"partner_name"}},[_vm._v("Partner/Guardian Name")])])])])])]),_vm._v(" "),_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.patient_notes),expression:"patient.patient_notes"}],staticClass:"field text addr tbox",staticStyle:{"width":"410px"},attrs:{"name":"patient_notes","id":"patient_notes"},domProps:{"value":(_vm.patient.patient_notes)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.patient_notes=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"patient_notes"}},[_vm._v("Patient Notes")])])]),_vm._v(" "),_c('div',{staticClass:"alert-text"},[_c('span',[_c('label',{staticStyle:{"display":"inline"},attrs:{"for":"alert_text"}},[_vm._v("Patient alert (display text notification at top of chart)?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.display_alert),expression:"patient.display_alert"}],attrs:{"type":"radio","name":"display_alert","value":"1"},domProps:{"checked":_vm._q(_vm.patient.display_alert,"1")},on:{"__c":function($event){_vm.patient.display_alert="1"}}}),_vm._v("Yes\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.display_alert),expression:"patient.display_alert"}],attrs:{"type":"radio","name":"display_alert","value":"0"},domProps:{"checked":_vm._q(_vm.patient.display_alert,"0")},on:{"__c":function($event){_vm.patient.display_alert="0"}}}),_vm._v("No\n                                ")]),_vm._v(" "),_c('textarea',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.display_alert == 1),expression:"patient.display_alert == 1"},{name:"model",rawName:"v-model",value:(_vm.patient.alert_text),expression:"patient.alert_text"}],attrs:{"name":"alert_text","id":"alert_text"},domProps:{"value":(_vm.patient.alert_text)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.alert_text=$event.target.value}}})])])])])]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                In case of an emergency\n                            ")]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emergency_name),expression:"patient.emergency_name"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"emergency_name","name":"emergency_name","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emergency_name)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emergency_name=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emergency_name"}},[_vm._v("Name")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emergency_relationship),expression:"patient.emergency_relationship"}],staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"emergency_relationship","name":"emergency_relationship","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emergency_relationship)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emergency_relationship=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emergency_relationship"}},[_vm._v("Relationship")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emergency_number),expression:"patient.emergency_number"}],staticClass:"extphonemask field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"emergency_number","name":"emergency_number","type":"text","maxlength":"14"},domProps:{"value":(_vm.patient.emergency_number)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emergency_number=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emergency_number"}},[_vm._v("Number")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2"}},[_c('font',{staticStyle:{"color":"#0a5da0","font-weight":"bold","font-size":"16px"}},[_vm._v("REFERRED BY")])],1)]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v(" ")]),_vm._v(" "),_c('div',[_c('div',{staticStyle:{"float":"left"}},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.copyreqdate),expression:"patient.copyreqdate"}],ref:"copyreqdate",staticClass:"field text addr tbox calendar",staticStyle:{"width":"100px"},attrs:{"id":"copyreqdate","name":"copyreqdate","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.copyreqdate)},on:{"change":function($event){_vm.validateDate('copyreqdate')},"input":function($event){if($event.target.composing){ return; }_vm.patient.copyreqdate=$event.target.value}}}),_vm._v(" "),_c('label',[_vm._v("Date")])]),_vm._v(" "),_c('div',{staticStyle:{"float":"left"},attrs:{"id":"referred_source_div"}},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_source),expression:"patient.referred_source"}],attrs:{"type":"radio"},domProps:{"checked":_vm.patient.referred_source == _vm.consts.DSS_REFERRED_PHYSICIAN,"value":_vm.consts.DSS_REFERRED_PATIENT,"checked":_vm._q(_vm.patient.referred_source,_vm.consts.DSS_REFERRED_PATIENT)},on:{"click":function($event){_vm.showReferredBy('person', '')},"__c":function($event){_vm.patient.referred_source=_vm.consts.DSS_REFERRED_PATIENT}}}),_vm._v(" Person\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_source),expression:"patient.referred_source"}],attrs:{"type":"radio"},domProps:{"value":_vm.consts.DSS_REFERRED_MEDIA,"checked":_vm._q(_vm.patient.referred_source,_vm.consts.DSS_REFERRED_MEDIA)},on:{"click":function($event){_vm.showReferredBy('notes', _vm.consts.DSS_REFERRED_MEDIA)},"__c":function($event){_vm.patient.referred_source=_vm.consts.DSS_REFERRED_MEDIA}}}),_vm._v(" "+_vm._s(_vm.consts.dssReferredLabels[_vm.consts.DSS_REFERRED_MEDIA])+"\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_source),expression:"patient.referred_source"}],attrs:{"type":"radio"},domProps:{"value":_vm.consts.DSS_REFERRED_FRANCHISE,"checked":_vm._q(_vm.patient.referred_source,_vm.consts.DSS_REFERRED_FRANCHISE)},on:{"click":function($event){_vm.showReferredBy('notes', _vm.consts.DSS_REFERRED_FRANCHISE)},"__c":function($event){_vm.patient.referred_source=_vm.consts.DSS_REFERRED_FRANCHISE}}}),_vm._v(" "+_vm._s(_vm.consts.dssReferredLabels[_vm.consts.DSS_REFERRED_FRANCHISE])+"\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_source),expression:"patient.referred_source"}],attrs:{"type":"radio"},domProps:{"value":_vm.consts.DSS_REFERRED_DSSOFFICE,"checked":_vm._q(_vm.patient.referred_source,_vm.consts.DSS_REFERRED_DSSOFFICE)},on:{"click":function($event){_vm.showReferredBy('notes', _vm.consts.DSS_REFERRED_DSSOFFICE)},"__c":function($event){_vm.patient.referred_source=_vm.consts.DSS_REFERRED_DSSOFFICE}}}),_vm._v(" "+_vm._s(_vm.consts.dssReferredLabels[_vm.consts.DSS_REFERRED_DSSOFFICE])+"\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_source),expression:"patient.referred_source"}],attrs:{"type":"radio"},domProps:{"value":_vm.consts.DSS_REFERRED_OTHER,"checked":_vm._q(_vm.patient.referred_source,_vm.consts.DSS_REFERRED_OTHER)},on:{"click":function($event){_vm.showReferredBy('notes', _vm.consts.DSS_REFERRED_OTHER)},"__c":function($event){_vm.patient.referred_source=_vm.consts.DSS_REFERRED_OTHER}}}),_vm._v(" "+_vm._s(_vm.consts.dssReferredLabels[_vm.consts.DSS_REFERRED_OTHER])+"\n                                ")]),_vm._v(" "),_c('div',{staticStyle:{"clear":"both","float":"left"}},[(_vm.showReferredPerson)?_c('div',{staticStyle:{"margin-left":"100px"},attrs:{"id":"referred_person"}},[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.referred_name),expression:"formedFullNames.referred_name"}],ref:"referred_by_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"referredby_name","autocomplete":"off","name":"referredby_name","placeholder":"Type referral name"},domProps:{"value":(_vm.formedFullNames.referred_name)},on:{"keyup":_vm.onKeyUpSearchReferrers,"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.referred_name=$event.target.value}}}),_vm._v(" "),_c('input',{staticClass:"button",staticStyle:{"width":"150px"},attrs:{"type":"button","value":"+ Create New Contact"},on:{"click":_vm.onClickCreateNewContact}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundReferrersByName.length > 0),expression:"foundReferrersByName.length > 0"}],staticClass:"search_hints",staticStyle:{"margin-top":"20px"},attrs:{"id":"referredby_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"referredby_list"}},_vm._l((_vm.foundReferrersByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setReferredBy(contact.id, contact.source)}}},[_vm._v(_vm._s(contact.name))])}))])]):_vm._e(),_vm._v(" "),(_vm.showReferredNotes)?_c('div',{staticStyle:{"margin-left":"200px"},attrs:{"id":"referred_notes"}},[_c('textarea',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.referred_notes),expression:"patient.referred_notes"}],staticStyle:{"width":"300px"},attrs:{"name":"referred_notes"},domProps:{"value":(_vm.patient.referred_notes)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.referred_notes=$event.target.value}}})]):_vm._e()])])])])])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2"}},[_c('font',{staticStyle:{"color":"#0a5da0","font-weight":"bold","font-size":"16px"}},[_vm._v("EMPLOYER")])],1)]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Employer Information\n                            ")]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.employer),expression:"patient.employer"}],staticClass:"field text addr tbox",staticStyle:{"width":"325px"},attrs:{"id":"employer","name":"employer","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.employer)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.employer=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"employer"}},[_vm._v("Employer")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_phone),expression:"patient.emp_phone"}],staticClass:"extphonemask field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"emp_phone","name":"emp_phone","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_phone)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_phone=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_phone"}},[_vm._v("  Phone")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_fax),expression:"patient.emp_fax"}],staticClass:"phonemask field text addr tbox",staticStyle:{"width":"120px"},attrs:{"id":"emp_fax","name":"emp_fax","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_fax)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_fax=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_fax"}},[_vm._v("Fax")])])]),_vm._v(" "),_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_add1),expression:"patient.emp_add1"}],staticClass:"field text addr tbox",staticStyle:{"width":"225px"},attrs:{"id":"emp_add1","name":"emp_add1","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_add1)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_add1=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_add1"}},[_vm._v("Address1")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_add2),expression:"patient.emp_add2"}],staticClass:"field text addr tbox",staticStyle:{"width":"175px"},attrs:{"id":"emp_add2","name":"emp_add2","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_add2)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_add2=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_add2"}},[_vm._v("Address2")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_city),expression:"patient.emp_city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"emp_city","name":"emp_city","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_city"}},[_vm._v("City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_state),expression:"patient.emp_state"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"emp_state","name":"emp_state","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_state"}},[_vm._v("State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.emp_zip),expression:"patient.emp_zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"emp_zip","name":"emp_zip","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.emp_zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.emp_zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"emp_zip"}},[_vm._v("Zip Code ")])])])])])])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2"}},[_c('a',{attrs:{"name":"p_m_ins"}}),_vm._v(" "),_c('font',{staticStyle:{"color":"#0a5da0","font-weight":"bold","font-size":"16px"}},[_vm._v("INSURANCE")])],1)]),_vm._v(" "),(_vm.docInfo.use_eligible_api == 1)?[_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_vm._v("\n                        Insurance Co.\n                        "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.ins_payer_name),expression:"formedFullNames.ins_payer_name"}],ref:"ins-payer-name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"ins_payer_name","autocomplete":"off","name":"ins_payer_name","placeholder":"Type insurance payer name"},domProps:{"value":(_vm.formedFullNames.ins_payer_name)},on:{"keyup":function($event){_vm.onKeyUpSearchEligiblePayers('primary')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.ins_payer_name=$event.target.value}}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.eligiblePayers.length > 0),expression:"eligiblePayers.length > 0"}],staticClass:"search_hints",staticStyle:{"margin-top":"20px"},attrs:{"id":"ins_payer_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"ins_payer_list"}},_vm._l((_vm.eligiblePayers),function(payer){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setEligiblePayer(payer.id, payer.name, 'primary')}}},[_vm._v(_vm._s(payer.id + ' - ' + payer.name))])}))])])])]:_vm._e(),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Primary Medical          \n                                "),(+_vm.billingCompany.exclusive)?[_vm._v("\n                                    "+_vm._s(_vm.billingCompany.name + ' filing insurance')+"\n                                ")]:_c('a',{staticClass:"plain",attrs:{"title":'Select YES if you would like ' + _vm.billingCompany.name + ' to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended).'}},[_vm._v(_vm._s(_vm.billingCompany.name)+" filing insurance?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_dss_file),expression:"patient.p_m_dss_file"}],staticClass:"dss_file_radio",attrs:{"id":"p_m_dss_file_yes","type":"radio","name":"p_m_dss_file","value":"1"},domProps:{"checked":_vm._q(_vm.patient.p_m_dss_file,"1")},on:{"__c":function($event){_vm.patient.p_m_dss_file="1"}}}),_vm._v("Yes    \n                                "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_dss_file),expression:"patient.p_m_dss_file"}],staticClass:"dss_file_radio",attrs:{"id":"p_m_dss_file_no","type":"radio","name":"p_m_dss_file","value":"2"},domProps:{"checked":_vm._q(_vm.patient.p_m_dss_file,"2")},on:{"__c":function($event){_vm.patient.p_m_dss_file="2"}}}),_vm._v("No         \n                                "),_c('a',{staticClass:"plain",attrs:{"onclick":"return false","title":"Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO."}},[_vm._v("Insured Address same as Pt. address?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_same_address),expression:"patient.p_m_same_address"}],attrs:{"type":"radio","name":"p_m_same_address","value":"1"},domProps:{"checked":_vm._q(_vm.patient.p_m_same_address,"1")},on:{"__c":function($event){_vm.patient.p_m_same_address="1"}}}),_vm._v(" Yes\n                                "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_same_address),expression:"patient.p_m_same_address"}],attrs:{"type":"radio","name":"p_m_same_address","value":"2"},domProps:{"checked":_vm._q(_vm.patient.p_m_same_address,"2")},on:{"__c":function($event){_vm.patient.p_m_same_address="2"}}}),_vm._v(" No\n                            ")],2),_vm._v(" "),_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_relation),expression:"patient.p_m_relation"}],ref:"p_m_relation",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"p_m_relation","name":"p_m_relation"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.p_m_relation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},function($event){_vm.handleChangingInsuranceInfo, _vm.onChangeRelations('primary_insurance')}]}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("None")]),_vm._v(" "),_c('option',{attrs:{"value":"Self"}},[_vm._v("Self")]),_vm._v(" "),_c('option',{attrs:{"value":"Spouse"}},[_vm._v("Spouse")]),_vm._v(" "),_c('option',{attrs:{"value":"Child"}},[_vm._v("Child")]),_vm._v(" "),_c('option',{attrs:{"value":"Other"}},[_vm._v("Other")])]),_vm._v(" "),_c('label',{attrs:{"for":"work_phone"}},[_vm._v("Relationship to insured party")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_partyfname),expression:"patient.p_m_partyfname"}],ref:"p_m_partyfname",staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"p_m_partyfname","name":"p_m_partyfname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_partyfname)},on:{"change":_vm.handleChangingInsuranceInfo,"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_partyfname=$event.target.value}}}),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_partymname),expression:"patient.p_m_partymname"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"p_m_partymname","name":"p_m_partymname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_partymname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_partymname=$event.target.value}}}),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_partylname),expression:"patient.p_m_partylname"}],ref:"p_m_partylname",staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"p_m_partylname","name":"p_m_partylname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_partylname)},on:{"change":_vm.handleChangingInsuranceInfo,"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_partylname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_partyfname"}},[_vm._v("Insured party First                   Middle     Last")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.ins_dob),expression:"patient.ins_dob"}],ref:"ins_dob",staticClass:"field text addr tbox calendar",staticStyle:{"width":"150px"},attrs:{"id":"ins_dob","name":"ins_dob","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.ins_dob)},on:{"change":function($event){_vm.handleChangingInsuranceInfo, _vm.validateDate(_vm.patient.ins_dob)},"input":function($event){if($event.target.composing){ return; }_vm.patient.ins_dob=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"ins_dob"}},[_vm._v("Insured Date of Birth")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_gender),expression:"patient.p_m_gender"}],ref:"p_m_gender",staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"p_m_gender","id":"p_m_gender"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.p_m_gender=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select")]),_vm._v(" "),_c('option',{attrs:{"value":"Male"}},[_vm._v("Male")]),_vm._v(" "),_c('option',{attrs:{"value":"Female"}},[_vm._v("Female")])]),_vm._v(" "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]),_vm._v(" "),_c('label',{attrs:{"for":"p_m_gender"}},[_vm._v("Insured Gender")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.p_m_same_address == 2),expression:"patient.p_m_same_address == 2"}],attrs:{"id":"p_m_address_fields"}},[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_address),expression:"patient.p_m_address"}],staticClass:"field text addr tbox",staticStyle:{"width":"225px"},attrs:{"id":"p_m_address","name":"p_m_address","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_address)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_address=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_address"}},[_vm._v("Insured Address")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_city),expression:"patient.p_m_city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"p_m_city","name":"p_m_city","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_city"}},[_vm._v("Insured City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_state),expression:"patient.p_m_state"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"p_m_state","name":"p_m_state","type":"text","maxlength":"2"},domProps:{"value":(_vm.patient.p_m_state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_state"}},[_vm._v("Insured State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_zip),expression:"patient.p_m_zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"p_m_zip","name":"p_m_zip","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_zip"}},[_vm._v("Insured Zip Code ")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_type),expression:"patient.p_m_ins_type"}],ref:"p_m_ins_type",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"p_m_ins_type","name":"p_m_ins_type"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.p_m_ins_type=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},_vm.handleChangingInsuranceInfo]}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Insurance Type")]),_vm._v(" "),_c('option',{attrs:{"value":"1"}},[_vm._v("Medicare")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("Medicaid")]),_vm._v(" "),_c('option',{attrs:{"value":"3"}},[_vm._v("Tricare Champus")]),_vm._v(" "),_c('option',{attrs:{"value":"4"}},[_vm._v("Champ VA")]),_vm._v(" "),_c('option',{attrs:{"value":"5"}},[_vm._v("Group Health Plan")]),_vm._v(" "),_c('option',{attrs:{"value":"6"}},[_vm._v("FECA BLKLUNG")]),_vm._v(" "),_c('option',{attrs:{"value":"7"}},[_vm._v("Other")])]),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_type"}},[_vm._v("Insurance Type")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_ass),expression:"patient.p_m_ins_ass"}],staticClass:"p_m_ins_ass",attrs:{"id":"p_m_ins_ass_yes","type":"radio","name":"p_m_ins_ass","value":"Yes"},domProps:{"checked":_vm._q(_vm.patient.p_m_ins_ass,"Yes")},on:{"__c":function($event){_vm.patient.p_m_ins_ass="Yes"}}}),_vm._v("Accept Assignment of Benefits     \n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_ass),expression:"patient.p_m_ins_ass"}],staticClass:"p_m_ins_ass pay_to_patient_radio",attrs:{"id":"p_m_ins_ass_no","type":"radio","name":"p_m_ins_ass","value":"No"},domProps:{"checked":_vm._q(_vm.patient.p_m_ins_ass,"No")},on:{"__c":function($event){_vm.patient.p_m_ins_ass="No"}}}),_vm._v("Payment to Patient\n                                ")]),_vm._v(" "),_c('span',{staticStyle:{"float":"right"}},[(!_vm.insuranceCardImage)?_c('button',{staticClass:"addButton",attrs:{"id":"p_m_ins_card"},on:{"click":function($event){_vm.onClickAddImage('primary-insurance-card-image')}}},[_vm._v("\n                                        + Add Insurance Card Image\n                                    ")]):_c('button',{staticClass:"addButton",attrs:{"id":"p_m_ins_card"},on:{"click":_vm.onClickDisplayFile}},[_vm._v("\n                                        View Insurance Card Image\n                                    ")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_co),expression:"patient.p_m_ins_co"}],ref:"p_m_ins_co",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"p_m_ins_co","name":"p_m_ins_co"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.p_m_ins_co=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},function($event){_vm.handleChangingInsuranceInfo, _vm.updateNumber('p_m_ins_phone')}]}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select Insurance Company")]),_vm._v(" "),_vm._l((_vm.insuranceContacts),function(contact){return _c('option',{domProps:{"value":contact.contactid}},[_vm._v(_vm._s(contact.company))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_co"}},[_vm._v("Insurance Co.")]),_c('br'),_vm._v(" "),_c('input',{staticClass:"button",staticStyle:{"width":"215px"},attrs:{"type":"button","value":"+ Create New Insurance Company"},on:{"click":function($event){_vm.onClickCreatingNewInsuranceCompany('p_m_ins_co')}}})]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_id),expression:"patient.p_m_ins_id"}],ref:"p_m_party",staticClass:"field text addr tbox",staticStyle:{"width":"190px"},attrs:{"id":"p_m_party","name":"p_m_ins_id","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_ins_id)},on:{"change":_vm.handleChangingInsuranceInfo,"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_ins_id=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_id"}},[_vm._v("Insurance ID.")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_grp),expression:"patient.p_m_ins_grp"}],ref:"p_m_ins_grp",staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"readonly":_vm.patient.p_m_ins_type == '1',"id":"p_m_ins_grp","name":"p_m_ins_grp","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_ins_grp)},on:{"change":_vm.handleChangingInsuranceInfo,"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_ins_grp=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_grp"}},[_vm._v("Group #")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.p_m_ins_plan),expression:"patient.p_m_ins_plan"}],ref:"p_m_ins_plan",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"readonly":_vm.patient.p_m_ins_type == '1',"id":"p_m_ins_plan","name":"p_m_ins_plan","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.p_m_ins_plan)},on:{"change":_vm.handleChangingInsuranceInfo,"input":function($event){if($event.target.composing){ return; }_vm.patient.p_m_ins_plan=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_plan"}},[_vm._v("Plan Name")])]),_vm._v(" "),_c('span',[_c('textarea',{staticClass:"field text addr tbox",staticStyle:{"width":"190px","height":"60px","background":"#ccc"},attrs:{"id":"p_m_ins_phone","name":"p_m_ins_phone","disabled":"disabled"}},[_vm._v(_vm._s(_vm.insCompanyContactInfo))]),_vm._v(" "),_c('label',{attrs:{"for":"p_m_ins_phone"}},[_vm._v("Address")])])]),_vm._v(" "),_c('div')])])])]),_vm._v(" "),_vm._m(4),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',{staticStyle:{"height":"40px","display":"block"}},[_c('span',[_c('label',{staticStyle:{"display":"inline"}},[_vm._v("Does patient have secondary insurance?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.has_s_m_ins),expression:"patient.has_s_m_ins"}],attrs:{"type":"radio","value":"Yes","name":"s_m_ins"},domProps:{"checked":_vm._q(_vm.patient.has_s_m_ins,"Yes")},on:{"__c":function($event){_vm.patient.has_s_m_ins="Yes"}}}),_vm._v(" Yes\n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.has_s_m_ins),expression:"patient.has_s_m_ins"}],attrs:{"type":"radio","value":"No","name":"s_m_ins"},domProps:{"checked":_vm._q(_vm.patient.has_s_m_ins,"No")},on:{"__c":function($event){_vm.patient.has_s_m_ins="No"}}}),_vm._v(" No\n                                ")])])])])])]),_vm._v(" "),(_vm.docInfo.use_eligible_api === 1)?[_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_vm._v("\n                        Insurance Co.\n                        "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.s_m_ins_payer_name),expression:"formedFullNames.s_m_ins_payer_name"}],ref:"secondary-ins-payer-name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"s_m_ins_payer_name","autocomplete":"off","name":"s_m_ins_payer_name","placeholder":"Type insurance payer name"},domProps:{"value":(_vm.formedFullNames.s_m_ins_payer_name)},on:{"keyup":function($event){_vm.onKeyUpSearchEligiblePayers('secondary')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.s_m_ins_payer_name=$event.target.value}}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.secondaryEligiblePayers.length > 0),expression:"secondaryEligiblePayers.length > 0"}],staticClass:"search_hints",staticStyle:{"margin-top":"20px"},attrs:{"id":"s_m_ins_payer_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"s_m_ins_payer_list"}},_vm._l((_vm.secondaryEligiblePayers),function(payer){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setEligiblePayer(payer.id, payer.name, 'secondary')}}},[_vm._v(_vm._s(payer.id + ' - ' + payer.name))])}))])])])]:_vm._e(),_vm._v(" "),_c('tr',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.has_s_m_ins == 'Yes'),expression:"patient.has_s_m_ins == 'Yes'"}]},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top","colspan":"2"}},[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticClass:"desc s_m_ins_div",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Secondary Medical           \n                                "),(+_vm.billingCompany.exclusive)?[_vm._v("\n                                    "+_vm._s(_vm.billingCompany.name + ' filing insurance')+"\n                                ")]:_c('a',{staticClass:"plain",attrs:{"onclick":"return false;","href":"#","title":'Select YES if you would like ' + _vm.billingCompany.name + ' to file insurance claims for this patient. Select NO only if you intend to file your own claims (not recommended).'}},[_vm._v(_vm._s(_vm.billingCompany.name)+" filing insurance?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.dss_file_radio),expression:"patient.dss_file_radio"}],staticClass:"dss_file_radio",attrs:{"id":"s_m_dss_file_yes","type":"radio","name":"s_m_dss_file","value":"1"},domProps:{"checked":_vm._q(_vm.patient.dss_file_radio,"1")},on:{"__c":function($event){_vm.patient.dss_file_radio="1"}}}),_vm._v("Yes    \n                                "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.dss_file_radio),expression:"patient.dss_file_radio"}],staticClass:"dss_file_radio",attrs:{"id":"s_m_dss_file_no","type":"radio","name":"s_m_dss_file","value":"2"},domProps:{"checked":_vm._q(_vm.patient.dss_file_radio,"2")},on:{"__c":function($event){_vm.patient.dss_file_radio="2"}}}),_vm._v("No         \n                                "),_c('a',{staticClass:"plain",attrs:{"onclick":"return false","href":"#","title":"Select YES if the address you listed in the patient address section is the same address on file with the patient's insurance company. It is uncommon to select NO."}},[_vm._v("Insured Address same as Pt. address?")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_same_address),expression:"patient.s_m_same_address"}],attrs:{"type":"radio","name":"s_m_same_address","value":"1"},domProps:{"checked":_vm._q(_vm.patient.s_m_same_address,"1")},on:{"__c":function($event){_vm.patient.s_m_same_address="1"}}}),_vm._v(" Yes\n                                "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_same_address),expression:"patient.s_m_same_address"}],attrs:{"type":"radio","name":"s_m_same_address","value":"2"},domProps:{"checked":_vm._q(_vm.patient.s_m_same_address,"2")},on:{"__c":function($event){_vm.patient.s_m_same_address="2"}}}),_vm._v(" No\n                            ")],2),_vm._v(" "),_c('div',{staticClass:"s_m_ins_div"},[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_relation),expression:"patient.s_m_relation"}],ref:"s_m_relation",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"s_m_relation","name":"s_m_relation"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.s_m_relation=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},function($event){_vm.onChangeRelations('secondary_insurance')}]}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("None")]),_vm._v(" "),_c('option',{attrs:{"value":"Self"}},[_vm._v("Self")]),_vm._v(" "),_c('option',{attrs:{"value":"Spouse"}},[_vm._v("Spouse")]),_vm._v(" "),_c('option',{attrs:{"value":"Child"}},[_vm._v("Child")]),_vm._v(" "),_c('option',{attrs:{"value":"Other"}},[_vm._v("Other")])]),_vm._v(" "),_c('label',{attrs:{"for":"s_m_relation"}},[_vm._v("Relationship to insured party")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_partyfname),expression:"patient.s_m_partyfname"}],ref:"s_m_partyfname",staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"s_m_partyfname","name":"s_m_partyfname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_partyfname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_partyfname=$event.target.value}}}),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_partymname),expression:"patient.s_m_partymname"}],staticClass:"field text addr tbox",staticStyle:{"width":"50px"},attrs:{"id":"s_m_partymname","name":"s_m_partymname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_partymname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_partymname=$event.target.value}}}),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_partylname),expression:"patient.s_m_partylname"}],ref:"s_m_partylname",staticClass:"field text addr tbox",staticStyle:{"width":"150px"},attrs:{"id":"s_m_partylname","name":"s_m_partylname","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_partylname)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_partylname=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_partyfname"}},[_vm._v("Insured party First              Middle    Last")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.ins2_dob),expression:"patient.ins2_dob"}],ref:"ins2_dob",staticClass:"field text addr tbox calendar",staticStyle:{"width":"150px"},attrs:{"id":"ins2_dob","name":"ins2_dob","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.ins2_dob)},on:{"change":function($event){_vm.validateDate(_vm.patient.ins2_dob)},"input":function($event){if($event.target.composing){ return; }_vm.patient.ins2_dob=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"ins2_dob"}},[_vm._v("Insured Date of Birth")])]),_vm._v(" "),_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_gender),expression:"patient.s_m_gender"}],ref:"s_m_gender",staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"name":"s_m_gender","id":"s_m_gender"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.s_m_gender=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select")]),_vm._v(" "),_c('option',{attrs:{"value":"Male"}},[_vm._v("Male")]),_vm._v(" "),_c('option',{attrs:{"value":"Female"}},[_vm._v("Female")])]),_vm._v(" "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")]),_vm._v(" "),_c('label',{attrs:{"for":"s_m_gender"}},[_vm._v("Insured Gender")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.s_m_same_address == 2),expression:"patient.s_m_same_address == 2"}],attrs:{"id":"s_m_address_fields"}},[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',[_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_address),expression:"patient.s_m_address"}],staticClass:"field text addr tbox",staticStyle:{"width":"225px"},attrs:{"id":"s_m_address","name":"s_m_address","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_address)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_address=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_address"}},[_vm._v("Insured Address")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_city),expression:"patient.s_m_city"}],staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"s_m_city","name":"s_m_city","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_city)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_city=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_city"}},[_vm._v("Insured City")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_state),expression:"patient.s_m_state"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"s_m_state","name":"s_m_state","type":"text","maxlength":"2"},domProps:{"value":(_vm.patient.s_m_state)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_state=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_state"}},[_vm._v("Insured State")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_zip),expression:"patient.s_m_zip"}],staticClass:"field text addr tbox",staticStyle:{"width":"80px"},attrs:{"id":"s_m_zip","name":"s_m_zip","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_zip)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_zip=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_zip"}},[_vm._v("Insured Zip Code ")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',{staticClass:"s_m_ins_div"},[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_type),expression:"patient.s_m_ins_type"}],ref:"s_m_ins_type",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"s_m_ins_type","name":"s_m_ins_type"},on:{"change":[function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.s_m_ins_type=$event.target.multiple ? $$selectedVal : $$selectedVal[0]},_vm.checkMedicare]}},[_c('option',{attrs:{"value":"default","disabled":""}}),_vm._v(" "),_c('option',{attrs:{"value":"1"}},[_vm._v("Medicare")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("Medicaid")]),_vm._v(" "),_c('option',{attrs:{"value":"3"}},[_vm._v("Tricare Champus")]),_vm._v(" "),_c('option',{attrs:{"value":"4"}},[_vm._v("Champ VA")]),_vm._v(" "),_c('option',{attrs:{"value":"5"}},[_vm._v("Group Health Plan")]),_vm._v(" "),_c('option',{attrs:{"value":"6"}},[_vm._v("FECA BLKLUNG")]),_vm._v(" "),_c('option',{attrs:{"value":"7"}},[_vm._v("Other")])]),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_type"}},[_vm._v("Insurance Type")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_ass),expression:"patient.s_m_ins_ass"}],ref:"s_m_ins_ass",attrs:{"id":"s_m_ins_ass_yes","type":"radio","name":"s_m_ins_ass","value":"Yes"},domProps:{"checked":_vm._q(_vm.patient.s_m_ins_ass,"Yes")},on:{"__c":function($event){_vm.patient.s_m_ins_ass="Yes"}}}),_vm._v("Accept Assignment of Benefits     \n                                    "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_ass),expression:"patient.s_m_ins_ass"}],attrs:{"id":"s_m_ins_ass_no pay_to_patient_radio","type":"radio","name":"s_m_ins_ass","value":"No"},domProps:{"checked":_vm._q(_vm.patient.s_m_ins_ass,"No")},on:{"__c":function($event){_vm.patient.s_m_ins_ass="No"}}}),_vm._v("Payment to Patient\n                                ")]),_vm._v(" "),_c('span',{staticStyle:{"float":"right"}},[(!_vm.insuranceCardImage)?_c('button',{staticClass:"addButton",attrs:{"id":"s_m_ins_card"},on:{"click":function($event){_vm.onClickAddImage('secondary-insurance-card-image')}}},[_vm._v("\n                                        + Add Insurance Card Image\n                                    ")]):_c('button',{staticClass:"addButton",attrs:{"id":"s_m_ins_card"},on:{"click":_vm.onClickDisplayFile}},[_vm._v("\n                                        View Insurance Card Image\n                                    ")])])]),_vm._v(" "),_c('div')])]),_vm._v(" "),_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('div',{staticClass:"s_m_ins_div"},[_c('span',[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_co),expression:"patient.s_m_ins_co"}],ref:"s_m_ins_co",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"s_m_ins_co","name":"s_m_ins_co"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.s_m_ins_co=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"default","disabled":""}},[_vm._v("Select Insurance Company")]),_vm._v(" "),_vm._l((_vm.insuranceContacts),function(contact){return _c('option',{domProps:{"value":contact.contactid}},[_vm._v(_vm._s(contact.company))])})],2),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_co"}},[_vm._v("Insurance Co.")]),_c('br'),_vm._v(" "),_c('input',{staticClass:"button",staticStyle:{"width":"215px"},attrs:{"type":"button","value":"+ Create New Insurance Company"},on:{"click":function($event){_vm.onClickCreatingNewInsuranceCompany('s_m_ins_co')}}})]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_id),expression:"patient.s_m_ins_id"}],staticClass:"field text addr tbox",staticStyle:{"width":"190px"},attrs:{"id":"s_m_party","name":"s_m_ins_id","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_ins_id)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_ins_id=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_id"}},[_vm._v("Insurance ID.")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_grp),expression:"patient.s_m_ins_grp"}],ref:"s_m_ins_grp",staticClass:"field text addr tbox",staticStyle:{"width":"100px"},attrs:{"id":"s_m_ins_grp","name":"s_m_ins_grp","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_ins_grp)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_ins_grp=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_grp"}},[_vm._v("Group #")])]),_vm._v(" "),_c('span',[_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.s_m_ins_plan),expression:"patient.s_m_ins_plan"}],ref:"s_m_ins_plan",staticClass:"field text addr tbox",staticStyle:{"width":"200px"},attrs:{"id":"s_m_ins_plan","name":"s_m_ins_plan","type":"text","maxlength":"255"},domProps:{"value":(_vm.patient.s_m_ins_plan)},on:{"input":function($event){if($event.target.composing){ return; }_vm.patient.s_m_ins_plan=$event.target.value}}}),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_plan"}},[_vm._v("Plan Name")])]),_vm._v(" "),_c('span',[_c('textarea',{staticClass:"field text addr tbox",staticStyle:{"width":"190px","height":"60px","background":"#ccc"},attrs:{"id":"s_m_ins_phone","name":"s_m_ins_phone","disabled":"disabled"}},[_vm._v(_vm._s(_vm.secondaryInsCompanyContactInfo))]),_vm._v(" "),_c('label',{attrs:{"for":"s_m_ins_phone"}},[_vm._v("Address")])])]),_vm._v(" "),_c('div')])])])]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2"}},[_c('font',{staticStyle:{"color":"#0a5da0","font-weight":"bold","font-size":"16px"}},[_vm._v("CONTACT SECTION")])],1)]),_vm._v(" "),_c('tr',[_c('td',{staticClass:"frmhead",attrs:{"colspan":"2"}},[_c('table',{staticStyle:{"float":"left"},attrs:{"id":"contactmds"}},[_c('tr',{attrs:{"height":"35"}},[_c('td',[_c('span',{staticStyle:{"padding-left":"10px","float":"left"}},[_vm._v("Add medical contacts so they can receive correspondence about this patient.")]),_vm._v(" "),_c('span',{staticStyle:{"float":"left","margin-left":"20px"}},[_c('input',{staticClass:"button",staticStyle:{"float":"left","width":"150px"},attrs:{"type":"button","value":"+ Create New Contact"},on:{"click":_vm.onClickCreateNewContact}})]),_vm._v(" "),_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Primary Care MD")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docpcp != ''),expression:"patient.docpcp != ''"}],attrs:{"id":"docpcp_static_info"}},[(_vm.patient.docpcp != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docpcp_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docpcp_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docpcp)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docpcp = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docpcp == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docpcp_name),expression:"formedFullNames.docpcp_name"}],ref:"docpcp_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docpcp_name","autocomplete":"off","name":"docpcp_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docpcp_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docpcp')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docpcp_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundPrimaryCareMdByName.length > 0),expression:"foundPrimaryCareMdByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docpcp_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docpcp_list"}},_vm._l((_vm.foundPrimaryCareMdByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docpcp', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{attrs:{"height":"35"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("ENT")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docent != ''),expression:"patient.docent != ''"}],attrs:{"id":"docent_static_info"}},[(_vm.patient.docent != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docent_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docent_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docent)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docent = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docent == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docent_name),expression:"formedFullNames.docent_name"}],ref:"docent_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docent_name","autocomplete":"off","name":"docent_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docent_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docent')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docent_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundEntByName.length > 0),expression:"foundEntByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docent_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docent_list"}},_vm._l((_vm.foundEntByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docent', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{attrs:{"height":"35"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Sleep MD")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docsleep != ''),expression:"patient.docsleep != ''"}],attrs:{"id":"docsleep_static_info"}},[(_vm.patient.docsleep != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docsleep_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docsleep_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docsleep)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docsleep = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docsleep == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docsleep_name),expression:"formedFullNames.docsleep_name"}],ref:"docsleep_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docsleep_name","autocomplete":"off","name":"docsleep_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docsleep_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docsleep')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docsleep_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundSleepMdByName.length > 0),expression:"foundSleepMdByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docsleep_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docsleep_list"}},_vm._l((_vm.foundSleepMdByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docsleep', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{attrs:{"height":"35"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Dentist")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docdentist != ''),expression:"patient.docdentist != ''"}],attrs:{"id":"docdentist_static_info"}},[(_vm.patient.docdentist != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docdentist_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docdentist_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docdentist)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docdentist = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docdentist == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docdentist_name),expression:"formedFullNames.docdentist_name"}],ref:"docdentist_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docdentist_name","autocomplete":"off","name":"docdentist_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docdentist_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docdentist')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docdentist_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundDentistContactsByName.length > 0),expression:"foundDentistContactsByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docdentist_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docdentist_list"}},_vm._l((_vm.foundDentistContactsByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docdentist', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{attrs:{"height":"35"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Other MD")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docmdother != ''),expression:"patient.docmdother != ''"}],staticStyle:{"height":"25px"},attrs:{"id":"docmdother_static_info"}},[(_vm.patient.docmdother != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docmdother_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docmdother_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docmdother)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docmdother = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docmdother == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docmdother_name),expression:"formedFullNames.docmdother_name"}],ref:"docmdother_name",staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docmdother_name","autocomplete":"off","name":"docmdother_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docmdother_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docmdother')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docmdother_name=$event.target.value}}}):_vm._e(),_vm._v(" "),(_vm.patient.docmdother2 == '' || _vm.patient.docmdother3 == '')?_c('a',{staticClass:"addButton",staticStyle:{"clear":"both"},attrs:{"href":"#","id":"add_new_md"}},[_vm._v("+ Add Additional MD")]):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundOtherMdByName.length > 0),expression:"foundOtherMdByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docmdother_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docmdother_list"}},_vm._l((_vm.foundOtherMdByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docmdother', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docmdother2 != ''),expression:"patient.docmdother2 != ''"}],attrs:{"height":"35","id":"docmdother2_tr"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Other MD 2")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docmdother2 != ''),expression:"patient.docmdother2 != ''"}],attrs:{"id":"docmdother2_static_info"}},[(_vm.patient.docmdother2 != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docmdother2_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docmdother2_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docmdother2)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docmdother2 = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docmdother2 == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docmdother2_name),expression:"formedFullNames.docmdother2_name"}],staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docmdother2_name","autocomplete":"off","name":"docmdother2_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docmdother2_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docmdother2')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docmdother2_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundOtherMd2ByName.length > 0),expression:"foundOtherMd2ByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docmdother2_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docmdother2_list"}},_vm._l((_vm.foundOtherMd2ByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docmdother2', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])]),_vm._v(" "),_c('tr',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docmdother3 != ''),expression:"patient.docmdother3 != ''"}],attrs:{"height":"35","id":"docmdother3_tr"}},[_c('td',[_c('ul',[_c('li',{staticClass:"complex",attrs:{"id":"foli8"}},[_c('label',{staticStyle:{"display":"block","float":"left","width":"110px"}},[_vm._v("Other MD 3")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.docmdother3 != ''),expression:"patient.docmdother3 != ''"}],attrs:{"id":"docmdother3_static_info"}},[(_vm.patient.docmdother3 != '')?_c('span',{staticStyle:{"width":"300px"},attrs:{"id":"docmdother3_name_static"}},[_vm._v(_vm._s(_vm.formedFullNames.docmdother3_name))]):_vm._e(),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickViewContact(_vm.patient.docmdother3)}}},[_vm._v("Quick View")]),_vm._v(" "),_c('a',{staticClass:"addButton",attrs:{"s":"","href":"#"},on:{"click":function($event){$event.preventDefault();_vm.patient.docmdother3 = ''}}},[_vm._v("Change Contact")])]),_vm._v(" "),(_vm.patient.docmdother3 == '')?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.formedFullNames.docmdother3_name),expression:"formedFullNames.docmdother3_name"}],staticStyle:{"width":"300px"},attrs:{"type":"text","id":"docmdother3_name","autocomplete":"off","name":"docmdother3_name","placeholder":"Type contact name"},domProps:{"value":(_vm.formedFullNames.docmdother3_name)},on:{"keyup":function($event){_vm.onKeyUpSearchContacts('docmdother3')},"input":function($event){if($event.target.composing){ return; }_vm.formedFullNames.docmdother3_name=$event.target.value}}}):_vm._e(),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.foundOtherMd3ByName.length > 0),expression:"foundOtherMd3ByName.length > 0"}],staticClass:"search_hints",attrs:{"id":"docmdother3_hints"}},[_c('ul',{staticClass:"search_list",attrs:{"id":"docmdother3_list"}},_vm._l((_vm.foundOtherMd3ByName),function(contact){return _c('li',{staticClass:"json_patient",on:{"click":function($event){_vm.setContact('docmdother3', contact.id)}}},[_vm._v(_vm._s(contact.name))])}))])])])])])])])]),_vm._v(" "),_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("\n                    Patient Status\n                ")]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.status),expression:"patient.status"}],staticClass:"tbox",attrs:{"name":"status","id":"status"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.status=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"1"}},[_vm._v("Active")]),_vm._v(" "),_c('option',{attrs:{"value":"2"}},[_vm._v("In-Active")])]),_vm._v(" "),_c('br'),_vm._v(" \n                ")])]),_vm._v(" "),(_vm.docInfo.use_patient_portal)?[_c('tr',{attrs:{"bgcolor":"#FFFFFF"}},[_c('td',{staticClass:"frmhead",attrs:{"valign":"top"}},[_vm._v("\n                        Portal Status\n                        "),_c('br'),_vm._v(" "),_c('span',{directives:[{name:"show",rawName:"v-show",value:(_vm.patient.status == 2),expression:"patient.status == 2"}],staticStyle:{"font-weight":"normal","font-size":"12px"},attrs:{"id":"ppAlert"}},[_vm._v("Patient is in-active and will not be able to access"),_c('br'),_vm._v("Patient Portal regardless of the setting of this field.\n                        ")])]),_vm._v(" "),_c('td',{staticClass:"frmdata",attrs:{"valign":"top"}},[_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.patient.use_patient_portal),expression:"patient.use_patient_portal"}],staticClass:"tbox",attrs:{"name":"use_patient_portal"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.patient.use_patient_portal=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{attrs:{"value":"1"}},[_vm._v("Active")]),_vm._v(" "),_c('option',{attrs:{"value":"0"}},[_vm._v("In-Active")])]),_vm._v(" "),_c('br'),_vm._v(" \n                    ")])])]:_vm._e(),_vm._v(" "),_c('tr',[_c('td',{attrs:{"valign":"top"}},[(!_vm.introLetter)?[_c('input',{attrs:{"id":"introletter","name":"introletter","type":"checkbox","value":"1"}}),_vm._v(" Send Intro Letter to DSS patient\n                    ")]:[_vm._v("\n                        DSS Intro Letter Sent to Patient "+_vm._s(_vm.introLetter.generated_date)+"\n                    ")]],2)]),_vm._v(" "),_c('tr',[_c('td',{attrs:{"colspan":"2","align":"right"}},[_c('span',{staticClass:"red"},[_vm._v("* Required Fields")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('input',{staticClass:"button",attrs:{"type":"submit"},domProps:{"value":_vm.buttonText + 'Patient'},on:{"click":function($event){$event.preventDefault();_vm.submitAddingOrEditingPatient($event)}}})])])],2)])],2)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",staticStyle:{"float":"left"},attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Name\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{attrs:{"for":"home_phone"}},[_vm._v("\n                                        Home Phone\n                                        "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('label',{staticClass:"desc",attrs:{"id":"title0","for":"Field0"}},[_vm._v("\n                                Address\n                                "),_c('span',{staticClass:"req",attrs:{"id":"req_0"}},[_vm._v("*")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('span',[_c('label',{attrs:{"for":"bmi"}},[_vm._v("\n                                        < 18.5 is Underweight\n                                        "),_c('br'),_vm._v("\n                                           \n                                        18.5 - 24.9 is Normal\n                                        "),_c('br'),_vm._v("\n                                           \n                                        25 - 29.9 is Overweight\n                                        "),_c('br'),_vm._v("\n                                        > 30 is Obese\n                                    ")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('td',{attrs:{"colspan":"2"}})])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 503 */
/***/ (function(module, exports) {

module.exports = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAYAAAA8AXHiAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAACd9JREFUeNrsnT902kgex7+rDeHEHy2xvOb23dKa0lBabVyG1jWVi7RUKVylcOX3Unnfo3JrWlzarVKaVm61tzlsi7AyoOO4JVdcpAe2ARkLkIbvp7MZMaOZz8z8RhKaH759+/YNhASMxCogFItQLEKxCKFYhGIRikUIxSIUi1AsQigWoViEYhFCsQjFIhSLkEB4xSqYjuM4cHo9OI6Dfr+P4XDofRaLxfA6Hocsy5BlGfF4nBX2nR/4BOnTMt3bNjqdzphIs4jFYkin00grCmKxGMWiSv+n2+mg1Wqh3++/+LsURcGbjY21FYxiAej3+7i7vYXjOIF/dyaTwYaqQpIkirVOtNtt3N3eLjSPWCyGrWwWsixTLNEZDodoNpvodjpLy3Mrm4WiKBRLZKn++fvvgcRS88ReW9ms8HUsUarlYts2bppNiiUaX/74Y2VSjcpl2zbFEoVFrfzm4abZDE1ZKNYLcBwH7XY7VGW6aTafdQGWYoUwrgpjXDMYDBZ+qYNiLZD2168YDAahLJtt20JOicKLNRgM0Gq1Ql3GlmVRrKjxNeRSufGfaKOW0GINh8PILOtFG7WEFitK14ocxwltHEixHvBnyC4viFbetRSr3+9HbgTodrsUK/SNtMSnFoJcwa76dhPFErT3i7I6FHoqpFgUi43jlr3Xo1gcrYJnOBwKcWNaSLH+G/HrQSIE8ByxWH6K9ZzpJNLl/+svisUeT9ZGLK5qKRbhiEUIxSIUi1AsshREePWRxIYJH69evaJYbBiyNmJJP/4Y6fKL8C5TIcWKv34d7RGXMRZ7PMu/RmK9jnDDiPJKb2FXhVF9mawo7ykV9jqWnEhwtKVYwZNMJiNZ7lQqRbE4pQQfX4nyPnhhxYrFYpGTKy3Qq7qFvlcYtYZSKFZ04pWoTC2Kogi1LYrQYkmShEwmw9GVYq1ng7n7HVKsiAXxGxsboS7jhqqKN1tgDci8eRPa+EVRFCF3BVsLsSRJQjaEGyNJkoTNn38Ws86xJiRTKSRDdlU7m80Ku0HmWj3zns1mQ/PYsqIooROdYr1g6vn7L7+sfJSIx+PC71m4dr/Sicfj+Mevv65MLjd/4Tsx1pBVybVqqZfJWm82PhgM8K8vX5bydpp12bKXYn1nGVv5rptUazsVPgzoF/1Q4JuQX/mnWBFFhJ/MUyxCsQjFEj6AXyQi71bPVeED+v0+HMdBt9NZeMNLkoRUKoW/yXKknmqlWD5HpU6ng39/3yZ3lVvOxeNxyLKMZCol5CMzwovV7/fR7XTQ7XZD+4puSZIgJxJIJpOQZVmYFaRwYrkiRXUr3Hg8jmQyiWQqFen3OERerNEprtPpCLHBkUssFkMymURaUSInWWTFsm0b3W43kjuproNkkRLLcRzc27ZwI9M8kqXTaaQVJbQxWejFGgwGuLdt3N/fRzJmWjSyLCOtKKH7FXVoxXIcB+12e22muiBWl4qi4KdMJhSjWOjEsm0bX1stjk4vQFEUpFf8s7JQiDUcDmHbNv5stylUwNPkhqquRLCVi2XbNu5ub9c6GBdRsJWJ1e10cHd3xxFqyYJtLekncEsXazAY4KbZXMs7/mEhk8lgQ1UXejN8qWK1LAutVostGwJisRi2stmFTY9LEavf7+Om2eRezWs0ei1cLAbn4cf9ZXaQt4oWKtZNswnbttlyEcB9I09Q75NYmFiUKppsZbOB3B6SKBVZRNsFLlbLsiiVAHK9dKEVqFjD4RDtdpstIwB3t7fhEcu2ba7+BOGlj3YHKhYfcRGLbrcbDrF4m0Ys/vOCOIu/hCYTCc1USAjFIhSLUCxCKBahWIRiEUKxCMUiFItQLFYBoVgkMgT6zDufbhBs1JGkuX+5s/abNBFOhYRiEYpFCMUiFItQLEIoFokErxb55bqu4/T0FABwdHQEVVWnpq/X66jX6yiVSiiVSnOnOTg4ePQ/VVWhadrEYx5iWRbOzs7w/v37R99brVYDq6On8pnnfIIqm5/yBC6WYRhIJBLI5XK+0n/+/HlMMr+NGhT5fB4A0Ov1YJom6vW61yCz+PjxI3q93pPfFyRP5bOI81lEeQIT6/j4GPl8HpVKxZf5hmFAVVVYljVRLF3XYVkWtre3p458s9I8xWg5Ly4uUKvV8PnzZ68hGo0GTNMEABQKBa/DGIbhVa5hGNjc3ISqqnj37t2jPEzTRKPRgCzLKBaLY6OyYRieEO45aJrmpZmUz7zn40qn6zocxxnLa7Rdrq6u4DgOcrkcCoXCWHknlWfacUudCnVdBwBomobr62sYhgHDMMZ6/enpqZfOHd4f4ieNHzY3N6d+b71eR7lchqZpOD4+HutM7rTr/t+dbtxp2eX8/BzlctmrdDd9Pp/3JKvX615YMCmfec5n9HvcznJ5eYnDw0OvzkZDE5dcLodKpYJEIjGxPLOOmyt413Udx8fHXqamaXp/uycwS6zd3d1HU6NpmtB1HYlEAkdHRzg6Onp0E9tPGj8xW61W8ypmZ2fHG03z+Tyq1Sr29/fHyjc6MlQqlSenGsuyvKno06dPODw8RK/Xw9nZ2aO0Ozs7qFarXqdy68ZPPn7OZ5Td3V1Uq1UUCgVv9HLLe3p6ikQigUqlgmq1Ck3TYJomarXaxPL4OW6uEctthNGh1v170lzcaDRgWRZyuRxUVfV6sK7r2N/fRyKRQKPR8MRze5Smabi4uBj7nllpZjXEKJqmYW9vz1tMuFP09fX1xFhqUlx1dXXlfe52sFwuB9M0YZrmWBzq5rm9vT1Wl37y8Xs+D/PK5XJe/Y2WV9M0L6/9/X3ouu6le6o8bl1PO24usUaH54ODA18xlpuhaZqPVjSNRmOsZ46+DnrSq6H9pJkVk+RyOW/Y7vV6+O2337xGnmd6dUdOXdfHptRpHe6lTDqf55R3tP5G6yPo4wKPsUaH39Ee4K5kLi8voWmaV1DLssZGx6eEmpbGzyrqqWnaMAwUCgWUy2Vven8Obtn29va8qfRhDLmoVe48jAbhD+tyWsea97hniVUqlWb2bleqQqHw6FrIhw8fvKmiWCyiVqtB13Vvtfew5/tJ89JrNqZp4vz8fOroK8vyo0YtFos4Pz/3yuYu//2umv3mExSFQgGJRAK6rkNVVWxvb3sx0tu3byeW57nHzXXlvVQqzQww3QD4qXTFYtFLo6oqyuWyt0Kr1+uPjvGTZh7cmM0dqVRVhaqqY8ttN1Y5OTl5UjxVVb2R6uTkxAvk3f/5ZVY+QeEG36qqol6ve4uvUqk0Fqc9LI/f4x6y8idILcvC3d3d1J7qJ808zLrga5omer3e1HjGneJfMlX5ySdIZuU36fPnlJOPJpOFwJvQhGIRikUoFiEUi1AsQrEIoViEYhGKRUiQ/G8AiMK8uZvAKWoAAAAASUVORK5CYII="

/***/ }),
/* 504 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_vobs_js__ = __webpack_require__(507);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_vobs_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_vobs_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_506f7ac2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_vobs_vue__ = __webpack_require__(511);
function injectStyle (ssrContext) {
  __webpack_require__(505)
  __webpack_require__(506)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-506f7ac2"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_vobs_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_506f7ac2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_vobs_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 505 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 506 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 507 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _SingleVob = __webpack_require__(508);

var _SingleVob2 = _interopRequireDefault(_SingleVob);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      routeParameters: {
        patientId: null,
        currentPageNumber: 0,
        sortDirection: 'desc',
        sortColumn: 'status',
        viewed: null
      },
      totalVobs: 0,
      vobsPerPage: 20,
      vobs: [],
      message: '',
      tableHeaders: {
        'request_date': 'Requested',
        'patient_name': 'Patient Name',
        'status': 'Status',
        'comments': 'Comments',
        'action': 'Action'
      }
    };
  },

  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.totalVobs / this.vobsPerPage);
    }
  },
  components: {
    singleVob: _SingleVob2.default
  },
  watch: {
    '$route.query.page': function $routeQueryPage() {
      if (this.$route.query.page) {
        if (this.$route.query.page <= this.totalPages) {
          this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page);
        }
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort);
        } else {
          this.$set(this.routeParameters, 'sortColumn', null);
        }
      }
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase());
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc');
        }
      }
    },
    '$route.query.pid': function $routeQueryPid() {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid);
      } else {
        this.$set(this.routeParameters, 'patientId', null);
      }
    },
    '$route.query.viewed': function $routeQueryViewed() {
      this.$set(this.routeParameters, 'viewed', this.$route.query.viewed);
    },
    'routeParameters': {
      handler: function handler() {
        this.getVobs();
      },
      deep: true
    }
  },
  created: function created() {
    this.getVobs();
  },

  methods: {
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      } else {
        return 'asc';
      }
    },
    getVobs: function getVobs() {
      var _this = this;

      this.findVobs(this.vobsPerPage, this.routeParameters.currentPageNumber, this.routeParameters.sortColumn, this.routeParameters.sortDirection, this.routeParameters.viewed).then(function (response) {
        var data = response.data.data;

        if (data.result.length) {
          _this.vobs = data.result;
          _this.totalVobs = data.total;
        }
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'findVobs', response: response });
      });
    },
    findVobs: function findVobs(vobsPerPage, pageNumber, sortColumn, sortDir, viewed) {
      var data = {
        page: pageNumber || 0,
        vobsPerPage: vobsPerPage,
        sortColumn: sortColumn || 'status',
        sortDir: sortDir || 'desc',
        viewed: viewed
      };

      return _http2.default.post(_endpoints2.default.insurancePreauth.findVobs, data);
    }
  }
};

/***/ }),
/* 508 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_SingleVob_js__ = __webpack_require__(509);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_SingleVob_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_SingleVob_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3a3e8988_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_SingleVob_vue__ = __webpack_require__(510);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_SingleVob_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_3a3e8988_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_SingleVob_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 509 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    vob: {
      type: Object,
      required: true
    }
  },
  data: function data() {
    return {
      statusLabel: _main.PREAUTH_STATUS_LABELS[this.vob.status]
    };
  },

  computed: {
    unviewedClass: function unviewedClass() {
      return !(this.vob.viewed === 1 || this.vob.status === _main.DSS_CONSTANTS.DSS_PREAUTH_PENDING);
    },
    rejectReason: function rejectReason() {
      return this.vob.status === _main.DSS_CONSTANTS.DSS_PREAUTH_REJECTED ? this.vob.reject_reason : '';
    }
  },
  methods: {
    setViewStatus: function setViewStatus() {
      var _this = this;

      var data = {
        viewed: this.vob.viewed === 0 ? 1 : 0
      };

      this.updateVob(this.vob.id, data).then(function () {
        _this.$router.push({
          name: _this.$route.name,
          query: {
            pid: _this.vob.patient_id || 0
          }
        });

        var foundVob = _this.vobs.find(function (el) {
          return el.id === _this.vob.id;
        });
        foundVob.viewed = data.viewed;
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'updateVob', response: response });
      });
    },
    updateVob: function updateVob(id, data) {
      id = id || 0;

      return _http2.default.put(_endpoints2.default.insurancePreauth.update + '/' + id, data);
    }
  }
};

/***/ }),
/* 510 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',{class:{ unviewed: _vm.unviewedClass }},[_c('td',{attrs:{"valign":"top"}},[_vm._v("\n        "+_vm._s(_vm.vob.front_office_request_date)+"\n    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n        "+_vm._s(_vm.vob.firstname)+" "+_vm._s(_vm.vob.lastname)+"\n    ")]),_vm._v(" "),_c('td',{class:'status_' + _vm.vob.status,attrs:{"valign":"top"}},[_vm._v("\n        "+_vm._s(_vm.statusLabel)+"\n    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n        "+_vm._s(_vm.rejectReason)+"\n    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('router-link',{staticClass:"editlink",attrs:{"to":{
              path: '/manage/insurance',
              query: {
                pid: _vm.routeParameters.patientId,
                vob_id: _vm.vob.id
              }
            },"title":"EDIT"}},[_vm._v("View")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"EDIT"},on:{"click":function($event){$event.preventDefault();_vm.setViewStatus()}}},[_vm._v(_vm._s(_vm.vob.viewed === 1 ? 'Mark Unread' : 'Mark Read'))])],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 511 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"id":"vobs"}},[_c('span',{staticClass:"admin_head"},[_vm._v("Manage Verification of Benefits")]),_vm._v(" "),_c('router-link',{staticClass:"addButton",staticStyle:{"float":"right","margin-right":"10px"},attrs:{"to":{
          name: _vm.$route.name,
          query: {
            pid: _vm.routeParameters.patientId,
            sort: _vm.routeParameters.sortColumn,
            sortdir: _vm.routeParameters.sortDirection,
            viewed: _vm.routeParameters.viewed === 0 ? null : 0
          }
        }}},[_vm._v("\n        "+_vm._s(_vm.routeParameters.viewed === 0 ? 'Show All' : 'Show Unread')+"\n    ")]),_vm._v(" "),_c('br'),_c('br'),_c('br'),_vm._v(" "),_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm","method":"post"}},[_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.totalVobs > _vm.vobsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber === (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                                name: _vm.$route.name,
                                query: {
                                    page    : index - 1,
                                    sort    : _vm.routeParameters.sortColumn,
                                    sortdir : _vm.routeParameters.sortDirection,
                                    viewed  : _vm.routeParameters.viewed
                                }
                            }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(label,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn === sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":sort == 'comments' ? '40%' : '15%'}},[(sort != 'comments' && sort != 'action')?_c('router-link',{attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                sort: sort,
                                sortdir: _vm.getCurrentDirection(sort)
                            }
                        }}},[_vm._v("\n                        "+_vm._s(label)+"\n                    ")]):[_vm._v(_vm._s(label))]],2)})),_vm._v(" "),(_vm.vobs.length)?_vm._l((_vm.vobs),function(vob){return _c('single-vob',{key:vob.id,attrs:{"vob":vob}})}):_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])])],2)])],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 512 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_referredby_js__ = __webpack_require__(515);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_referredby_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_referredby_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_f72c6fc2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_referredby_vue__ = __webpack_require__(516);
function injectStyle (ssrContext) {
  __webpack_require__(513)
  __webpack_require__(514)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-f72c6fc2"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_referredby_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_f72c6fc2_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_referredby_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 513 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 514 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 515 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'referredby',
  data: function data() {
    return {
      message: '',
      routeParameters: {
        currentPageNumber: 0,
        sortColumn: '',
        sortDirection: 'asc'
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 10,
      tableHeaders: {
        'name': {
          type: 'general',
          title: 'Name'
        },
        'contacttype': {
          type: 'general',
          title: 'Physician Type'
        },
        'total': {
          type: 'general',
          title: 'Total Referrals'
        },
        'thirty': '30 Days',
        'sixty': '60 Days',
        'ninty': '90 Days',
        'nintyplus': '90+ Days',
        'notes': 'Notes',
        'expand': 'Expand'
      },
      referredPhysician: _main.DSS_CONSTANTS.DSS_REFERRED_PHYSICIAN
    };
  },

  watch: {
    '$route.query.page': function $routeQueryPage() {
      if (this.$route.query.page <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page);
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort);
        } else {
          this.$set(this.routeParameters, 'sortColumn', null);
        }
      }
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase());
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc');
        }
      }
    },
    '$route.query.delid': function $routeQueryDelid() {
      if (this.$route.query.delid > 0) {
        this.removeContact(this.$route.query.delid);
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getContacts();
      },
      deep: true
    }
  },
  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage);
    }
  },
  created: function created() {
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal);
  },
  mounted: function mounted() {
    this.getContacts();
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal);
  },

  methods: {
    onSettingDataFromModal: function onSettingDataFromModal(data) {
      var _this = this;

      this.message = data.message;

      this.$nextTick(function () {
        setTimeout(function () {
          _this.message = '';
        }, 3000);
      });
    },
    onClickEditReferredByNotes: function onClickEditReferredByNotes(id) {
      this.$parent.$refs.modal.display('edit-referred-by-note');
      this.$parent.$refs.modal.setComponentParameters({ noteId: id });
    },
    onClickViewContact: function onClickViewContact(id) {
      this.$parent.$refs.modal.display('view-contact');
      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: id });
    },
    onClickAddNewReferredBy: function onClickAddNewReferredBy() {
      this.$parent.$refs.modal.display('edit-referred-by-contact');
    },
    removeContact: function removeContact(id) {
      var _this2 = this;

      this.deleteReferredByContact(id).then(function () {
        _this2.message = 'Deleted Successfully';
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'deleteReferredByContact', response: response });
      });
    },
    getContacts: function getContacts() {
      var _this3 = this;

      this.getReferredByContacts(this.routeParameters.sortColumn, this.routeParameters.currentPageNumber, this.routeParameters.sortDirection, this.contactsPerPage).then(function (response) {
        var data = response.data.data;

        if (data.total > 0) {
          _this3.contactsTotalNumber = data.total;
          _this3.contacts = data.contacts;
        }
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getReferredByContacts', response: response });
      });
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      }
      return 'asc';
    },
    getReferredByContacts: function getReferredByContacts(sort, pageNumber, sortDir, contactsPerPage) {
      var data = {
        sort: sort,
        page: pageNumber,
        sortdir: sortDir,
        contacts_per_page: contactsPerPage
      };

      return _http2.default.post(_endpoints2.default.contacts.referredBy, data);
    },
    deleteReferredByContact: function deleteReferredByContact(id) {
      return _http2.default.delete(_endpoints2.default.referredByContacts.destroy + '/' + id);
    }
  }
};

/***/ }),
/* 516 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v("Manage Referred By")]),_vm._v(" "),_c('br'),_c('br'),_vm._v(" \n\n    "),_c('div',{attrs:{"align":"right"}},[_c('button',{staticClass:"addButton",on:{"click":_vm.onClickAddNewReferredBy}},[_vm._v("\n            Add New Referred By\n        ")]),_vm._v("\n          \n        "),_c('router-link',{staticClass:"button",attrs:{"to":{ name: 'print-referred-by-contact' }}},[_vm._v("Print List")]),_vm._v("\n          \n    ")],1),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"id":"sort_table","width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.contactsTotalNumber > _vm.contactsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber == (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                                name: _vm.$route.name,
                                query: {
                                    page: index - 1,
                                    sort: _vm.routeParameters.sortColumn,
                                    sortdir: _vm.routeParameters.sortDirection
                                }
                            }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(label,sort){return _c('th',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":label.type == 'general' ? '20%' : ''}},[(sort != 'notes' && sort != 'expand')?_c('router-link',{attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                sort: sort,
                                sortdir: _vm.getCurrentDirection(sort)
                            }
                        }}},[_vm._v("\n                        "+_vm._s(label.title || label)+"\n                    ")]):[_vm._v(_vm._s(label))]],2)})),_vm._v(" "),(_vm.contacts.length == 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.contacts),function(contact){return _c('tr',{attrs:{"data-contact-id":contact.contactid,"data-contact-type":contact.referral_type}},[_c('td',{attrs:{"valign":"top","width":"20%"}},[(contact.referred_source == _vm.referredPhysician)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.onClickViewContact(contact.contactid)}}},[_vm._v(_vm._s(contact.name))]):[_vm._v(_vm._s(contact.name))]],2),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"30%"}},[_vm._v(_vm._s(contact.contacttype))]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type}},[_vm._v(_vm._s(contact.num_ref))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type}},[_c('span',{staticClass:"num_ref30"},[_vm._v(_vm._s(contact.num_ref30))])])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type}},[_c('span',{staticClass:"num_ref60"},[_vm._v(_vm._s(contact.num_ref60))])])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type}},[_c('span',{staticClass:"num_ref90"},[_vm._v(_vm._s(contact.num_ref90))])])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type}},[_c('span',{staticClass:"num_ref90plus"},[_vm._v(_vm._s(contact.num_ref90plus))])])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('a',{staticClass:"editlink",attrs:{"href":"#","title":contact.referredby_notes ? contact.referredby_notes : 'No Notes'},on:{"click":function($event){$event.preventDefault();_vm.onClickEditReferredByNotes(contact.contactid)}}},[_vm._v("\n                        View\n                    ")])]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('a',{staticClass:"editlink",attrs:{"href":_vm.legacyUrl + 'referredby_patient.php?rid=' + contact.contactid + '&rsource=' + contact.referral_type,"title":contact.patients_list}},[_vm._v("\n                        List\n                    ")])])])})],2)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 517 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_printReferredByContact_js__ = __webpack_require__(518);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_printReferredByContact_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_printReferredByContact_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_713d6ce4_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_printReferredByContact_vue__ = __webpack_require__(519);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_printReferredByContact_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_713d6ce4_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_printReferredByContact_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 518 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _MomentWrapper = __webpack_require__(64);

var _MomentWrapper2 = _interopRequireDefault(_MomentWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'print-referred-by-contact',
  data: function data() {
    return {
      title: 'Referral Source Printout - ' + _MomentWrapper2.default.create().format('MM/DD/YYYY'),
      contacts: [],
      routeParameters: {
        sortColumn: '',
        sortDirection: 'asc'
      },
      tableHeaders: {
        'name': {
          width: 15,
          title: 'Name'
        },
        'contacttype': {
          width: 15,
          title: 'Physician Type'
        },
        'total': {
          width: 10,
          title: 'Total Referrals'
        },
        'thirty': {
          width: 15,
          title: '30 Days'
        },
        'sixty': {
          width: 15,
          title: '60 Days'
        },
        'ninty': {
          width: 15,
          title: '90 Days'
        },
        'nintyplus': {
          width: 15,
          title: '90+ Days'
        }
      }
    };
  },

  watch: {
    '$route.query.sort': function $routeQuerySort() {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort);
        } else {
          this.$set(this.routeParameters, 'sortColumn', null);
        }
      }
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase());
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc');
        }
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getContacts();
      },
      deep: true
    }
  },
  created: function created() {
    window.$('body').removeClass('main-template');
  },
  mounted: function mounted() {
    this.getContacts();
  },
  beforeDestroy: function beforeDestroy() {
    window.$('body').addClass('main-template');
  },

  methods: {
    getContacts: function getContacts() {
      var _this = this;

      this.getReferredByContacts(this.routeParameters.sortColumn, this.routeParameters.sortDirection).then(function (response) {
        var data = response.data.data;

        if (data.total > 0) {
          _this.contacts = data.contacts;
        }
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getReferredByContacts', response: response });
      });
    },
    getReferredByContacts: function getReferredByContacts(sort, sortDir) {
      var data = {
        sort: sort,
        sortdir: sortDir,
        detailed: true
      };

      return _http2.default.post(_endpoints2.default.contacts.referredBy, data);
    }
  }
};

/***/ }),
/* 519 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v(_vm._s(_vm.title))]),_vm._v(" "),_c('br'),_c('br'),_c('br'),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"0","border":"1","bgcolor":"#FFFFFF","align":"center"}},[_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(meta,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":meta.width + '%'}},[_vm._v("\n                    "+_vm._s(meta.title)+"\n                ")])})),_vm._v(" "),(_vm.contacts.length == 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.contacts),function(contact){return _c('tr',{class:contact.status == 1 ? 'tr_active' : 'tr_inactive'},[_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.name)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.contacttype)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.num_ref)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._l((contact.num_ref30),function(contact30){return [_vm._v("\n                        "+_vm._s(contact30.firstname)+" "+_vm._s(contact30.lastname + (contact30.copyreqdate ? ' - ' : ''))+_vm._s(_vm._f("moment")(contact30.copyreqdate,"MM/DD/YYYY"))),_c('br')]})],2),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._l((contact.num_ref60),function(contact60){return [_vm._v("\n                        "+_vm._s(contact60.firstname)+" "+_vm._s(contact60.lastname + (contact60.copyreqdate ? ' - ' : ''))+_vm._s(_vm._f("moment")(contact60.copyreqdate,"MM/DD/YYYY"))),_c('br')]})],2),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._l((contact.num_ref90),function(contact90){return [_vm._v("\n                        "+_vm._s(contact90.firstname)+" "+_vm._s(contact90.lastname + (contact90.copyreqdate ? ' - ' : ''))+_vm._s(_vm._f("moment")(contact90.copyreqdate,"MM/DD/YYYY"))),_c('br')]})],2),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._l((contact.num_ref90plus),function(contact90plus){return [_vm._v("\n                        "+_vm._s(contact90plus.firstname)+" "+_vm._s(contact90plus.lastname + (contact90plus.copyreqdate ? ' - ' : ''))+_vm._s(_vm._f("moment")(contact90plus.copyreqdate,"MM/DD/YYYY"))),_c('br')]})],2)])})],2)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 520 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_sleeplabs_js__ = __webpack_require__(523);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_sleeplabs_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_sleeplabs_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1849184a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_sleeplabs_vue__ = __webpack_require__(524);
function injectStyle (ssrContext) {
  __webpack_require__(521)
  __webpack_require__(522)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1849184a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_sleeplabs_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1849184a_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_sleeplabs_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 521 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 522 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 523 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'sleeplabs',
  data: function data() {
    return {
      routeParameters: {
        currentPageNumber: 0,
        sortDirection: 'asc',
        sortColumn: 'lab',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      sleeplabsTotalNumber: 0,
      sleeplabsPerPage: 20,
      sleeplabs: [],
      tableHeaders: {
        'lab': {
          title: 'Lab Name',
          with_link: true,
          width: 30
        },
        'name': {
          title: 'Name',
          with_link: true,
          width: 40
        },
        'patients-number': {
          title: '# Patients',
          width: 10
        },
        'action': {
          title: 'Action',
          width: 20
        }
      }
    };
  },

  watch: {
    '$route.query.page': function $routeQueryPage() {
      var queryPage = this.$route.query.page;
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage);
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      var querySortColumn = this.$route.query.sort;
      var sortColumn = 'lab';
      if (querySortColumn in this.tableHeaders) {
        sortColumn = querySortColumn;
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn);
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      var querySortDir = this.$route.query.sortdir;
      var sortDir = 'asc';
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc';
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir);
    },
    '$route.query.letter': function $routeQueryLetter() {
      var queryLetter = this.$route.query.letter;
      var letter = null;
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter;
      }
      this.$set(this.routeParameters, 'currentLetter', letter);
    },
    '$route.query.delid': function $routeQueryDelid() {
      var queryDelId = this.$route.query.delid;
      if (queryDelId > 0) {
        this.removeSleeplab(queryDelId);
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getListOfSleeplabs();
      },
      deep: true
    }
  },
  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.sleeplabsTotalNumber / this.sleeplabsPerPage);
    }
  },
  created: function created() {
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal);
  },
  mounted: function mounted() {
    this.getListOfSleeplabs();
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal);
  },

  methods: {
    onSettingDataFromModal: function onSettingDataFromModal(data) {
      var _this = this;

      this.message = data.message;

      this.$nextTick(function () {
        setTimeout(function () {
          _this.message = '';
        }, 3000);
      });
    },
    onClickEdit: function onClickEdit(id) {
      this.$parent.$refs.modal.display('edit-sleeplab');
      this.$parent.$refs.modal.setComponentParameters({ sleeplabId: id });
    },
    onClickQuickView: function onClickQuickView(id) {
      this.$parent.$refs.modal.display('view-sleeplab');
      this.$parent.$refs.modal.setComponentParameters({ sleeplabId: id });
    },
    removeSleeplab: function removeSleeplab(id) {
      var _this2 = this;

      this.deleteSleeplab(id).then(function () {
        _this2.message = 'Deleted Successfully';

        _this2.$nextTick(function () {
          setTimeout(function () {
            _this2.message = '';
          }, 3000);
        });
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'deleteSleeplab', response: response });
      });
    },
    getListOfSleeplabs: function getListOfSleeplabs() {
      var _this3 = this;

      this.getSleeplabs(this.routeParameters.currentPageNumber, this.sleeplabsPerPage, this.routeParameters.sortColumn, this.routeParameters.sortDirection, this.routeParameters.currentLetter).then(function (response) {
        var data = response.data.data;

        data.result = data.result.map(function (value) {
          value['name'] = (value.salutation ? value.salutation + ' ' : '') + (value.firstname ? value.firstname + ' ' : '') + (value.middlename ? value.middlename + ' ' : '') + (value.lastname || '');

          value['show_patients'] = false;

          return value;
        });

        _this3.sleeplabs = data.result;
        _this3.sleeplabsTotalNumber = data.total;
      }).catch(function (response) {
        _this3.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getSleeplabs', response: response });
      });
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      }
      return 'asc';
    },
    getSleeplabs: function getSleeplabs(pageNumber, rowsPerPage, sort, sortDir, letter) {
      var data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir,
        letter: letter
      };

      return _http2.default.post(_endpoints2.default.sleeplabs.list, data);
    },
    deleteSleeplab: function deleteSleeplab(id) {
      id = id || 0;

      return _http2.default.delete(_endpoints2.default.sleeplabs.destroy + '/' + id);
    }
  }
};

/***/ }),
/* 524 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v("\n        Manage Sleep Lab\n    ")]),_vm._v(" "),_c('br'),_c('br'),_vm._v(" "),_c('div',{staticStyle:{"padding-right":"12px"},attrs:{"align":"right"}},[_c('button',{staticClass:"addButton",on:{"click":function($event){_vm.$parent.$refs.modal.display('edit-sleeplab')}}},[_vm._v("\n            Add New Sleep Lab\n        ")])]),_vm._v(" "),_c('div',{staticClass:"letter_select",staticStyle:{"padding-left":"12px"}},_vm._l((_vm.letters),function(letter){return _c('router-link',{key:letter.id,class:'letters ' + (letter == _vm.routeParameters.currentLetter ? 'selected_letter' : ''),attrs:{"to":{
                name: _vm.$route.name,
                query: {
                    letter: letter,
                    sort: _vm.routeParameters.sortColumn,
                    sortdir: _vm.routeParameters.sortDirection
                }
            }}},[_vm._v(_vm._s(letter))])})),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.sleeplabsTotalNumber > _vm.sleeplabsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber == (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                                name: _vm.$route.name,
                                query: {
                                    page    : index - 1,
                                    letter  : _vm.routeParameters.currentLetter || undefined,
                                    sort    : _vm.routeParameters.sortColumn,
                                    sortdir : _vm.routeParameters.sortDirection
                                }
                            }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(settings,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":settings.width + '%'}},[(settings.with_link)?_c('router-link',{attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                sort: sort,
                                sortdir: _vm.getCurrentDirection(sort)
                            }
                        }}},[_vm._v(_vm._s(settings.title))]):[_vm._v(_vm._s(settings.title))]],2)})),_vm._v(" "),(_vm.sleeplabs.length == 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.sleeplabs),function(sleeplab){return [_c('tr',{class:sleeplab.status == 1 ? 'tr_active' : 'tr_inactive'},[_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                        "+_vm._s(sleeplab.company)+"\n                    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                        "+_vm._s(sleeplab.name)+"\n                    ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[(sleeplab.patients.length > 0)?_c('a',{attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();sleeplab.show_patients ?
                                sleeplab.show_patients = false :
                                sleeplab.show_patients = true
                            }}},[_vm._v(_vm._s(sleeplab.patients.length))]):_c('span',[_vm._v(_vm._s(sleeplab.patients.length))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"EDIT"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickView(sleeplab.sleeplabid)}}},[_vm._v("Quick View")]),_vm._v("\n                        |\n                        "),_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"EDIT"},on:{"click":function($event){$event.preventDefault();_vm.onClickEdit(sleeplab.sleeplabid)}}},[_vm._v("Edit")])])]),_vm._v(" "),(sleeplab.patients.length > 0)?_c('tr',{directives:[{name:"show",rawName:"v-show",value:(sleeplab.show_patients),expression:"sleeplab.show_patients"}]},[_c('td',{attrs:{"colspan":"4"}},[_c('h3',[_vm._v("Patients")]),_vm._v(" "),_vm._l((sleeplab.patients),function(patient){return [_c('a',{attrs:{"href":_vm.legacyUrl + 'dss_summ.php?sect=sleep&pid=' + patient.patientid}},[_vm._v(_vm._s(patient.firstname)+" "+_vm._s(patient.lastname))]),_vm._v(" "),_c('br')]})],2)]):_vm._e()]})],2)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 525 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_corporateContacts_js__ = __webpack_require__(528);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_corporateContacts_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_corporateContacts_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d145084_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_corporateContacts_vue__ = __webpack_require__(529);
function injectStyle (ssrContext) {
  __webpack_require__(526)
  __webpack_require__(527)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6d145084"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_corporateContacts_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d145084_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_corporateContacts_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 526 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 527 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 528 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'corporate-contacts',
  data: function data() {
    return {
      message: '',
      routeParameters: {
        currentPageNumber: 0,
        sortDirection: 'asc',
        sortColumn: ''
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 10,
      tableHeaders: {
        'company': {
          title: 'Company',
          with_link: true,
          width: 30
        },
        'type': {
          title: 'Type',
          with_link: true,
          width: 20
        },
        'name': {
          title: 'Name',
          with_link: true,
          width: 30
        },
        'action': {
          title: 'Action',
          width: 20
        }
      }
    };
  },

  watch: {
    '$route.query.page': function $routeQueryPage() {
      var queryPage = this.$route.query.page;
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage);
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      var querySort = this.$route.query.sort;
      var sortColumn = '';
      if (querySort in this.tableHeaders) {
        sortColumn = querySort;
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn);
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      var querySortDir = this.$route.query.sortdir;
      var sortDir = 'asc';
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc';
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir);
    },
    '$route.query.delid': function $routeQueryDelid() {
      var queryDelId = this.$route.query.delid;
      if (queryDelId > 0) {
        this.removeContact(queryDelId);
      }
    },
    'routeParameters': {
      handler: function handler() {
        this.getListOfContacts();
      },
      deep: true
    }
  },
  computed: {
    totalPages: function totalPages() {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage);
    }
  },
  mounted: function mounted() {
    this.getListOfContacts();
  },

  methods: {
    onClickViewFull: function onClickViewFull(contactId) {
      this.$parent.$refs.modal.display('view-corporate-contact');

      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: contactId });
    },
    onClickQuickView: function onClickQuickView(contactId) {
      this.$parent.$refs.modal.display('view-contact');
      this.$store.dispatch(_symbols2.default.actions.setCurrentContact, { contactId: contactId });
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      } else {
        return 'asc';
      }
    },
    removeContact: function removeContact(id) {
      var _this = this;

      this.deleteContact(id).then(function () {
        _this.message = 'Deleted Successfully';

        _this.$nextTick(function () {
          setTimeout(function () {
            _this.message = '';
          }, 3000);
        });
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'deleteContact', response: response });
      });
    },
    getListOfContacts: function getListOfContacts() {
      var _this2 = this;

      this.getCorporateContacts(this.routeParameters.currentPageNumber, this.contactsPerPage, this.routeParameters.sortColumn, this.routeParameters.sortDirection).then(function (response) {
        var data = response.data.data;

        data.result = data.result.map(function (value) {
          value['name'] = (value.lastname ? value.lastname + (!value.middlename ? ', ' : ' ') : '') + (value.middlename ? value.middlename + ', ' : '') + (value.firstname || '');

          return value;
        });

        _this2.contacts = data.result;
        _this2.contactsTotalNumber = data.total;
      }).catch(function (response) {
        _this2.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getCorporateContacts', response: response });
      });
    },
    getCorporateContacts: function getCorporateContacts(pageNumber, rowsPerPage, sort, sortDir) {
      var data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir
      };

      return _http2.default.post(_endpoints2.default.contacts.corporate, data);
    },
    deleteContact: function deleteContact(id) {
      id = id || 0;

      return _http2.default.delete(_endpoints2.default.corporateContacts.destroy + '/' + id);
    }
  }
};

/***/ }),
/* 529 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v("\n        Manage Corporate Contacts\n    ")]),_vm._v(" "),_c('br'),_c('br'),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"sortfrm"}},[_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.contactsTotalNumber > _vm.contactsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                    Pages:\n                    "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber == (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                                name: _vm.$route.name,
                                query: {
                                    page    : index - 1,
                                    sort    : _vm.routeParameters.sortColumn || undefined,
                                    sortdir : _vm.routeParameters.sortDirection
                                }
                            }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(settings,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":settings.width + '%'}},[(settings.with_link)?_c('router-link',{attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                sort: sort,
                                sortdir: _vm.getCurrentDirection(sort)
                            }
                        }}},[_vm._v(_vm._s(settings.title))]):[_vm._v(_vm._s(settings.title))]],2)})),_vm._v(" "),(_vm.contacts.length == 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                    No Records\n                ")])]):_vm._l((_vm.contacts),function(contact){return _c('tr',{class:contact.status == 1 ? 'tr_active' : 'tr_inactive'},[_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.company)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.contacttype)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_vm._v("\n                    "+_vm._s(contact.name)+"\n                ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}},[_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"Edit"},on:{"click":function($event){$event.preventDefault();_vm.onClickQuickView(contact.contactid)}}},[_vm._v("Quick View")]),_vm._v(" |\n                    "),_c('a',{staticClass:"editlink",attrs:{"href":"#","title":"Edit"},on:{"click":function($event){$event.preventDefault();_vm.onClickViewFull(contact.contactid)}}},[_vm._v("View Full")])])])})],2)])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 530 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerReportFull_js__ = __webpack_require__(533);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerReportFull_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerReportFull_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_414a7ad0_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ledgerReportFull_vue__ = __webpack_require__(538);
function injectStyle (ssrContext) {
  __webpack_require__(531)
  __webpack_require__(532)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-414a7ad0"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerReportFull_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_414a7ad0_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ledgerReportFull_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 531 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 532 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 533 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _accounting = __webpack_require__(63);

var _accounting2 = _interopRequireDefault(_accounting);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _ledgerSummaryReportFull = __webpack_require__(534);

var _ledgerSummaryReportFull2 = _interopRequireDefault(_ledgerSummaryReportFull);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

var _ConstantTitleGetter = __webpack_require__(537);

var _ConstantTitleGetter2 = _interopRequireDefault(_ConstantTitleGetter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'ledger-report-full',
  data: function data() {
    return {
      patientId: 0,
      routeParameters: {
        currentPageNumber: 0,
        sortColumn: 'service_date',
        sortDirection: 'desc'
      },
      reportType: 'today',
      name: '',
      message: '',
      ledgerRowsTotalNumber: 0,
      ledgerRowsPerPage: 20,
      ledgerRows: [],
      totalCharges: 0,
      totalCredits: 0,
      totalAdjustments: 0,
      tableHeaders: {
        'service_date': {
          title: 'Svc Date',
          with_link: true,
          width: 10
        },
        'entry_date': {
          title: 'Entry Date',
          with_link: true,
          width: 10
        },
        'patient': {
          title: 'Patient',
          with_link: true,
          width: 10
        },
        'producer': {
          title: 'Producer',
          with_link: true,
          width: 10
        },
        'description': {
          title: 'Description',
          with_link: true,
          width: 30
        },
        'amount': {
          title: 'Charges',
          with_link: true,
          width: 10
        },
        'paid_amount': {
          title: 'Credits',
          with_link: true,
          width: 10
        },
        'adjustments': {
          title: 'Adjustments',
          width: 10
        },
        'status': {
          title: 'Ins',
          with_link: true,
          width: 5
        }
      }
    };
  },

  components: {
    'ledger-summary-report-full': _ledgerSummaryReportFull2.default
  },
  watch: {
    '$route.query.page': function $routeQueryPage() {
      var queryPage = this.$route.query.page;
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage);
      }
    },
    '$route.query.sort': function $routeQuerySort() {
      var querySort = this.$route.query.sort;
      var sortColumn = 'service_date';
      if (querySort in this.tableHeaders) {
        sortColumn = querySort;
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn);
    },
    '$route.query.sortdir': function $routeQuerySortdir() {
      var querySortDir = this.$route.query.sortdir;
      var sortDir = 'asc';
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'asc';
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir);
    },
    'routeParameters': {
      handler: function handler() {
        this.getLedgerData();
      },
      deep: true
    }
  },
  computed: {
    currentDate: function currentDate() {
      return new Date();
    },
    totalPageCharges: function totalPageCharges() {
      var total = this.ledgerRows.reduce(function (sum, currentRow) {
        return sum + (currentRow.ledger === 'ledger' && currentRow.amount > 0 ? +currentRow.amount : 0);
      }, 0);

      return total;
    },
    totalPageCredits: function totalPageCredits() {
      var total = this.ledgerRows.reduce(function (sum, currentRow) {
        var isNotLedgerPaidAndAdjustment = !(currentRow.ledger === 'ledger_paid' && currentRow.payer === _main.DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ);

        return sum + (isNotLedgerPaidAndAdjustment && currentRow.ledger !== 'claim' && currentRow.paid_amount > 0 ? +currentRow.paid_amount : 0);
      }, 0);

      return total;
    },
    totalPageAdjustments: function totalPageAdjustments() {
      var total = this.ledgerRows.reduce(function (sum, currentRow) {
        var isLedgerPaidAndAdjustment = currentRow.ledger === 'ledger_paid' && currentRow.payer === _main.DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ;

        return sum + (isLedgerPaidAndAdjustment && currentRow.paid_amount > 0 ? +currentRow.paid_amount : 0);
      }, 0);

      return total;
    },
    totalPages: function totalPages() {
      return Math.ceil(this.ledgerRowsTotalNumber / this.ledgerRowsPerPage);
    }
  },
  created: function created() {
    window.eventHub.$on('setting-totals-from-summary-block', this.onSetTotalsFromSummaryBlock);
  },
  mounted: function mounted() {
    this.getLedgerData();
  },
  beforeDestroy: function beforeDestroy() {
    window.eventHub.$off('setting-totals-from-summary-block', this.onSetTotalsFromSummaryBlock);
  },

  methods: {
    isCredit: function isCredit(row) {
      return !(row.ledger === 'ledger_paid' && row.payer === _main.DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ);
    },
    isAdjustment: function isAdjustment(row) {
      return row.ledger === 'ledger_paid' && row.payer === _main.DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ;
    },
    onSetTotalsFromSummaryBlock: function onSetTotalsFromSummaryBlock(totals) {
      this.totalCharges = totals.charges;
      this.totalCredits = totals.credits;
      this.totalAdjustments = totals.adjustments;
    },
    getPatientFullName: function getPatientFullName(patientInfo) {
      return patientInfo ? patientInfo.lastname + ', ' + patientInfo.firstname : '';
    },
    getDescription: function getDescription(ledgerRow) {
      var description = void 0;

      switch (ledgerRow.ledger) {
        case 'ledger_payment':
          description = _ConstantTitleGetter2.default.dssTransactionPayerLabels(+ledgerRow.payer) + ' Payment - ' + _ConstantTitleGetter2.default.dssTransactionPaymentTypeLabels(+ledgerRow.payment_type) + ' ';
          break;

        default:
          description = '';
          break;
      }

      description += ledgerRow.description;

      return description;
    },
    getLedgerData: function getLedgerData() {
      var _this = this;

      this.getLedgerRows(this.reportType, this.routeParameters.currentPageNumber, this.ledgerRowsPerPage, this.routeParameters.sortColumn, this.routeParameters.sortDirection).then(function (response) {
        var data = response.data.data;

        _this.ledgerRowsTotalNumber = data.total;
        _this.ledgerRows = data.result;
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getLedgerRows', response: response });
      });
    },
    formatLedger: function formatLedger(value) {
      return _accounting2.default.formatMoney(value, '$');
    },
    getCurrentDirection: function getCurrentDirection(sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
      }
      return 'asc';
    },
    getLedgerRows: function getLedgerRows(reportType, pageNumber, rowsPerPage, sortColumn, sortDir) {
      var data = {
        report_type: reportType,
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sortColumn,
        sort_dir: sortDir
      };

      return _http2.default.post(_endpoints2.default.ledgers.list, data);
    }
  }
};

/***/ }),
/* 534 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerSummaryReportFull_js__ = __webpack_require__(535);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerSummaryReportFull_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerSummaryReportFull_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4c01efdd_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ledgerSummaryReportFull_vue__ = __webpack_require__(536);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ledgerSummaryReportFull_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4c01efdd_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ledgerSummaryReportFull_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 535 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _accounting = __webpack_require__(63);

var _accounting2 = _interopRequireDefault(_accounting);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  name: 'ledger-summary-report-full',
  props: {
    reportType: {
      type: String,
      required: true
    }
  },
  data: function data() {
    return {
      charges: [],
      credits: [],
      adjustments: [],
      totals: {
        charges: 0,
        credits: 0,
        adjustments: 0
      }
    };
  },

  watch: {
    'charges': function charges() {
      var total = this.charges.reduce(function (sum, currentRow) {
        return sum + +currentRow.amount;
      }, 0);

      this.$set(this.totals, 'charges', total);
    },
    'credits': function credits() {
      var total = this.credits.reduce(function (sum, currentRow) {
        return sum + +currentRow.amount;
      }, 0);

      this.$set(this.totals, 'credits', total);
    },
    'adjustments': function adjustments() {
      var total = this.adjustments.reduce(function (sum, currentRow) {
        return sum + +currentRow.amount;
      }, 0);

      this.$set(this.totals, 'adjustments', total);
    },
    'totals': {
      handler: function handler() {
        window.eventHub.$emit('setting-totals-from-summary-block', this.totals);
      },
      deep: true
    }
  },
  created: function created() {
    this.formReportTotals();
  },

  methods: {
    formReportTotals: function formReportTotals() {
      var _this = this;

      this.getLedgerTotals(this.reportType).then(function (response) {
        var data = response.data.data;

        _this.charges = data.charges;
        _this.credits = data.credits.hasOwnProperty('type') ? data.credits['type'].concat(data.credits['named']) : data.credits;
        _this.adjustments = data.adjustments;
      }).catch(function (response) {
        _this.$store.dispatch(_symbols2.default.actions.handleErrors, { title: 'getLedgerTotals', response: response });
      });
    },
    getLedgerTotals: function getLedgerTotals(reportType) {
      var data = { report_type: reportType };

      return _http2.default.post(_endpoints2.default.ledgers.totals, data);
    },
    formatLedger: function formatLedger(value) {
      return _accounting2.default.formatMoney(value, '$');
    }
  }
};

/***/ }),
/* 536 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"fullwidth"},[_c('h3',[_vm._v("Charges")]),_vm._v(" "),_c('ul',[_vm._l((_vm.charges),function(charge){return _c('li',[_c('label',{domProps:{"innerHTML":_vm._s(charge.description)}}),_vm._v(" "+_vm._s(_vm.formatLedger(charge.amount))+"\n        ")])}),_vm._v(" "),_c('li',[_c('label',[_vm._v("Charges Total")]),_vm._v(" "+_vm._s(_vm.formatLedger(_vm.totals.charges))+"\n        ")])],2),_vm._v(" "),_c('h3',[_vm._v("Credit")]),_vm._v(" "),_c('ul',[_vm._l((_vm.credits),function(credit){return _c('li',[_c('label',{domProps:{"innerHTML":_vm._s(credit.description)}}),_vm._v(" "+_vm._s(_vm.formatLedger(credit.amount))+"\n        ")])}),_vm._v(" "),_c('li',[_c('label',[_vm._v("Credits Total")]),_vm._v(" "+_vm._s(_vm.formatLedger(_vm.totals.credits))+"\n        ")])],2),_vm._v(" "),_c('h3',[_vm._v("Adjustments")]),_vm._v(" "),_c('ul',[_vm._l((_vm.adjustments),function(adjustment){return _c('li',[_c('label',{domProps:{"innerHTML":_vm._s(adjustment.description)}}),_vm._v(" "+_vm._s(_vm.formatLedger(adjustment.amount))+"\n        ")])}),_vm._v(" "),_c('li',[_c('label',[_vm._v("Adjust. Total")]),_vm._v(" "+_vm._s(_vm.formatLedger(_vm.totals.adjustments))+"\n        ")])],2)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 537 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

exports.default = {
  dssTransactionTypeLabels: function dssTransactionTypeLabels(status) {
    if (_main.TRANSACTION_TYPE_LABELS.hasOwnProperty(status)) {
      return _main.TRANSACTION_TYPE_LABELS[status];
    }
    return null;
  },
  dssTransactionPaymentTypeLabels: function dssTransactionPaymentTypeLabels(status) {
    if (_main.PAYMENT_TYPE_LABELS.hasOwnProperty(status)) {
      return _main.PAYMENT_TYPE_LABELS[status];
    }
    return null;
  },
  dssTransactionPayerLabels: function dssTransactionPayerLabels(status) {
    if (_main.TRANSACTION_PAYER_LABELS.hasOwnProperty(status)) {
      return _main.TRANSACTION_PAYER_LABELS[status];
    }
    return null;
  }
};

/***/ }),
/* 538 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('span',{staticClass:"admin_head"},[_vm._v("\n        Today's Ledger Report\n        "),(_vm.patientId > 0)?[_vm._v("\n            ("),_c('i',[_vm._v(_vm._s(_vm.name))]),_vm._v(")\n        ")]:_vm._e(),_vm._v(" "),(true)?[_vm._v("\n            ("),_c('i',[_vm._v(_vm._s(_vm._f("moment")(_vm.currentDate,"MM/DD/YYYY")))]),_vm._v(")\n        ")]:_vm._e()],2),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{staticStyle:{"margin-right":"15px"},attrs:{"align":"right"}},[_c('router-link',{staticClass:"addButton",attrs:{"to":{ path: 'report-claim-aging' },"title":"This report can take several minutes to generate"}},[_vm._v("Claim Aging")]),_vm._v(" "),_c('router-link',{staticClass:"addButton",attrs:{"to":{
                path: 'print_ledger_reportfull',
                query: {
                    dailysub: 0,
                    monthlysub: 0,
                    d_mm: '',
                    d_dd: '',
                    d_yy: '',
                    pid: 0
                }
            },"target":"_blank"}},[_vm._v("Print Ledger")]),_vm._v(" "),_c('router-link',{staticClass:"addButton",attrs:{"to":{ path: 'ledger' }}},[_vm._v("Other Reports")]),_vm._v(" "),_c('router-link',{staticClass:"addButton",attrs:{"to":{ path: 'unpaid_patient' }}},[_vm._v("Unpaid Pt.")])],1),_vm._v(" "),_c('br'),_vm._v(" "),(_vm.message)?_c('div',{staticClass:"red",attrs:{"align":"center"}},[_c('b',[_vm._v(_vm._s(_vm.message))])]):_vm._e(),_vm._v(" "),_c('table',{attrs:{"width":"98%","cellpadding":"5","cellspacing":"1","bgcolor":"#FFFFFF","align":"center"}},[(_vm.ledgerRowsTotalNumber > _vm.ledgerRowsPerPage)?_c('tr',{attrs:{"bgColor":"#ffffff","align":"center","width":"98%","cellpadding":"5","cellspacing":"1"}},[_c('td',{staticClass:"bp",attrs:{"align":"right","colspan":"15"}},[_vm._v("\n                Pages:\n                "),_vm._l((_vm.totalPages),function(index){return _c('span',{staticClass:"page_numbers"},[(_vm.routeParameters.currentPageNumber == (index - 1))?_c('strong',[_vm._v(_vm._s(index))]):_c('router-link',{staticClass:"fp",attrs:{"to":{
                            name: _vm.$route.name,
                            query: {
                                page    : index - 1,
                                sort    : _vm.routeParameters.sortColumn,
                                sortdir : _vm.routeParameters.sortDirection
                            }
                        }}},[_vm._v(_vm._s(index))])],1)})],2)]):_vm._e(),_vm._v(" "),_c('tr',{staticClass:"tr_bg_h"},_vm._l((_vm.tableHeaders),function(settings,sort){return _c('td',{class:'col_head ' + (_vm.routeParameters.sortColumn == sort ? 'arrow_' + _vm.routeParameters.sortDirection : ''),attrs:{"valign":"top","width":settings.width + '%'}},[(settings.with_link)?_c('router-link',{attrs:{"to":{
                        name: _vm.$route.name,
                        query: {
                            sort: sort,
                            sortdir: _vm.getCurrentDirection(sort)
                        }
                    }}},[_vm._v(_vm._s(settings.title))]):[_vm._v(_vm._s(settings.title))]],2)})),_vm._v(" "),(_vm.ledgerRows.length == 0)?_c('tr',{staticClass:"tr_bg"},[_c('td',{staticClass:"col_head",attrs:{"valign":"top","colspan":"10","align":"center"}},[_vm._v("\n                No Records\n            ")])]):_vm._l((_vm.ledgerRows),function(row){return _c('tr',{class:/*row.status == 1 ? 'tr_active' : 'tr_inactive'*/'tr_active'},[_c('td',{attrs:{"valign":"top","width":"10%"}},[_vm._v("\n                "+_vm._s(_vm._f("moment")(row.service_date,"MM-DD-YYYY"))+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_vm._v("\n                "+_vm._s(_vm._f("moment")(row.entry_date,"MM-DD-YYYY"))+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_c('router-link',{attrs:{"to":{
                        path: 'manage_ledger',
                        query: {
                           pid: row.patientid
                        }
                    }}},[_vm._v(_vm._s(_vm.getPatientFullName(row.patient_info)))])],1),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"10%"}},[_vm._v("\n                "+_vm._s(row.name)+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"25%"},domProps:{"innerHTML":_vm._s(_vm.getDescription(row))}}),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right","width":"10%"}},[_vm._v("\n                "+_vm._s(row.ledger === 'ledger' && row.amount > 0 ? _vm.formatLedger(row.amount) : '')+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right","width":"10%"}},[_vm._v("\n                "+_vm._s(row.paid_amount > 0 && _vm.isCredit(row) ? _vm.formatLedger(row.paid_amount) : '')+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right","width":"10%"}},[_vm._v("\n                "+_vm._s(row.paid_amount > 0 && _vm.isAdjustment(row) ? _vm.formatLedger(row.paid_amount) : '')+"\n            ")]),_vm._v(" "),_c('td',{attrs:{"valign":"top","width":"5%"}},[_vm._v("\n                "+_vm._s(row.status == 1 ? 'Sent' : (row.status == 2 ? 'Filed' : 'Pend'))+"\n            ")])])}),_vm._v(" "),_c('tr',[_vm._m(0),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalPageCharges)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalPageCredits)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalPageAdjustments)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}})]),_vm._v(" "),_c('tr',[_vm._m(1),_vm._v(" "),_c('td',{attrs:{"align":"right"}},[_c('b',[_vm._v("\n                    "+_vm._s(_vm.formatLedger(_vm.totalPageCharges - _vm.totalPageCredits - _vm.totalPageAdjustments))+"\n                ")])]),_vm._v(" "),_c('td',{attrs:{"colspan":"2"}})]),_vm._v(" "),_vm._m(2),_vm._v(" "),_c('tr',[_vm._m(3),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalCharges)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalCredits)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top","align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalAdjustments)))])]),_vm._v(" "),_c('td',{attrs:{"valign":"top"}})]),_vm._v(" "),_c('tr',[_vm._m(4),_vm._v(" "),_c('td',{attrs:{"align":"right"}},[_c('b',[_vm._v(_vm._s(_vm.formatLedger(_vm.totalCharges - _vm.totalCredits - _vm.totalAdjustments)))])]),_vm._v(" "),_c('td',{attrs:{"colspan":"2"}})])],2),_vm._v(" "),_c('ledger-summary-report-full',{attrs:{"report-type":_vm.reportType}})],1)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{attrs:{"valign":"top","colspan":"5","align":"right"}},[_c('b',[_vm._v("Page Totals")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{attrs:{"valign":"top","colspan":"5","align":"right"}},[_c('b',[_vm._v("Page Balance")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('td',{attrs:{"colspan":"4"}}),_vm._v(" "),_c('td',{attrs:{"colspan":"5"}},[_c('hr',{staticStyle:{"border-top":"thin dashed"}})])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{attrs:{"valign":"top","colspan":"5","align":"right"}},[_c('b',[_vm._v("Totals")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('td',{attrs:{"valign":"top","colspan":"5","align":"right"}},[_c('b',[_vm._v("Balance")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 539 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8e3de204_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_SoftwareTutorials_vue__ = __webpack_require__(541);
function injectStyle (ssrContext) {
  __webpack_require__(540)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = null
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-8e3de204"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __WEBPACK_IMPORTED_MODULE_0__node_modules_vue_loader_lib_template_compiler_index_id_data_v_8e3de204_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_SoftwareTutorials_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 540 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 541 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _vm._m(0)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"tutorial"},[_c('br'),_vm._v(" "),_c('h1',[_vm._v("Software Tutorials and Training")]),_vm._v(" "),_c('div',[_vm._v(" ")]),_vm._v(" "),_c('h2',[_vm._v("DS3 Software Introduction")]),_vm._v(" "),_c('div',[_vm._v("\n        Just signed up? Great! Start here with a general introduction to the DS3 software. You will learn about HIPAA requirements, adding staff members, billing and forms, and electronically registering and screening patients. After watching this video you should be ready to get started.\n        "),_c('em',[_vm._v("Time: 45 Minutes")])]),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',[_c('iframe',{attrs:{"src":"https://player.vimeo.com/video/225094443","width":"640","height":"360","frameborder":"0","allowfullscreen":""}})])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 542 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTracker_js__ = __webpack_require__(544);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTracker_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTracker_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4edd1838_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientTracker_vue__ = __webpack_require__(560);
function injectStyle (ssrContext) {
  __webpack_require__(543)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4edd1838"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_PatientTracker_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4edd1838_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_PatientTracker_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 543 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 544 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _AppointmentSummary = __webpack_require__(545);

var _AppointmentSummary2 = _interopRequireDefault(_AppointmentSummary);

var _ChartButtons = __webpack_require__(548);

var _ChartButtons2 = _interopRequireDefault(_ChartButtons);

var _TrackerSectionOne = __webpack_require__(551);

var _TrackerSectionOne2 = _interopRequireDefault(_TrackerSectionOne);

var _TrackerSectionTwo = __webpack_require__(557);

var _TrackerSectionTwo2 = _interopRequireDefault(_TrackerSectionTwo);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      patientId: this.$store.state.patients[_symbols2.default.state.patientId],
      schedules: [],
      letterCount: 0
    };
  },

  computed: {
    scheduledAppointment: function scheduledAppointment() {
      if (this.$store.state.flowsheet[_symbols2.default.state.hasScheduledAppointment]) {
        return true;
      }
      if (this.schedules.length > 0) {
        return true;
      }
      return false;
    }
  },
  components: {
    appointmentSummary: _AppointmentSummary2.default,
    chartButtons: _ChartButtons2.default,
    trackerSectionOne: _TrackerSectionOne2.default,
    trackerSectionTwo: _TrackerSectionTwo2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.stepsByRank, this.patientId);
  }
};

/***/ }),
/* 545 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_AppointmentSummary_js__ = __webpack_require__(546);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_AppointmentSummary_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_AppointmentSummary_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_371293f8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_AppointmentSummary_vue__ = __webpack_require__(547);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_AppointmentSummary_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_371293f8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_AppointmentSummary_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 546 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    letterCount: {
      type: Number,
      default: 0
    }
  },
  data: function data() {
    return {
      flowElements: this.$store.state.flowsheet[_symbols2.default.state.appointmentSummaries],
      devices: this.$store.state.flowsheet[_symbols2.default.state.devices],
      letters: this.$store.state.flowsheet[_symbols2.default.state.letters]
    };
  },
  created: function created() {
    var _this = this;

    this.$store.dispatch(_symbols2.default.actions.appointmentSummariesByPatient, this.patientId).then(function () {
      _this.$store.dispatch(_symbols2.default.actions.lettersByPatientAndInfo, _this.patientId);
    });
    this.$store.dispatch(_symbols2.default.actions.devicesByStatus);
  },

  methods: {
    deleteSegment: function deleteSegment(flowElementId) {
      this.$store.dispatch(_symbols2.default.actions.deleteAppointmentSummary, flowElementId);
    }
  }
};

/***/ }),
/* 547 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"appt_summ",attrs:{"id":"appt_summ"}},[_c('table',{staticClass:"table table-bordered table-hover",attrs:{"width":"98%"}},[_vm._m(0),_vm._v(" "),_vm._l((_vm.flowElements),function(flowElement){return (flowElement.dateCompleted)?_c('appointment-summary-row',{key:flowElement.id,attrs:{"patient-id":_vm.patientId,"element-id":flowElement.id,"segment-id":flowElement.segmentId,"device-id":flowElement.deviceId,"study-type":flowElement.studyType,"delay-reason":flowElement.delayReason,"non-compliance-reason":flowElement.nonComplianceReason,"date-completed":flowElement.dateCompleted,"devices":_vm.devices,"letters":_vm.letters}}):_vm._e()})],2)])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('tr',[_c('th',[_vm._v("Date")]),_vm._v(" "),_c('th',[_vm._v("Treatment")]),_vm._v(" "),_c('th',{staticStyle:{"width":"80px"}},[_vm._v("Letters")]),_vm._v(" "),_c('th')])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 548 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ChartButtons_js__ = __webpack_require__(549);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ChartButtons_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ChartButtons_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1a90d918_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ChartButtons_vue__ = __webpack_require__(550);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ChartButtons_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_1a90d918_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ChartButtons_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 549 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _LocationWrapper = __webpack_require__(60);

var _LocationWrapper2 = _interopRequireDefault(_LocationWrapper);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    isHSTCompany: function isHSTCompany() {
      if (this.$store.state.screener[_symbols2.default.state.companyData].length > 0) {
        return true;
      }
      return false;
    },
    incompleteHSTs: function incompleteHSTs() {
      return this.$store.state.patients[_symbols2.default.state.incompleteHomeSleepTests];
    },
    hstStatus: function hstStatus() {
      if (!this.incompleteHSTs.length) {
        return '';
      }
      var lastHST = this.incompleteHSTs[this.incompleteHSTs.length - 1];
      if (!_main.HST_STATUSES.hasOwnProperty(lastHST)) {
        return '';
      }
      return _main.HST_STATUSES[lastHST];
    }
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.getCompanyData);
  },

  methods: {
    orderHst: function orderHst() {
      var alertText = 'Patient has existing HST with status ' + this.hstStatus + '. Only one HST can be requested at a time.';
      _Alerter2.default.alert(alertText);
    },
    requestHst: function requestHst() {
      var confirmText = 'Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.';
      if (_Alerter2.default.isConfirmed(confirmText)) {
        var legacyUrl = 'manage/hst_request_co.php?ed=' + this.patientId;
        _LocationWrapper2.default.goToLegacyPage(legacyUrl, this.$store.state.main[_symbols2.default.state.mainToken]);
      }
    }
  }
};

/***/ }),
/* 550 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"tracker-div"},[(_vm.isHSTCompany)?[(_vm.incompleteHSTs.length)?_c('a',{staticClass:"button",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.orderHst()}}},[_vm._v("Order HST")]):_c('a',{staticClass:"button",attrs:{"href":"#"},on:{"click":function($event){$event.preventDefault();_vm.requestHst()}}},[_vm._v("Request HST")])]:_vm._e(),_vm._v(" "),_c('a',{directives:[{name:"legacy-href",rawName:"v-legacy-href",value:('manage/calendar_pat.php?pid=' + _vm.patientId),expression:"'manage/calendar_pat.php?pid=' + patientId"}],staticClass:"button"},[_vm._v("View Calendar Appts")])],2)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 551 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionOne_js__ = __webpack_require__(552);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionOne_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionOne_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_376463b8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerSectionOne_vue__ = __webpack_require__(556);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionOne_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_376463b8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerSectionOne_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 552 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _TrackerStep = __webpack_require__(553);

var _TrackerStep2 = _interopRequireDefault(_TrackerStep);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    scheduledAppointment: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    stepsFirst: function stepsFirst() {
      return this.$store.getters[_symbols2.default.getters.trackerStepsFirst];
    },
    stepsSecond: function stepsSecond() {
      return this.$store.getters[_symbols2.default.getters.trackerStepsSecond];
    },
    arrowHeight: function arrowHeight() {
      var completedSteps = 0;
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.stepsFirst), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var step = _step.value;

          if (step.completed) {
            completedSteps++;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      var stepHeight = 20;
      return completedSteps * stepHeight;
    }
  },
  components: {
    trackerStep: _TrackerStep2.default
  }
};

/***/ }),
/* 553 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerStep_js__ = __webpack_require__(554);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerStep_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerStep_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4e7f0f03_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerStep_vue__ = __webpack_require__(555);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerStep_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4e7f0f03_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerStep_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 554 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    patientId: {
      type: Number,
      required: true
    },
    section: {
      type: Number,
      required: true
    },
    completed: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    schedule: function schedule() {
      return this.$store.getters[_symbols2.default.getters.trackerStepSchedule];
    },
    stepClass: function stepClass() {
      if (this.section === 1 && this.completed) {
        return true;
      }
      return false;
    }
  },
  methods: {
    addAction: function addAction() {},
    updateCurrentStep: function updateCurrentStep() {
      var hasScheduledAppointment = false;
      if (this.schedule.segmentid && this.schedule.date_scheduled) {
        hasScheduledAppointment = true;
      }
      this.$store.commit(_symbols2.default.mutations.hasScheduledAppointment, hasScheduledAppointment);
    }
  }
};

/***/ }),
/* 555 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('li',{class:{'completed_step': _vm.stepClass}},[(_vm.id === 1)?_c('span',[_vm._v(_vm._s(_vm.name))]):_c('a',{staticClass:"completed_today",attrs:{"href":"#","id":'completed_' + _vm.id},on:{"click":function($event){$event.preventDefault();_vm.addAction()}}},[_vm._v(_vm._s(_vm.name))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 556 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{class:{'current_step': _vm.scheduledAppointment},attrs:{"id":"treatment_list"}},[_c('div',{style:({height: _vm.arrowHeight + 'px'}),attrs:{"id":"arrow_div"}}),_vm._v(" "),_c('ul',{staticClass:"treatment sect1"},_vm._l((_vm.stepsFirst),function(step){return _c('tracker-step',{key:step.id,attrs:{"id":step.id,"name":step.name,"patient-id":_vm.patientId,"section":1,"completed":step.completed}})})),_vm._v(" "),_c('ul',{staticClass:"treatment sect2"},_vm._l((_vm.stepsSecond),function(step){return _c('tracker-step',{key:step.id,attrs:{"id":step.id,"name":step.name,"patient-id":_vm.patientId,"section":2,"completed":step.completed}})}))])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 557 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionTwo_js__ = __webpack_require__(558);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionTwo_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionTwo_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4fcc149e_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerSectionTwo_vue__ = __webpack_require__(559);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_TrackerSectionTwo_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_4fcc149e_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_TrackerSectionTwo_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 558 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _moment = __webpack_require__(0);

var _moment2 = _interopRequireDefault(_moment);

var _vuejsDatepicker = __webpack_require__(83);

var _vuejsDatepicker2 = _interopRequireDefault(_vuejsDatepicker);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  props: {
    scheduledAppointment: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    schedule: function schedule() {
      return this.$store.getters['schedule'];
    },
    nextSteps: function nextSteps() {
      return this.$store.getters['nextSteps'];
    },
    trackerNotes: function trackerNotes() {
      return this.$store.state.flowsheet['trackerNotesByPatient'];
    },
    dateAfterSchedule: function dateAfterSchedule() {
      if (!this.schedule.date_scheduled) {
        return '';
      }
      return (0, _moment2.default)(this.schedule.date_scheduled).format('MM/DD/YYYY');
    }
  },
  components: {
    datepicker: _vuejsDatepicker2.default
  },
  created: function created() {
    this.$store.dispatch('trackerNotesByPatient', this.patientId);
  }
};

/***/ }),
/* 559 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{class:{'current_step': !_vm.scheduledAppointment},attrs:{"id":"sched_div"}},[_c('div',{attrs:{"id":"next_step_div"}},[_c('label',[_vm._v("Select Next Appointment")]),_vm._v(" "),_c('select',{directives:[{name:"model",rawName:"v-model",value:(_vm.schedule.segmentid),expression:"schedule.segmentid"}],attrs:{"id":"next_step"},on:{"change":function($event){var $$selectedVal = Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return val}); _vm.schedule.segmentid=$event.target.multiple ? $$selectedVal : $$selectedVal[0]}}},[_c('option',{staticClass:"empty-option",attrs:{"value":""}},[_vm._v("Select Next Step")]),_vm._v(" "),_vm._l((_vm.nextSteps),function(nextStep){return _c('option',{domProps:{"value":nextStep.id}},[_vm._v(_vm._s(nextStep.name))])})],2)]),_vm._v(" "),_c('div',{attrs:{"id":"next_step_date_div"}},[_c('label',[_vm._v("Schedule On/After")]),_vm._v(" "),_c('datepicker',{attrs:{"name":"next_step_date","id":"next_step_date","input-class":"flow_next_calendar","format":"MM/dd/yyyy"},model:{value:(_vm.dateAfterSchedule),callback:function ($$v) {_vm.dateAfterSchedule=$$v},expression:"dateAfterSchedule"}}),_vm._v(" "),_c('span',{attrs:{"id":"next_step_until"}},[_vm._v(_vm._s(_vm.schedule.date_until))])],1),_vm._v(" "),_c('div',{attrs:{"id":"tracker-notes-container"}},[_c('label',[_vm._v("Notes")]),_vm._v(" "),_c('input',{attrs:{"id":"tracker-notes","type":"text"},domProps:{"value":_vm.trackerNotes}})]),_vm._v(" "),_c('div',{staticClass:"clear"})])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 560 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('chart-buttons',{attrs:{"patient-id":_vm.patientId}}),_vm._v(" "),_c('div',{attrs:{"id":"treatment_div"}},[_c('h3',[_vm._v("1) What did you do today?*")]),_vm._v(" "),_c('tracker-section-one',{attrs:{"patient-id":_vm.patientId,"scheduled-appointment":_vm.scheduledAppointment}}),_vm._v(" "),_c('span',{staticClass:"sub_text"},[_vm._v("*Click a treatment above to add it to the Treatment Summary")])],1),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 561 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _main = __webpack_require__(6);

var _ScreenerLogin = __webpack_require__(562);

var _ScreenerLogin2 = _interopRequireDefault(_ScreenerLogin);

var _ScreenerApp = __webpack_require__(566);

var _ScreenerApp2 = _interopRequireDefault(_ScreenerApp);

var _ScreenerIntro = __webpack_require__(575);

var _ScreenerIntro2 = _interopRequireDefault(_ScreenerIntro);

var _ScreenerEpworth = __webpack_require__(579);

var _ScreenerEpworth2 = _interopRequireDefault(_ScreenerEpworth);

var _ScreenerSymptoms = __webpack_require__(584);

var _ScreenerSymptoms2 = _interopRequireDefault(_ScreenerSymptoms);

var _ScreenerDiagnoses = __webpack_require__(588);

var _ScreenerDiagnoses2 = _interopRequireDefault(_ScreenerDiagnoses);

var _ScreenerResults = __webpack_require__(591);

var _ScreenerResults2 = _interopRequireDefault(_ScreenerResults);

var _ScreenerDoctor = __webpack_require__(594);

var _ScreenerDoctor2 = _interopRequireDefault(_ScreenerDoctor);

var _ScreenerHst = __webpack_require__(597);

var _ScreenerHst2 = _interopRequireDefault(_ScreenerHst);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = [{
  path: 'login',
  name: 'screener-login',
  component: _ScreenerLogin2.default
}, {
  path: 'main',
  name: 'screener-main',
  component: _ScreenerApp2.default,
  children: [{
    path: 'intro',
    name: 'screener-intro',
    component: _ScreenerIntro2.default
  }, {
    path: 'epworth',
    name: 'screener-epworth',
    component: _ScreenerEpworth2.default
  }, {
    path: 'symptoms',
    name: 'screener-symptoms',
    component: _ScreenerSymptoms2.default
  }, {
    path: 'diagnoses',
    name: 'screener-diagnoses',
    component: _ScreenerDiagnoses2.default
  }, {
    path: 'results',
    name: 'screener-results',
    component: _ScreenerResults2.default
  }, {
    path: 'doctor',
    name: 'screener-doctor',
    component: _ScreenerDoctor2.default
  }, {
    path: 'hst',
    name: 'screener-hst',
    component: _ScreenerHst2.default
  }],
  meta: _main.STANDARD_META
}];

/***/ }),
/* 562 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerLogin_js__ = __webpack_require__(564);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerLogin_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerLogin_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_061c3b14_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerLogin_vue__ = __webpack_require__(565);
function injectStyle (ssrContext) {
  __webpack_require__(563)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-061c3b14"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerLogin_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_061c3b14_hasScoped_true_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerLogin_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 563 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 564 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _SiteSeal = __webpack_require__(100);

var _SiteSeal2 = _interopRequireDefault(_SiteSeal);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      username: '',
      password: '',
      loginError: false
    };
  },
  components: {
    siteSeal: _SiteSeal2.default
  },
  mounted: function mounted() {
    if (this.$store.state.screener[_symbols2.default.state.screenerToken]) {
      this.$router.push({ name: 'screener-intro' });
    }
  },

  methods: {
    setPassword: function setPassword(event) {
      this.password = event.target.value;
    },
    onSubmit: function onSubmit() {
      var _this = this;

      if (!this.username) {
        alert('Username is Required');
        return;
      }
      if (!this.password) {
        alert('Password is Required');
        return;
      }

      var data = {
        username: this.username,
        password: this.password
      };
      this.$store.dispatch(_symbols2.default.actions.authenticateScreener, data).then(function () {
        _this.$router.push({ name: 'screener-intro' });
      }).catch(function () {
        _this.loginError = true;
      });
    }
  }
};

/***/ }),
/* 565 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"login_body"},[_c('div',{attrs:{"id":"login_container"}},[_c('h1',[_vm._v("Dental Sleep Solutions")]),_vm._v(" "),_c('div',{staticClass:"login_content",attrs:{"id":"login_sect"}},[_c('h2',[_vm._v("Screener Tool")]),_vm._v(" "),(_vm.loginError)?_c('span',{staticClass:"error"},[_vm._v("Error! Wrong email address or password.")]):_vm._e(),_vm._v(" "),_c('form',{attrs:{"name":"loginfrm"}},[_c('div',{staticClass:"field"},[_c('label',{attrs:{"for":"username"}},[_vm._v("Username")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.username),expression:"username"}],attrs:{"type":"text","tabindex":"1","id":"username","name":"username"},domProps:{"value":(_vm.username)},on:{"input":function($event){if($event.target.composing){ return; }_vm.username=$event.target.value}}})]),_vm._v(" "),_c('div',{staticClass:"field"},[_c('label',{attrs:{"for":"password"}},[_vm._v("Password")]),_vm._v(" "),_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.password),expression:"password"}],attrs:{"type":"password","tabindex":"2","id":"password","name":"password"},domProps:{"value":(_vm.password)},on:{"change":function($event){_vm.setPassword($event)},"input":function($event){if($event.target.composing){ return; }_vm.password=$event.target.value}}})]),_vm._v(" "),_c('div',{staticClass:"field"},[_c('button',{staticClass:"large",attrs:{"type":"submit","name":"loginbut","id":"loginbut"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}},[_vm._v("Log In")])])])])]),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}}),_vm._v(" "),_c('site-seal'),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})],1)}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 566 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerApp_js__ = __webpack_require__(570);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerApp_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerApp_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0db9f28c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerApp_vue__ = __webpack_require__(574);
function injectStyle (ssrContext) {
  __webpack_require__(567)
  __webpack_require__(568)
  __webpack_require__(569)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerApp_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_0db9f28c_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerApp_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 567 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 568 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 569 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 570 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _FancyboxScreener = __webpack_require__(571);

var _FancyboxScreener2 = _interopRequireDefault(_FancyboxScreener);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      currentYear: new Date().getFullYear()
    };
  },
  computed: {
    showReset: function showReset() {
      return this.$route.name !== 'screener-intro';
    },
    showFancybox: function showFancybox() {
      return this.$store.state.screener[_symbols2.default.state.showFancybox];
    }
  },
  components: {
    'fancybox-screener': _FancyboxScreener2.default
  },
  mounted: function mounted() {
    if (!this.$store.state.screener[_symbols2.default.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' });
    }
  },

  methods: {
    onLogout: function onLogout() {
      var logoutAlert = 'Are you sure you want to logout?';
      if (_Alerter2.default.isConfirmed(logoutAlert)) {
        this.$store.commit(_symbols2.default.mutations.screenerToken, '');
        this.$router.push({ name: 'screener-login' });
      }
    },
    onReset: function onReset() {
      var resetAlert = 'Are you sure? All current progress will be lost.';
      if (_Alerter2.default.isConfirmed(resetAlert)) {
        this.$store.commit(_symbols2.default.mutations.restoreInitialScreenerKeepSession);
        this.$router.push({ name: 'screener-intro' });
      }
    }
  }
};

/***/ }),
/* 571 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_FancyboxScreener_js__ = __webpack_require__(572);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_FancyboxScreener_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_FancyboxScreener_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_411d1a43_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_FancyboxScreener_vue__ = __webpack_require__(573);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_FancyboxScreener_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_411d1a43_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_FancyboxScreener_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 572 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  methods: {
    closeFancybox: function closeFancybox() {
      this.$store.commit(_symbols2.default.mutations.hideFancybox);
    },
    closeAndReset: function closeAndReset() {
      this.$store.commit(_symbols2.default.mutations.restoreInitialScreenerKeepSession);
      this.$store.commit(_symbols2.default.mutations.hideFancybox);
      this.$router.push({ name: 'screener-intro' });
    }
  }
};

/***/ }),
/* 573 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('div',{staticStyle:{"background-color":"rgb(119, 119, 119)","opacity":"0","cursor":"auto","height":"559px"},attrs:{"id":"fancybox-overlay"}}),_vm._v(" "),_c('div',{staticStyle:{"width":"320px","height":"auto","top":"241px","left":"495px"},attrs:{"id":"fancybox-wrap"}},[_c('div',{attrs:{"id":"fancybox-outer"}},[_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-n"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-ne"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-e"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-se"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-s"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-sw"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-w"}}),_vm._v(" "),_c('div',{staticClass:"fancybox-bg",attrs:{"id":"fancybox-bg-nw"}}),_vm._v(" "),_c('div',{staticStyle:{"border-width":"10px","width":"300px","height":"150px"},attrs:{"id":"fancybox-content"}},[_c('div',{staticStyle:{"width":"300px","height":"150px","overflow":"auto","position":"relative"}},[_c('div',{attrs:{"id":"regModal"}},[_c('h4',{staticClass:"sepH_a"},[_vm._v("Survey Complete")]),_vm._v(" "),_c('p',{staticClass:"sepH_c"},[_vm._v("Thank you for completing the survey. Please return this device to our staff or let them know you have completed the survey.")]),_vm._v(" "),_c('a',{staticClass:"btn btn_d",attrs:{"href":"#","id":"finish_ok"},on:{"click":function($event){$event.preventDefault();_vm.closeAndReset()}}},[_vm._v("OK")])])])]),_vm._v(" "),_c('a',{staticStyle:{"display":"inline"},attrs:{"href":"#","id":"fancybox-close"},on:{"click":function($event){$event.preventDefault();_vm.closeFancybox()}}})])])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 574 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"screener_body fixed"},[_c('div',{attrs:{"id":"header"}},[_c('div',{staticClass:"wrapper cf"},[_vm._m(0),_vm._v(" "),_c('ul',{staticClass:"fr",attrs:{"id":"main_nav"}},[_c('li',{directives:[{name:"show",rawName:"v-show",value:(_vm.showReset),expression:"showReset"}],staticClass:"nav_item lgutipT",attrs:{"title":"start over","id":"reset_nav"}},[_c('a',{staticClass:"main_link",attrs:{"href":"#","id":"reset_link"},on:{"click":function($event){$event.preventDefault();_vm.onReset()}}},[_c('img',{staticClass:"img_holder refresh_image",attrs:{"alt":"Refresh","src":__webpack_require__(84)}}),_vm._v(" "),_c('span',[_vm._v("Reset and Start Over")])])]),_vm._v(" "),_c('li',{staticClass:"nav_item lgutipT",attrs:{"title":"Log Out"}},[_c('a',{staticClass:"main_link",attrs:{"href":"#","id":"logout_link"},on:{"click":function($event){$event.preventDefault();_vm.onLogout()}}},[_c('img',{staticClass:"img_holder logout_image",attrs:{"alt":"Logout","src":__webpack_require__(84)}}),_vm._v(" "),_c('span',[_vm._v("Log Out")])])])])])]),_vm._v(" "),_c('div',{attrs:{"id":"main"}},[_c('div',{staticClass:"wrapper cf"},[_c('div',{staticClass:"cf brdrrad_a",attrs:{"id":"main_section"}},[_c('router-view'),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})],1)]),_vm._v(" "),_c('div',{attrs:{"id":"footer"}},[_c('div',{staticClass:"wrapper"},[_c('span',{staticClass:"fr"},[_vm._v("Copyright Dental Sleep Solutions "+_vm._s(_vm.currentYear))])])])]),_vm._v(" "),_c('fancybox-screener',{directives:[{name:"show",rawName:"v-show",value:(_vm.showFancybox),expression:"showFancybox"}]})],1)}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"logo fl"},[_c('h1',[_vm._v("Dental Sleep Solutions")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 575 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerIntro_js__ = __webpack_require__(576);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerIntro_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerIntro_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d7d98de_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerIntro_vue__ = __webpack_require__(577);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerIntro_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_6d7d98de_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerIntro_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 576 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _awesomeMask = __webpack_require__(98);

var _awesomeMask2 = _interopRequireDefault(_awesomeMask);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      nextDisabled: false,
      contactData: this.$store.state.screener[_symbols2.default.state.contactData],
      storedContacts: {},
      errors: {}
    };
  },
  directives: {
    mask: _awesomeMask2.default
  },
  methods: {
    updateValue: function updateValue(event) {
      this.storedContacts[event.target.id] = event.target.value;
    },
    onSubmit: function onSubmit() {
      this.nextDisabled = true;

      var hasError = false;

      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.contactData), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var nameField = _step.value;

          if (nameField.firstPage && (!this.storedContacts.hasOwnProperty(nameField.name) || this.storedContacts[nameField.name] === '')) {
            this.errors[nameField.name] = true;
            hasError = true;
          } else {
            this.errors[nameField.name] = false;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (hasError) {
        this.nextDisabled = false;
        return;
      }

      this.$store.commit(_symbols2.default.mutations.contactData, this.storedContacts);

      this.$router.push({ name: 'screener-epworth' });
    }
  }
};

/***/ }),
/* 577 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sect0"}},[_c('div',{staticClass:"dp50"},[_c('h3',{staticClass:"sepH_a"},[_vm._v("Dental Sleep Solutions - Patient Health Assessment")]),_vm._v(" "),_vm._m(0),_vm._v(" "),_c('br'),_vm._v(" "),_c('p',[_vm._v("Please enter your contact information to complete this brief health assessment.")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{staticClass:"clear"}),_vm._v(" "),_vm._l((_vm.contactData),function(contact){return (contact.firstPage)?_c('div',{key:contact.name,staticClass:"sepH_b",class:{error: _vm.errors[contact.name]},attrs:{"id":contact.name + '_div'}},[_c('label',{staticClass:"lbl_a",attrs:{"for":contact.name}},[_vm._v(_vm._s(contact.label))]),_vm._v(" "),_c('input',{directives:[{name:"mask",rawName:"v-mask",value:(contact.mask),expression:"contact.mask"}],staticClass:"inpt_a",attrs:{"type":"text","id":contact.name,"name":contact.name},domProps:{"value":contact.value},on:{"change":function($event){_vm.updateValue($event)}}})]):_vm._e()})],2),_vm._v(" "),_c('div',{staticClass:"dp50"},[_c('img',{staticStyle:{"float":"right"},attrs:{"src":__webpack_require__(578)}}),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{staticClass:"cf"},[_c('a',{staticClass:"fr next btn btn_large btn_d",class:{disabled: _vm.nextDisabled},attrs:{"href":"#","id":"sect1_next"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit($event)}}},[_vm._v("Proceed »")])])]),_vm._v(" "),_c('div',{staticClass:"clear"})])])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('p',{staticStyle:{"font-size":"14px"}},[_vm._v("\n                More than 20 million Americans suffer from Obstructive Sleep Apnea (OSA). Despite this high prevalence, 93% of women and 82% of men with moderate to severe OSA remain UNDIAGNOSED and UNAWARE that they have a deadly disease.\n                "),_c('br'),_vm._v("\n                Please complete this short questionnaire to determine your risk of OSA. Your information is confidential and will only be shared with healthcare providers for diagnostic and treatment purposes.\n            ")])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 578 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/sleeping_couple.950d4a8.png";

/***/ }),
/* 579 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerEpworth_js__ = __webpack_require__(580);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerEpworth_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerEpworth_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_33e56335_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerEpworth_vue__ = __webpack_require__(583);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerEpworth_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_33e56335_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerEpworth_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 580 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _helpers = __webpack_require__(219);

var _helpers2 = _interopRequireDefault(_helpers);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      nextDisabled: false,
      hasError: false,
      epworthOptions: this.$store.state.screener[_symbols2.default.state.epworthOptions],
      storedProps: {},
      errors: []
    };
  },
  computed: {
    epworthProps: function epworthProps() {
      return this.$store.state.screener[_symbols2.default.state.epworthProps];
    }
  },
  components: {
    'health-assessment': _HealthAssessment2.default
  },
  created: function created() {
    if (!this.$store.state.screener[_symbols2.default.state.epworthProps].length) {
      this.$store.dispatch(_symbols2.default.actions.setEpworthProps);
    }
  },

  methods: {
    updateValue: function updateValue(event) {
      var fieldId = event.target.id.replace('epworth_', '');
      this.storedProps[fieldId] = event.target.value;
    },
    onSubmit: function onSubmit() {
      this.nextDisabled = true;
      this.hasError = false;

      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.epworthProps), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var epworth = _step.value;

          if (this.storedProps.hasOwnProperty(epworth.epworthid)) {
            this.errors = _helpers2.default.arrayRemove(this.errors, epworth.epworth);
          } else {
            this.errors = _helpers2.default.arrayAddUnique(this.errors, epworth.epworth);
            this.hasError = true;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (this.hasError) {
        this.nextDisabled = false;
        this.$store.commit(_symbols2.default.mutations.setEpworthErrors, this.errors);
        return;
      }

      this.$store.commit(_symbols2.default.mutations.modifyEpworthProps, this.storedProps);

      this.$router.push({ name: 'screener-symptoms' });
    }
  }
};

/***/ }),
/* 581 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends2 = __webpack_require__(85);

var _extends3 = _interopRequireDefault(_extends2);

var _vuex = __webpack_require__(55);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: (0, _extends3.default)({}, (0, _vuex.mapGetters)({
    assessmentName: _symbols2.default.getters.fullName
  }))
};

/***/ }),
/* 582 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('h5',{staticStyle:{"float":"right"}},[_vm._v("Health Assessment - "),_c('span',{staticClass:"assessment_name"},[_vm._v(_vm._s(_vm.assessmentName))])])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 583 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sect2"}},[_c('health-assessment'),_vm._v(" "),_c('h3',[_vm._v("Epworth Sleepiness Scale")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('p',[_vm._v("How likely are you to sleep or doze in each of the following situations?")]),_vm._v(" "),_c('div',{staticClass:"formEl_a"},[_c('div',{staticClass:"dp66"},[_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.errors.length),expression:"errors.length"}],staticClass:"msg_box msg_error",attrs:{"id":"epworth_error_box"}},_vm._l((_vm.errors),function(error){return _c('div',{staticClass:"error"},[_c('strong',[_vm._v(_vm._s(error))]),_vm._v(": Please provide an answer\n                    ")])})),_vm._v(" "),_vm._l((_vm.epworthProps),function(element){return _c('div',{staticClass:"sepH_b clear",class:{error: element.error},attrs:{"id":'epworth_' + element.epworthid + '_div'}},[_c('select',{staticClass:"inpt_in epworth_select",attrs:{"id":'epworth_' + element.epworthid,"name":'epworth_' + element.epworthid},on:{"change":function($event){_vm.updateValue($event)}}},[_c('option',{attrs:{"value":""}},[_vm._v("Select an answer")]),_vm._v(" "),_vm._l((_vm.epworthOptions),function(answer){return _c('option',{domProps:{"value":answer.option}},[_vm._v(_vm._s(answer.option)+" - "+_vm._s(answer.label))])})],2),_vm._v(" "),_c('label',{staticClass:"lbl_in",attrs:{"for":'epworth_' + element.epworthid}},[_vm._v(_vm._s(element.epworth))])])})],2),_vm._v(" "),_c('div',{staticClass:"legend dp33"},[_vm._v("\n                Using the following scale, choose the most appropriate number for each situation.\n                "),_c('br'),_vm._v(" "),_vm._l((_vm.epworthOptions),function(answer){return _c('div',[_c('strong',[_vm._v(_vm._s(answer.option))]),_vm._v(" = "+_vm._s(answer.label))])})],2),_vm._v(" "),_c('div',{staticStyle:{"clear":"both"}})]),_vm._v(" "),_c('a',{staticClass:"fr next btn btn_medium btn_d",class:{disabled: _vm.nextDisabled},attrs:{"href":"#","id":"sect2_next"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}},[_vm._v("Next")])],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 584 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerSymptoms_js__ = __webpack_require__(586);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerSymptoms_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerSymptoms_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_65352e30_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerSymptoms_vue__ = __webpack_require__(587);
function injectStyle (ssrContext) {
  __webpack_require__(585)
}
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerSymptoms_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_65352e30_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerSymptoms_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 585 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 586 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _helpers = __webpack_require__(219);

var _helpers2 = _interopRequireDefault(_helpers);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      nextDisabled: false,
      hasError: false,
      symptoms: this.$store.state.screener[_symbols2.default.state.symptoms],
      storedSymptoms: {},
      errors: []
    };
  },
  mounted: function mounted() {
    window.$(function () {
      window.$('.buttonset').buttonset();
    });
  },

  components: {
    'health-assessment': _HealthAssessment2.default
  },
  methods: {
    updateValue: function updateValue(event) {
      this.storedSymptoms[event.target.name] = event.target.value;
    },
    onSubmit: function onSubmit() {
      this.hasError = false;
      this.nextDisabled = true;

      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.symptoms), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var symptom = _step.value;

          if (this.storedSymptoms.hasOwnProperty(symptom.name)) {
            this.errors = _helpers2.default.arrayRemove(this.errors, symptom.label);
          } else {
            this.errors = _helpers2.default.arrayAddUnique(this.errors, symptom.label);
            this.hasError = true;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (this.hasError) {
        this.nextDisabled = false;
        return;
      }

      this.$store.commit(_symbols2.default.mutations.symptoms, this.storedSymptoms);

      this.$router.push({ name: 'screener-diagnoses' });
    }
  }
};

/***/ }),
/* 587 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sect3"}},[_c('health-assessment'),_vm._v(" "),_c('h3',[_vm._v("Health Symptoms")]),_vm._v(" "),_c('p',[_vm._v("Please answer the following questions about your sleep habits.")]),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.errors.length),expression:"errors.length"}],staticClass:"msg_box msg_error",attrs:{"id":"sect3_error_box"}},_vm._l((_vm.errors),function(error){return _c('div',{staticClass:"error"},[_c('strong',[_vm._v(_vm._s(error))]),_vm._v(": Please provide an answer\n            ")])})),_vm._v(" "),_vm._l((_vm.symptoms),function(symptom){return _c('div',{staticClass:"sepH_b",attrs:{"id":symptom.name + '_div'}},[_c('div',{staticClass:"buttonset"},[_c('input',{attrs:{"type":"radio","id":symptom.name + '1',"name":symptom.name},domProps:{"value":symptom.weight},on:{"click":function($event){_vm.updateValue($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":symptom.name + '1'}},[_vm._v("Yes")]),_vm._v(" "),_c('input',{attrs:{"type":"radio","id":symptom.name + '2',"name":symptom.name,"value":"0"},on:{"click":function($event){_vm.updateValue($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":symptom.name + '2'}},[_vm._v("No")])]),_vm._v(" "),_c('label',{staticClass:"question"},[_vm._v(_vm._s(symptom.label))])])}),_vm._v(" "),_c('a',{staticClass:"fr next btn btn_medium btn_d",class:{disabled: _vm.nextDisabled},attrs:{"href":"#","id":"sect3_next"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}},[_vm._v("Next")])],2)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 588 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDiagnoses_js__ = __webpack_require__(589);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDiagnoses_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDiagnoses_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ee759932_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerDiagnoses_vue__ = __webpack_require__(590);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDiagnoses_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_ee759932_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerDiagnoses_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 589 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      nextDisabled: false,
      communicationError: false,
      cpap: this.$store.state.screener[_symbols2.default.state.cpap],
      storedCpap: 0,
      conditions: this.$store.state.screener[_symbols2.default.state.coMorbidityData],
      storedConditions: {}
    };
  },
  mounted: function mounted() {
    window.$(function () {
      window.$('.buttonset').buttonset();
    });
  },

  components: {
    'health-assessment': _HealthAssessment2.default
  },
  methods: {
    updateValue: function updateValue(event) {
      this.storedConditions[event.target.name] = false;
      if (event.target.checked) {
        this.storedConditions[event.target.name] = true;
      }
    },
    updateCpap: function updateCpap(event) {
      this.storedCpap = parseInt(event.target.value);
    },
    onSubmit: function onSubmit() {
      var _this = this;

      this.nextDisabled = true;

      this.$store.commit(_symbols2.default.mutations.coMorbidity, this.storedConditions);
      this.$store.commit(_symbols2.default.mutations.cpap, this.storedCpap);

      this.$store.dispatch(_symbols2.default.actions.submitScreener).then(function (response) {
        var data = response.data.data;
        _this.$store.dispatch(_symbols2.default.actions.parseScreenerResults, data);
        _this.$router.push({ name: 'screener-results' });
      }).catch(function () {
        _this.nextDisabled = false;
        var alertText = 'There was an error communicating with the server, please try again in a few minutes';
        _Alerter2.default.alert(alertText);
      });
    }
  }
};

/***/ }),
/* 590 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sect4"}},[_c('health-assessment'),_vm._v(" "),_c('h3',[_vm._v("Previous medical diagnoses")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{staticClass:"sepH_b",attrs:{"id":"rx_cpap_div"}},[_c('div',{staticClass:"buttonset"},[_c('input',{attrs:{"type":"radio","id":_vm.cpap.name + '1',"name":_vm.cpap.name},domProps:{"value":_vm.cpap.weight},on:{"click":function($event){_vm.updateCpap($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":_vm.cpap.name + '1'}},[_vm._v("Yes")]),_vm._v(" "),_c('input',{attrs:{"type":"radio","id":_vm.cpap.name + '2',"name":_vm.cpap.name,"value":"0"},on:{"click":function($event){_vm.updateCpap($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":_vm.cpap.name + '2'}},[_vm._v("No")])]),_vm._v(" "),_c('label',{staticClass:"question"},[_vm._v(_vm._s(_vm.cpap.label))])]),_vm._v(" "),_c('br'),_c('br'),_vm._v(" "),_c('p',{staticClass:"clear"},[_vm._v("Please check any conditions for which you have been medically diagnosed or treated.")]),_vm._v(" "),_vm._l((_vm.conditions),function(condition){return _c('div',{staticClass:"field half"},[_c('input',{attrs:{"type":"checkbox","id":condition.name,"name":condition.name,"value":"1"},on:{"click":function($event){_vm.updateValue($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":condition.name}},[_vm._v(_vm._s(condition.label))])])}),_vm._v(" "),_c('a',{staticClass:"fr next btn btn_medium btn_d",class:{disabled: _vm.nextDisabled},attrs:{"href":"#","id":"sect4_next"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}},[_vm._v("Next")])],2)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 591 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerResults_js__ = __webpack_require__(592);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerResults_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerResults_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_25c58ae8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerResults_vue__ = __webpack_require__(593);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerResults_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_25c58ae8_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerResults_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 592 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

var _screenerLow_risk = __webpack_require__(220);

var _screenerLow_risk2 = _interopRequireDefault(_screenerLow_risk);

var _screenerModerate_risk = __webpack_require__(221);

var _screenerModerate_risk2 = _interopRequireDefault(_screenerModerate_risk);

var _screenerHigh_risk = __webpack_require__(222);

var _screenerHigh_risk2 = _interopRequireDefault(_screenerHigh_risk);

var _screenerSevere_risk = __webpack_require__(223);

var _screenerSevere_risk2 = _interopRequireDefault(_screenerSevere_risk);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  computed: {
    patientName: function patientName() {
      var contactData = this.$store.state.screener[_symbols2.default.state.contactData];
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(contactData), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var property = _step.value;

          if (property.camelName === 'firstName') {
            return property.value;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      return '';
    },
    riskLevel: function riskLevel() {
      return this.$store.getters[_symbols2.default.getters.calculateRisk];
    },
    riskLevelImage: function riskLevelImage() {
      var images = {
        low: _screenerLow_risk2.default,
        moderate: _screenerModerate_risk2.default,
        high: _screenerHigh_risk2.default,
        severe: _screenerSevere_risk2.default
      };
      var riskLevel = this.$store.getters[_symbols2.default.getters.calculateRisk];
      if (images.hasOwnProperty(riskLevel)) {
        return images[riskLevel];
      }
      return _screenerLow_risk2.default;
    },
    doctorName: function doctorName() {
      return this.$store.state.screener[_symbols2.default.state.doctorName];
    }
  },
  components: {
    'health-assessment': _HealthAssessment2.default
  },
  created: function created() {
    if (!this.$store.state.screener[_symbols2.default.state.doctorName]) {
      this.$store.dispatch(_symbols2.default.actions.getDoctorData);
    }
  }
};

/***/ }),
/* 593 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sectresults"}},[_c('health-assessment'),_vm._v(" "),_c('h3',[_vm._v("Your Results")]),_vm._v(" "),(_vm.riskLevel === 'low')?_c('div',{staticClass:"risk_desc",attrs:{"id":"risk_low"}},[_c('span',{staticClass:"pat_name"},[_vm._v(_vm._s(_vm.patientName))]),_vm._v(", thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at low risk for sleep apnea, indicating a normal amount of sleepiness. Should any of your symptoms change, please let us know so we can reassess your sleepiness and risk for sleep apnea.\n            Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.\n        ")]):(_vm.riskLevel === 'moderate')?_c('div',{staticClass:"risk_desc",attrs:{"id":"risk_moderate"}},[_c('span',{staticClass:"pat_name"},[_vm._v(_vm._s(_vm.patientName))]),_vm._v(", thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at moderate risk for sleep apnea, indicating that some of your symptoms may be signs of Obstructive Sleep Apnea (OSA). Please talk to "+_vm._s(_vm.doctorName)+" or any of our staff to find out about our advanced tools for diagnosing sleep apnea. We are here to answer your questions and help you breathe and sleep better!\n            Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.\n        ")]):(_vm.riskLevel === 'high')?_c('div',{staticClass:"risk_desc",attrs:{"id":"risk_high"}},[_c('span',{staticClass:"pat_name"},[_vm._v(_vm._s(_vm.patientName))]),_vm._v(", thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to "+_vm._s(_vm.doctorName)+" or any of our staff to find out about our advanced tools for diagnosing sleep apnea.\n            Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your HIGH risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!\n        ")]):(_vm.riskLevel === 'severe')?_c('div',{staticClass:"risk_desc",attrs:{"id":"risk_severe"}},[_c('span',{staticClass:"pat_name"},[_vm._v(_vm._s(_vm.patientName))]),_vm._v(", thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at severe risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness and medical attention should be sought. Please talk to "+_vm._s(_vm.doctorName)+" or any of our staff to find out about our advanced tools for diagnosing sleep apnea.\n            Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your SEVERE risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We're here to help!\n        ")]):_vm._e(),_vm._v(" "),_c('div',{attrs:{"id":"risk_image"}},[_c('img',{attrs:{"src":_vm.riskLevelImage,"alt":_vm.riskLevel + ' risk',"title":_vm.riskLevel + ' risk'}})]),_vm._v(" "),_c('h2',[_vm._v("Thank you for completing the survey. Please return the device to your provider.")]),_vm._v(" "),_c('router-link',{staticClass:"fr next btn btn_medium btn_d",attrs:{"to":{ name: 'screener-doctor' },"id":"sect5_next"}},[_vm._v("Dentist Only - Click Here »")])],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 594 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDoctor_js__ = __webpack_require__(595);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDoctor_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDoctor_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cefe7cc6_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerDoctor_vue__ = __webpack_require__(596);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerDoctor_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_cefe7cc6_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerDoctor_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 595 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

var _screenerLow_risk = __webpack_require__(220);

var _screenerLow_risk2 = _interopRequireDefault(_screenerLow_risk);

var _screenerModerate_risk = __webpack_require__(221);

var _screenerModerate_risk2 = _interopRequireDefault(_screenerModerate_risk);

var _screenerHigh_risk = __webpack_require__(222);

var _screenerHigh_risk2 = _interopRequireDefault(_screenerHigh_risk);

var _screenerSevere_risk = __webpack_require__(223);

var _screenerSevere_risk2 = _interopRequireDefault(_screenerSevere_risk);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      symptoms: this.$store.state.screener[_symbols2.default.state.symptoms],
      coMorbidityData: this.$store.state.screener[_symbols2.default.state.coMorbidityData],
      cpap: this.$store.state.screener[_symbols2.default.state.cpap],
      resultsShown: false
    };
  },

  computed: {
    epworthProps: function epworthProps() {
      return this.$store.state.screener[_symbols2.default.state.epworthProps];
    },
    epworthWeight: function epworthWeight() {
      return this.$store.state.screener[_symbols2.default.state.screenerWeights].epworth;
    },
    contactData: function contactData() {
      return this.$store.state.screener[_symbols2.default.state.contactData];
    },
    riskLevel: function riskLevel() {
      return this.$store.getters[_symbols2.default.getters.calculateRisk];
    },
    riskLevelImage: function riskLevelImage() {
      var images = {
        low: _screenerLow_risk2.default,
        moderate: _screenerModerate_risk2.default,
        high: _screenerHigh_risk2.default,
        severe: _screenerSevere_risk2.default
      };
      var riskLevel = this.$store.getters[_symbols2.default.getters.calculateRisk];
      if (images.hasOwnProperty(riskLevel)) {
        return images[riskLevel];
      }
      return _screenerLow_risk2.default;
    }
  },
  components: {
    'health-assessment': _HealthAssessment2.default
  },
  created: function created() {
    if (!this.$store.state.screener[_symbols2.default.state.epworthProps.length]) {
      this.$store.dispatch(_symbols2.default.actions.setEpworthProps);
    }
  },

  methods: {
    showResults: function showResults() {
      this.resultsShown = true;
    },
    openFancybox: function openFancybox() {
      this.$store.commit(_symbols2.default.mutations.showFancybox);
    }
  }
};

/***/ }),
/* 596 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('form',{staticClass:"formEl_a screener"},[_c('div',{staticClass:"sect",attrs:{"id":"sectdoctor"}},[_c('health-assessment'),_vm._v(" "),_c('h3',{staticClass:"sepH_a"},[_vm._v("Dental Sleep Solutions - Summary of Results")]),_vm._v(" "),_c('p',[_vm._v("Please choose from the options below. You may view the patient results, finish this screener and allow a new patient to be screened, or request a Home Sleep Test for the patient by clicking the buttons below.")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{attrs:{"id":"risk_image_doc"}},[_c('img',{attrs:{"src":_vm.riskLevelImage,"alt":_vm.riskLevel + ' risk',"title":_vm.riskLevel + ' risk'}})]),_vm._v(" "),_c('a',{staticClass:"fl next btn btn_medium btn_d",attrs:{"href":"#results","id":"sect_results_next"},on:{"click":function($event){_vm.showResults()}}},[_vm._v("View Results")]),_vm._v(" "),_c('router-link',{staticClass:"fr next btn btn_medium btn_d",staticStyle:{"margin-left":"20px"},attrs:{"to":{ name: 'screener-hst' },"id":"sect6_next"}},[_vm._v("Request HST (Doctor Only) »")]),_vm._v(" "),_c('a',{staticClass:"fr next btn btn_medium btn_d",attrs:{"rel":"fancyReg","href":"#","id":"fancy-reg"},on:{"click":function($event){$event.preventDefault();_vm.openFancybox()}}},[_vm._v("Finish/Screen New Patient")]),_vm._v(" "),_c('a',{attrs:{"name":"results"}}),_vm._v(" "),_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.resultsShown),expression:"resultsShown"}],staticStyle:{"clear":"both"},attrs:{"id":"results_div"}},[_c('h4',[_vm._v("Results")]),_vm._v(" "),_c('div',{staticStyle:{"width":"58%","float":"left"}},[_vm._l((_vm.contactData),function(contact){return (contact.value)?_c('div',{staticClass:"check contact_div"},[_c('label',[_vm._v(_vm._s(contact.resultLabel)+":")]),_vm._v(" "),_c('span',{attrs:{"id":'r_' + contact.name}},[_vm._v(_vm._s(contact.value))])]):_vm._e()}),_vm._v(" "),_vm._m(0),_vm._v(" "),_c('div',[_c('span',{attrs:{"id":"r_ep_total"}},[_vm._v(_vm._s(_vm.epworthWeight))]),_vm._v(" -\n                    "),_c('label',[_vm._v("Epworth Sleepiness Scale Total")])]),_vm._v(" "),_vm._l((_vm.epworthProps),function(element){return (element.selected)?_c('div',{staticClass:"check epworth_div"},[_c('span',{attrs:{"id":'r_epworth_' + element.id}},[_vm._v(_vm._s(element.selected))]),_vm._v(" -\n                    "),_c('label',[_vm._v(_vm._s(element.epworth))])]):_vm._e()})],2),_vm._v(" "),_c('div',{staticStyle:{"width":"38%","float":"left"}},[_vm._m(1),_vm._v(" "),_vm._l((_vm.symptoms),function(symptom){return (parseInt(symptom.selected))?_c('div',{staticClass:"check symptom_div"},[_c('span',{attrs:{"id":'r_' + symptom.name}},[_vm._v("Yes")]),_vm._v(" "),_c('label',[_vm._v(_vm._s(symptom.label))])]):_vm._e()}),_vm._v(" "),_c('div',{staticClass:"check cpap_div"},[_c('span',{attrs:{"id":"r_rx_cpap"}},[_vm._v(_vm._s(parseInt(_vm.cpap.selected) ? 'Yes' : 'No'))]),_vm._v(" "),_c('label',[_vm._v(_vm._s(_vm.cpap.label))])]),_vm._v(" "),_c('br'),_vm._v(" "),_vm._m(2),_vm._v(" "),_c('div',[_c('label',[_vm._v("Please check any conditions for which you have been medically diagnosed or treated.")]),_vm._v(" "),_c('ul',{attrs:{"id":"r_diagnosed"}},_vm._l((_vm.coMorbidityData),function(coMorbidity){return (coMorbidity.checked)?_c('li',[_vm._v(_vm._s(coMorbidity.label))]):_vm._e()}))])],2)])],1)])}
var staticRenderFns = [function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('strong',[_vm._v("Epworth Sleepiness Scale")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('strong',[_vm._v("Health Symptoms")])])},function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',[_c('strong',[_vm._v("Co-morbidity")])])}]
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 597 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerHst_js__ = __webpack_require__(598);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerHst_js___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerHst_js__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_104a018a_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerHst_vue__ = __webpack_require__(599);
var normalizeComponent = __webpack_require__(2)
/* script */
/* template */

/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __WEBPACK_IMPORTED_MODULE_0__babel_loader_ScreenerHst_js___default.a,
  __WEBPACK_IMPORTED_MODULE_1__node_modules_vue_loader_lib_template_compiler_index_id_data_v_104a018a_hasScoped_false_node_modules_vue_loader_lib_selector_type_template_index_0_ScreenerHst_vue__["a" /* default */],
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)

/* harmony default export */ __webpack_exports__["default"] = (Component.exports);


/***/ }),
/* 598 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _HealthAssessment = __webpack_require__(26);

var _HealthAssessment2 = _interopRequireDefault(_HealthAssessment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  data: function data() {
    return {
      contactData: this.$store.state.screener[_symbols2.default.state.contactData],
      currentCompanyId: 0,
      storedContacts: {}
    };
  },
  computed: {
    companies: function companies() {
      return this.$store.state.screener[_symbols2.default.state.companyData];
    }
  },
  components: {
    'health-assessment': _HealthAssessment2.default
  },
  created: function created() {
    this.$store.dispatch(_symbols2.default.actions.getCompanyData);
  },

  methods: {
    updateCompany: function updateCompany(event) {
      this.currentCompanyId = event.target.value;
    },
    updateContact: function updateContact(event) {
      var contactName = event.target.id.replace('hst_', '');
      this.storedContacts[contactName] = event.target.value;
    },
    onSubmit: function onSubmit() {
      var _this = this;

      this.$store.commit(_symbols2.default.mutations.contactData, this.storedContacts);

      var hasMissingField = false;
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = (0, _getIterator3.default)(this.contactData), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          var nameField = _step.value;

          if (nameField.value === '') {
            hasMissingField = true;
          }
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }

      if (hasMissingField || !this.currentCompanyId) {
        alert('All fields are required.');
        return;
      }

      var payload = {
        companyId: this.currentCompanyId,
        contactData: this.contactData
      };
      this.$store.dispatch(_symbols2.default.actions.submitHst, payload).then(function () {
        alert('HST submitted for approval and is in your Pending HST queue.');
        _this.$store.commit(_symbols2.default.mutations.restoreInitialScreener);
        _this.$router.push({ name: 'screener-intro' });
      }).catch(function () {
        var alertText = 'There was an error communicating with the server, please try again in a few minutes';
        _Alerter2.default.alert(alertText);
      });
    }
  }
};

/***/ }),
/* 599 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"sect",attrs:{"id":"secthst"}},[_c('form',{staticClass:"formEl_a screener"},[_c('health-assessment'),_vm._v(" "),_c('h3',{staticClass:"sepH_a"},[_vm._v("Dental Sleep Solutions - Home Sleep Test Request")]),_vm._v(" "),_c('p',[_vm._v("Please enter your contact information to request a home sleep test.")]),_vm._v(" "),_c('br'),_vm._v(" "),_c('div',{staticClass:"dp50",attrs:{"id":"hst_column_left"}},[_c('div',{staticClass:"sepH_b clear",attrs:{"id":"hst_company_id_div"}},[_c('label',{staticClass:"lbl_a"},[_vm._v("HST Company")]),_vm._v(" "),_vm._l((_vm.companies),function(company){return _c('div',{staticClass:"company_div"},[_c('br'),_vm._v(" "),_c('input',{attrs:{"type":"radio","id":'hst_company_id_' + company.id,"name":"hst_company_id"},domProps:{"value":company.id},on:{"click":function($event){_vm.updateCompany($event)}}}),_vm._v(" "),_c('label',{attrs:{"for":'hst_company_id_' + company.id}},[_vm._v(_vm._s(company.name))]),_vm._v(" "),_c('br'),_c('br')])})],2),_vm._v(" "),_vm._l((_vm.contactData),function(contact){return (contact.hstColumn === 'left')?_c('div',{staticClass:"sepH_b contact_div",attrs:{"id":'hst_' + contact.name + '_div'}},[_c('label',{staticClass:"lbl_a",attrs:{"for":'hst_' + contact.name}},[_vm._v(_vm._s(contact.label))]),_vm._v(" "),_c('input',{staticClass:"inpt_a",class:contact.class,attrs:{"type":"text","id":'hst_' + contact.name,"name":'hst_' + contact.name},domProps:{"value":contact.value},on:{"change":function($event){_vm.updateContact($event)}}})]):_vm._e()})],2),_vm._v(" "),_c('div',{staticClass:"dp50",attrs:{"id":"hst_column_right"}},_vm._l((_vm.contactData),function(contact){return (contact.hstColumn === 'right')?_c('div',{staticClass:"sepH_b contact_div",attrs:{"id":'hst_' + contact.name + '_div'}},[_c('label',{staticClass:"lbl_a",attrs:{"for":'hst_' + contact.name}},[_vm._v(_vm._s(contact.label))]),_vm._v(" "),_c('input',{staticClass:"inpt_a",class:contact.class,attrs:{"type":"text","id":'hst_' + contact.name,"name":'hst_' + contact.name},domProps:{"value":contact.value},on:{"change":function($event){_vm.updateContact($event)}}})]):_vm._e()})),_vm._v(" "),_c('a',{staticClass:"fr next btn btn_medium btn_d",attrs:{"href":"#","id":"sect7_next"},on:{"click":function($event){$event.preventDefault();_vm.onSubmit()}}},[_vm._v("Submit Request")])],1)])}
var staticRenderFns = []
var esExports = { render: render, staticRenderFns: staticRenderFns }
/* harmony default export */ __webpack_exports__["a"] = (esExports);

/***/ }),
/* 600 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _vue = __webpack_require__(28);

var _vue2 = _interopRequireDefault(_vue);

var _vuex = __webpack_require__(55);

var _vuex2 = _interopRequireDefault(_vuex);

var _main = __webpack_require__(601);

var _main2 = _interopRequireDefault(_main);

var _dashboard = __webpack_require__(632);

var _dashboard2 = _interopRequireDefault(_dashboard);

var _contacts = __webpack_require__(647);

var _contacts2 = _interopRequireDefault(_contacts);

var _patients = __webpack_require__(648);

var _patients2 = _interopRequireDefault(_patients);

var _screener = __webpack_require__(653);

var _screener2 = _interopRequireDefault(_screener);

var _tasks = __webpack_require__(659);

var _tasks2 = _interopRequireDefault(_tasks);

var _flowsheet = __webpack_require__(664);

var _flowsheet2 = _interopRequireDefault(_flowsheet);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

_vue2.default.use(_vuex2.default);

var modules = {
  main: _main2.default,
  contacts: _contacts2.default,
  dashboard: _dashboard2.default,
  flowsheet: _flowsheet2.default,
  patients: _patients2.default,
  screener: _screener2.default,
  tasks: _tasks2.default
};

exports.default = new _vuex2.default.Store({ modules: modules });

/***/ }),
/* 601 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _state = __webpack_require__(602);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(603);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(604);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(605);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: _state2.default,
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 602 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$notifi, _symbols$state$mainTo;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$mainTo = {}, (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.mainToken, ''), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.modal, {
  name: '',
  params: {}
}), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.popupEdit, false), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.docInfo, {
  homepage: 0,
  manageStaff: 0,
  useEligibleApi: 0,
  useLetters: 0,
  usePatientPortal: 0
}), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.userInfo, {
  userId: '',
  plainUserId: 0,
  docId: 0,
  manageStaff: 0,
  userType: 0,
  useCourse: 0,
  username: ''
}), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.notificationNumbers, (_symbols$state$notifi = {}, (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.alerts, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.emailBounces, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.faxAlerts, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.hst, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.patientChanges, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.patientContacts, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.patientInsurances, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.patientNotifications, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.paymentReports, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.pendingClaims, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.pendingDuplicates, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.pendingLetters, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.preAuth, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.rejectedClaims, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.rejectedHst, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.rejectedPreAuth, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.requestedHst, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.unmailedClaims, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.unmailedLetters, 0), (0, _defineProperty3.default)(_symbols$state$notifi, _main.NOTIFICATION_NUMBERS.unsignedNotes, 0), _symbols$state$notifi)), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.companyLogo, ''), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.showSearchHints, false), (0, _defineProperty3.default)(_symbols$state$mainTo, _symbols2.default.state.patientSearchList, []), _symbols$state$mainTo);

/***/ }),
/* 603 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$getters$main;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$main = {}, (0, _defineProperty3.default)(_symbols$getters$main, _symbols2.default.getters.mainToken, function (state) {
  return state[_symbols2.default.state.mainToken];
}), (0, _defineProperty3.default)(_symbols$getters$main, _symbols2.default.getters.notificationsNumber, function (state) {
  var stateNumbers = state[_symbols2.default.state.notificationNumbers];
  var notificationsNumber = stateNumbers[_main.NOTIFICATION_NUMBERS.pendingLetters] + stateNumbers[_main.NOTIFICATION_NUMBERS.preAuth] + stateNumbers[_main.NOTIFICATION_NUMBERS.rejectedPreAuth] + stateNumbers[_main.NOTIFICATION_NUMBERS.patientContacts] + stateNumbers[_main.NOTIFICATION_NUMBERS.patientInsurances] + stateNumbers[_main.NOTIFICATION_NUMBERS.patientChanges] + stateNumbers[_main.NOTIFICATION_NUMBERS.emailBounces] + stateNumbers[_main.NOTIFICATION_NUMBERS.unsignedNotes] + stateNumbers[_main.NOTIFICATION_NUMBERS.pendingDuplicates] + stateNumbers[_main.NOTIFICATION_NUMBERS.pendingClaims];
  if (state[_symbols2.default.state.userInfo].userType === _main.DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
    notificationsNumber += stateNumbers[_main.NOTIFICATION_NUMBERS.unmailedClaims];
  }
  return notificationsNumber;
}), (0, _defineProperty3.default)(_symbols$getters$main, _symbols2.default.getters.isUserDoctor, function (state) {
  return state[_symbols2.default.state.userInfo].docId === state[_symbols2.default.state.userInfo].userId;
}), _symbols$getters$main);

/***/ }),
/* 604 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$mutations$ma;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$ma = {}, (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.mainToken, function (state, token) {
  state[_symbols2.default.state.mainToken] = token;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.popupEdit, function (state, _ref) {
  var value = _ref.value;

  state[_symbols2.default.state.popupEdit] = value;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.notificationNumbers, function (state, numbers) {
  var _state$symbols$state$;

  var patientContacts = parseInt(numbers.patient_contacts);
  var patientInsurances = parseInt(numbers.patient_insurances);
  var patientChanges = parseInt(numbers.patient_changes);
  var patientNotifications = patientContacts + patientInsurances + patientChanges;
  state[_symbols2.default.state.notificationNumbers] = (_state$symbols$state$ = {}, (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.pendingClaims, parseInt(numbers.pending_claims)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.paymentReports, parseInt(numbers.payment_reports)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.unmailedClaims, parseInt(numbers.unmailed_claims)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.unmailedLetters, parseInt(numbers.unmailed_letters)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.rejectedClaims, parseInt(numbers.rejected_claims)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.preAuth, parseInt(numbers.completed_preauth)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.pendingPreAuth, parseInt(numbers.pending_preauth)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.rejectedPreAuth, parseInt(numbers.rejected_preauth)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.supportTickets, parseInt(numbers.support_tickets)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.faxAlerts, parseInt(numbers.fax_alerts)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.unsignedNotes, parseInt(numbers.unsigned_notes)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.emailBounces, parseInt(numbers.email_bounces)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.pendingDuplicates, parseInt(numbers.pending_duplicates)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.hst, parseInt(numbers.completed_hst)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.requestedHst, parseInt(numbers.requested_hst)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.rejectedHst, parseInt(numbers.rejected_hst)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.pendingLetters, parseInt(numbers.pending_letters)), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.patientContacts, patientContacts), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.patientInsurances, patientInsurances), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.patientChanges, patientChanges), (0, _defineProperty3.default)(_state$symbols$state$, _main.NOTIFICATION_NUMBERS.patientNotifications, patientNotifications), _state$symbols$state$);
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.docInfo, function (state, docInfo) {
  state[_symbols2.default.state.docInfo] = docInfo;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.userInfo, function (state, userInfo) {
  state[_symbols2.default.state.userInfo] = userInfo;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.patientSearchList, function (state, data) {
  state[_symbols2.default.state.patientSearchList] = data;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.modal, function (state, payload) {
  var componentName = payload.name;
  var params = {};
  if (payload.hasOwnProperty('params')) {
    params = payload.params;
  }
  state[_symbols2.default.state.modal] = {
    name: componentName,
    params: params
  };
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.resetModal, function (state) {
  state[_symbols2.default.state.modal] = {
    name: '',
    params: {}
  };
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.companyLogo, function (state, image) {
  state[_symbols2.default.state.companyLogo] = image;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.showSearchHints, function (state) {
  state[_symbols2.default.state.showSearchHints] = true;
}), (0, _defineProperty3.default)(_symbols$mutations$ma, _symbols2.default.mutations.hideSearchHints, function (state) {
  state[_symbols2.default.state.showSearchHints] = false;
}), _symbols$mutations$ma);

/***/ }),
/* 605 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _promise = __webpack_require__(32);

var _promise2 = _interopRequireDefault(_promise);

var _symbols$actions$main;

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _LocalStorageManager = __webpack_require__(59);

var _LocalStorageManager2 = _interopRequireDefault(_LocalStorageManager);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

var _RouterKeeper = __webpack_require__(72);

var _RouterKeeper2 = _interopRequireDefault(_RouterKeeper);

var _MediaFileRetriever = __webpack_require__(606);

var _MediaFileRetriever2 = _interopRequireDefault(_MediaFileRetriever);

var _FileRetrievalError = __webpack_require__(607);

var _FileRetrievalError2 = _interopRequireDefault(_FileRetrievalError);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

var _NameComposer = __webpack_require__(629);

var _NameComposer2 = _interopRequireDefault(_NameComposer);

var _LoginError = __webpack_require__(631);

var _LoginError2 = _interopRequireDefault(_LoginError);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$main = {}, (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.mainLogin, function (_ref, credentials) {
  var dispatch = _ref.dispatch;

  return new _promise2.default(function (resolve, reject) {
    _axios2.default.post(_ProcessWrapper2.default.getApiRoot() + 'auth', credentials).then(function (response) {
      var data = response.data;
      return dispatch(_symbols2.default.actions.dualAppLogin, data.token);
    }).then(function () {
      resolve();
    }).catch(function (response) {
      var reason = '';
      if (response.hasOwnProperty('response') && response.response.hasOwnProperty('status') && response.response.status === 403) {
        reason = 'Username or password not found. This account may be inactive.';
      }
      dispatch(_symbols2.default.actions.handleErrors, { title: 'getToken', response: response });
      reject(new Error(reason));
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.dualAppLogin, function (_ref2, token) {
  var commit = _ref2.commit,
      dispatch = _ref2.dispatch;

  _http2.default.token = token;
  return _http2.default.post(_endpoints2.default.users.check).then(function (response) {
    var data = response.data.data;
    if (data.type.toLowerCase() === 'suspended') {
      commit(_symbols2.default.mutations.mainToken, '');
      _http2.default.token = '';
      throw new _LoginError2.default('This account has been suspended.');
    }
    commit(_symbols2.default.mutations.mainToken, token);
    _http2.default.token = token;
    dispatch(_symbols2.default.actions.userInfo);
  }).catch(function (response) {
    commit(_symbols2.default.mutations.mainToken, '');
    var reason = '';
    if (response.hasOwnProperty('status') && response.status === 422) {
      reason = 'Bad token';
    }
    if (response instanceof _LoginError2.default) {
      reason = response.response;
    }
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getUserByToken', response: response });
    throw new Error(reason);
  });
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.userInfo, function (_ref3) {
  var state = _ref3.state,
      commit = _ref3.commit,
      dispatch = _ref3.dispatch;

  _http2.default.token = state[_symbols2.default.state.mainToken];
  return _http2.default.request('get', _endpoints2.default.users.current).then(function (response) {
    var data = response.data.data;
    var userInfo = {
      userId: data.id,
      plainUserId: parseInt(data.userid),
      docId: parseInt(data.docid),
      manageStaff: parseInt(data.manage_staff),
      userType: parseInt(data.user_type),
      useCourse: parseInt(data.use_course),
      username: data.username
    };
    var docInfo = {
      homepage: parseInt(data.doc_info.homepage),
      manageStaff: parseInt(data.doc_info.manage_staff),
      useEligibleApi: parseInt(data.doc_info.use_eligible_api),
      useLetters: parseInt(data.doc_info.use_letters),
      usePatientPortal: parseInt(data.doc_info.use_patient_portal),
      usePaymentReports: parseInt(data.doc_info.use_payment_reports),
      useCourseStaff: parseInt(data.doc_info.use_course_staff)
    };
    commit(_symbols2.default.mutations.userInfo, userInfo);
    commit(_symbols2.default.mutations.docInfo, docInfo);
    commit(_symbols2.default.mutations.notificationNumbers, data.numbers);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getCurrentUser', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.disablePopupEdit, function (_ref4) {
  var commit = _ref4.commit;

  commit(_symbols2.default.mutations.popupEdit, {
    value: false
  });
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.handleErrors, function (data, _ref5) {
  var title = _ref5.title,
      response = _ref5.response;

  if (response.status === 401) {
    _LocalStorageManager2.default.remove('token');
    var router = _RouterKeeper2.default.getRouter();
    router.push('/manage/login');
    return;
  }
  if (_ProcessWrapper2.default.getNodeEnv() === 'development') {
    if (response.hasOwnProperty('status')) {
      console.error(title + ' [status]: ' + response.status);
    } else {
      console.error(title);
    }
  } else {}
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.companyLogo, function (_ref6) {
  var state = _ref6.state,
      commit = _ref6.commit,
      dispatch = _ref6.dispatch;

  _http2.default.token = state[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.companies.companyByUser).then(function (response) {
    var data = response.data.data;
    if (data.hasOwnProperty('logo') && data.logo) {
      _MediaFileRetriever2.default.getMediaFile(data.logo).then(function (image) {
        commit(_symbols2.default.mutations.companyLogo, image);
      });
    }
  }).catch(function (response) {
    var title = 'getCompanyByUser';
    if (response instanceof _FileRetrievalError2.default) {
      title = response.title;
    }
    dispatch(_symbols2.default.actions.handleErrors, { title: title, response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$main, _symbols2.default.actions.patientSearchList, function (_ref7, searchTerm) {
  var state = _ref7.state,
      commit = _ref7.commit;

  var legacyUrl = _ProcessWrapper2.default.getLegacyRoot();
  _http2.default.token = state[_symbols2.default.state.mainToken];
  var queryData = {
    partial_name: searchTerm
  };
  _http2.default.post(_endpoints2.default.patients.list, queryData).then(function (response) {
    var data = response.data.data;
    if (data.length === 0) {
      var noMatchesElement = {
        id: 0,
        name: 'No Matches',
        patientType: 'no',
        link: ''
      };


      var newElement = {
        id: 0,
        name: 'Add patient with this name\u2026',
        patientType: 'new',
        link: legacyUrl + 'add_patient.php?search=' + searchTerm
      };
      var _newList = [noMatchesElement, newElement];
      commit(_symbols2.default.mutations.patientSearchList, _newList);

      return;
    }

    var newList = [];
    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
      for (var _iterator = (0, _getIterator3.default)(data), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
        var element = _step.value;

        var fullName = _NameComposer2.default.composeName(element);
        var link = 'manage/add_patient.php?pid=' + element.patientid + '&ed=' + element.patientid;
        if (element.patientInfo === 1) {
          link = 'manage/manage_flowsheet3.php?pid=' + element.patientid;
        }
        var patientElement = {
          id: element.patientid,
          name: fullName,
          patientType: 'json',
          link: legacyUrl + link
        };
        newList.push(patientElement);
      }
    } catch (err) {
      _didIteratorError = true;
      _iteratorError = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion && _iterator.return) {
          _iterator.return();
        }
      } finally {
        if (_didIteratorError) {
          throw _iteratorError;
        }
      }
    }

    commit(_symbols2.default.mutations.patientSearchList, newList);
  }).catch(function () {
    var alertText = 'Could not select patient from database';
    _Alerter2.default.alert(alertText);
  });
}), _symbols$actions$main);

/***/ }),
/* 606 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = {
  getMediaFile: function getMediaFile() {}
};

/***/ }),
/* 607 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getPrototypeOf = __webpack_require__(65);

var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);

var _classCallCheck2 = __webpack_require__(66);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _possibleConstructorReturn2 = __webpack_require__(67);

var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

var _inherits2 = __webpack_require__(70);

var _inherits3 = _interopRequireDefault(_inherits2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var FileRetrievalError = function (_Error) {
  (0, _inherits3.default)(FileRetrievalError, _Error);

  function FileRetrievalError(response) {
    (0, _classCallCheck3.default)(this, FileRetrievalError);

    var _this = (0, _possibleConstructorReturn3.default)(this, (FileRetrievalError.__proto__ || (0, _getPrototypeOf2.default)(FileRetrievalError)).call(this));

    _this.title = 'getFileForDisplaying';
    _this.response = response;
    Error.captureStackTrace(_this, FileRetrievalError);
    return _this;
  }

  return FileRetrievalError;
}(Error);

exports.default = FileRetrievalError;

/***/ }),
/* 608 */,
/* 609 */,
/* 610 */,
/* 611 */,
/* 612 */,
/* 613 */,
/* 614 */,
/* 615 */,
/* 616 */,
/* 617 */,
/* 618 */,
/* 619 */,
/* 620 */,
/* 621 */,
/* 622 */,
/* 623 */,
/* 624 */,
/* 625 */,
/* 626 */,
/* 627 */,
/* 628 */,
/* 629 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _GeneralError = __webpack_require__(630);

var _GeneralError2 = _interopRequireDefault(_GeneralError);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  composeName: function composeName(element) {
    if (!element.hasOwnProperty('firstname') || !element.hasOwnProperty('lastname')) {
      throw new _GeneralError2.default('Element must have firstname and lastname properties');
    }
    var fullName = element.lastname + ', ' + element.firstname;
    if (element.hasOwnProperty('middlename') && element.middlename) {
      fullName += ' ' + element.middlename;
    }
    return fullName;
  }
};

/***/ }),
/* 630 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getPrototypeOf = __webpack_require__(65);

var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);

var _classCallCheck2 = __webpack_require__(66);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _possibleConstructorReturn2 = __webpack_require__(67);

var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

var _inherits2 = __webpack_require__(70);

var _inherits3 = _interopRequireDefault(_inherits2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var GeneralError = function (_Error) {
  (0, _inherits3.default)(GeneralError, _Error);

  function GeneralError() {
    (0, _classCallCheck3.default)(this, GeneralError);

    var _this = (0, _possibleConstructorReturn3.default)(this, (GeneralError.__proto__ || (0, _getPrototypeOf2.default)(GeneralError)).call(this));

    Error.captureStackTrace(_this, GeneralError);
    return _this;
  }

  return GeneralError;
}(Error);

exports.default = GeneralError;

/***/ }),
/* 631 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _getPrototypeOf = __webpack_require__(65);

var _getPrototypeOf2 = _interopRequireDefault(_getPrototypeOf);

var _classCallCheck2 = __webpack_require__(66);

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _possibleConstructorReturn2 = __webpack_require__(67);

var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

var _inherits2 = __webpack_require__(70);

var _inherits3 = _interopRequireDefault(_inherits2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var LoginError = function (_Error) {
  (0, _inherits3.default)(LoginError, _Error);

  function LoginError(response) {
    (0, _classCallCheck3.default)(this, LoginError);

    var _this = (0, _possibleConstructorReturn3.default)(this, (LoginError.__proto__ || (0, _getPrototypeOf2.default)(LoginError)).call(this));

    _this.response = response;
    Error.captureStackTrace(_this, LoginError);
    return _this;
  }

  return LoginError;
}(Error);

exports.default = LoginError;

/***/ }),
/* 632 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _state = __webpack_require__(633);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(634);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(635);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(636);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: _state2.default,
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 633 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$docume;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$docume = {}, (0, _defineProperty3.default)(_symbols$state$docume, _symbols2.default.state.documentCategories, []), (0, _defineProperty3.default)(_symbols$state$docume, _symbols2.default.state.memos, []), (0, _defineProperty3.default)(_symbols$state$docume, _symbols2.default.state.deviceGuideSettingOptions, []), (0, _defineProperty3.default)(_symbols$state$docume, _symbols2.default.state.deviceGuideResults, []), _symbols$state$docume);

/***/ }),
/* 634 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$getters$docu;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$docu = {}, (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.documentCategories, function (state) {
  return state[_symbols2.default.state.documentCategories];
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowEnrollments, function (state, getters, rootState) {
  var useEligible = rootState.main[_symbols2.default.state.docInfo].useEligibleApi;
  if (useEligible === 1) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowInvoices, function (state, getters, rootState) {
  var userId = rootState.main[_symbols2.default.state.userInfo].plainUserId;
  var docId = rootState.main[_symbols2.default.state.userInfo].docId;
  if (userId === docId) {
    return true;
  }
  var manageStaff = rootState.main[_symbols2.default.state.docInfo].manageStaff;
  if (manageStaff) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowGetCE, function (state, getters, rootState) {
  var useCourse = rootState.main[_symbols2.default.state.userInfo].useCourse;
  var useCourseStaff = rootState.main[_symbols2.default.state.docInfo].useCourseStaff;
  if (useCourse !== 1) {
    return false;
  }
  if (useCourseStaff !== 1) {
    return false;
  }
  return true;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowFranchiseManual, function (state, getters, rootState) {
  var userType = rootState.main[_symbols2.default.state.userInfo].userType;
  if (userType === _main.DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowTransactionCode, function (state, getters, rootState) {
  var userId = rootState.main[_symbols2.default.state.userInfo].plainUserId;
  var docId = rootState.main[_symbols2.default.state.userInfo].docId;
  if (userId === docId) {
    return true;
  }
  var manageStaff = rootState.main[_symbols2.default.state.userInfo].manageStaff;
  if (manageStaff) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowUnmailedClaims, function (state, getters, rootState) {
  if (rootState.main[_symbols2.default.state.userInfo].userType === _main.DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowUnmailedLettersNumber, function (state, getters, rootState) {
  if (rootState.main[_symbols2.default.state.userInfo].userType !== _main.DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
    return false;
  }
  if (!rootState.main[_symbols2.default.state.docInfo].useLetters) {
    return false;
  }
  return true;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowPaymentReportsNumber, function (state, getters, rootState) {
  return !!rootState.main[_symbols2.default.state.docInfo].usePaymentReports;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldShowRejectedPreauthNumber, function (state, getters, rootState) {
  var rejectedNumber = rootState.main[_symbols2.default.state.notificationNumbers][_main.NOTIFICATION_NUMBERS.rejectedPreAuth];
  return !!rejectedNumber;
}), (0, _defineProperty3.default)(_symbols$getters$docu, _symbols2.default.getters.shouldUseLetters, function (state, getters, rootState) {
  if (rootState.main[_symbols2.default.state.docInfo].useLetters === 1) {
    return true;
  }
  return false;
}), _symbols$getters$docu);

/***/ }),
/* 635 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$mutations$do;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$do = {}, (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.documentCategories, function (state, data) {
  var categories = [];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(data), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var element = _step.value;

      categories.push({
        id: element.categoryid,
        name: element.name
      });
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  state[_symbols2.default.state.documentCategories] = categories;
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.memos, function (state, data) {
  state[_symbols2.default.state.memos] = data;
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.deviceGuideResults, function (state, data) {
  state[_symbols2.default.state.deviceGuideResults] = data;
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.deviceGuideSettingOptions, function (state, data) {
  var options = [];
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(data), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var element = _step2.value;

      var newOption = {
        id: parseInt(element.id),
        name: element.name,
        labels: element.labels,
        checkedOption: 0,
        checked: false
      };
      options.push(newOption);
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  state[_symbols2.default.state.deviceGuideSettingOptions] = options;
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.resetDeviceGuideSettingOptions, function (state) {
  var options = [];
  var _iteratorNormalCompletion3 = true;
  var _didIteratorError3 = false;
  var _iteratorError3 = undefined;

  try {
    for (var _iterator3 = (0, _getIterator3.default)(state[_symbols2.default.state.deviceGuideSettingOptions]), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
      var element = _step3.value;

      element.checkedOption = 0;
      element.checked = false;
      options.push(element);
    }
  } catch (err) {
    _didIteratorError3 = true;
    _iteratorError3 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion3 && _iterator3.return) {
        _iterator3.return();
      }
    } finally {
      if (_didIteratorError3) {
        throw _iteratorError3;
      }
    }
  }

  state[_symbols2.default.state.deviceGuideSettingOptions] = options;
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.checkGuideSetting, function (state, _ref) {
  var id = _ref.id,
      isChecked = _ref.isChecked;
  var _iteratorNormalCompletion4 = true;
  var _didIteratorError4 = false;
  var _iteratorError4 = undefined;

  try {
    for (var _iterator4 = (0, _getIterator3.default)(state[_symbols2.default.state.deviceGuideSettingOptions]), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
      var setting = _step4.value;

      if (id === setting.id) {
        setting.checked = isChecked;
        return;
      }
    }
  } catch (err) {
    _didIteratorError4 = true;
    _iteratorError4 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion4 && _iterator4.return) {
        _iterator4.return();
      }
    } finally {
      if (_didIteratorError4) {
        throw _iteratorError4;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$do, _symbols2.default.mutations.moveGuideSettingSlider, function (state, _ref2) {
  var id = _ref2.id,
      value = _ref2.value;
  var _iteratorNormalCompletion5 = true;
  var _didIteratorError5 = false;
  var _iteratorError5 = undefined;

  try {
    for (var _iterator5 = (0, _getIterator3.default)(state[_symbols2.default.state.deviceGuideSettingOptions]), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
      var setting = _step5.value;

      if (id === setting.id) {
        setting.checkedOption = value;
        return;
      }
    }
  } catch (err) {
    _didIteratorError5 = true;
    _iteratorError5 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion5 && _iterator5.return) {
        _iterator5.return();
      }
    } finally {
      if (_didIteratorError5) {
        throw _iteratorError5;
      }
    }
  }
}), _symbols$mutations$do);

/***/ }),
/* 636 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _slicedToArray2 = __webpack_require__(637);

var _slicedToArray3 = _interopRequireDefault(_slicedToArray2);

var _entries = __webpack_require__(641);

var _entries2 = _interopRequireDefault(_entries);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$actions$docu;

var _qs = __webpack_require__(227);

var _qs2 = _interopRequireDefault(_qs);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _LocationWrapper = __webpack_require__(60);

var _LocationWrapper2 = _interopRequireDefault(_LocationWrapper);

var _SwalWrapper = __webpack_require__(96);

var _SwalWrapper2 = _interopRequireDefault(_SwalWrapper);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$docu = {}, (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.documentCategories, function (_ref) {
  var rootState = _ref.rootState,
      commit = _ref.commit,
      dispatch = _ref.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.post(_endpoints2.default.documentCategories.active).then(function (response) {
    commit(_symbols2.default.mutations.documentCategories, response.data.data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getDocumentCategories', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.deviceSelectorModal, function (_ref2) {
  var commit = _ref2.commit;

  commit(_symbols2.default.mutations.modal, { name: 'deviceSelector', params: { white: true } });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.exportMDModal, function () {
  _SwalWrapper2.default.callSwal({
    title: '',
    text: 'Enter your password',
    type: 'input',
    inputType: 'password',
    showCancelButton: true,
    closeOnConfirm: false,
    animation: 'slide-from-top',
    inputPlaceholder: 'Enter password'
  }, function (inputValue) {
    var goodPassword = '1234';
    if (inputValue === goodPassword) {
      _SwalWrapper2.default.close();
      _LocationWrapper2.default.goToPage(_ProcessWrapper2.default.getLegacyRoot() + 'manage/export_md.php');
      return true;
    }
    if (inputValue.length > 0) {
      _SwalWrapper2.default.callSwal({
        title: 'Oops...',
        text: 'Wrong password!',
        type: 'error'
      });
      return false;
    }
    var errorText = 'You need to write the password!';
    _SwalWrapper2.default.showInputError(errorText);
    return false;
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.dataImportModal, function () {
  _SwalWrapper2.default.callSwal({
    title: '',
    text: 'Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3CB371',
    confirmButtonText: 'Ok',
    cancelButtonText: 'Cancel',
    closeOnConfirm: true,
    closeOnCancel: true
  }, function (isConfirm) {
    if (isConfirm) {
      _LocationWrapper2.default.goToPage(_ProcessWrapper2.default.getLegacyRoot() + 'manage/data_import.php');
    }
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.memos, function (_ref3) {
  var rootState = _ref3.rootState,
      commit = _ref3.commit,
      dispatch = _ref3.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.post(_endpoints2.default.memos.current).then(function (response) {
    commit(_symbols2.default.mutations.memos, response.data.data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getCurrentMemos', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.getDeviceGuideSettingOptions, function (_ref4) {
  var rootState = _ref4.rootState,
      commit = _ref4.commit,
      dispatch = _ref4.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  return _http2.default.get(_endpoints2.default.guideSettingOptions.settingIds).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.deviceGuideSettingOptions, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getDeviceGuideSettingOptions', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.getDeviceGuideResults, function (_ref5) {
  var state = _ref5.state,
      rootState = _ref5.rootState,
      commit = _ref5.commit,
      dispatch = _ref5.dispatch;

  var impressions = {};
  var checkedOptions = {};
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(state[_symbols2.default.state.deviceGuideSettingOptions]), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var setting = _step.value;

      checkedOptions[setting.id] = setting.checkedOption + 1;
      impressions[setting.id] = 0;
      if (setting.checked) {
        impressions[setting.id] = 1;
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  var queryString = _qs2.default.stringify({
    impressions: impressions,
    options: checkedOptions
  });
  var endpoint = _endpoints2.default.guideDevices.withImages;
  if (queryString) {
    endpoint += '?' + queryString;
  }
  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(endpoint).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.deviceGuideResults, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getDeviceGuideResults', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.updateFlowDevice, function (_ref6, deviceId) {
  var commit = _ref6.commit,
      dispatch = _ref6.dispatch,
      rootState = _ref6.rootState;

  var data = {
    patient_id: rootState.patients[_symbols2.default.state.patientId]
  };
  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  return _http2.default.put(_endpoints2.default.tmjClinicalExams.updateFlowDevice + '/' + deviceId, data).then(function (response) {
    _Alerter2.default.alert(response.data.message);
    commit(_symbols2.default.mutations.resetModal);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'updateFlowDevice', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$docu, _symbols2.default.actions.moveGuideSettingSlider, function (_ref7, _ref8) {
  var commit = _ref7.commit;
  var id = _ref8.id,
      value = _ref8.value,
      labels = _ref8.labels;

  var optionId = 0;
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)((0, _entries2.default)(labels)), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var _step2$value = (0, _slicedToArray3.default)(_step2.value, 2),
          key = _step2$value[0],
          label = _step2$value[1];

      if (value === label) {
        optionId = parseInt(key);
        break;
      }
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  var data = {
    id: id,
    value: optionId
  };
  commit(_symbols2.default.mutations.moveGuideSettingSlider, data);
}), _symbols$actions$docu);

/***/ }),
/* 637 */,
/* 638 */,
/* 639 */,
/* 640 */,
/* 641 */,
/* 642 */,
/* 643 */,
/* 644 */,
/* 645 */,
/* 646 */,
/* 647 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _main = __webpack_require__(6);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: (0, _defineProperty3.default)({}, _symbols2.default.state.contact, {
    contactid: 0,
    phone1: '',
    phone2: '',
    fax: ''
  }),
  getters: (0, _defineProperty3.default)({}, _symbols2.default.getters.filteredContact, function (state) {
    var contact = state[_symbols2.default.state.contact];
    _main.PHONE_FIELDS.forEach(function (el) {
      if (contact.hasOwnProperty(el)) {
        contact[el] = contact[el].replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
      }
    });

    return contact;
  }),
  mutations: (0, _defineProperty3.default)({}, _symbols2.default.mutations.setContact, function (state, _ref) {
    var data = _ref.data;

    state[_symbols2.default.state.contact] = data;
  }),
  actions: (0, _defineProperty3.default)({}, _symbols2.default.actions.setCurrentContact, function (_ref2, payload) {
    var commit = _ref2.commit,
        dispatch = _ref2.dispatch;

    var requestData = { contact_id: payload.contactId };

    _http2.default.post(_endpoints2.default.contacts.withContactType, requestData).then(function (response) {
      var data = response.data.data;

      if (data) {
        commit(_symbols2.default.mutations.setContact, { data: data });
      }

      dispatch(_symbols2.default.actions.disablePopupEdit);
    }, function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'getContactById', response: response });
    });
  })
};

/***/ }),
/* 648 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _state = __webpack_require__(649);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(650);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(651);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(652);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: _state2.default,
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 649 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$showAl;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$showAl = {}, (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.showAllWarnings, true), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.patientId, 0), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.allergen, false), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.medicare, false), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.premedCheck, 0), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.patientName, ''), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.displayAlert, false), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.headerTitle, ''), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.headerAlertText, ''), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.questionnaireStatuses, {
  symptoms: 0,
  treatments: 0,
  history: 0
}), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.isEmailBounced, false), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.totalPatientContacts, 0), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.totalPatientInsurances, 0), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.totalSubPatients, 0), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.rejectedClaimsForCurrentPatient, []), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.patientHomeSleepTestStatus, ''), (0, _defineProperty3.default)(_symbols$state$showAl, _symbols2.default.state.incompleteHomeSleepTests, []), _symbols$state$showAl);

/***/ }),
/* 650 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$getters$pati;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$pati = {}, (0, _defineProperty3.default)(_symbols$getters$pati, _symbols2.default.getters.patientId, function (state) {
  return state[_symbols2.default.state.patientId];
}), (0, _defineProperty3.default)(_symbols$getters$pati, _symbols2.default.getters.showWarningAboutQuestionnaireChanges, function (state) {
  var correctStatus = 2;
  var questionnaireStatuses = state[_symbols2.default.state.questionnaireStatuses];
  if (questionnaireStatuses.symptoms === correctStatus) {
    return true;
  }
  if (questionnaireStatuses.treatments === correctStatus) {
    return true;
  }
  if (questionnaireStatuses.history === correctStatus) {
    return true;
  }
  return false;
}), (0, _defineProperty3.default)(_symbols$getters$pati, _symbols2.default.getters.showWarningAboutBouncedEmails, function (state) {
  return state[_symbols2.default.state.isEmailBounced];
}), (0, _defineProperty3.default)(_symbols$getters$pati, _symbols2.default.getters.showWarningAboutPatientChanges, function (state) {
  if (state[_symbols2.default.state.totalSubPatients]) {
    return true;
  }
  if (state[_symbols2.default.state.totalPatientContacts]) {
    return true;
  }
  if (state[_symbols2.default.state.totalPatientInsurances]) {
    return true;
  }
  return false;
}), _symbols$getters$pati);

/***/ }),
/* 651 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$mutations$pa;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _main = __webpack_require__(6);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$pa = {}, (0, _defineProperty3.default)(_symbols$mutations$pa, _symbols2.default.mutations.patientId, function (state, data) {
  state[_symbols2.default.state.patientId] = parseInt(data);
}), (0, _defineProperty3.default)(_symbols$mutations$pa, _symbols2.default.mutations.patientData, function (state, data) {
  var insuranceType = parseInt(data.insuranceType);
  var hasMedicare = false;
  if (insuranceType === 1) {
    hasMedicare = true;
  }
  var premedCheck = parseInt(data.preMedCheck);
  var allergen = !!parseInt(data.hasAllergen);
  var title = '';
  if (premedCheck) {
    title += 'Pre-medication: ' + data.preMed + '\n';
  }
  if (allergen) {
    title += 'Allergens: ' + data.otherAllergens + '\n';
  }
  var hstStatus = '';
  var dataStatus = parseInt(data.hstStatus);
  if (_main.HST_STATUSES.hasOwnProperty(dataStatus)) {
    hstStatus = _main.HST_STATUSES[dataStatus];
  }
  state[_symbols2.default.state.allergen] = allergen;
  state[_symbols2.default.state.medicare] = hasMedicare;
  state[_symbols2.default.state.premedCheck] = premedCheck;
  state[_symbols2.default.state.patientName] = data.firstName + ' ' + data.lastName;
  state[_symbols2.default.state.displayAlert] = !!parseInt(data.displayAlert);
  state[_symbols2.default.state.headerTitle] = title;
  state[_symbols2.default.state.headerAlertText] = data.alertText;
  state[_symbols2.default.state.questionnaireStatuses] = {
    symptoms: parseInt(data.questionnaireData.symptomsStatus),
    treatments: parseInt(data.questionnaireData.treatmentsStatus),
    history: parseInt(data.questionnaireData.historyStatus)
  };
  state[_symbols2.default.state.isEmailBounced] = !!parseInt(data.isEmailBounced);
  state[_symbols2.default.state.totalPatientContacts] = parseInt(data.patientContactsNumber);
  state[_symbols2.default.state.totalPatientInsurances] = parseInt(data.patientInsurancesNumber);
  state[_symbols2.default.state.totalSubPatients] = parseInt(data.subPatientsNumber);
  var parsedClaims = [];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(data.rejectedClaims), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var rejectedClaim = _step.value;

      var newClaim = {
        insuranceId: parseInt(rejectedClaim.insuranceid),
        addDate: new Date(rejectedClaim.adddate)
      };
      parsedClaims.push(newClaim);
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  state[_symbols2.default.state.rejectedClaimsForCurrentPatient] = parsedClaims;
  state[_symbols2.default.state.patientHomeSleepTestStatus] = hstStatus;
  var parsedHsts = [];
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(data.incompleteHomeSleepTests), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var incompleteHst = _step2.value;

      var newHst = {
        id: parseInt(incompleteHst.id),
        status: parseInt(incompleteHst.status),
        patientId: parseInt(incompleteHst.patient_id),
        addDate: new Date(incompleteHst.adddate),
        officeNotes: incompleteHst.office_notes,
        rejectedReason: incompleteHst.rejected_reason,
        rejectedDate: null
      };
      if (incompleteHst.rejecteddate) {
        newHst.rejectedDate = new Date(incompleteHst.rejecteddate);
      }
      parsedHsts.push(newHst);
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  state[_symbols2.default.state.incompleteHomeSleepTests] = parsedHsts;
}), (0, _defineProperty3.default)(_symbols$mutations$pa, _symbols2.default.mutations.clearPatientData, function (state) {
  state[_symbols2.default.state.allergen] = false;
  state[_symbols2.default.state.medicare] = false;
  state[_symbols2.default.state.premedCheck] = 0;
  state[_symbols2.default.state.patientName] = '';
  state[_symbols2.default.state.displayAlert] = false;
  state[_symbols2.default.state.headerTitle] = '';
  state[_symbols2.default.state.headerAlertText] = '';
  state[_symbols2.default.state.questionnaireStatuses] = {
    symptoms: 0,
    treatments: 0,
    history: 0
  };
  state[_symbols2.default.state.isEmailBounced] = false;
  state[_symbols2.default.state.totalPatientContacts] = 0;
  state[_symbols2.default.state.totalPatientInsurances] = 0;
  state[_symbols2.default.state.totalSubPatients] = 0;
  state[_symbols2.default.state.rejectedClaimsForCurrentPatient] = [];
  state[_symbols2.default.state.patientHomeSleepTestStatus] = '';
  state[_symbols2.default.state.incompleteHomeSleepTests] = [];
}), (0, _defineProperty3.default)(_symbols$mutations$pa, _symbols2.default.mutations.showAllWarnings, function (state) {
  state[_symbols2.default.state.showAllWarnings] = true;
}), (0, _defineProperty3.default)(_symbols$mutations$pa, _symbols2.default.mutations.hideAllWarnings, function (state) {
  state[_symbols2.default.state.showAllWarnings] = false;
}), _symbols$mutations$pa);

/***/ }),
/* 652 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$actions$pati;

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$pati = {}, (0, _defineProperty3.default)(_symbols$actions$pati, _symbols2.default.actions.patientData, function (_ref, patientId) {
  var rootState = _ref.rootState,
      commit = _ref.commit,
      dispatch = _ref.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.patients.patientData + '/' + patientId).then(function (response) {
    commit(_symbols2.default.mutations.patientId, patientId);
    var data = response.data.data;
    var patientData = {
      insuranceType: data.insurance_type,
      preMed: data.premed,
      preMedCheck: data.premedcheck,
      alertText: data.alert_text,
      displayAlert: data.display_alert,
      firstName: data.firstname,
      lastName: data.lastname,
      questionnaireData: {
        symptomsStatus: data.questionnaire_data.symptoms_status,
        treatmentsStatus: data.questionnaire_data.treatments_status,
        historyStatus: data.questionnaire_data.history_status
      },
      isEmailBounced: data.is_email_bounced,
      patientContactsNumber: data.patient_contacts_number,
      patientInsurancesNumber: data.patient_insurances_number,
      subPatientsNumber: data.sub_patients_number,
      rejectedClaims: data.rejected_claims,
      hasAllergen: data.has_allergen,
      otherAllergens: data.other_allergens,
      hstStatus: data.hst_status,
      incompleteHomeSleepTests: data.incomplete_hsts
    };
    commit(_symbols2.default.mutations.patientData, patientData);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getPatientByIdAndDocId', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$pati, _symbols2.default.actions.clearPatientData, function (_ref2) {
  var commit = _ref2.commit;

  commit(_symbols2.default.mutations.patientId, 0);
  commit(_symbols2.default.mutations.clearPatientData);
}), _symbols$actions$pati);

/***/ }),
/* 653 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _stringify = __webpack_require__(230);

var _stringify2 = _interopRequireDefault(_stringify);

var _state = __webpack_require__(231);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(656);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(657);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(658);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: JSON.parse((0, _stringify2.default)(_state2.default)),
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 654 */,
/* 655 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
var INITIAL_CONTACT_DATA = exports.INITIAL_CONTACT_DATA = [{
  name: 'first_name',
  camelName: 'firstName',
  label: 'First Name',
  resultLabel: 'First name',
  mask: '',
  firstPage: true,
  hstColumn: 'left',
  value: ''
}, {
  name: 'last_name',
  camelName: 'lastName',
  label: 'Last Name',
  resultLabel: 'Last name',
  mask: '',
  firstPage: true,
  hstColumn: 'left',
  value: ''
}, {
  name: 'dob',
  camelName: 'dob',
  label: 'Date of Birth',
  resultLabel: '',
  mask: '99/99/9999',
  firstPage: false,
  hstColumn: 'left',
  value: ''
}, {
  name: 'phone',
  camelName: 'phone',
  label: 'Phone Number',
  resultLabel: 'Phone',
  mask: '(999) 999-9999',
  firstPage: true,
  hstColumn: 'right',
  value: ''
}, {
  name: 'email',
  camelName: 'email',
  label: 'Email',
  resultLabel: '',
  mask: '',
  firstPage: false,
  hstColumn: 'right',
  value: ''
}];

var EPWORTH_OPTIONS = exports.EPWORTH_OPTIONS = [{
  option: '0',
  label: 'No chance of dozing'
}, {
  option: '1',
  label: 'Slight chance of dozing'
}, {
  option: '2',
  label: 'Moderate chance of dozing'
}, {
  option: '3',
  label: 'High chance of dozing'
}];

var INITIAL_SYMPTOMS = exports.INITIAL_SYMPTOMS = [{
  name: 'breathing',
  label: 'Have you ever been told you stop breathing while asleep?',
  weight: 8,
  selected: false
}, {
  name: 'driving',
  label: 'Have you ever fallen asleep or nodded off while driving?',
  weight: 6,
  selected: false
}, {
  name: 'gasping',
  label: 'Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?',
  weight: 6,
  selected: false
}, {
  name: 'sleepy',
  label: 'Do you feel excessively sleepy during the day?',
  weight: 4,
  selected: false
}, {
  name: 'snore',
  label: 'Do you snore or have you ever been told that you snore?',
  weight: 4,
  selected: false
}, {
  name: 'weight_gain',
  label: 'Have you had weight gain and found it difficult to lose?',
  weight: 2,
  selected: false
}, {
  name: 'blood_pressure',
  label: 'Have you taken medication for, or been diagnosed with high blood pressure?',
  weight: 2,
  selected: false
}, {
  name: 'jerk',
  label: 'Do you kick or jerk your legs while sleeping?',
  weight: 3,
  selected: false
}, {
  name: 'burning',
  label: 'Do you feel burning, tingling or crawling sensations in your legs when you wake up?',
  weight: 3,
  selected: false
}, {
  name: 'headaches',
  label: 'Do you wake up with headaches during the night or in the morning?',
  weight: 3,
  selected: false
}, {
  name: 'falling_asleep',
  label: 'Do you have trouble falling asleep?',
  weight: 4,
  selected: false
}, {
  name: 'staying_asleep',
  label: 'Do you have trouble staying asleep once you fall asleep?',
  weight: 4,
  selected: false
}];

var INITIAL_CO_MORBIDITY = exports.INITIAL_CO_MORBIDITY = [{
  name: 'rx_heart_disease',
  label: 'Heart Failure',
  weight: 2,
  checked: false
}, {
  name: 'rx_stroke',
  label: 'Stroke',
  weight: 2,
  checked: false
}, {
  name: 'rx_hypertension',
  label: 'Hypertension',
  weight: 1,
  checked: false
}, {
  name: 'rx_diabetes',
  label: 'Diabetes',
  weight: 1,
  checked: false
}, {
  name: 'rx_metabolic_syndrome',
  label: 'Metabolic Syndrome',
  weight: 1,
  checked: false
}, {
  name: 'rx_obesity',
  label: 'Obesity',
  weight: 2,
  checked: false
}, {
  name: 'rx_heartburn',
  label: 'Heartburn (Gastroesophageal Reflux)',
  weight: 1,
  checked: false
}, {
  name: 'rx_afib',
  label: 'Atrial Fibrillation',
  weight: 2,
  checked: false
}];

/***/ }),
/* 656 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$getters$full;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$full = {}, (0, _defineProperty3.default)(_symbols$getters$full, _symbols2.default.getters.fullName, function (state) {
  var contactData = state[_symbols2.default.state.contactData];
  var firstName = '';
  var lastName = '';
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(contactData), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var nameField = _step.value;

      if (nameField.camelName === 'firstName') {
        firstName = nameField.value;
      }
      if (nameField.camelName === 'lastName') {
        lastName = nameField.value;
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  return firstName + ' ' + lastName;
}), (0, _defineProperty3.default)(_symbols$getters$full, _symbols2.default.getters.calculateRisk, function (state) {
  var surveyWeight = state[_symbols2.default.state.screenerWeights].survey;
  var epworthWeight = state[_symbols2.default.state.screenerWeights].epworth;
  var coMorbidityWeight = state[_symbols2.default.state.screenerWeights].coMorbidity;
  if (surveyWeight > 15 || epworthWeight > 18 || coMorbidityWeight > 3) {
    return 'severe';
  }
  if (surveyWeight > 11 || epworthWeight > 14 || coMorbidityWeight > 2) {
    return 'high';
  }
  if (surveyWeight > 7 || epworthWeight > 9 || coMorbidityWeight > 1) {
    return 'moderate';
  }
  return 'low';
}), _symbols$getters$full);

/***/ }),
/* 657 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _stringify = __webpack_require__(230);

var _stringify2 = _interopRequireDefault(_stringify);

var _symbols$mutations$re;

var _state = __webpack_require__(231);

var _state2 = _interopRequireDefault(_state);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$re = {}, (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.restoreInitialScreener, function (state) {
  var initialStateCopy = JSON.parse((0, _stringify2.default)(_state2.default));
  for (var property in _state2.default) {
    state[property] = initialStateCopy[property];
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.restoreInitialScreenerKeepSession, function (state) {
  var initialStateCopy = JSON.parse((0, _stringify2.default)(_state2.default));
  for (var property in _state2.default) {
    if (property !== _symbols2.default.state.sessionData && property !== _symbols2.default.state.screenerToken) {
      state[property] = initialStateCopy[property];
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.contactData, function (state, storedContacts) {
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(state[_symbols2.default.state.contactData]), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var field = _step.value;

      if (storedContacts.hasOwnProperty(field.name)) {
        field.value = storedContacts[field.name];
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.companyData, function (state, companyData) {
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(companyData), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var company = _step2.value;

      if (company.hasOwnProperty('logo') && company.logo) {
        company.logo = _ProcessWrapper2.default.getImagePath() + company.logo;
      }
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  state[_symbols2.default.state.companyData] = companyData;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.coMorbidityWeight, function (state, weight) {
  state[_symbols2.default.state.screenerWeights].coMorbidity = weight;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.epworthWeight, function (state, weight) {
  state[_symbols2.default.state.screenerWeights].epworth = weight;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.surveyWeight, function (state, weight) {
  state[_symbols2.default.state.screenerWeights].survey = weight;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.setEpworthErrors, function (state, errors) {
  var _iteratorNormalCompletion3 = true;
  var _didIteratorError3 = false;
  var _iteratorError3 = undefined;

  try {
    for (var _iterator3 = (0, _getIterator3.default)(state[_symbols2.default.state.epworthProps]), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
      var prop = _step3.value;

      var errorIndex = errors.indexOf(prop.epworth);
      prop.error = errorIndex !== -1;
    }
  } catch (err) {
    _didIteratorError3 = true;
    _iteratorError3 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion3 && _iterator3.return) {
        _iterator3.return();
      }
    } finally {
      if (_didIteratorError3) {
        throw _iteratorError3;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.setEpworthProps, function (state, epworthProps) {
  state[_symbols2.default.state.epworthProps] = epworthProps;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.modifyEpworthProps, function (state, storedProps) {
  var _iteratorNormalCompletion4 = true;
  var _didIteratorError4 = false;
  var _iteratorError4 = undefined;

  try {
    for (var _iterator4 = (0, _getIterator3.default)(state[_symbols2.default.state.epworthProps]), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
      var prop = _step4.value;

      prop.error = false;
      if (storedProps.hasOwnProperty(prop.epworthid)) {
        prop.selected = storedProps[prop.epworthid];
      }
    }
  } catch (err) {
    _didIteratorError4 = true;
    _iteratorError4 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion4 && _iterator4.return) {
        _iterator4.return();
      }
    } finally {
      if (_didIteratorError4) {
        throw _iteratorError4;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.doctorName, function (state, name) {
  state[_symbols2.default.state.doctorName] = name;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.symptoms, function (state, storedSymptoms) {
  var _iteratorNormalCompletion5 = true;
  var _didIteratorError5 = false;
  var _iteratorError5 = undefined;

  try {
    for (var _iterator5 = (0, _getIterator3.default)(state[_symbols2.default.state.symptoms]), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
      var symptom = _step5.value;

      if (storedSymptoms.hasOwnProperty(symptom.name)) {
        symptom.selected = storedSymptoms[symptom.name];
      }
    }
  } catch (err) {
    _didIteratorError5 = true;
    _iteratorError5 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion5 && _iterator5.return) {
        _iterator5.return();
      }
    } finally {
      if (_didIteratorError5) {
        throw _iteratorError5;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.coMorbidity, function (state, storedConditions) {
  var _iteratorNormalCompletion6 = true;
  var _didIteratorError6 = false;
  var _iteratorError6 = undefined;

  try {
    for (var _iterator6 = (0, _getIterator3.default)(state[_symbols2.default.state.coMorbidityData]), _step6; !(_iteratorNormalCompletion6 = (_step6 = _iterator6.next()).done); _iteratorNormalCompletion6 = true) {
      var condition = _step6.value;

      if (storedConditions.hasOwnProperty(condition.name)) {
        condition.checked = storedConditions[condition.name];
      }
    }
  } catch (err) {
    _didIteratorError6 = true;
    _iteratorError6 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion6 && _iterator6.return) {
        _iterator6.return();
      }
    } finally {
      if (_didIteratorError6) {
        throw _iteratorError6;
      }
    }
  }
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.cpap, function (state, storedCpap) {
  state[_symbols2.default.state.cpap].selected = storedCpap;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.sessionData, function (state, sessionData) {
  state[_symbols2.default.state.sessionData] = sessionData;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.screenerId, function (state, screenerId) {
  state[_symbols2.default.state.screenerId] = screenerId;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.screenerToken, function (state, screenerToken) {
  state[_symbols2.default.state.screenerToken] = screenerToken;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.showFancybox, function (state) {
  state[_symbols2.default.state.showFancybox] = true;
}), (0, _defineProperty3.default)(_symbols$mutations$re, _symbols2.default.mutations.hideFancybox, function (state) {
  state[_symbols2.default.state.showFancybox] = false;
}), _symbols$mutations$re);

/***/ }),
/* 658 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _promise = __webpack_require__(32);

var _promise2 = _interopRequireDefault(_promise);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$actions$getD;

var _axios = __webpack_require__(22);

var _axios2 = _interopRequireDefault(_axios);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _ProcessWrapper = __webpack_require__(15);

var _ProcessWrapper2 = _interopRequireDefault(_ProcessWrapper);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$getD = {}, (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.getDoctorData, function (_ref) {
  var state = _ref.state,
      commit = _ref.commit;

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  var doctorId = state[_symbols2.default.state.sessionData].docId;
  _http2.default.get(_endpoints2.default.users.show + '/' + doctorId).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.doctorName, data.first_name);
  });
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.getCompanyData, function (_ref2) {
  var state = _ref2.state,
      commit = _ref2.commit;

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  _http2.default.post(_endpoints2.default.companies.homeSleepTest).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.companyData, data);
  });
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.submitScreener, function (_ref3) {
  var state = _ref3.state;

  var contactData = state[_symbols2.default.state.contactData];
  var symptoms = state[_symbols2.default.state.symptoms];
  var coMorbidityData = state[_symbols2.default.state.coMorbidityData];
  var cpap = state[_symbols2.default.state.cpap];
  var sessionData = state[_symbols2.default.state.sessionData];
  var epworthProps = state[_symbols2.default.state.epworthProps];

  var screenerData = {
    docid: sessionData.docId,
    userid: sessionData.userId,
    rx_cpap: cpap.selected,
    epworth: []
  };

  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(contactData), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var contactProperty = _step.value;

      switch (contactProperty.camelName) {
        case 'firstName':
          screenerData.first_name = contactProperty.value;
          break;
        case 'lastName':
          screenerData.last_name = contactProperty.value;
          break;
        case 'phone':
          screenerData.phone = contactProperty.value;
          break;
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(epworthProps), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var epworth = _step2.value;

      screenerData.epworth.push(epworth);
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  var _iteratorNormalCompletion3 = true;
  var _didIteratorError3 = false;
  var _iteratorError3 = undefined;

  try {
    for (var _iterator3 = (0, _getIterator3.default)(symptoms), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
      var symptom = _step3.value;

      screenerData[symptom.name] = symptom.selected;
    }
  } catch (err) {
    _didIteratorError3 = true;
    _iteratorError3 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion3 && _iterator3.return) {
        _iterator3.return();
      }
    } finally {
      if (_didIteratorError3) {
        throw _iteratorError3;
      }
    }
  }

  var _iteratorNormalCompletion4 = true;
  var _didIteratorError4 = false;
  var _iteratorError4 = undefined;

  try {
    for (var _iterator4 = (0, _getIterator3.default)(coMorbidityData), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
      var coMorbidity = _step4.value;

      screenerData[coMorbidity.name] = 0;
      if (coMorbidity.checked) {
        screenerData[coMorbidity.name] = coMorbidity.weight;
      }
    }
  } catch (err) {
    _didIteratorError4 = true;
    _iteratorError4 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion4 && _iterator4.return) {
        _iterator4.return();
      }
    } finally {
      if (_didIteratorError4) {
        throw _iteratorError4;
      }
    }
  }

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  return _http2.default.request('post', _endpoints2.default.screeners.store, screenerData);
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.parseScreenerResults, function (_ref4, _ref5) {
  var state = _ref4.state,
      commit = _ref4.commit;
  var id = _ref5.id;

  commit(_symbols2.default.mutations.screenerId, id);

  var epworthWeight = 0;
  var _iteratorNormalCompletion5 = true;
  var _didIteratorError5 = false;
  var _iteratorError5 = undefined;

  try {
    for (var _iterator5 = (0, _getIterator3.default)(state[_symbols2.default.state.epworthProps]), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
      var epworth = _step5.value;

      epworthWeight += parseInt(epworth.selected);
    }
  } catch (err) {
    _didIteratorError5 = true;
    _iteratorError5 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion5 && _iterator5.return) {
        _iterator5.return();
      }
    } finally {
      if (_didIteratorError5) {
        throw _iteratorError5;
      }
    }
  }

  commit(_symbols2.default.mutations.epworthWeight, epworthWeight);

  var coMorbidityData = state[_symbols2.default.state.coMorbidityData];

  var coMorbidityWeight = 0;
  var _iteratorNormalCompletion6 = true;
  var _didIteratorError6 = false;
  var _iteratorError6 = undefined;

  try {
    for (var _iterator6 = (0, _getIterator3.default)(coMorbidityData), _step6; !(_iteratorNormalCompletion6 = (_step6 = _iterator6.next()).done); _iteratorNormalCompletion6 = true) {
      var coMorbidity = _step6.value;

      if (coMorbidity.checked) {
        coMorbidityWeight += parseInt(coMorbidity.weight);
      }
    }
  } catch (err) {
    _didIteratorError6 = true;
    _iteratorError6 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion6 && _iterator6.return) {
        _iterator6.return();
      }
    } finally {
      if (_didIteratorError6) {
        throw _iteratorError6;
      }
    }
  }

  var cpap = state[_symbols2.default.state.cpap];
  if (cpap.selected) {
    coMorbidityWeight += parseInt(cpap.weight);
  }
  commit(_symbols2.default.mutations.coMorbidityWeight, coMorbidityWeight);

  var symptoms = state[_symbols2.default.state.symptoms];
  var surveyWeight = 0;
  var _iteratorNormalCompletion7 = true;
  var _didIteratorError7 = false;
  var _iteratorError7 = undefined;

  try {
    for (var _iterator7 = (0, _getIterator3.default)(symptoms), _step7; !(_iteratorNormalCompletion7 = (_step7 = _iterator7.next()).done); _iteratorNormalCompletion7 = true) {
      var symptom = _step7.value;

      if (symptom.selected) {
        surveyWeight += parseInt(symptom.selected);
      }
    }
  } catch (err) {
    _didIteratorError7 = true;
    _iteratorError7 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion7 && _iterator7.return) {
        _iterator7.return();
      }
    } finally {
      if (_didIteratorError7) {
        throw _iteratorError7;
      }
    }
  }

  commit(_symbols2.default.mutations.surveyWeight, surveyWeight);
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.setEpworthProps, function (_ref6) {
  var state = _ref6.state,
      commit = _ref6.commit;

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  _http2.default.get(_endpoints2.default.epworthSleepinessScale.index + '?status=1&order=sortby').then(function (response) {
    var data = response.data.data;
    var _iteratorNormalCompletion8 = true;
    var _didIteratorError8 = false;
    var _iteratorError8 = undefined;

    try {
      for (var _iterator8 = (0, _getIterator3.default)(data), _step8; !(_iteratorNormalCompletion8 = (_step8 = _iterator8.next()).done); _iteratorNormalCompletion8 = true) {
        var element = _step8.value;

        element.selected = '';
        element.error = false;
      }
    } catch (err) {
      _didIteratorError8 = true;
      _iteratorError8 = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion8 && _iterator8.return) {
          _iterator8.return();
        }
      } finally {
        if (_didIteratorError8) {
          throw _iteratorError8;
        }
      }
    }

    commit(_symbols2.default.mutations.setEpworthProps, data);
  });
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.submitHst, function (_ref7, _ref8) {
  var state = _ref7.state;
  var companyId = _ref8.companyId,
      contactData = _ref8.contactData;

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  var sessionData = state[_symbols2.default.state.sessionData];
  var screenerId = state[_symbols2.default.state.screenerId];

  function getContactValue(propertyName) {
    var _iteratorNormalCompletion9 = true;
    var _didIteratorError9 = false;
    var _iteratorError9 = undefined;

    try {
      for (var _iterator9 = (0, _getIterator3.default)(contactData), _step9; !(_iteratorNormalCompletion9 = (_step9 = _iterator9.next()).done); _iteratorNormalCompletion9 = true) {
        var element = _step9.value;

        if (element.camelName === propertyName) {
          return element.value;
        }
      }
    } catch (err) {
      _didIteratorError9 = true;
      _iteratorError9 = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion9 && _iterator9.return) {
          _iterator9.return();
        }
      } finally {
        if (_didIteratorError9) {
          throw _iteratorError9;
        }
      }
    }

    return '';
  }

  var ajaxData = {
    screener_id: screenerId,
    doc_id: sessionData.docId,
    user_id: sessionData.userId,
    company_id: companyId,
    patient_firstname: getContactValue('firstName'),
    patient_lastname: getContactValue('lastName'),
    patient_cell_phone: getContactValue('phone'),
    patient_email: getContactValue('email'),
    patient_dob: getContactValue('dob')
  };

  return _http2.default.request('post', _endpoints2.default.homeSleepTests.store, ajaxData);
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.authenticateScreener, function (_ref9, payload) {
  var commit = _ref9.commit,
      dispatch = _ref9.dispatch;

  return new _promise2.default(function (resolve, reject) {
    _axios2.default.post(_ProcessWrapper2.default.getApiRoot() + 'auth', payload).then(function (response) {
      var data = response.data;
      if (!data.hasOwnProperty('token') || !data.token) {
        throw new Error('No token retrieved');
      }
      commit(_symbols2.default.mutations.screenerToken, data.token);
      dispatch(_symbols2.default.actions.setSessionData);
      resolve();
    }).catch(function (reason) {
      var newReason = 'Authentication failed';
      if (reason instanceof Error && reason.message) {
        newReason = reason.message;
      }
      reject(new Error(newReason));
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$getD, _symbols2.default.actions.setSessionData, function (_ref10) {
  var state = _ref10.state,
      commit = _ref10.commit;

  _http2.default.token = state[_symbols2.default.state.screenerToken];
  return _http2.default.request('get', _endpoints2.default.users.current).then(function (response) {
    var data = response.data.data;
    var sessionData = {
      userId: data.userid,
      docId: data.docid
    };
    commit(_symbols2.default.mutations.sessionData, sessionData);
  }).catch(function () {
    throw new Error('No user ID retrieved');
  });
}), _symbols$actions$getD);

/***/ }),
/* 659 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _state = __webpack_require__(660);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(661);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(662);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(663);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: _state2.default,
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 660 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$respon;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$respon = {}, (0, _defineProperty3.default)(_symbols$state$respon, _symbols2.default.state.responsibleUsers, []), (0, _defineProperty3.default)(_symbols$state$respon, _symbols2.default.state.tasks, []), (0, _defineProperty3.default)(_symbols$state$respon, _symbols2.default.state.tasksForPatient, []), (0, _defineProperty3.default)(_symbols$state$respon, _symbols2.default.state.currentTask, {
  id: 0,
  dueDate: null,
  task: '',
  responsible: 0,
  status: false,
  patientName: '',
  patientId: 0
}), _symbols$state$respon);

/***/ }),
/* 661 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$getters$task;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$task = {}, (0, _defineProperty3.default)(_symbols$getters$task, _symbols2.default.getters.tasksNumber, function (state) {
  return state[_symbols2.default.state.tasks].length;
}), (0, _defineProperty3.default)(_symbols$getters$task, _symbols2.default.getters.tasksByType, function (state) {
  return function (type) {
    var tasks = [];
    var _iteratorNormalCompletion = true;
    var _didIteratorError = false;
    var _iteratorError = undefined;

    try {
      for (var _iterator = (0, _getIterator3.default)(state[_symbols2.default.state.tasks]), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
        var task = _step.value;

        if (task.type === type) {
          tasks.push(task);
        }
      }
    } catch (err) {
      _didIteratorError = true;
      _iteratorError = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion && _iterator.return) {
          _iterator.return();
        }
      } finally {
        if (_didIteratorError) {
          throw _iteratorError;
        }
      }
    }

    return tasks;
  };
}), (0, _defineProperty3.default)(_symbols$getters$task, _symbols2.default.getters.tasksPatientNumber, function (state) {
  return state[_symbols2.default.state.tasksForPatient].length;
}), (0, _defineProperty3.default)(_symbols$getters$task, _symbols2.default.getters.tasksPatientByType, function (state) {
  return function (type) {
    var tasks = [];
    var _iteratorNormalCompletion2 = true;
    var _didIteratorError2 = false;
    var _iteratorError2 = undefined;

    try {
      for (var _iterator2 = (0, _getIterator3.default)(state[_symbols2.default.state.tasksForPatient]), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
        var task = _step2.value;

        if (task.type === type) {
          tasks.push(task);
        }
      }
    } catch (err) {
      _didIteratorError2 = true;
      _iteratorError2 = err;
    } finally {
      try {
        if (!_iteratorNormalCompletion2 && _iterator2.return) {
          _iterator2.return();
        }
      } finally {
        if (_didIteratorError2) {
          throw _iteratorError2;
        }
      }
    }

    return tasks;
  };
}), _symbols$getters$task);

/***/ }),
/* 662 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$mutations$se;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$se = {}, (0, _defineProperty3.default)(_symbols$mutations$se, _symbols2.default.mutations.setTasks, function (state, tasks) {
  state[_symbols2.default.state.tasks] = tasks;
}), (0, _defineProperty3.default)(_symbols$mutations$se, _symbols2.default.mutations.setTasksForPatient, function (state, tasks) {
  state[_symbols2.default.state.tasksForPatient] = tasks;
}), (0, _defineProperty3.default)(_symbols$mutations$se, _symbols2.default.mutations.responsibleUsers, function (state, data) {
  var revisedData = [];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(data), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var user = _step.value;

      revisedData.push({
        id: parseInt(user.userid),
        fullName: user.first_name + ' ' + user.last_name
      });
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  state[_symbols2.default.state.responsibleUsers] = revisedData;
}), (0, _defineProperty3.default)(_symbols$mutations$se, _symbols2.default.mutations.getTask, function (state, task) {
  var taskData = {
    id: task.id,
    dueDate: new Date(task.due_date),
    task: task.task,
    responsible: task.responsibleid,
    status: !!task.status,
    patientId: parseInt(task.patientid),
    patientName: ''
  };
  if (task.firstname && task.lastname) {
    taskData.patientName = task.firstname + ' ' + task.lastname;
  }
  state[_symbols2.default.state.currentTask] = taskData;
}), _symbols$mutations$se);

/***/ }),
/* 663 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _promise = __webpack_require__(32);

var _promise2 = _interopRequireDefault(_promise);

var _symbols$actions$retr;

var _moment = __webpack_require__(0);

var _moment2 = _interopRequireDefault(_moment);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$retr = {}, (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.retrieveTasks, function (_ref) {
  var rootState = _ref.rootState,
      commit = _ref.commit,
      dispatch = _ref.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.tasks.index).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.setTasks, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getTasks', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.retrieveTasksForPatient, function (_ref2) {
  var rootState = _ref2.rootState,
      commit = _ref2.commit,
      dispatch = _ref2.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.tasks.indexForPatient + '/' + rootState.patients[_symbols2.default.state.patientId]).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.setTasksForPatient, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getPatientTasks', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.addTask, function (_ref3, data) {
  var rootState = _ref3.rootState,
      dispatch = _ref3.dispatch;

  return new _promise2.default(function (resolve, reject) {
    if (!data.task) {
      reject(new Error('Task is required'));
      return;
    }
    if (!data.dueDate || !(data.dueDate instanceof Date)) {
      reject(new Error('Date is required'));
      return;
    }
    if (!data.responsible) {
      reject(new Error('User is required'));
      return;
    }
    _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
    var dueDate = (0, _moment2.default)(data.dueDate).format().substr(0, 10);
    var parsedData = {
      task: data.task,
      due_date: dueDate,
      status: +data.status,
      responsibleid: data.responsible,
      userid: rootState.main[_symbols2.default.state.userInfo].plainUserId,
      patientid: data.patientId
    };
    if (data.id) {
      _http2.default.put(_endpoints2.default.tasks.update + '/' + data.id, parsedData).then(function () {
        dispatch(_symbols2.default.actions.retrieveTasks);
        resolve();
      }).catch(function (response) {
        dispatch(_symbols2.default.actions.handleErrors, { title: 'updateTask', response: response });
        reject(new Error());
      });
      return;
    }
    _http2.default.post(_endpoints2.default.tasks.store, parsedData).then(function () {
      dispatch(_symbols2.default.actions.retrieveTasks);
      resolve();
    }).catch(function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'addTask', response: response });
      reject(new Error());
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.responsibleUsers, function (_ref4) {
  var rootState = _ref4.rootState,
      commit = _ref4.commit,
      dispatch = _ref4.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.users.responsible).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.responsibleUsers, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getResponsibleUsers', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.getTask, function (_ref5, taskId) {
  var rootState = _ref5.rootState,
      commit = _ref5.commit,
      dispatch = _ref5.dispatch;

  return new _promise2.default(function (resolve, reject) {
    _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
    _http2.default.get(_endpoints2.default.tasks.show + '/' + taskId).then(function (response) {
      var data = response.data.data;
      commit(_symbols2.default.mutations.getTask, data);
      resolve();
    }).catch(function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'getTask', response: response });
      reject(new Error());
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.updateTaskStatus, function (_ref6, taskId) {
  var rootState = _ref6.rootState,
      dispatch = _ref6.dispatch;

  var data = {
    status: 1
  };
  return new _promise2.default(function (resolve, reject) {
    _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
    _http2.default.put(_endpoints2.default.tasks.update + '/' + taskId, data).then(function () {
      if (rootState.main[_symbols2.default.state.patientId]) {
        dispatch(_symbols2.default.actions.retrieveTasksForPatient);
      }
      dispatch(_symbols2.default.actions.retrieveTasks);
      resolve();
    }).catch(function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'updateTaskToActive', response: response });
      reject(new Error());
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$retr, _symbols2.default.actions.deleteTask, function (_ref7, taskId) {
  var rootState = _ref7.rootState,
      dispatch = _ref7.dispatch;

  return new _promise2.default(function (resolve, reject) {
    _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
    _http2.default.delete(_endpoints2.default.tasks.destroy + '/' + taskId).then(function () {
      if (rootState.main[_symbols2.default.state.patientId]) {
        dispatch(_symbols2.default.actions.retrieveTasksForPatient);
      }
      dispatch(_symbols2.default.actions.retrieveTasks);
      resolve();
    }).catch(function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'deleteTask', response: response });
      reject(new Error());
    });
  });
}), _symbols$actions$retr);

/***/ }),
/* 664 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _state = __webpack_require__(665);

var _state2 = _interopRequireDefault(_state);

var _getters = __webpack_require__(666);

var _getters2 = _interopRequireDefault(_getters);

var _mutations = __webpack_require__(667);

var _mutations2 = _interopRequireDefault(_mutations);

var _actions = __webpack_require__(668);

var _actions2 = _interopRequireDefault(_actions);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  state: _state2.default,
  getters: _getters2.default,
  mutations: _mutations2.default,
  actions: _actions2.default
};

/***/ }),
/* 665 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _symbols$state$appoin;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$state$appoin = {}, (0, _defineProperty3.default)(_symbols$state$appoin, _symbols2.default.state.appointmentSummaries, []), (0, _defineProperty3.default)(_symbols$state$appoin, _symbols2.default.state.devices, []), (0, _defineProperty3.default)(_symbols$state$appoin, _symbols2.default.state.letters, []), (0, _defineProperty3.default)(_symbols$state$appoin, _symbols2.default.state.trackerSteps, []), (0, _defineProperty3.default)(_symbols$state$appoin, _symbols2.default.state.hasScheduledAppointment, false), _symbols$state$appoin);

/***/ }),
/* 666 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$getters$trac;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$getters$trac = {}, (0, _defineProperty3.default)(_symbols$getters$trac, _symbols2.default.getters.trackerStepsFirst, function (state) {
  var steps = [];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(state[_symbols2.default.state.trackerSteps]), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var element = _step.value;

      if (element.sectionId === 1) {
        steps.push(element);
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  return steps;
}), (0, _defineProperty3.default)(_symbols$getters$trac, _symbols2.default.getters.trackerStepsSecond, function (state) {
  var steps = [];
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(state[_symbols2.default.state.trackerSteps]), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var element = _step2.value;

      if (element.sectionId === 2) {
        steps.push(element);
      }
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  return steps;
}), (0, _defineProperty3.default)(_symbols$getters$trac, _symbols2.default.getters.trackerStepSchedule, function () {
  return {};
}), _symbols$getters$trac);

/***/ }),
/* 667 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _symbols$mutations$ap;

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$mutations$ap = {}, (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.appointmentSummaries, function (state, data) {
  var appointmentSummaries = [];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(data), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var element = _step.value;

      var newSummary = {
        id: parseInt(element.id),
        segmentId: parseInt(element.segmentid),
        deviceId: parseInt(element.device_id),
        description: element.description,
        studyType: element.study_type,
        delayReason: element.delay_reason,
        nonComplianceReason: element.noncomp_reason,
        dateCompleted: new Date(element.date_completed)
      };
      appointmentSummaries.push(newSummary);
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  state[_symbols2.default.state.appointmentSummaries] = appointmentSummaries;
}), (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.devices, function (state, data) {
  var devices = [];
  var _iteratorNormalCompletion2 = true;
  var _didIteratorError2 = false;
  var _iteratorError2 = undefined;

  try {
    for (var _iterator2 = (0, _getIterator3.default)(data), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
      var element = _step2.value;

      var newDevice = {
        id: parseInt(element.deviceid),
        device: element.device
      };
      devices.push(newDevice);
    }
  } catch (err) {
    _didIteratorError2 = true;
    _iteratorError2 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion2 && _iterator2.return) {
        _iterator2.return();
      }
    } finally {
      if (_didIteratorError2) {
        throw _iteratorError2;
      }
    }
  }

  state[_symbols2.default.state.devices] = devices;
}), (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.letters, function (state, data) {
  var letters = [];
  var _iteratorNormalCompletion3 = true;
  var _didIteratorError3 = false;
  var _iteratorError3 = undefined;

  try {
    for (var _iterator3 = (0, _getIterator3.default)(data), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
      var element = _step3.value;

      var newLetter = {
        infoId: parseInt(element.info_id),
        toPatient: !!element.topatient,
        mdList: element.md_list,
        mdReferralList: element.md_referral_list,
        status: parseInt(element.status)
      };
      letters.push(newLetter);
    }
  } catch (err) {
    _didIteratorError3 = true;
    _iteratorError3 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion3 && _iterator3.return) {
        _iterator3.return();
      }
    } finally {
      if (_didIteratorError3) {
        throw _iteratorError3;
      }
    }
  }

  state[_symbols2.default.state.letters] = letters;
}), (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.insertTrackerStep, function (state, data) {
  state[_symbols2.default.state.trackerSteps].push(data);
}), (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.stepsByRank, function (state, data) {
  var steps = [];
  var _iteratorNormalCompletion4 = true;
  var _didIteratorError4 = false;
  var _iteratorError4 = undefined;

  try {
    for (var _iterator4 = (0, _getIterator3.default)(data), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
      var element = _step4.value;

      var newStep = {
        id: parseInt(element.id),
        name: element.name,
        completed: !!element.completed
      };
      steps.push(newStep);
    }
  } catch (err) {
    _didIteratorError4 = true;
    _iteratorError4 = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion4 && _iterator4.return) {
        _iterator4.return();
      }
    } finally {
      if (_didIteratorError4) {
        throw _iteratorError4;
      }
    }
  }

  state[_symbols2.default.state.trackerSteps] = steps;
}), (0, _defineProperty3.default)(_symbols$mutations$ap, _symbols2.default.mutations.hasScheduledAppointment, function (state, data) {
  state[_symbols2.default.state.hasScheduledAppointment] = data;
}), _symbols$mutations$ap);

/***/ }),
/* 668 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _defineProperty2 = __webpack_require__(3);

var _defineProperty3 = _interopRequireDefault(_defineProperty2);

var _getIterator2 = __webpack_require__(7);

var _getIterator3 = _interopRequireDefault(_getIterator2);

var _promise = __webpack_require__(32);

var _promise2 = _interopRequireDefault(_promise);

var _symbols$actions$upda;

var _qs = __webpack_require__(227);

var _qs2 = _interopRequireDefault(_qs);

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _http = __webpack_require__(5);

var _http2 = _interopRequireDefault(_http);

var _endpoints = __webpack_require__(4);

var _endpoints2 = _interopRequireDefault(_endpoints);

var _Alerter = __webpack_require__(9);

var _Alerter2 = _interopRequireDefault(_Alerter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = (_symbols$actions$upda = {}, (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.updateAppointmentSummary, function (_ref, _ref2) {
  var rootState = _ref.rootState,
      dispatch = _ref.dispatch;
  var id = _ref2.id,
      patientId = _ref2.patientId,
      data = _ref2.data;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  return _http2.default.put(_endpoints2.default.appointmentSummaries.update + '/' + id, data).then(function () {
    dispatch(_symbols2.default.actions.appointmentSummariesByPatient, patientId);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'updateAppointmentSummary', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.deleteAppointmentSummary, function (_ref3, _ref4) {
  var rootState = _ref3.rootState,
      dispatch = _ref3.dispatch;
  var id = _ref4.id,
      patientId = _ref4.patientId;

  var confirmText = 'Are you sure you want to delete this appointment?';
  if (!_Alerter2.default.isConfirmed(confirmText)) {
    return;
  }
  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.delete(_endpoints2.default.appointmentSummaries.destroy + '/' + id).then(function () {
    dispatch(_symbols2.default.actions.appointmentSummariesByPatient, patientId);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'deleteAppointmentSummary', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.appointmentSummariesByPatient, function (_ref5, patientId) {
  var rootState = _ref5.rootState,
      commit = _ref5.commit,
      dispatch = _ref5.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  return new _promise2.default(function (resolve, reject) {
    _http2.default.get(_endpoints2.default.appointmentSummaries.byPatient + '/' + patientId).then(function (response) {
      commit(_symbols2.default.mutations.appointmentSummaries, response.data.data);
      resolve();
    }).catch(function (response) {
      dispatch(_symbols2.default.actions.handleErrors, { title: 'appointmentSummariesByPatient', response: response });
      reject(new Error());
    });
  });
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.devicesByStatus, function (_ref6) {
  var rootState = _ref6.rootState,
      commit = _ref6.commit,
      dispatch = _ref6.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.devices.byStatus).then(function (response) {
    commit(_symbols2.default.mutations.devices, response.data.data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getDevicesByStatus', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.lettersByPatientAndInfo, function (_ref7, patientId) {
  var rootState = _ref7.rootState,
      state = _ref7.state,
      commit = _ref7.commit,
      dispatch = _ref7.dispatch;

  var infoIds = [];
  var summaries = state[_symbols2.default.state.appointmentSummaries];
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = (0, _getIterator3.default)(summaries), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var summary = _step.value;

      if (infoIds.indexOf(summary.id) === -1) {
        infoIds.push(summary.id);
      }
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  var queryStringData = {
    patient_id: patientId,
    info_ids: infoIds
  };
  var queryString = _qs2.default.stringify(queryStringData);
  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.letters.byPatientAndInfo + '?' + queryString).then(function (response) {
    commit(_symbols2.default.mutations.letters, response.data.data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getLettersByPatientAndInfo', response: response });
  });
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.insertTrackerStep, function (_ref8, responseData) {
  var commit = _ref8.commit;

  var newStep = {
    id: responseData.id,
    title: responseData.title,
    letterCount: responseData.letters,
    dateCompleted: responseData.datecomp
  };
  var modalData = {};
  switch (this.id) {
    case 9:
      modalData = {
        name: 'flowsheetNonCompliance',
        params: {
          flowId: responseData.id
        }
      };
      this.$store.commit(_symbols2.default.mutations.modal, modalData);
      break;
    case 5:
      modalData = {
        name: 'flowsheetDelayTreatment',
        params: {
          flowId: responseData.id
        }
      };
      commit(_symbols2.default.mutations.modal, modalData);
      break;
    case 3:
      modalData = {
        name: 'flowsheetStudyType',
        params: {
          flowId: responseData.id,
          patientId: this.patientId
        }
      };
      commit(_symbols2.default.mutations.modal, modalData);
      break;
    case 15:
      modalData = {
        name: 'flowsheetStudyType',
        params: {
          flowId: responseData.id,
          patientId: this.patientId
        }
      };
      commit(_symbols2.default.mutations.modal, modalData);
      break;
    case 4:
    case 7:
      if (responseData.impression) {
        newStep.impression = responseData.impression;
        break;
      }
      modalData = {
        name: 'impressionDevice',
        params: {
          flowId: responseData.id,
          patientId: this.patientId
        }
      };
      commit(_symbols2.default.mutations.modal, modalData);
      break;
  }
  commit(_symbols2.default.mutations.insertTrackerStep, newStep);
}), (0, _defineProperty3.default)(_symbols$actions$upda, _symbols2.default.actions.stepsByRank, function (_ref9, patientId) {
  var rootState = _ref9.rootState,
      commit = _ref9.commit,
      dispatch = _ref9.dispatch;

  _http2.default.token = rootState.main[_symbols2.default.state.mainToken];
  _http2.default.get(_endpoints2.default.appointmentSummaries.stepsByRank + '/' + patientId).then(function (response) {
    var data = response.data.data;
    commit(_symbols2.default.mutations.stepsByRank, data);
  }).catch(function (response) {
    dispatch(_symbols2.default.actions.handleErrors, { title: 'getStepsByRank', response: response });
  });
}), _symbols$actions$upda);

/***/ }),
/* 669 */,
/* 670 */,
/* 671 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _symbols = __webpack_require__(1);

var _symbols2 = _interopRequireDefault(_symbols);

var _LegacyModifier = __webpack_require__(61);

var _LegacyModifier2 = _interopRequireDefault(_LegacyModifier);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
  bind: function bind(el, binding, vnode) {
    var currentHref = binding.value;
    var token = vnode.context.$store.getters[_symbols2.default.state.mainToken];
    var newHref = _LegacyModifier2.default.modifyLegacyLink(currentHref, token);
    el.setAttribute('href', newHref);
  }
};

/***/ }),
/* 672 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

exports.default = function (value) {
  var newValue = value.replace(/&amp;/g, '&');
  return newValue;
};

/***/ })
],[233]);
//# sourceMappingURL=app.df68a8cdff03739f783c.js.map