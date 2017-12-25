/*
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      flowElements: this.$store.state.flowsheet[symbols.state.appointmentSummaries],
      devices: this.$store.state.flowsheet[symbols.state.devices],
      letters: this.$store.state.flowsheet[symbols.state.letters]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.appointmentSummariesByPatient, this.patientId).then(() => {
      this.$store.dispatch(symbols.actions.lettersByPatientAndInfo, this.patientId)
    })
    this.$store.dispatch(symbols.actions.devicesByStatus)
  },
  methods: {
    deleteSegment (flowElementId) {
      this.$store.dispatch(symbols.actions.deleteAppointmentSummary, flowElementId)
    }
  }
}
*/
