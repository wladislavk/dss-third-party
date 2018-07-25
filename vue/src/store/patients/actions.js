import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.patientData] ({rootState, commit, dispatch}, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.patients.patientData + '/' + patientId).then((response) => {
      commit(symbols.mutations.patientId, patientId)
      const data = response.data.data
      const patientData = {
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
      }
      commit(symbols.mutations.patientData, patientData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getPatientByIdAndDocId', response: response })
    })
  },

  [symbols.actions.clearPatientData] ({commit}) {
    commit(symbols.mutations.patientId, 0)
    commit(symbols.mutations.clearPatientData)
  },

  [symbols.actions.patientClinicalExam] ({ rootState, state, dispatch }, deviceId) {
    http.token = rootState.main[symbols.state.mainToken]
    const data = {
      dentaldevice: deviceId,
      patientid: state[symbols.state.patientId]
    }
    return http.post(endpoints.tmjClinicalExams.storeForPatient, data).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'storeClinicalExam', response: response })
    })
  }
}
