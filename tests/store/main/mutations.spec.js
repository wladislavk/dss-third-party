import { NOTIFICATION_NUMBERS } from '../../../src/constants'
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
          [NOTIFICATION_NUMBERS.pendingLetters]: 20
        }
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('patientName mutation', () => {
    it('populates patient name', function () {
      const state = {
        [symbols.state.patientName]: ''
      }
      const payload = {
        firstName: 'John',
        lastName: 'Doe'
      }
      MainModule.mutations[symbols.mutations.patientName](state, payload)
      const expectedState = {
        [symbols.state.patientName]: 'John Doe'
      }
      expect(state).toEqual(expectedState)
    })
  })
})
