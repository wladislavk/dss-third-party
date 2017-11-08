import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocalStorageManager from '../../services/LocalStorageManager'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import RouterKeeper from '../../services/RouterKeeper'
import { HST_STATUSES } from '../../constants/main'
import MediaFileRetriever from '../../services/MediaFileRetriever'
import FileRetrievalError from '../../exceptions/FileRetrievalError'

export default {
  [symbols.actions.userInfo] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    return http.request('post', endpoints.users.current).then((response) => {
      const data = response.data.data
      const userInfo = {
        userId: data.id,
        plainUserId: parseInt(data.id.replace('u_', '').replace('a_', '')),
        docId: data.docid,
        manageStaff: data.manage_staff,
        userType: parseInt(data.user_type),
        useCourse: parseInt(data.use_course),
        loginId: data.loginid,
        username: data.username
      }
      commit(symbols.mutations.userInfo, userInfo)
      commit(symbols.mutations.notificationNumbers, data.numbers)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentUser', response: response})
    })
  },
  [symbols.actions.docInfo] ({state, commit, dispatch}) {
    const userId = state[symbols.state.userInfo].docId
    http.token = state[symbols.state.mainToken]
    http.get(endpoints.users.show + '/' + userId).then((response) => {
      const data = response.data.data
      const docInfo = {
        homepage: data.homepage,
        manageStaff: data.manage_staff,
        useEligibleApi: data.use_eligible_api,
        useLetters: parseInt(data.use_letters),
        usePatientPortal: data.use_patient_portal,
        usePaymentReports: data.use_payment_reports
      }
      commit(symbols.mutations.docInfo, docInfo)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getUser', response: response})
    })
  },
  [symbols.actions.disablePopupEdit] ({commit}) {
    commit(symbols.mutations.popupEdit, {
      value: false
    })
  },
  [symbols.actions.handleErrors] (data, {title, response}) {
    // token expired
    if (response.status === 401) {
      LocalStorageManager.remove('token')
      const router = RouterKeeper.getRouter()
      router.push('/manage/login')
      return
    }
    if (ProcessWrapper.getNodeEnv() === 'development') {
      if (response.hasOwnProperty('status')) {
        console.error(title + ' [status]: ' + response.status)
      } else {
        console.error(title)
      }
    } else {
      // TODO if prod
    }
  },
  [symbols.actions.courseStaff] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.users.courseStaff).then((response) => {
      const data = response.data.data
      if (!data || !data.hasOwnProperty('use_course') || !data.hasOwnProperty('use_course_staff')) {
        return
      }
      const courseStaffData = {
        useCourse: parseInt(data.use_course),
        useCourseStaff: parseInt(data.use_course_staff)
      }
      commit(symbols.mutations.courseStaff, courseStaffData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getCourseStaff', response: response })
    })
  },
  [symbols.actions.patientData] ({state, commit, dispatch}, patientId) {
    const queryData = {
      where: {
        docid: state[symbols.state.userInfo].docId,
        patientid: patientId
      }
    }
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.patients.withFilter, queryData).then((response) => {
      commit(symbols.mutations.patientId, patientId)
      const data = response.data.data
      if (!(data instanceof Array) || !data.length) {
        return
      }
      const firstElement = data[0]
      const insuranceType = parseInt(firstElement.p_m_ins_type)
      let hasMedicare = false
      if (insuranceType === 1) {
        hasMedicare = true
      }
      commit(symbols.mutations.medicare, hasMedicare)
      const premedCheck = parseInt(firstElement.premedcheck)
      commit(symbols.mutations.premedCheck, premedCheck)
      if (premedCheck) {
        let title = state[symbols.state.headerTitle]
        title += 'Pre-medication: ' + firstElement.premed + '\n'
        commit(symbols.mutations.headerTitle, title)
      }
      commit(symbols.mutations.headerAlertText, firstElement.alert_text)
      commit(symbols.mutations.displayAlert, firstElement.display_alert)
      const patientName = {
        firstName: firstElement.firstname,
        lastName: firstElement.lastname
      }
      commit(symbols.mutations.patientName, patientName)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getPatientByIdAndDocId', response: response })
    })
  },
  [symbols.actions.healthHistoryForPatient] ({state, commit, dispatch}, patientId) {
    const queryData = {
      fields: ['other_allergens', 'allergenscheck'],
      where: { patientid: patientId }
    }
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.healthHistories.withFilter, queryData).then((response) => {
      const data = response.data.data
      if (data instanceof Array && data.length) {
        const allergen = data[0].allergenscheck
        commit(symbols.mutations.allergen, allergen)
        if (allergen) {
          let title = state[symbols.state.headerTitle]
          title += 'Allergens: ' + data[0].other_allergens
          commit(symbols.mutations.headerTitle, title)
        }
      }
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getHealthHistoryByPatientId', response: response })
    })
  },
  [symbols.actions.incompleteHomeSleepTests] ({state, commit, dispatch}, patientId) {
    const queryData = {
      patientId: patientId || 0
    }
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.homeSleepTests.incomplete, queryData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.incompleteHomeSleepTests, data)
      let status = ''
      if (data instanceof Array && data.length > 0) {
        const lastElement = data[data.length - 1]
        if (HST_STATUSES.hasOwnProperty(lastElement.status)) {
          status = HST_STATUSES[lastElement.status]
        }
      }
      commit(symbols.mutations.patientHomeSleepTestStatus, status)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getIncompleteHomeSleepTests', response: response })
    })
  },
  [symbols.actions.logout] ({state, commit}) {
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.logout).then(() => {
      SwalWrapper.callSwal(
        {
          title: '',
          text: 'Logout Successfully!',
          type: 'success'
        },
        () => {
          commit(symbols.mutations.mainToken, '')
        }
      )
    }).catch((response) => {
      console.error('invalidateToken [status]: ' + response.status)
    })
  },
  [symbols.actions.storeLoginDetails] ({state, dispatch}, queryString) {
    if (!state[symbols.state.userInfo].loginId) {
      return
    }
    http.token = state[symbols.state.mainToken]
    const loginData = {
      loginid: state[symbols.state.userInfo].loginId,
      userid: state[symbols.state.userInfo].plainUserId,
      cur_page: queryString
    }
    http.post(endpoints.loginDetails.store, loginData).then(() => {
      // do nothing
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'setLoginDetails', response: response})
    })
  },
  [symbols.actions.companyLogo] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('logo') && data.logo) {
        MediaFileRetriever.getMediaFile(data.logo).then((image) => {
          commit(symbols.mutations.companyLogo, image)
        })
      }
    }).catch((response) => {
      let title = 'getCompanyByUser'
      if (response instanceof FileRetrievalError) {
        title = response.title
      }
      dispatch(symbols.actions.handleErrors, {title: title, response: response})
    })
  },
  [symbols.actions.questionnaireStatuses] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const questionnaireData = {
      fields: [
        'symptoms_status',
        'treatments_status',
        'history_status'
      ],
      where: {
        patientid: patientId
      }
    }
    http.post(endpoints.patients.withFilter, questionnaireData).then((response) => {
      const data = response.data.data
      const statuses = {
        symptoms: parseInt(data.symptoms_status),
        treatments: parseInt(data.treatments_status),
        history: parseInt(data.history_status)
      }
      commit(symbols.mutations.questionnaireStatuses, statuses)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getQuestionnaireStatuses', response: response})
    })
  },
  [symbols.actions.bouncedEmailsNumber] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const bouncedData = {
      fields: [
        'patientid'
      ],
      where: {
        email_bounce: 1,
        patientId: patientId
      }
    }
    http.post(endpoints.patients.withFilter, bouncedData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.bouncedEmailsNumberForCurrentPatient, data.length)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getBouncedEmailsNumberForCurrentPatient', response: response})
    })
  },
  [symbols.actions.patientContacts] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const queryData = {
      patientId: patientId
    }
    http.post(endpoints.patientContacts.current, queryData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.totalPatientContacts, data.length)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientContacts', response: response})
    })
  },
  [symbols.actions.patientInsurances] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const queryData = {
      patientId: patientId
    }
    http.post(endpoints.patientInsurances.current, queryData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.totalPatientInsurances, data.length)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientInsurances', response: response})
    })
  },
  [symbols.actions.subPatients] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const parentQueryData = {
      where: {
        parent_patientid: patientId
      }
    }
    http.post(endpoints.patients.withFilter, parentQueryData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.subPatients, data.length)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getPatientsByParentId', response: response})
    })
  },
  [symbols.actions.rejectedClaimsForCurrentPatient] ({state, commit, dispatch}, patientId) {
    http.token = state[symbols.state.mainToken]
    const queryData = {
      patientId: patientId
    }
    http.post(endpoints.insurances.rejected, queryData).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.rejectedClaimsForCurrentPatient, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getRejectedClaimsForCurrentPatient', response: response})
    })
  }
}
