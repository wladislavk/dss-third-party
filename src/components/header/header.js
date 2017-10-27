import endpoints from '../../endpoints'
import handlerMixin from '../../modules/handler/HandlerMixin'
import http from '../../services/http'
import logoutTimerMixin from '../../modules/logout/LogoutTimerMixin'
import modal from '../modal/modal.vue'
import symbols from '../../symbols'
import PatientTaskMenuComponent from '../manage/tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../manage/tasks/TaskMenu.vue'
import { LEGACY_URL } from '../../constants'

// include static libs
require('../../../static/third-party/dynamic-drive-dhtml/ddlevelsmenu.js')

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      username: this.$store.state[symbols.state.userInfo].username,
      headerInfo: {
        patientName: '',
        patientHomeSleepTestStatus: '',
        medicare: 0,
        premedCheck: 0,
        title: '',
        alertText: '',
        displayAlert: false
      },
      secondsPerDay: 86400,
      pendingPreauthNumber: 0,
      supportTicketsNumber: 0,
      alergen: 0,
      companyLogo: '',
      childrenPatients: [],
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      bouncedEmailsNumberForCurrentPatient: 0,
      rejectedClaimsForCurrentPatient: [],
      uncompletedHomeSleepTests: [],
      showAllWarnings: true,
    }
  },
  computed: {
    notificationsNumber () {
      return this.$store.getters[symbols.getters.notificationsNumber]
    },
    isUserDoctor () {
      return this.$store.getters[symbols.getters.isUserDoctor]
    },
    patientId () {
      return parseInt(this.$route.query.pid)
    },
    showOnlineCEAndSnoozleHelp: function () {
      return (
        (this.isUserDoctor && this.$store.state[symbols.state.userInfo].useCourse === 1) ||
        (
          !this.isUserDoctor &&
          this.$store.state[symbols.state.courseStaff].useCourse === 1 &&
          this.$store.state[symbols.state.courseStaff].useCourseStaff === 1
        )
      )
    },
    showWarningAboutPatientChanges: function () {
      return ((this.childrenPatients.length + this.totalContacts + this.totalInsurances) > 0)
    },
    showWarningAboutQuestionnaireChanges: function () {
      return (parseInt(this.questionnaireStatuses.symptoms_status) === 2 || parseInt(this.questionnaireStatuses.treatments_status) === 2 || parseInt(this.questionnaireStatuses.history_status) === 2)
    },
    showWarningAboutBouncedEmails: function () {
      return this.bouncedEmailsNumberForCurrentPatient
    }
  },
  components: {
    modal: modal,
    taskMenu: TaskMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent
  },
  mixins: [handlerMixin, logoutTimerMixin],
  created () {
    this.setLogoutTimer()
    http.token = this.$store.state.main[symbols.state.mainToken]

    if (this.$store.state[symbols.state.userInfo].loginId) {
      const currentPage = this.$route.query
      this.setLoginDetails(currentPage).then(() => {
        // @todo: add handler
      }).catch((response) => {
        this.handleErrors('setLoginDetails', response)
      })
    }
    if (this.$route.query.pid) {
      this.getPatientByIdAndDocId(this.$store.state[symbols.state.userInfo].docId, this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data.length) {
          this.$set(this.headerInfo, 'medicare', (parseInt(data[0].p_m_ins_type) === 1))
          this.$set(this.headerInfo, 'premedCheck', data[0].premedcheck)
          this.$set(this.headerInfo, 'alertText', data[0].alert_text)
          this.$set(this.headerInfo, 'displayAlert', data[0].display_alert)
          if (this.headerInfo.premedCheck) {
            this.headerInfo.title += 'Pre-medication: ' + data[0].premed + '\n'
          }
          this.$set(this.headerInfo, 'patientName', data[0].firstname + ' ' + data[0].lastname)
        }
      }).catch((response) => {
        this.handleErrors('getPatientByIdAndDocId', response)
      })
      this.getHealthHistoryByPatientId(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data.length) {
          this.alergen = data[0].allergenscheck
          if (this.alergen) {
            this.headerInfo.title += 'Allergens: ' + data[0].other_allergens
          }
        }
      }).catch((response) => {
        this.handleErrors('getHealthHistoryByPatientId', response)
      })
    }
    const userId = this.$store.state[symbols.state.userInfo].userId.replace('u_', '')
    http.get(endpoints.users.show + '/' + userId).then((response) => {
      const data = response.data.data
      if (data) {
        this.$set(this.headerInfo.user, 'use_course', data.use_course)
      }
    }).catch((response) => {
      this.handleErrors('getUserById', response)
    })
    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data) {
        this.getFileForDisplaying(data.logo).then((response) => {
          const data = response.data.data
          this.companyLogo = data.image
        }).catch((response) => {
          this.handleErrors('getFileForDisplaying', response)
        })
      }
    }).catch((response) => {
      this.handleErrors('getCompanyByUser', response)
    })
    if (this.$route.query.pid) {
      this.getPatientsByParentId(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.childrenPatients = data
        }
      }).catch((response) => {
        this.handleErrors('getPatientsByParentId', response)
      })
      this.getCurrentPatientContacts(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalContacts = data.length
        }
      }).catch((response) => {
        this.handleErrors('getCurrentPatientContacts', response)
      })
      this.getCurrentPatientInsurances(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalInsurances = data.length
        }
      }).catch((response) => {
        this.handleErrors('getCurrentPatientInsurances', response)
      })
      this.getQuestionnaireStatuses(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          for (let field in data) {
            if (data.hasOwnProperty(field)) {
              this.questionnaireStatuses[field] = data[field]
            }
          }
        }
      }).catch((response) => {
        this.handleErrors('getQuestionnaireStatuses', response)
      })
      this.getBouncedEmailsNumberForCurrentPatient(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.bouncedEmailsNumberForCurrentPatient = data.length
        }
      }).catch((response) => {
        this.handleErrors('getBouncedEmailsNumberForCurrentPatient', response)
      })
      this.getRejectedClaimsForCurrentPatient(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.rejectedClaimsForCurrentPatient = data
        }
      }).catch((response) => {
        this.handleErrors('getRejectedClaimsForCurrentPatient', response)
      })
    }
    this.getUncompletedHomeSleepTests().then((response) => {
      const data = response.data.data
      if (data) {
        this.uncompletedHomeSleepTests = data
      }
    }).catch((response) => {
      this.handleErrors('getUncompletedHomeSleepTests', response)
    })
  },
  watch: {
    'uncompletedHomeSleepTests': function () {
      let status = ''
      if (this.uncompletedHomeSleepTests.length > 0) {
        const lastElement = this.uncompletedHomeSleepTests[this.uncompletedHomeSleepTests.length - 1]
        status = window.constants.dssHstStatusLabels[lastElement.status]
      }
      this.$set(this.headerInfo, 'patientHomeSleepTestStatus', status)
    }
  },
  methods: {
    setLoginDetails: function (currentPage) {
      const data = {
        loginid: this.$store.state[symbols.state.userInfo].loginId,
        userid: this.$store.state[symbols.state.userInfo].userId,
        cur_page: currentPage || ''
      }
      return http.post(endpoints.loginDetails.store, data)
    },
    getPatientByIdAndDocId: function (docId, patientId) {
      const data = {
        where: {
          docid: docId || 0,
          patientid: patientId || 0
        }
      }
      return http.post(endpoints.patients.withFilter, data)
    },
    getHealthHistoryByPatientId: function (patientId) {
      const data = {
        fields: ['other_allergens', 'allergenscheck'],
        where: { patientid: patientId || 0 }
      }
      return http.post(endpoints.healthHistories.withFilter, data)
    },
    getPatientsByParentId: function (parentPatientId) {
      const data = {
        where: { parent_patientid: parentPatientId || 0 }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getCurrentPatientContacts: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.patientContacts.current, data)
    },
    getCurrentPatientInsurances: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.patientInsurances.current, data)
    },
    getQuestionnaireStatuses: function (patientId) {
      const data = {
        fields: ['symptoms_status', 'treatments_status', 'history_status'],
        where: {
          patientid: patientId || 0
        }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getBouncedEmailsNumberForCurrentPatient: function (patientId) {
      const data = {
        fields: ['patientid'],
        where: {
          email_bounce: 1,
          patientId: patientId || 0
        }
      }

      return http.post(endpoints.patients.withFilter, data)
    },
    getRejectedClaimsForCurrentPatient: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.insurances.rejected, data)
    },
    getUncompletedHomeSleepTests: function (patientId) {
      const data = {
        patientId: patientId || 0
      }

      return http.post(endpoints.homeSleepTests.uncompleted, data)
    },
    getFileForDisplaying: function (filename) {
      filename = filename || ''

      return http.get(endpoints.displayFile + '/' + filename)
    },
    showWarnings: function () {
      this.showAllWarnings = true
    },
    hideWarnings: function () {
      this.showAllWarnings = false
    },
    logout () {
      http.token = this.$store.state.main[symbols.state.mainToken]
      http.post(endpoints.logout).then(() => {
        window.swal({
          title: '',
          text: 'Logout Successfully!',
          type: 'success'
        }, () => {
          this.$store.commit(symbols.mutations.mainToken, '')
          this.$router.push({ name: 'login' })
        })
      }).catch((response) => {
        console.error('invalidateToken [status]: ', response.status)
      })
    }
  }
}
