import symbols from '../../../src/symbols'
import MainModule from '../../../src/store/main'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../../src/constants'

describe('Main module getters', () => {
  describe('notificationsNumber getter', () => {
    beforeEach(function () {
      this.state = {
        [symbols.state.userInfo]: {
          userType: DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE
        },
        [symbols.state.notificationNumbers]: {
          [NOTIFICATION_NUMBERS.pendingLetters]: 1,
          [NOTIFICATION_NUMBERS.preAuth]: 2,
          [NOTIFICATION_NUMBERS.rejectedPreAuth]: 3,
          [NOTIFICATION_NUMBERS.patientContacts]: 4,
          [NOTIFICATION_NUMBERS.patientInsurances]: 5,
          [NOTIFICATION_NUMBERS.patientChanges]: 6,
          [NOTIFICATION_NUMBERS.emailBounces]: 7,
          [NOTIFICATION_NUMBERS.unsignedNotes]: 8,
          [NOTIFICATION_NUMBERS.pendingDuplicates]: 9,
          [NOTIFICATION_NUMBERS.pendingClaims]: 10,
          [NOTIFICATION_NUMBERS.unmailedClaims]: 11
        }
      }
    })
    it('should calculate number for software', function () {
      const result = MainModule.getters[symbols.getters.notificationsNumber](this.state)
      expect(result).toBe(55)
    })
    it('should calculate number for non-software type', function () {
      this.state[symbols.state.userInfo].userType = DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE
      const result = MainModule.getters[symbols.getters.notificationsNumber](this.state)
      expect(result).toBe(66)
    })
  })
  describe('isUserDoctor getter', () => {
    it('should get doctor user', function () {
      const state = {
        [symbols.state.userInfo]: {
          userId: 1,
          docId: 2
        }
      }
      const result = MainModule.getters[symbols.getters.isUserDoctor](state)
      expect(result).toBe(false)
    })
    it('should get non-doctor user', function () {
      const state = {
        [symbols.state.userInfo]: {
          userId: 1,
          docId: 1
        }
      }
      const result = MainModule.getters[symbols.getters.isUserDoctor](state)
      expect(result).toBe(true)
    })
  })
})
