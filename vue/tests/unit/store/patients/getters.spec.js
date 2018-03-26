import symbols from '../../../../src/symbols'
import PatientsModule from '../../../../src/store/patients'

describe('Patients module getters', () => {
  describe('patientId getter', () => {
    it('gets patient ID', function () {
      const state = {
        [symbols.state.patientId]: 1
      }
      const result = PatientsModule.getters[symbols.getters.patientId](state)
      expect(result).toBe(1)
    })
  })

  describe('showWarningAboutQuestionnaireChanges getter', () => {
    it('shows warning for symptoms', function () {
      const state = {
        [symbols.state.questionnaireStatuses]: {
          symptoms: 2,
          treatments: 0,
          history: 0
        }
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutQuestionnaireChanges](state)
      expect(result).toBe(true)
    })
    it('shows warning for treatments', function () {
      const state = {
        [symbols.state.questionnaireStatuses]: {
          symptoms: 0,
          treatments: 2,
          history: 0
        }
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutQuestionnaireChanges](state)
      expect(result).toBe(true)
    })
    it('shows warning for history', function () {
      const state = {
        [symbols.state.questionnaireStatuses]: {
          symptoms: 0,
          treatments: 0,
          history: 2
        }
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutQuestionnaireChanges](state)
      expect(result).toBe(true)
    })
    it('does not show warning', function () {
      const state = {
        [symbols.state.questionnaireStatuses]: {
          symptoms: 0,
          treatments: 0,
          history: 0
        }
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutQuestionnaireChanges](state)
      expect(result).toBe(false)
    })
  })

  describe('showWarningAboutBouncedEmails getter', () => {
    it('shows warning', function () {
      const state = {
        [symbols.state.isEmailBounced]: true
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutBouncedEmails](state)
      expect(result).toBe(true)
    })
  })

  describe('showWarningAboutPatientChanges getter', () => {
    it('shows warning for sub-patients', function () {
      const state = {
        [symbols.state.totalSubPatients]: 2,
        [symbols.state.totalPatientContacts]: 0,
        [symbols.state.totalPatientInsurances]: 0
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutPatientChanges](state)
      expect(result).toBe(true)
    })
    it('shows warning for contacts', function () {
      const state = {
        [symbols.state.totalSubPatients]: 0,
        [symbols.state.totalPatientContacts]: 2,
        [symbols.state.totalPatientInsurances]: 0
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutPatientChanges](state)
      expect(result).toBe(true)
    })
    it('shows warning for insurances', function () {
      const state = {
        [symbols.state.totalSubPatients]: 0,
        [symbols.state.totalPatientContacts]: 0,
        [symbols.state.totalPatientInsurances]: 2
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutPatientChanges](state)
      expect(result).toBe(true)
    })
    it('does not show warning', function () {
      const state = {
        [symbols.state.totalSubPatients]: 0,
        [symbols.state.totalPatientContacts]: 0,
        [symbols.state.totalPatientInsurances]: 0
      }
      const result = PatientsModule.getters[symbols.getters.showWarningAboutPatientChanges](state)
      expect(result).toBe(false)
    })
  })
})
