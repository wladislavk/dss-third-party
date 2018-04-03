import symbols from '../../../../symbols'

export default {
  data () {
    return {
      selectedReason: ''
    }
  },
  computed: {
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    },
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    changeReason (event) {
      this.selectedReason = event.target.value
    },
    submitReason () {
      const queryData = {
        id: this.flowId,
        data: {
          delay_reason: this.selectedReason
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, queryData).then(() => {
        if (this.selectedReason !== 'other') {
          this.$store.commit(symbols.mutations.resetModal)
          return
        }
        const modalData = {
          name: symbols.modals.flowsheetReason,
          params: {
            flowId: this.flowId,
            segmentId: 5
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
      })
    }
  }
}
