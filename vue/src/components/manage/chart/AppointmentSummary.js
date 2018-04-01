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
          let mdNumber = 0
          if (letter.mdList.length) {
            mdNumber = letter.mdList.split(',').length
          }
          let mdReferralNumber = 0
          if (letter.mdReferralList.length) {
            mdReferralNumber = letter.mdReferralList.split(',').length
          }
          result += toPatient + mdNumber + mdReferralNumber
        }
      }
      return result
    }
  }
}
