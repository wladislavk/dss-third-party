import symbols from '../../../../symbols'

export default {
  data () {
    return {
      selectedReason: ''
    }
  },
  computed: {
    firstName () {
      return this.$store.state.main[symbols.state.modal].params.firstName
    },
    lastName () {
      return this.$store.state.main[symbols.state.modal].params.lastName
    },
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  methods: {
    submitReason () {
      $('#noncomp_reason' + this.flowId).val(this.selectedReason)
      const queryData = {
        id: this.flowId,
        patientId: this.$store.state.flowsheet[symbols.state.currentAppointmentSummary].patientId,
        data: {
          noncomp_reason: this.selectedReason
        }
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, queryData).then(() => {
        const newTrackerStep = {
          type: 'noncompliance_reason',
          id: this.flowId,
          value: this.selectedReason
        }
        this.$store.commit(symbols.mutations.selectTrackerStep, newTrackerStep)
        if (this.selectedReason === 'other') {
          const modalData = {
            name: 'flowsheetReason',
            params: {
              flowId: this.flowId,
              segmentId: 9
            }
          }
          this.$store.commit(symbols.mutations.modal, modalData)
        }
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
