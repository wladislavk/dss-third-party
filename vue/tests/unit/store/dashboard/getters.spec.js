import symbols from '../../../../src/symbols'
import DashboardModule from '../../../../src/store/dashboard'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../../../src/constants/main'

describe('Dashboard module getters', () => {
  describe('documentCategories getter', () => {
    it('gets document categories', function () {
      const state = {
        [symbols.state.documentCategories]: [
          { id: 1 },
          { id: 2 }
        ]
      }
      const result = DashboardModule.getters[symbols.getters.documentCategories](state)
      expect(result).toEqual(state[symbols.state.documentCategories])
    })
  })

  describe('shouldShowEnrollments getter', () => {
    it('gets enrollments with eligible', function () {
      const rootState = {
        main: {
          [symbols.state.docInfo]: {
            useEligibleApi: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowEnrollments]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets enrollments without eligible', function () {
      const rootState = {
        main: {
          [symbols.state.docInfo]: {
            useEligibleApi: 2
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowEnrollments]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })

  describe('shouldShowInvoices getter', () => {
    it('gets invoices for doctor', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 1
          },
          [symbols.state.docInfo]: {
            manageStaff: false
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowInvoices]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets invoices for staff manager', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 2
          },
          [symbols.state.docInfo]: {
            manageStaff: true
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowInvoices]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets invoices for others', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 2
          },
          [symbols.state.docInfo]: {
            manageStaff: false
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowInvoices]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })

  describe('shouldShowGetCE getter', () => {
    it('gets CE for course', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            useCourse: 1
          },
          [symbols.state.docInfo]: {
            useCourseStaff: 0
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowGetCE]({}, {}, rootState)
      expect(result).toBe(false)
    })
    it('gets CE for course staff', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            useCourse: 0
          },
          [symbols.state.docInfo]: {
            useCourseStaff: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowGetCE]({}, {}, rootState)
      expect(result).toBe(false)
    })
    it('gets CE for course and staff', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            useCourse: 1
          },
          [symbols.state.docInfo]: {
            useCourseStaff: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowGetCE]({}, {}, rootState)
      expect(result).toBe(true)
    })
  })

  describe('shouldShowFranchiseManual getter', () => {
    it('gets manual for franchisee', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowFranchiseManual]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets manual for others', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowFranchiseManual]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })

  describe('shouldShowTransactionCode getter', () => {
    it('gets transaction code for doctor', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 1,
            manageStaff: false
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowTransactionCode]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets transaction code for staff manager', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 2,
            manageStaff: true
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowTransactionCode]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets transaction code for others', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 1,
            docId: 2,
            manageStaff: false
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowTransactionCode]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })

  describe('shouldShowUnmailedClaims getter', () => {
    it('gets claims for software', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowUnmailedClaims]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets claims for others', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowUnmailedClaims]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })

  describe('shouldShowUnmailedLettersNumber getter', () => {
    it('gets letters for franchisee', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE
          },
          [symbols.state.docInfo]: {
            useLetters: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowUnmailedLettersNumber]({}, {}, rootState)
      expect(result).toBe(false)
    })
    it('gets letters without letters', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE
          },
          [symbols.state.docInfo]: {
            useLetters: 0
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowUnmailedLettersNumber]({}, {}, rootState)
      expect(result).toBe(false)
    })
    it('gets letters for software', function () {
      const rootState = {
        main: {
          [symbols.state.userInfo]: {
            userType: DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE
          },
          [symbols.state.docInfo]: {
            useLetters: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowUnmailedLettersNumber]({}, {}, rootState)
      expect(result).toBe(true)
    })
  })

  describe('shouldShowPaymentReportsNumber getter', () => {
    it('gets payment reports number', function () {
      const rootState = {
        main: {
          [symbols.state.docInfo]: {
            usePaymentReports: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowPaymentReportsNumber]({}, {}, rootState)
      expect(result).toBe(true)
    })
  })

  describe('shouldShowRejectedPreauthNumber getter', () => {
    it('gets rejected preauth number', function () {
      const rootState = {
        main: {
          [symbols.state.notificationNumbers]: {
            [NOTIFICATION_NUMBERS.rejectedPreAuth]: 3
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldShowRejectedPreauthNumber]({}, {}, rootState)
      expect(result).toBe(true)
    })
  })

  describe('shouldUseLetters getter', () => {
    it('gets letters with useLetters', function () {
      const rootState = {
        main: {
          [symbols.state.docInfo]: {
            useLetters: 1
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldUseLetters]({}, {}, rootState)
      expect(result).toBe(true)
    })
    it('gets letters without useLetters', function () {
      const rootState = {
        main: {
          [symbols.state.docInfo]: {
            useLetters: 2
          }
        }
      }
      const result = DashboardModule.getters[symbols.getters.shouldUseLetters]({}, {}, rootState)
      expect(result).toBe(false)
    })
  })
})
