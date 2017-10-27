import Vue from 'vue'
import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import storage from '../../modules/storage'
import ErrorHandler from '../../modules/handler/HandlerMixin'

export default {
  [symbols.actions.userInfo] ({commit, dispatch}) {
    http.post(endpoints.users.current).then((response) => {
      const data = response.data.data
      const userInfo = {
        userId: data.id,
        docId: data.docid,
        manageStaff: data.manage_staff,
        userType: parseInt(data.user_type),
        useCourse: parseInt(data.use_course),
        loginId: data.loginid,
        username: data.username
      }
      commit(symbols.mutations.userInfo, userInfo)
      dispatch(symbols.actions.docInfo, data.id)
    }).catch((response) => {
      this.handleErrors('getCurrentUser', response)
    })
  },
  [symbols.actions.docInfo] ({commit}, userId) {
    http.get(endpoints.users.show + '/' + userId).then((response) => {
      const data = response.data.data
      const docInfo = {
        homepage: data.homepage,
        manageStaff: data.manage_staff,
        useEligibleApi: data.use_eligible_api,
        useLetters: parseInt(data.use_letters)
      }
      commit(symbols.mutations.docInfo, docInfo)
    }).catch((response) => {
      this.handleErrors('getUser', response)
    })
  },
  [symbols.actions.disablePopupEdit] ({commit}) {
    commit(symbols.mutations.popupEdit, {
      value: false
    })
  },
  [symbols.actions.handleErrors] ({title, response}) {
    // @todo: use wrappers to make this action testable
    // token expired
    if (response.status === 401) {
      storage.remove('token')
      Vue.$router.push('/manage/login')
    } else {
      if (process.env.NODE_ENV === 'development') {
        console.error(title + ' [status]: ', response.status)
      } else {
        // TODO if prod
      }
    }
  },
  [symbols.actions.courseStaff] ({commit}) {
    http.post(endpoints.users.courseStaff).then((response) => {
      const data = response.data.data
      const courseStaffData = {
        useCourse: parseInt(data.use_course),
        useCourseStaff: parseInt(data.use_course_staff)
      }
      commit(symbols.mutations.courseStaff, courseStaffData)
    }).catch((response) => {
      ErrorHandler.handleErrors('getCourseStaff', response)
    })
  },
  [symbols.actions.usePaymentReports] ({commit, dispatch}) {
    http.post(endpoints.users.paymentReports).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('use_payment_reports')) {
        commit(symbols.mutations.usePaymentReports, !!data.use_payment_reports)
        dispatch(symbols.actions.paymentReportsNumber)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getUsingPaymentReports', response)
    })
  },
  [symbols.actions.paymentReportsNumber] ({state, commit}) {
    if (!state[symbols.state.usePaymentReports]) {
      return
    }
    http.post(endpoints.paymentReports.number).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.paymentReportsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPaymentReportsNumber', response)
    })
  },
  [symbols.actions.pendingClaimsNumber] ({commit}) {
    http.post(endpoints.insurances.pendingClaims).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.pendingClaimsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPendingClaimsNumber', response)
    })
  },
  [symbols.actions.patientContactsNumber] ({commit}) {
    http.post(endpoints.patientContacts.number).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.patientContactsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPatientContactsNumber', response)
    })
  },
  [symbols.actions.unmailedLettersNumber] ({commit}) {
    http.post(endpoints.letters.unmailed).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.unmailedLettersNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getUnmailedLettersNumber', response)
    })
  },
  [symbols.actions.unmailedClaimsNumber] ({commit}) {
    http.post(endpoints.insurances.unmailedClaims).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.unmailedClaimsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getUnmailedClaimsNumber', response)
    })
  },
  [symbols.actions.rejectedClaimsNumber] ({commit}) {
    http.post(endpoints.insurances.rejectedClaims).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.rejectedClaimsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getRejectedClaimsNumber', response)
    })
  },
  [symbols.actions.preauthNumber] ({commit}) {
    http.post(endpoints.insurancePreauth.completed).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.preauthNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPreauthNumber', response)
    })
  },
  [symbols.actions.pendingPreauthNumber] ({commit}) {
    http.post(endpoints.insurancePreauth.pending).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.pendingPreauthNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPendingPreauthNumber', response)
    })
  },
  [symbols.actions.rejectedPreauthNumber] ({commit}) {
    http.post(endpoints.insurancePreauth.rejected).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.rejectedPreauthNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getRejectedPreauthNumber', response)
    })
  },
  [symbols.actions.supportTicketsNumber] ({commit}) {
    http.post(endpoints.supportTickets.number).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.supportTicketsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getSupportTicketsNumber', response)
    })
  },
  [symbols.actions.faxAlertsNumber] ({commit}) {
    http.post(endpoints.faxes.alerts).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.faxAlertsNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getFaxAlertsNumber', response)
    })
  },
  [symbols.actions.unsignedNotesNumber] ({commit}) {
    http.post(endpoints.notes.unsigned).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.unsignedNotesNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getUnsignedNotesNumber', response)
    })
  },
  [symbols.actions.emailBouncesNumber] ({commit}) {
    http.post(endpoints.patients.bounces).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.emailBouncesNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getBouncesNumber', response)
    })
  },
  [symbols.actions.pendingDuplicatesNumber] ({commit}) {
    http.post(endpoints.patients.duplicates).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.pendingDuplicatesNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPendingDuplicatesNumber', response)
    })
  },
  [symbols.actions.patientChangesNumber] ({commit}) {
    http.post(endpoints.patients.number).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.patientChangesNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPatientChangesNumber', response)
    })
  },
  [symbols.actions.hstNumber] ({commit}) {
    http.post(endpoints.homeSleepTests.completed).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.hstNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getHSTNumber', response)
    })
  },
  [symbols.actions.requestedHstNumber] ({commit}) {
    http.post(endpoints.homeSleepTests.requested).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.requestedHstNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getRequestedHSTNumber', response)
    })
  },
  [symbols.actions.rejectedHstNumber] ({commit}) {
    http.post(endpoints.homeSleepTests.rejected).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.rejectedHstNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getRejectedHSTNumber', response)
    })
  },
  [symbols.actions.patientInsurancesNumber] ({commit}) {
    http.post(endpoints.patientInsurances.number).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('total')) {
        commit(symbols.mutations.patientInsurancesNumber, data.total)
      }
    }).catch((response) => {
      ErrorHandler.handleErrors('getPatientInsurancesNumber', response)
    })
  },
  [symbols.actions.pendingLettersNumber] ({commit}) {
    http.post(endpoints.letters.pending).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.pendingLettersNumber, data.length)
    }).catch((response) => {
      this.handleErrors('getPendingLetters', response)
    })
  }
}
