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
      return this.$store.state.flowsheet[symbols.state.letters]
    }
  },
  components: {
    appointmentSummaryRow: AppointmentSummaryRowComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.appointmentSummariesByPatient, this.patientId).then(() => {
      this.$store.dispatch(symbols.actions.lettersByPatientAndInfo, this.patientId)
    })
    this.$store.dispatch(symbols.actions.devicesByStatus)
  },
  watch: {
    patientId (newPatientId) {
      this.$store.dispatch(symbols.actions.appointmentSummariesByPatient, newPatientId).then(() => {
        this.$store.dispatch(symbols.actions.lettersByPatientAndInfo, newPatientId)
      })
    }
  },
  methods: {
    deleteSegment (summaryId) {
      this.$store.dispatch(symbols.actions.deleteAppointmentSummary, summaryId)
    },
    letterCount (summaryId) {
      let result = 0
      for (let letter of this.letters) {
        if (letter.infoId === summaryId) {
          let toPatient = 0
          if (letter.toPatient) {
            toPatient = 1
          }
          const mdNumber = letter.mdList.length
          const mdReferralNumber = letter.mdReferralList.length
          result += toPatient + mdNumber + mdReferralNumber
        }
      }
      return result
    },
    areLettersSent (summaryId) {
      for (let letter of this.letters) {
        if (letter.infoId === summaryId && letter.status === 1) {
          return true
        }
      }
      return false
    }
  }
}
