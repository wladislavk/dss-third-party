import symbols from '../../../symbols'
import AppointmentSummaryRowComponent from './AppointmentSummaryRow.vue'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    summaries () {
      return this.$store.state.flowsheet[symbols.state.appointmentSummaries]
    },
    letters () {
      return this.$store.state.flowsheet[symbols.state.appointmentSummaryLetters]
    }
  },
  components: {
    appointmentSummaryRow: AppointmentSummaryRowComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.appointmentSummariesByPatient, this.patientId)
    this.$store.dispatch(symbols.actions.devicesByStatus)
  },
  watch: {
    patientId (newPatientId) {
      this.$store.dispatch(symbols.actions.appointmentSummariesByPatient, newPatientId)
    }
  },
  methods: {
    letterCount (summaryId) {
      const result = this.$store.getters[symbols.getters.appointmentLetterCount]
      if (result.hasOwnProperty(summaryId)) {
        return result[summaryId]
      }
      return 0
    },
    areLettersSent (summaryId) {
      const result = this.$store.getters[symbols.getters.appointmentLettersSent]
      if (result.hasOwnProperty(summaryId)) {
        return result[summaryId]
      }
      return false
    }
  }
}
