import axios from 'axios'
import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocalStorageManager from '../../services/LocalStorageManager'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import RouterKeeper from '../../services/RouterKeeper'
import Alerter from '../../services/Alerter'
import NameComposer from '../../services/NameComposer'
import LoginError from '../../exceptions/LoginError'

export default {
  [symbols.actions.mainLogin] ({dispatch}, credentials) {
    return new Promise((resolve, reject) => {
      axios.post(ProcessWrapper.getApiRoot() + 'auth', credentials).then((response) => {
        const data = response.data
        return dispatch(symbols.actions.dualAppLogin, data.token)
      }).then(() => {
        resolve()
      }).catch((response) => {
        let reason = ''
        if (response.hasOwnProperty('response') && response.response.hasOwnProperty('status') && response.response.status === 403) {
          reason = 'Username or password not found. This account may be inactive.'
        }
        dispatch(symbols.actions.handleErrors, {title: 'getToken', response: response})
        reject(new Error(reason))
      })
    })
  },

  [symbols.actions.dualAppLogin] ({commit, dispatch}, token) {
    http.token = token
    return http.post(endpoints.users.check).then((response) => {
      const data = response.data.data
      if (data.type.toLowerCase() === 'suspended') {
        commit(symbols.mutations.mainToken, '')
        http.token = ''
        throw new LoginError('This account has been suspended.')
      }
      commit(symbols.mutations.mainToken, token)
      http.token = token
      dispatch(symbols.actions.userInfo)
    }).catch((response) => {
      commit(symbols.mutations.mainToken, '')
      let reason = ''
      if (response.hasOwnProperty('status') && response.status === 422) {
        reason = 'Bad token'
      }
      if (response instanceof LoginError) {
        reason = response.response
      }
      dispatch(symbols.actions.handleErrors, {title: 'getUserByToken', response: response})
      throw new Error(reason)
    })
  },

  [symbols.actions.userInfo] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    return http.request('get', endpoints.users.current).then((response) => {
      const data = response.data.data
      const userInfo = {
        userId: data.id,
        plainUserId: parseInt(data.userid),
        docId: parseInt(data.docid),
        manageStaff: parseInt(data.manage_staff),
        userType: parseInt(data.user_type),
        useCourse: parseInt(data.use_course),
        username: data.username
      }
      const docInfo = {
        homepage: parseInt(data.doc_info.homepage),
        manageStaff: parseInt(data.doc_info.manage_staff),
        useEligibleApi: parseInt(data.doc_info.use_eligible_api),
        useLetters: parseInt(data.doc_info.use_letters),
        usePatientPortal: parseInt(data.doc_info.use_patient_portal),
        usePaymentReports: parseInt(data.doc_info.use_payment_reports),
        useCourseStaff: parseInt(data.doc_info.use_course_staff)
      }
      commit(symbols.mutations.userInfo, userInfo)
      commit(symbols.mutations.docInfo, docInfo)
      commit(symbols.mutations.notificationNumbers, data.numbers)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentUser', response: response})
    })
  },

  [symbols.actions.enablePopupEdit] ({commit}) {
    commit(symbols.mutations.popupEdit, {value: true})
  },

  [symbols.actions.disablePopupEdit] ({commit}) {
    commit(symbols.mutations.popupEdit, {value: false})
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

  // @todo: add proper logging. currently logins are not stored
  /*
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
  */

  [symbols.actions.patientSearchList] ({state, commit}, searchTerm) {
    const legacyUrl = ProcessWrapper.getLegacyRoot()
    http.token = state[symbols.state.mainToken]
    const queryData = {
      partial_name: searchTerm
    }
    http.post(endpoints.patients.list, queryData).then((response) => {
      const data = response.data.data
      if (data.length === 0) {
        const noMatchesElement = {
          id: 0,
          name: 'No Matches',
          patientType: 'no',
          link: ''
        }
        // @todo: add transition
        // this.templateListNew().fadeIn(noMatchesElement)

        const newElement = {
          id: 0,
          name: 'Add patient with this name\u2026',
          patientType: 'new',
          link: legacyUrl + 'add_patient.php?search=' + searchTerm
        }
        const newList = [
          noMatchesElement,
          newElement
        ]
        commit(symbols.mutations.patientSearchList, newList)

        // @todo: add transition
        // this.templateListNew().fadeIn(newElement)
        return
      }

      const newList = []
      for (let element of data) {
        const fullName = NameComposer.composeName(element)
        let link = 'manage/add_patient.php?pid=' + element.patientid + '&ed=' + element.patientid
        if (element.patientInfo === 1) {
          link = 'manage/manage_flowsheet3.php?pid=' + element.patientid
        }
        const patientElement = {
          id: element.patientid,
          name: fullName,
          patientType: 'json',
          link: legacyUrl + link
        }
        newList.push(patientElement)
        // @todo: add transition
        // this.templateList().fadeIn(patientElement)
      }
      commit(symbols.mutations.patientSearchList, newList)
    }).catch(() => {
      const alertText = 'Could not select patient from database'
      Alerter.alert(alertText)
    })
  }
}
