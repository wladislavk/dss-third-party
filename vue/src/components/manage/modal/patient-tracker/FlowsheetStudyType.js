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
    segmentId () {
      return this.$store.state.main[symbols.state.modal].params.segmentId
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
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
  methods: {
    selectType () {
      const queryData = {
        id: this.flowId,
        data: {
          study_type: this.selectedType
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, queryData).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
