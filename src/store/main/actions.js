import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import storage from '../../modules/storage'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import RouterKeeper from '../../services/RouterKeeper'
import {HST_STATUSES} from '../../constants'

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
      storage.remove('token')
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
  }
}
