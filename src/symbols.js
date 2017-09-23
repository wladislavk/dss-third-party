export default {
  state: {
    coMorbidityData: 'CO_MORBIDITY_DATA',
    companyData: 'COMPANY_DATA',
    contact: 'CONTACT',
    contactData: 'CONTACT_DATA',
    cpap: 'CPAP',
    doctorName: 'DOCTOR_NAME',
    epworthOptions: 'EPWORTH_OPTIONS',
    epworthProps: 'EPWORTH_PROPS',
    screenerId: 'SCREENER_ID',
    screenerToken: 'SCREENER_TOKEN',
    screenerWeights: 'SCREENER_WEIGHTS',
    sessionData: 'SESSION_DATA',
    symptoms: 'SYMPTOMS'
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
    cpap: 'CPAP',
    doctorName: 'DOCTOR_NAME',
    epworthWeight: 'EPWORTH_WEIGHT',
    modifyEpworthProps: 'MODIFY_EPWORTH_PROPS',
    popupEdit: 'POPUP_EDIT',
    restoreInitialScreener: 'RESTORE_INITIAL_SCREENER',
    screenerId: 'SCREENER_ID',
    screenerToken: 'SCREENER_TOKEN',
    sessionData: 'SESSION_DATA',
    setContact: 'SET_CONTACT',
    setEpworthErrors: 'SET_EPWORTH_ERRORS',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    surveyWeight: 'SURVEY_WEIGHT',
    symptoms: 'SYMPTOMS'
  },
  actions: {
    authenticateScreener: 'AUTHENTICATE_SCREENER',
    disablePopupEdit: 'DISABLE_POPUP_EDIT',
    getCompanyData: 'GET_COMPANY_DATA',
    getDoctorData: 'GET_DOCTOR_DATA',
    handleErrors: 'HANDLE_ERRORS',
    parseScreenerResults: 'PARSE_SCREENER_RESULTS',
    setCurrentContact: 'SET_CURRENT_CONTACT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    setSessionData: 'SET_SESSION_DATA',
    submitScreener: 'SUBMIT_SCREENER',
    submitHst: 'SUBMIT_HST'
  }
}
