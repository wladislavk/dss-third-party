import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import PatientTaskMenuComponent from '../../manage/tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../../manage/tasks/TaskMenu.vue'
import { LEGACY_URL } from '../../../constants'

// include static libs
require('../../../../static/third-party/dynamic-drive-dhtml/ddlevelsmenu.js')

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      username: this.$store.state.main[symbols.state.userInfo].username,
      companyLogo: '',
      childrenPatients: [],
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      bouncedEmailsNumberForCurrentPatient: 0,
      rejectedClaimsForCurrentPatient: [],
      incompleteHomeSleepTests: this.$store.state.main[symbols.state.incompleteHomeSleepTests],
      showAllWarnings: true,
      patientId: this.$store.state.main[symbols.state.patientId]
    }
  },
  computed: {
    showOnlineCEAndSnoozleHelp: function () {
      if (
        this.$store.getters[symbols.getters.isUserDoctor] &&
        this.$store.state.main[symbols.state.userInfo].useCourse === 1
      ) {
        return true
      }
      if (
        !this.$store.getters[symbols.getters.isUserDoctor] &&
        this.$store.state.main[symbols.state.courseStaff].useCourse === 1 &&
        this.$store.state.main[symbols.state.courseStaff].useCourseStaff === 1
      ) {
        return true
      }
      return false
    },
    showWarningAboutPatientChanges: function () {
      if (this.childrenPatients.length) {
        return true
      }
      if (this.totalContacts) {
        return true
      }
      if (this.totalInsurances) {
        return true
      }
      return false
    },
    showWarningAboutQuestionnaireChanges: function () {
      return (
        parseInt(this.questionnaireStatuses.symptoms_status) === 2 ||
        parseInt(this.questionnaireStatuses.treatments_status) === 2 ||
        parseInt(this.questionnaireStatuses.history_status) === 2
      )
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
      const loginData = {
        loginid: this.$store.state.main[symbols.state.userInfo].loginId,
        userid: this.$store.state.main[symbols.state.userInfo].userId,
        cur_page: this.$route.query || ''
      }
      http.post(endpoints.loginDetails.store, loginData).then(() => {
        // @todo: add handler
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'setLoginDetails', response: response})
      })
    }

    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data) {
        http.get(endpoints.displayFile + '/' + data.logo).then((response) => {
          const data = response.data.data
          this.companyLogo = data.image
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getFileForDisplaying', response: response})
        })
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCompanyByUser', response: response})
    })

    if (this.patientId) {
      const parentQueryData = {
        where: {
          parent_patientid: this.patientId
        }
      }
      http.post(endpoints.patients.withFilter, parentQueryData).then((response) => {
        const data = response.data.data
        if (data) {
          this.childrenPatients = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getPatientsByParentId', response: response})
      })

      const queryData = {
        patientId: this.patientId
      }
      http.post(endpoints.patientContacts.current, queryData).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalContacts = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientContacts', response: response})
      })
      http.post(endpoints.patientInsurances.current, queryData).then((response) => {
        const data = response.data.data
        if (data) {
          this.totalInsurances = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCurrentPatientInsurances', response: response})
      })
      http.post(endpoints.insurances.rejected, queryData).then((response) => {
        const data = response.data.data
        if (data) {
          this.rejectedClaimsForCurrentPatient = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getRejectedClaimsForCurrentPatient', response: response})
      })

      const questionnaireData = {
        fields: ['symptoms_status', 'treatments_status', 'history_status'],
        where: {
          patientid: this.patientId
        }
      }
      http.post(endpoints.patients.withFilter, questionnaireData).then((response) => {
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

      const bouncedData = {
        fields: ['patientid'],
        where: {
          email_bounce: 1,
          patientId: this.patientId
        }
      }
      http.post(endpoints.patients.withFilter, bouncedData).then((response) => {
        const data = response.data.data
        if (data) {
          this.bouncedEmailsNumberForCurrentPatient = data.length
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getBouncedEmailsNumberForCurrentPatient', response: response})
      })
    }
  },
  methods: {
    showWarnings: function () {
      this.showAllWarnings = true
    },
    hideWarnings: function () {
      this.showAllWarnings = false
    }
  }
}
