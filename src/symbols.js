export default {
  state: {
    assessmentName: 'ASSESSMENT_NAME',
    coMorbidityData: 'CO_MORBIDITY_DATA',
    contactData: 'CONTACT_DATA',
    contactProperties: 'CONTACT_PROPERTIES',
    doctorName: 'DOCTOR_NAME',
    epworthOptions: 'EPWORTH_OPTIONS',
    epworthProps: 'EPWORTH_PROPS',
    screenerWeights: 'SCREENER_WEIGHTS',
    symptoms: 'SYMPTOMS'
  },
  getters: {
    calculateRisk: 'CALCULATE_RISK',
    filteredContact: 'FILTERED_CONTACT',
    fullContactData: 'FULL_CONTACT_DATA',
    diagnosisCoMorbidity: 'DIAGNOSIS_CO_MORBIDITY'
  },
  mutations: {
    coMorbidityWeight: 'CO_MORBIDITY_WEIGHT',
    contactProperties: 'CONTACT_PROPERTIES',
    doctorName: 'DOCTOR_NAME',
    epworthWeight: 'EPWORTH_WEIGHT',
    setAssessmentName: 'SET_ASSESSMENT_NAME',
    popupEdit: 'POPUP_EDIT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    surveyWeight: 'SURVEY_WEIGHT'
  },
  actions: {
    disablePopupEdit: 'DISABLE_POPUP_EDIT',
    getDoctorData: 'GET_DOCTOR_DATA',
    handleErrors: 'HANDLE_ERRORS',
    parseScreenerResults: 'PARSE_SCREENER_RESULTS',
    setCurrentContact: 'SET_CURRENT_CONTACT',
    setEpworthProps: 'SET_EPWORTH_PROPS',
    submitScreener: 'SUBMIT_SCREENER'
  }
}
