import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocalStorageManager from '../../services/LocalStorageManager'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import RouterKeeper from '../../services/RouterKeeper'
import MediaFileRetriever from '../../services/MediaFileRetriever'
import FileRetrievalError from '../../exceptions/FileRetrievalError'
import Alerter from '../../services/Alerter'
import { LEGACY_URL } from '../../constants/main'
import NameComposer from '../../services/NameComposer'

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
    http.token = state[symbols.state.mainToken]
    http.get(endpoints.patients.patientData + '/' + patientId).then((response) => {
      commit(symbols.mutations.patientId, patientId)
      const data = response.data.data
      const patientData = {
        insuranceType: data.insurance_type,
        preMed: data.premed,
        preMedCheck: data.premedcheck,
        alertText: data.alert_text,
        displayAlert: data.display_alert,
        firstName: data.firstname,
        lastName: data.lastname,
        questionnaireData: {
          symptomsStatus: data.questionnaire_data.symptoms_status,
          treatmentsStatus: data.questionnaire_data.treatments_status,
          historyStatus: data.questionnaire_data.history_status
        },
        isEmailBounced: data.is_email_bounced,
        patientContactsNumber: data.patient_contacts_number,
        patientInsurancesNumber: data.patient_insurances_number,
        subPatientsNumber: data.sub_patients_number,
        rejectedClaims: data.rejected_claims,
        hasAllergen: data.has_allergen,
        otherAllergens: data.other_allergens,
        hstStatus: data.hst_status,
        incompleteHomeSleepTests: data.incomplete_hsts
      }
      commit(symbols.mutations.patientData, patientData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, { title: 'getPatientByIdAndDocId', response: response })
    })
  },

  [symbols.actions.clearPatientData] ({commit}) {
    commit(symbols.mutations.clearPatientData)
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

  // @todo: the code needs to be rewritten and acceptance-tested
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

  [symbols.actions.patientSearchList] ({state, commit}, searchTerm) {
    http.token = state[symbols.state.mainToken]
    const queryData = {
      partial_name: searchTerm
    }
    http.post(endpoints.patients.list, queryData).then((response) => {
      const data = response.data.data
      if (data.length === 0) {
        const noMatchesElement = {
          name: 'No Matches',
          patientType: 'no',
          link: ''
        }
        // @todo: add transition
        // this.templateListNew().fadeIn(noMatchesElement)

        const newElement = {
          name: 'Add patient with this name\u2026',
          patientType: 'new',
          link: LEGACY_URL + 'add_patient.php?search=' + searchTerm
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
        let link = 'manage/add_patient.php?pid=' + element.patientId + '&ed=' + element.patientId
        if (element.patientInfo === 1) {
          link = 'manage/manage_flowsheet3.php?pid=' + element.patientId
        }
        const patientElement = {
          name: fullName,
          patientType: 'json',
          link: LEGACY_URL + link
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
