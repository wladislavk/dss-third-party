import swal from 'sweetalert'
import endpoints from '../endpoints'
import http from '../services/http'
import symbols from '../symbols'
import ErrorHandler from '../modules/handler/HandlerMixin'
import { DSS_CONSTANTS, NOTIFICATION_NUMBERS } from '../constants'

export default {
  state: {
    [symbols.state.documentCategories]: [],
    [symbols.state.memos]: []
  },
  getters: {
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
  },
  mutations: {
    [symbols.mutations.documentCategories] ({state}, data) {
      state[symbols.state.documentCategories] = data
    },
    [symbols.mutations.memos] ({state, data}) {
      state[symbols.state.memos] = data
    }
  },
  actions: {
    [symbols.actions.documentCategories] ({commit}) {
      http.token = this.$store.state.main[symbols.state.mainToken]

      http.post(endpoints.documentCategories.active).then((response) => {
        commit(symbols.mutations.documentCategories, response.data.data)
      }).catch((response) => {
        ErrorHandler.handleErrors('getDocumentCategories', response)
      })
    },
    [symbols.actions.populateClaims] ({state}, element) {
      const pendingClaimsNumber = state[symbols.state.pendingClaimsNumber]
      element.name += ` (${pendingClaimsNumber})`
    },
    [symbols.actions.deviceSelectorModal] () {
      this.$parent.$refs.modal.display('device-selector')
    },
    [symbols.actions.exportMDModal] () {
      swal(
        {
          title: '',
          text: 'Enter your password',
          type: 'input',
          inputType: 'password',
          showCancelButton: true,
          closeOnConfirm: false,
          animation: 'slide-from-top',
          inputPlaceholder: 'Enter password'
        },
        (inputValue) => {
          if (inputValue === '1234') {
            swal.close()
            window.location.href = this.legacyUrl + '/manage/export_md.php'
            return true
          }
          if (inputValue.length > 0) {
            swal('Oops...', 'Wrong password!', 'error')
            return false
          }
          const errorText = 'You need to write the password!'
          swal.showInputError(errorText)
          return false
        }
      )
    },
    [symbols.actions.dataImportModal] () {
      swal(
        {
          title: '',
          text: 'Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3CB371',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
          closeOnConfirm: true,
          closeOnCancel: true
        },
        (isConfirm) => {
          if (isConfirm) {
            window.location.href = this.legacyUrl + '/manage/data_import.php'
          }
        }
      )
    },
    [symbols.actions.memos] ({commit}) {
      http.post(endpoints.memos.current).then((response) => {
        commit(symbols.mutations.memos, response.data.data)
      }).catch((response) => {
        ErrorHandler.handleErrors('getCurrentMemos', response)
      })
    }
  }
}
