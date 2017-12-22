import symbols from '../../symbols'
import { HST_STATUSES } from '../../constants/main'

export default {
  [symbols.mutations.patientId] (state, data) {
    state[symbols.state.patientId] = parseInt(data)
  },

  [symbols.mutations.patientData] (state, data) {
    const insuranceType = parseInt(data.insuranceType)
    let hasMedicare = false
    if (insuranceType === 1) {
      hasMedicare = true
    }
    const premedCheck = parseInt(data.preMedCheck)
    const allergen = !!parseInt(data.hasAllergen)
    let title = state[symbols.state.headerTitle]
    if (premedCheck) {
      title += 'Pre-medication: ' + data.preMed + '\n'
    }
    if (allergen) {
      title += 'Allergens: ' + data.otherAllergens + '\n'
    }
    let hstStatus = ''
    const dataStatus = parseInt(data.hstStatus)
    if (HST_STATUSES.hasOwnProperty(dataStatus)) {
      hstStatus = HST_STATUSES[dataStatus]
    }
    state[symbols.state.allergen] = allergen
    state[symbols.state.medicare] = hasMedicare
    state[symbols.state.premedCheck] = premedCheck
    state[symbols.state.patientName] = data.firstName + ' ' + data.lastName
    state[symbols.state.displayAlert] = !!parseInt(data.displayAlert)
    state[symbols.state.headerTitle] = title
    state[symbols.state.headerAlertText] = data.alertText
    state[symbols.state.questionnaireStatuses] = {
      symptoms: parseInt(data.questionnaireData.symptomsStatus),
      treatments: parseInt(data.questionnaireData.treatmentsStatus),
      history: parseInt(data.questionnaireData.historyStatus)
    }
    state[symbols.state.isEmailBounced] = !!parseInt(data.isEmailBounced)
    state[symbols.state.totalPatientContacts] = parseInt(data.patientContactsNumber)
    state[symbols.state.totalPatientInsurances] = parseInt(data.patientInsurancesNumber)
    state[symbols.state.totalSubPatients] = parseInt(data.subPatientsNumber)
    const parsedClaims = []
    for (let rejectedClaim of data.rejectedClaims) {
      const newClaim = {
        insuranceId: parseInt(rejectedClaim.insuranceid),
        addDate: new Date(rejectedClaim.adddate)
      }
      parsedClaims.push(newClaim)
    }
    state[symbols.state.rejectedClaimsForCurrentPatient] = parsedClaims
    state[symbols.state.patientHomeSleepTestStatus] = hstStatus
    const parsedHsts = []
    for (let incompleteHst of data.incompleteHomeSleepTests) {
      const newHst = {
        id: parseInt(incompleteHst.id),
        status: parseInt(incompleteHst.status),
        patientId: parseInt(incompleteHst.patient_id),
        addDate: new Date(incompleteHst.adddate),
        officeNotes: incompleteHst.office_notes,
        rejectedReason: incompleteHst.rejected_reason,
        rejectedDate: null
      }
      if (incompleteHst.rejecteddate) {
        newHst.rejectedDate = new Date(incompleteHst.rejecteddate)
      }
      parsedHsts.push(newHst)
    }
    state[symbols.state.incompleteHomeSleepTests] = parsedHsts
  },

  [symbols.mutations.clearPatientData] (state) {
    state[symbols.state.allergen] = false
    state[symbols.state.medicare] = false
    state[symbols.state.premedCheck] = 0
    state[symbols.state.patientName] = ''
    state[symbols.state.displayAlert] = false
    state[symbols.state.headerTitle] = ''
    state[symbols.state.headerAlertText] = ''
    state[symbols.state.questionnaireStatuses] = {
      symptoms: 0,
      treatments: 0,
      history: 0
    }
    state[symbols.state.isEmailBounced] = false
    state[symbols.state.totalPatientContacts] = 0
    state[symbols.state.totalPatientInsurances] = 0
    state[symbols.state.totalSubPatients] = 0
    state[symbols.state.rejectedClaimsForCurrentPatient] = []
    state[symbols.state.patientHomeSleepTestStatus] = ''
    state[symbols.state.incompleteHomeSleepTests] = []
  },

  [symbols.mutations.showAllWarnings] (state) {
    state[symbols.state.showAllWarnings] = true
  },

  [symbols.mutations.hideAllWarnings] (state) {
    state[symbols.state.showAllWarnings] = false
  }
}
