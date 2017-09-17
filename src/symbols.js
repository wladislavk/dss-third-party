export default {
  state: {
    coMorbidityData: 'CO_MORBIDITY_DATA',
    companyData: 'COMPANY_DATA',
    contact: 'CONTACT',
    contactData: 'CONTACT_DATA',
    doctorName: 'DOCTOR_NAME',
    epworthOptions: 'EPWORTH_OPTIONS',
    epworthProps: 'EPWORTH_PROPS',
    screenerWeights: 'SCREENER_WEIGHTS',
    symptoms: 'SYMPTOMS',
    cpap: 'CPAP',
    sessionData: 'SESSION_DATA'
  },
  getters: {
    calculateRisk: 'CALCULATE_RISK',
    filteredContact: 'FILTERED_CONTACT',
    fullContactData: 'FULL_CONTACT_DATA',
    fullName: 'FULL_NAME'
  },
  mutations: {
    coMorbidity: 'CO_MORBIDITY',
    coMorbidityWeight: 'CO_MORBIDITY_WEIGHT',
    companyData: 'COMPANY_DATA',
    contactData: 'CONTACT_DATA',
    doctorName: 'DOCTOR_NAME',
    epworthWeight: 'EPWORTH_WEIGHT',
    popupEdit: 'POPUP_EDIT',
    restoreInitialScreener: 'RESTORE_INITIAL_SCREENER',
    setContact: 'SET_CONTACT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    surveyWeight: 'SURVEY_WEIGHT',
    symptoms: 'SYMPTOMS',
    cpap: 'CPAP'
  },
  actions: {
    disablePopupEdit: 'DISABLE_POPUP_EDIT',
    getCompanyData: 'GET_COMPANY_DATA',
    getDoctorData: 'GET_DOCTOR_DATA',
    handleErrors: 'HANDLE_ERRORS',
    parseScreenerResults: 'PARSE_SCREENER_RESULTS',
    setCurrentContact: 'SET_CURRENT_CONTACT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    submitScreener: 'SUBMIT_SCREENER',
    submitHst: 'SUBMIT_HST'
  }
}
