import symbols from '../../../../symbols'

export default {
  data () {
    return {
      currentDescription: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    segmentId () {
      return this.$store.state.main[symbols.state.modal].params.segmentId
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
      if (this.segmentId === 5) {
        return 'Delaying Treatment'
      }
      if (this.segmentId === 9) {
        return 'Patient Non-Compliant'
      }
      return ''
    },
    description () {
      if (this.appointmentSummary) {
        return this.appointmentSummary.description
      }
      return ''
    }
  },
  methods: {
    changeDescription (event) {
      this.currentDescription = event.target.value
    },
    submitForm () {
      let description = this.description
      if (this.currentDescription !== '') {
        description = this.currentDescription
      }
      const payload = {
        id: this.flowId,
        data: {
          reason: description
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, payload).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
