export default {
  state: {
    allergen: 'ALLERGEN',
    coMorbidityData: 'CO_MORBIDITY_DATA',
    companyData: 'COMPANY_DATA',
    contact: 'CONTACT',
    contactData: 'CONTACT_DATA',
    cpap: 'CPAP',
    currentTask: 'CURRENT_TASK',
    displayAlert: 'DISPLAY_ALERT',
    docInfo: 'DOC_INFO',
    doctorName: 'DOCTOR_NAME',
    documentCategories: 'DOCUMENT_CATEGORIES',
    deviceGuideResults: 'DEVICE_GUIDE_RESULTS',
    deviceGuideSettingOptions: 'DEVICE_GUIDE_SETTING_OPTIONS',
    edxCertificates: 'EDX_CERTIFICATES',
    epworthOptions: 'EPWORTH_OPTIONS',
    epworthProps: 'EPWORTH_PROPS',
    headerAlertText: 'HEADER_ALERT_TEXT',
    headerTitle: 'HEADER_TITLE',
    incompleteHomeSleepTests: 'INCOMPLETE_HOME_SLEEP_TESTS',
    isEmailBounced: 'IS_EMAIL_BOUNCED',
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
    storedContactData: 'STORED_CONTACT_DATA',
    storedCpap: 'STORED_CPAP',
    storedSymptoms: 'STORED_SYMPTOMS',
    symptoms: 'SYMPTOMS',
    tasks: 'TASKS',
    tasksForPatient: 'TASKS_FOR_PATIENT',
    totalPatientContacts: 'TOTAL_PATIENT_CONTACTS',
    totalPatientInsurances: 'TOTAL_PATIENT_INSURANCES',
    totalSubPatients: 'TOTAL_SUB_PATIENTS',
    userInfo: 'USER_INFO'
  },
  getters: {
    calculateRisk: 'CALCULATE_RISK',
    documentCategories: 'DOCUMENT_CATEGORIES',
    edxCertificates: 'EDX_CERTIFICATES',
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
    tasksPatientNumber: 'TASKS_PATIENT_NUMBER'
  },
  mutations: {
    addStoredContact: 'ADD_STORED_CONTACT',
    addStoredCpap: 'ADD_STORED_CPAP',
    addStoredSymptom: 'ADD_STORED_SYMPTOM',
    checkGuideSetting: 'CHECK_GUIDE_SETTING',
    clearPatientData: 'CLEAR_PATIENT_DATA',
    coMorbidity: 'CO_MORBIDITY',
    coMorbidityWeight: 'CO_MORBIDITY_WEIGHT',
    companyData: 'COMPANY_DATA',
    contactData: 'CONTACT_DATA',
    cpap: 'CPAP',
    docInfo: 'DOC_INFO',
    doctorName: 'DOCTOR_NAME',
    documentCategories: 'DOCUMENT_CATEGORIES',
    deviceGuideResults: 'DEVICE_GUIDE_RESULTS',
    deviceGuideSettingOptions: 'DEVICE_GUIDE_SETTING_OPTIONS',
    edxCertificatesData: 'EDX_CERTIFICATES_DATA',
    epworthWeight: 'EPWORTH_WEIGHT',
    getTask: 'GET_TASK',
    hideAllWarnings: 'HIDE_ALL_WARNINGS',
    hideFancybox: 'HIDE_FANCYBOX',
    hideSearchHints: 'HIDE_SEARCH_HINTS',
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
    surveyWeight: 'SURVEY_WEIGHT',
    symptoms: 'SYMPTOMS',
    userInfo: 'USER_INFO'
  },
  actions: {
    addTask: 'ADD_TASK',
    authenticateScreener: 'AUTHENTICATE_SCREENER',
    clearPatientData: 'CLEAR_PATIENT_DATA',
    dataImportModal: 'DATA_IMPORT_MODAL',
    deleteTask: 'DELETE_TASK',
    deviceSelectorModal: 'DEVICE_SELECTOR_MODAL',
    disablePopupEdit: 'DISABLE_POPUP_EDIT',
    documentCategories: 'DOCUMENT_CATEGORIES',
    dualAppLogin: 'DUAL_APP_LOGIN',
    enablePopupEdit: 'ENABLE_POPUP_EDIT',
    exportMDModal: 'EXPORT_MD_MODAL',
    getCompanyData: 'GET_COMPANY_DATA',
    getDoctorData: 'GET_DOCTOR_DATA',
    getDeviceGuideResults: 'GET_DEVICE_GUIDE_RESULTS',
    getDeviceGuideSettingOptions: 'GET_DEVICE_GUIDE_SETTING_OPTIONS',
    getEdxCertificatesData: 'GET_EDX_CERTIFICATES_DATA',
    getTask: 'GET_TASK',
    handleErrors: 'HANDLE_ERRORS',
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
    storeLoginDetails: 'STORE_LOGIN_DETAILS',
    submitScreener: 'SUBMIT_SCREENER',
    submitHst: 'SUBMIT_HST',
    updateFlowDevice: 'UPDATE_FLOW_DEVICE',
    updateTaskStatus: 'UPDATE_TASK_STATUS',
    userInfo: 'USER_INFO'
  },
  populators: {
    populateClaims: 'POPULATE_CLAIMS'
  },
  modals: {
    addTask: 'addTask',
    deviceSelector: 'deviceSelector',
    editContact: 'editContact',
    editReferredByContact: 'editReferredByContact',
    editReferredByNote: 'editReferredByNote',
    editSleeplab: 'editSleeplab',
    patientAccessCode: 'patientAccessCode',
    viewContact: 'viewContact',
    viewCorporateContact: 'viewCorporateContact',
    viewSleeplab: 'viewSleeplab'
  }
}
