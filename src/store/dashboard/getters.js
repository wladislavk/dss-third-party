import symbols from '../../symbols'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../constants/main'

export default {
  [symbols.getters.documentCategories] (state) {
    return state[symbols.state.documentCategories]
  },
  [symbols.getters.shouldShowEnrollments] (state, getters, rootState) {
    const useEligible = rootState.main[symbols.state.docInfo].useEligibleApi
    if (useEligible === 1) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowInvoices] (state, getters, rootState) {
    const userId = rootState.main[symbols.state.userInfo].plainUserId
    const docId = rootState.main[symbols.state.userInfo].docId
    if (userId === docId) {
      return true
    }
    const manageStaff = rootState.main[symbols.state.docInfo].manageStaff
    if (manageStaff) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowGetCE] (state, getters, rootState) {
    const userId = rootState.main[symbols.state.userInfo].plainUserId
    const docId = rootState.main[symbols.state.userInfo].docId
    if (userId === docId) {
      if (rootState.main[symbols.state.userInfo].useCourse === 1) {
        return true
      }
      return false
    }
    const useCourse = rootState.main[symbols.state.courseStaff].useCourse
    const useCourseStaff = rootState.main[symbols.state.courseStaff].useCourseStaff
    if (useCourse !== 1) {
      return false
    }
    if (useCourseStaff !== 1) {
      return false
    }
    return true
  },
  [symbols.getters.shouldShowFranchiseManual] (state, getters, rootState) {
    const userType = rootState.main[symbols.state.userInfo].userType
    if (userType === DSS_CONSTANTS.DSS_USER_TYPE_FRANCHISEE) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowTransactionCode] (state, getters, rootState) {
    const userId = rootState.main[symbols.state.userInfo].plainUserId
    const docId = rootState.main[symbols.state.userInfo].docId
    if (userId === docId) {
      return true
    }
    const manageStaff = rootState.main[symbols.state.userInfo].manageStaff
    if (manageStaff) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowUnmailedClaims] (state, getters, rootState) {
    if (rootState.main[symbols.state.userInfo].userType === DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowUnmailedLettersNumber] (state, getters, rootState) {
    if (rootState.main[symbols.state.userInfo].userType !== DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
      return false
    }
    if (!rootState.main[symbols.state.docInfo].useLetters) {
      return false
    }
    return true
  },
  [symbols.getters.shouldShowPaymentReportsNumber] (state, getters, rootState) {
    return !!rootState.main[symbols.state.docInfo].usePaymentReports
  },
  [symbols.getters.shouldShowRejectedPreauthNumber] (state, getters, rootState) {
    const rejectedNumber = rootState.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.rejectedPreAuth]
    return !!rejectedNumber
  },
  [symbols.getters.shouldUseLetters] (state, getters, rootState) {
    if (rootState.main[symbols.state.docInfo].useLetters === 1) {
      return true
    }
    return false
  }
}
