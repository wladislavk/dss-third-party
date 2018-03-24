import symbols from '../../../../symbols'

export default {
  data () {
    return {
      selectedReason: ''
    }
  },
  computed: {
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    },
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    submitReason () {
      const queryData = {
        id: this.flowId,
        data: {
          noncomp_reason: this.selectedReason
        }
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
            segmentId: 9
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
      })
    }
  }
}
