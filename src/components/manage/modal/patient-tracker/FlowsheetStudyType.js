import symbols from '../../../../symbols'

export default {
  data () {
    return {
      selectedType: ''
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    firstName () {
      return this.$store.state.main[symbols.state.modal].params.firstName
    },
    lastName () {
      return this.$store.state.main[symbols.state.modal].params.lastName
    },
    segmentId () {
      return this.$store.state.flowsheet[symbols.state.currentAppointmentSummary].segmentId
    },
    isTitration () {
      if (this.segmentId === 3) {
        return true
      }
      return false
    },
    isBaseline () {
      if (this.segmentId === 15) {
        return true
      }
      return false
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getAppointmentSummary, this.flowId)
  },
  methods: {
    selectType () {
      const patientId = this.$store.state.flowsheet[symbols.state.currentAppointmentSummary].patientId
      const queryData = {
        id: this.flowId,
        patientId: patientId,
        data: {
          study_type: this.selectedType
        }
      }
      this.$store.dispatch(symbols.actions.addAppointmentSummary, queryData).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
