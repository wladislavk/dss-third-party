/*
import symbols from '../../../symbols'

export default {
  data () {
    return {
      reason: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    appointmentSummary () {
      for (let summary of this.$store.state.flowsheet[symbols.state.appointmentSummaries]) {
        if (summary.id === this.flowId) {
          return summary
        }
      }
      return null
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    segmentType () {
      const segmentId = this.appointmentSummary.segmentId
      if (segmentId === 5) {
        return 'Delaying Treatment'
      }
      if (segmentId === 9) {
        return 'Patient Non-Compliant'
      }
      return ''
    },
    description () {
      return this.appointmentSummary.description
    }
  },
  methods: {
    submitForm () {
      const payload = {
        id: this.flowId,
        patientId: this.patientId,
        data: {
          reason: this.reason
        }
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, payload).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
*/
