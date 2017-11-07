import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import PatientTaskMenuComponent from '../../manage/tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../../manage/tasks/TaskMenu.vue'
import { LEGACY_URL, NOTIFICATION_NUMBERS } from '../../../constants'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      username: this.$store.state.main[symbols.state.userInfo].username,
      secondsPerDay: 86400,
      supportTicketsNumber: this.$store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets],
      allergen: this.$store.state.main[symbols.state.allergen],
      companyLogo: '',
      childrenPatients: [],
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      bouncedEmailsNumberForCurrentPatient: 0,
      rejectedClaimsForCurrentPatient: [],
      incompleteHomeSleepTests: this.$store.state.main[symbols.state.incompleteHomeSleepTests],
      showAllWarnings: true,
      patientName: this.$store.state.main[symbols.state.patientName],
      medicare: this.$store.state.main[symbols.state.medicare],
      displayAlert: this.$store.state.main[symbols.state.displayAlert],
      headerTitle: this.$store.state.main[symbols.state.headerTitle],
      alertText: this.$store.state.main[symbols.state.headerAlertText],
      premedCheck: this.$store.state.main[symbols.state.premedCheck]
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
        (this.isUserDoctor && this.$store.state.main[symbols.state.userInfo].useCourse === 1) ||
        (
          !this.isUserDoctor &&
          this.$store.state.main[symbols.state.courseStaff].useCourse === 1 &&
          this.$store.state.main[symbols.state.courseStaff].useCourseStaff === 1
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
    taskMenu: TaskMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent
  },
  created () {
    http.token = this.$store.state.main[symbols.state.mainToken]

    if (this.$store.state.main[symbols.state.userInfo].hasOwnProperty('loginId') && this.$store.state.main[symbols.state.userInfo].loginId) {
      const currentPage = this.$route.query
      this.setLoginDetails(currentPage).then(() => {
        // @todo: add handler
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'setLoginDetails', response: response})
      })
    }
    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data) {
        this.getFileForDisplaying(data.logo).then((response) => {
          const data = response.data.data
          this.companyLogo = data.image
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getFileForDisplaying', response: response})
        })
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCompanyByUser', response: response})
    })
    if (this.$route.query.pid) {
      this.getPatientsByParentId(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.childrenPatients = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getPatientsByParentId', response: response})
      })
      this.getCurrentPatientContacts(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalContacts = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientContacts', response: response})
      })
      this.getCurrentPatientInsurances(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalInsurances = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientInsurances', response: response})
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
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getQuestionnaireStatuses', response: response})
      })
      this.getBouncedEmailsNumberForCurrentPatient(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.bouncedEmailsNumberForCurrentPatient = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getBouncedEmailsNumberForCurrentPatient', response: response})
      })
      this.getRejectedClaimsForCurrentPatient(this.$route.query.pid).then((response) => {
        const data = response.data.data
        if (data) {
          this.rejectedClaimsForCurrentPatient = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getRejectedClaimsForCurrentPatient', response: response})
      })
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
      this.$store.dispatch(symbols.actions.logout)
      this.$router.push({ name: 'main-login' })
    }
  }
}
