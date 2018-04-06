import {
  APPOINTMENT_SUMMARY_SEGMENTS, BASELINE_TYPES, DELAY_REASONS, NON_COMPLIANCE_REASONS, TITRATION_TYPES
} from '../../../constants/chart'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'
import Datepicker from 'vuejs-datepicker'

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
    deviceId: {
      type: Number,
      required: true
    },
    elementType: {
      type: String,
      required: true
    },
    dateCompleted: {
      validator: function (value) {
        return value instanceof Date
      }
    },
    delayReason: {
      type: String,
      default: ''
    },
    nonComplianceReason: {
      type: String,
      default: ''
    },
    studyType: {
      type: String,
      default: ''
    },
    letterCount: {
      type: Number,
      default: 0
    },
    lettersSent: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      delayReasons: DELAY_REASONS,
      nonComplianceReasons: NON_COMPLIANCE_REASONS,
      titrationTypes: TITRATION_TYPES,
      baselineTypes: BASELINE_TYPES,
      previousDelayReason: this.delayReason,
      previousNonComplianceReason: this.nonComplianceReason
    }
  },
  computed: {
    devices () {
      return this.$store.state.flowsheet[symbols.state.devices]
    },
    defaultDeviceId () {
      for (let device of this.devices) {
        if (device.hasOwnProperty('default') && device.default) {
          return device.id
        }
      }
      return this.deviceId
    },
    segmentName () {
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === this.segmentId) {
          return segment.text
        }
      }
      return ''
    },
    isDeviceSegment () {
      if (this.segmentName === 'Impressions' || this.segmentName === 'Device Delivery') {
        return true
      }
      return false
    },
    currentDelayReason () {
      if (this.delayReason) {
        return this.delayReason
      }
      if (this.delayReasons.length) {
        return this.delayReasons[0].value
      }
      return ''
    }
  },
  watch: {
    delayReason (newValue, oldValue) {
      this.previousDelayReason = oldValue
    },
    nonComplianceReason (newValue, oldValue) {
      this.previousNonComplianceReason = oldValue
    }
  },
  components: {
    datepicker: Datepicker
  },
  methods: {
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
    },
    deleteStep () {
      if (this.lettersSent) {
        const alertText = 'Letters have been sent. Unable to delete step.'
        Alerter.alert(alertText)
        return
      }
      const confirmText = 'Are you sure you want to delete this appointment?'
      if (Alerter.isConfirmed(confirmText)) {
        this.$store.dispatch(symbols.actions.deleteAppointmentSummary, this.elementId)
      }
    },
    updateCompletedDate () {
      const postData = {
        id: this.elementId,
        data: {
          comp_date: this.dateCompleted,
          pid: this.patientId
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    updateStudyType (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      const postData = {
        id: this.elementId,
        data: {
          type: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    updateDelayReason (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      if (newValue !== 'other' && this.previousDelayReason === 'other') {
        const confirmText = 'Are you sure you want to change the reason?'
        if (!Alerter.isConfirmed(confirmText)) {
          return
        }
      }
      const postData = {
        id: this.elementId,
        data: {
          delay_reason: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    updateNonComplianceReason (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      if (newValue !== 'other' && this.previousNonComplianceReason === 'other') {
        const confirmText = 'Are you sure you want to change the reason?'
        if (!Alerter.isConfirmed(confirmText)) {
          return
        }
      }
      const postData = {
        id: this.elementId,
        data: {
          noncomp_reason: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    updateDeviceId (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      const postData = {
        id: this.elementId,
        data: {
          device_id: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    }
  }
}
