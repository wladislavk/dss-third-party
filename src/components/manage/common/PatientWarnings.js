import symbols from '../../../symbols'
import { LEGACY_URL, DSS_CONSTANTS, NOT_ACCEPTED_UPDATE, PREAUTH_STATUS_LABELS } from '../../../constants/main'

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
      scheduledHst: DSS_CONSTANTS.DSS_HST_SCHEDULED,
      rejectedHst: DSS_CONSTANTS.DSS_HST_REJECTED,
      preauthLabels: PREAUTH_STATUS_LABELS,
      profileUpdateText: this.getUpdateText('profile'),
      questionnaireUpdateText: this.getUpdateText('questionnaire')
    }
  },
  computed: {
    showWarningAboutPatientChanges () {
      return this.$store.getters[symbols.getters.showWarningAboutPatientChanges]
    },
    showWarningAboutQuestionnaireChanges () {
      return this.$store.getters[symbols.getters.showWarningAboutQuestionnaireChanges]
    },
    showWarningAboutBouncedEmails () {
      return this.$store.getters[symbols.getters.showWarningAboutBouncedEmails]
    },
    rejectedClaimsForCurrentPatient () {
      return this.$store.state.main[symbols.state.rejectedClaimsForCurrentPatient]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.rejectedClaimsForCurrentPatient, this.patientId)
    this.$store.dispatch(symbols.actions.patientContacts, this.patientId)
    this.$store.dispatch(symbols.actions.patientInsurances, this.patientId)
    this.$store.dispatch(symbols.actions.subPatients, this.patientId)
    this.$store.dispatch(symbols.actions.questionnaireStatuses, this.patientId)
    this.$store.dispatch(symbols.actions.bouncedEmailsNumber, this.patientId)
  },
  methods: {
    getUpdateText (replacement) {
      return NOT_ACCEPTED_UPDATE.replace('%s', replacement.toUpperCase())
    }
  }
}
