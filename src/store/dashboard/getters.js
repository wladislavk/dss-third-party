import symbols from '../../symbols'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../../constants'

export default {
  [symbols.getters.documentCategories] (state) {
    return state[symbols.state.documentCategories]
  },
  [symbols.actions.shouldShowEnrollments] (state) {
    const useEligible = state[symbols.state.docInfo].useEligibleApi
    return (useEligible === 1)
  },
  [symbols.actions.shouldShowInvoices] (state) {
    const userId = state[symbols.state.userInfo].userId
    const docId = state[symbols.state.userInfo].docId
    if (userId === docId) {
      return true
    }
    const manageStaff = state[symbols.state.docInfo].manageStaff
    if (manageStaff) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowGetCE] (state) {
    const userId = state[symbols.state.userInfo].userId
    const docId = state[symbols.state.userInfo].docId
    if (userId === docId) {
      return true
    }
    const useCourse = state[symbols.state.courseStaff].useCourse
    const useCourseStaff = state[symbols.state.courseStaff].useCourseStaff
    if (useCourse === 1 && useCourseStaff === 1) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowFranchiseManual] (state) {
    const userType = state[symbols.state.userInfo].userType
    return (userType === this.constants.DSS_USER_TYPE_FRANCHISEE)
  },
  [symbols.getters.shouldShowTransactionCode] (state) {
    const userId = state[symbols.state.userInfo].userId
    const docId = state[symbols.state.userInfo].docId
    if (userId === docId) {
      return true
    }
    const manageStaff = state[symbols.state.userInfo].manageStaff
    if (manageStaff) {
      return true
    }
    return false
  },
  [symbols.getters.shouldShowUnmailedClaims] (state) {
    return (state[symbols.state.userInfo].userType === DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE)
  },
  [symbols.getters.shouldShowUnmailedLettersNumber] (state) {
    if (state[symbols.state.userInfo].userType !== DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE) {
      return false
    }
    if (!this.headerInfo.useLetters) {
      return false
    }
    return true
  },
  [symbols.getters.shouldShowPaymentReportsNumber] (state) {
    return state[symbols.state.usePaymentReports]
  },
  [symbols.getters.shouldShowRejectedPreauthNumber] (state) {
    const rejectedNumber = state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.rejectedPreAuth]
    return !!rejectedNumber
  },
  [symbols.getters.shouldUseLetters] (state) {
    return (state[symbols.state.docInfo].useLetters === 1)
  },
  [symbols.getters.patientNotificationsNumber] (state) {
    const stateNotifications = state[symbols.state.notificationNumbers]
    const number =
      stateNotifications[NOTIFICATION_NUMBERS.patientContacts] +
      stateNotifications[NOTIFICATION_NUMBERS.patientInsurances] +
      stateNotifications[NOTIFICATION_NUMBERS.patientChanges]
    return number
  }
}
