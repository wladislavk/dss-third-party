import { NOTIFICATION_NUMBERS } from '../../../src/constants/main'
import MainModule from '../../../src/store/main'
import symbols from '../../../src/symbols'

describe('Main module mutations', () => {
  describe('notificationNumbers mutation', () => {
    it('populates notification numbers', function () {
      const state = {
        [symbols.state.notificationNumbers]: {
          [NOTIFICATION_NUMBERS.pendingClaims]: 0,
          [NOTIFICATION_NUMBERS.paymentReports]: 0,
          [NOTIFICATION_NUMBERS.patientContacts]: 0,
          [NOTIFICATION_NUMBERS.unmailedClaims]: 0,
          [NOTIFICATION_NUMBERS.unmailedLetters]: 0,
          [NOTIFICATION_NUMBERS.rejectedClaims]: 0,
          [NOTIFICATION_NUMBERS.preAuth]: 0,
          [NOTIFICATION_NUMBERS.pendingPreAuth]: 0,
          [NOTIFICATION_NUMBERS.rejectedPreAuth]: 0,
          [NOTIFICATION_NUMBERS.supportTickets]: 0,
          [NOTIFICATION_NUMBERS.faxAlerts]: 0,
          [NOTIFICATION_NUMBERS.unsignedNotes]: 0,
          [NOTIFICATION_NUMBERS.emailBounces]: 0,
          [NOTIFICATION_NUMBERS.pendingDuplicates]: 0,
          [NOTIFICATION_NUMBERS.patientChanges]: 0,
          [NOTIFICATION_NUMBERS.hst]: 0,
          [NOTIFICATION_NUMBERS.requestedHst]: 0,
          [NOTIFICATION_NUMBERS.rejectedHst]: 0,
          [NOTIFICATION_NUMBERS.patientInsurances]: 0,
          [NOTIFICATION_NUMBERS.pendingLetters]: 0
        }
      }
      const payload = {
        pending_claims: '1',
        payment_reports: '2',
        patient_contacts: '3',
        unmailed_claims: '4',
        unmailed_letters: '5',
        rejected_claims: '6',
        completed_preauth: '7',
        pending_preauth: '8',
        rejected_preauth: '9',
        support_tickets: '10',
        fax_alerts: '11',
        unsigned_notes: '12',
        email_bounces: '13',
        pending_duplicates: '14',
        patient_changes: '15',
        completed_hst: '16',
        requested_hst: '17',
        rejected_hst: '18',
        patient_insurances: '19',
        pending_letters: '20'
      }
      MainModule.mutations[symbols.mutations.notificationNumbers](state, payload)
      const expectedState = {
        [symbols.state.notificationNumbers]: {
          [NOTIFICATION_NUMBERS.pendingClaims]: 1,
          [NOTIFICATION_NUMBERS.paymentReports]: 2,
          [NOTIFICATION_NUMBERS.patientContacts]: 3,
          [NOTIFICATION_NUMBERS.unmailedClaims]: 4,
          [NOTIFICATION_NUMBERS.unmailedLetters]: 5,
          [NOTIFICATION_NUMBERS.rejectedClaims]: 6,
          [NOTIFICATION_NUMBERS.preAuth]: 7,
          [NOTIFICATION_NUMBERS.pendingPreAuth]: 8,
          [NOTIFICATION_NUMBERS.rejectedPreAuth]: 9,
          [NOTIFICATION_NUMBERS.supportTickets]: 10,
          [NOTIFICATION_NUMBERS.faxAlerts]: 11,
          [NOTIFICATION_NUMBERS.unsignedNotes]: 12,
          [NOTIFICATION_NUMBERS.emailBounces]: 13,
          [NOTIFICATION_NUMBERS.pendingDuplicates]: 14,
          [NOTIFICATION_NUMBERS.patientChanges]: 15,
          [NOTIFICATION_NUMBERS.hst]: 16,
          [NOTIFICATION_NUMBERS.requestedHst]: 17,
          [NOTIFICATION_NUMBERS.rejectedHst]: 18,
          [NOTIFICATION_NUMBERS.patientInsurances]: 19,
          [NOTIFICATION_NUMBERS.pendingLetters]: 20,
          [NOTIFICATION_NUMBERS.patientNotifications]: 37
        }
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('modal mutation', () => {
    it('loads modal with params', function () {
      const state = {
        [symbols.state.modal]: {}
      }
      const payload = {
        name: 'foo',
        params: {first: 1, second: 2}
      }
      MainModule.mutations[symbols.mutations.modal](state, payload)
      const expectedState = {
        [symbols.state.modal]: {
          name: 'foo',
          params: {first: 1, second: 2}
        }
      }
      expect(state).toEqual(expectedState)
    })
    it('loads modal without params', function () {
      const state = {
        [symbols.state.modal]: {}
      }
      const payload = {
        name: 'foo'
      }
      MainModule.mutations[symbols.mutations.modal](state, payload)
      const expectedState = {
        [symbols.state.modal]: {
          name: 'foo',
          params: {}
        }
      }
      expect(state).toEqual(expectedState)
    })
  })

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
        rejectedClaims: ['first', 'second'],
        incompleteHomeSleepTests: ['third', 'fourth']
      }
      MainModule.mutations[symbols.mutations.patientData](this.state, data)

      const expectedState = {
        [symbols.state.allergen]: false,
        [symbols.state.medicare]: false,
        [symbols.state.premedCheck]: 0,
        [symbols.state.patientName]: 'John Doe',
        [symbols.state.displayAlert]: true,
        [symbols.state.headerTitle]: 'title',
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
        [symbols.state.rejectedClaimsForCurrentPatient]: ['first', 'second'],
        [symbols.state.patientHomeSleepTestStatus]: '',
        [symbols.state.incompleteHomeSleepTests]: ['third', 'fourth']
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
        rejectedClaims: ['first', 'second'],
        incompleteHomeSleepTests: ['third', 'fourth']
      }
      MainModule.mutations[symbols.mutations.patientData](this.state, data)

      const expectedState = {
        [symbols.state.allergen]: true,
        [symbols.state.medicare]: true,
        [symbols.state.premedCheck]: 1,
        [symbols.state.patientName]: 'John Doe',
        [symbols.state.displayAlert]: true,
        [symbols.state.headerTitle]: 'titlePre-medication: medication\nAllergens: other\n',
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
        [symbols.state.rejectedClaimsForCurrentPatient]: ['first', 'second'],
        [symbols.state.patientHomeSleepTestStatus]: 'Unsent',
        [symbols.state.incompleteHomeSleepTests]: ['third', 'fourth']
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
      MainModule.mutations[symbols.mutations.clearPatientData](state)

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
