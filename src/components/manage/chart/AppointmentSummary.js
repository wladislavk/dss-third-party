import symbols from '../../../symbols'
import AppointmentSummaryRowComponent from './AppointmentSummaryRow.vue'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    letterCount: {
      type: Number,
      default: 0
    }
  },
  data () {
    return {
      flowElements: this.$store.state.flowsheet[symbols.state.appointmentSummaries],
      devices: this.$store.state.flowsheet[symbols.state.devices],
      letters: this.$store.state.flowsheet[symbols.state.letters]
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
    deleteSegment (flowElementId) {
      this.$store.dispatch(symbols.actions.deleteAppointmentSummary, flowElementId)
    }
  }
}
