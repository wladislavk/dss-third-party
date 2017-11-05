import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      legacyUrl: LEGACY_URL,
      incompleteHomeSleepTests: this.$store.state.main[symbols.state.incompleteHomeSleepTests],
      rejectedClaimsForCurrentPatient: [],
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings],
      bouncedEmailsNumberForCurrentPatient: 0,
      totalContacts: 0,
      totalInsurances: 0,
      questionnaireStatuses: [],
      childrenPatients: []
    }
  },
  computed: {
    showWarningAboutPatientChanges () {
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
    showWarningAboutQuestionnaireChanges () {
      return (
        parseInt(this.questionnaireStatuses.symptoms_status) === 2 ||
        parseInt(this.questionnaireStatuses.treatments_status) === 2 ||
        parseInt(this.questionnaireStatuses.history_status) === 2
      )
    },
    showWarningAboutBouncedEmails () {
      return this.bouncedEmailsNumberForCurrentPatient
    }
  },
  created () {
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
}
