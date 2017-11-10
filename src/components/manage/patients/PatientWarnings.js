import symbols from '../../../symbols'
import { LEGACY_URL, NOT_ACCEPTED_UPDATE } from '../../../constants/main'
import PatientIncompleteHstComponent from './PatientIncompleteHst.vue'

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
  components: {
    patientIncompleteHst: PatientIncompleteHstComponent
  },
  methods: {
    getUpdateText (replacement) {
      return NOT_ACCEPTED_UPDATE.replace('%s', replacement.toUpperCase())
    }
  }
}
