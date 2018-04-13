import { APPOINTMENT_SUMMARY_SEGMENTS } from 'src/constants/chart'
import symbols from 'src/symbols'
import Alerter from 'src/services/Alerter'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    elementId: {
      type: Number,
      required: true
    },
    segmentId: {
      type: Number,
      required: true
    },
    reason: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      previousReason: this.reason
    }
  },
  computed: {
    reasonData () {
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === this.segmentId) {
          return segment
        }
      }
      return null
    },
    currentReason () {
      if (this.reason) {
        return this.reason
      }
      if (this.reasonData) {
        return this.reasonData.types[0].value
      }
      return ''
    }
  },
  watch: {
    reason (newValue, oldValue) {
      this.previousReason = oldValue
    }
  },
  methods: {
    updateReason (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      if (newValue !== 'other' && this.previousReason === 'other') {
        const confirmText = 'Are you sure you want to change the reason?'
        if (!Alerter.isConfirmed(confirmText)) {
          return
        }
      }
      const postData = {
        id: this.elementId,
        data: {
          [this.reasonData.className]: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    openFlowsheetModal () {
      const modalData = {
        name: symbols.modals.flowsheetReason,
        params: {
          flowId: this.elementId,
          segmentId: this.segmentId,
          patientId: this.patientId
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    }
  }
}
