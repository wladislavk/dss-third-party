import symbols from '../../../../symbols'
import { NON_COMPLIANT_ID, NON_COMPLIANCE_REASONS } from '../../../../constants/chart'

export default {
  data () {
    return {
      nonComplianceReasons: NON_COMPLIANCE_REASONS,
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
    submitReason () {
      const queryData = {
        id: this.flowId,
        data: {
          noncomp_reason: this.selectedReason
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
            segmentId: NON_COMPLIANT_ID,
            patientId: this.patientId
          }
        }
        this.$store.commit(symbols.mutations.modal, modalData)
      })
    }
  }
}
