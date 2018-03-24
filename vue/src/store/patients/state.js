import symbols from '../../symbols'

export default {
  [symbols.state.patientId]: 0,
  [symbols.state.allergen]: false,
  [symbols.state.medicare]: false,
  [symbols.state.premedCheck]: 0,
  [symbols.state.patientName]: '',
  [symbols.state.displayAlert]: false,
  [symbols.state.headerTitle]: '',
  [symbols.state.headerAlertText]: '',
  [symbols.state.questionnaireStatuses]: {
    symptoms: 0,
    treatments: 0,
    history: 0
  },
  [symbols.state.isEmailBounced]: false,
  [symbols.state.totalPatientContacts]: 0,
  [symbols.state.totalPatientInsurances]: 0,
  [symbols.state.totalSubPatients]: 0,
  [symbols.state.rejectedClaimsForCurrentPatient]: [],
  [symbols.state.patientHomeSleepTestStatus]: '',
  [symbols.state.incompleteHomeSleepTests]: []
}
