import symbols from '../../../symbols'

export default {
  computed: {
    patientDevice () {
      return this.$store.getters[symbols.getters.firstDevice]
    },
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    },
    devices () {
      return this.$store.state.flowsheet[symbols.state.devices]
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.devicesByStatus)
  },
  methods: {
    selectDevice () {
      const data = {
        id: this.flowId,
        data: {
          device_id: this.patientDevice
        }
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, data).then(() => {
        this.$store.dispatch(symbols.actions.patientClinicalExam, this.patientDevice).then(() => {
          this.$store.commit(symbols.mutations.resetModal)
        })
      })
    }
  }
}
