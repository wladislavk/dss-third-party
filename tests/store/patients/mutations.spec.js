import PatientsModule from '../../../src/store/patients'
import symbols from '../../../src/symbols'

describe('Patients module mutations', () => {
  describe('patientData mutation', () => {
    beforeEach(function () {
      this.state = {
        [symbols.state.allergen]: false,
        [symbols.state.medicare]: false,
        [symbols.state.premedCheck]: 0,
        [symbols.state.patientName]: '',
        [symbols.state.displayAlert]: false,
        [symbols.state.headerTitle]: 'title',
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
    })
    it('sets patient data', function () {
      const data = {
        insuranceType: '0',
        preMedCheck: '0',
        hasAllergen: '0',
        preMed: '',
        otherAllergens: '',
        hstStatus: '9',
        firstName: 'John',
        lastName: 'Doe',
        displayAlert: '1',
        alertText: 'alert',
        questionnaireData: {
          symptomsStatus: '2',
          treatmentsStatus: '3',
          historyStatus: '4'
        },
        isEmailBounced: '1',
        patientContactsNumber: '5',
        patientInsurancesNumber: '6',
        subPatientsNumber: '7',
        rejectedClaims: [
          {
            insuranceid: '1',
            adddate: '12/10/2017'
          },
          {
            insuranceid: '2',
            adddate: '12/11/2017'
          }
        ],
        incompleteHomeSleepTests: [
          {
            id: '1',
            status: '2',
            patient_id: '3',
            office_notes: 'notes',
            rejected_reason: 'reason',
            adddate: '05/03/2015',
            rejecteddate: '10/23/2016'
          },
          {
            id: '1',
            status: '2',
            patient_id: '3',
            office_notes: 'notes',
            rejected_reason: 'reason',
            adddate: '06/04/2015',
            rejecteddate: null
          }
        ]
      }
      PatientsModule.mutations[symbols.mutations.patientData](this.state, data)

      const expectedState = {
        [symbols.state.allergen]: false,
        [symbols.state.medicare]: false,
        [symbols.state.premedCheck]: 0,
        [symbols.state.patientName]: 'John Doe',
        [symbols.state.displayAlert]: true,
        [symbols.state.headerTitle]: '',
        [symbols.state.headerAlertText]: 'alert',
        [symbols.state.questionnaireStatuses]: {
          symptoms: 2,
          treatments: 3,
          history: 4
        },
        [symbols.state.isEmailBounced]: true,
        [symbols.state.totalPatientContacts]: 5,
        [symbols.state.totalPatientInsurances]: 6,
        [symbols.state.totalSubPatients]: 7,
        [symbols.state.rejectedClaimsForCurrentPatient]: [
          {
            insuranceId: 1,
            addDate: new Date('12/10/2017')
          },
          {
            insuranceId: 2,
            addDate: new Date('12/11/2017')
          }
        ],
        [symbols.state.patientHomeSleepTestStatus]: '',
        [symbols.state.incompleteHomeSleepTests]: [
          {
            id: 1,
            status: 2,
            patientId: 3,
            officeNotes: 'notes',
            rejectedReason: 'reason',
            addDate: new Date('05/03/2015'),
            rejectedDate: new Date('10/23/2016')
          },
          {
            id: 1,
            status: 2,
            patientId: 3,
            officeNotes: 'notes',
            rejectedReason: 'reason',
            addDate: new Date('06/04/2015'),
            rejectedDate: null
          }
        ]
      }
      expect(this.state).toEqual(expectedState)
    })
    it('sets patient data with medicare, pre-med, allergen and HST status', function () {
      const data = {
        insuranceType: '1',
        preMedCheck: '1',
        hasAllergen: '1',
        preMed: 'medication',
        otherAllergens: 'other',
        hstStatus: '0',
        firstName: 'John',
        lastName: 'Doe',
        displayAlert: '1',
        alertText: 'alert',
        questionnaireData: {
          symptomsStatus: '2',
          treatmentsStatus: '3',
          historyStatus: '4'
        },
        isEmailBounced: '1',
        patientContactsNumber: '5',
        patientInsurancesNumber: '6',
        subPatientsNumber: '7',
        rejectedClaims: [],
        incompleteHomeSleepTests: []
      }
      PatientsModule.mutations[symbols.mutations.patientData](this.state, data)

      const expectedState = {
        [symbols.state.allergen]: true,
        [symbols.state.medicare]: true,
        [symbols.state.premedCheck]: 1,
        [symbols.state.patientName]: 'John Doe',
        [symbols.state.displayAlert]: true,
        [symbols.state.headerTitle]: 'Pre-medication: medication\nAllergens: other\n',
        [symbols.state.headerAlertText]: 'alert',
        [symbols.state.questionnaireStatuses]: {
          symptoms: 2,
          treatments: 3,
          history: 4
        },
        [symbols.state.isEmailBounced]: true,
        [symbols.state.totalPatientContacts]: 5,
        [symbols.state.totalPatientInsurances]: 6,
        [symbols.state.totalSubPatients]: 7,
        [symbols.state.rejectedClaimsForCurrentPatient]: [],
        [symbols.state.patientHomeSleepTestStatus]: 'Unsent',
        [symbols.state.incompleteHomeSleepTests]: []
      }
      expect(this.state).toEqual(expectedState)
    })
  })

  describe('clearPatientData mutation', () => {
    it('clears patient data', function () {
      const state = {
        [symbols.state.allergen]: true,
        [symbols.state.medicare]: true,
        [symbols.state.premedCheck]: 3,
        [symbols.state.patientName]: 'John',
        [symbols.state.displayAlert]: true,
        [symbols.state.headerTitle]: 'foo',
        [symbols.state.headerAlertText]: 'bar',
        [symbols.state.questionnaireStatuses]: {
          symptoms: 4,
          treatments: 5,
          history: 6
        },
        [symbols.state.isEmailBounced]: true,
        [symbols.state.totalPatientContacts]: 7,
        [symbols.state.totalPatientInsurances]: 8,
        [symbols.state.totalSubPatients]: 9,
        [symbols.state.rejectedClaimsForCurrentPatient]: ['first', 'second'],
        [symbols.state.patientHomeSleepTestStatus]: 'baz',
        [symbols.state.incompleteHomeSleepTests]: ['first', 'second']
      }
      PatientsModule.mutations[symbols.mutations.clearPatientData](state)

      const expectedState = {
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
      expect(state).toEqual(expectedState)
    })
  })
})
