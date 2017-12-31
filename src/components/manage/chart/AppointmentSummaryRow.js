import {
  APPOINTMENT_SUMMARY_SEGMENTS, BASELINE_TYPES, DELAY_REASONS, NON_COMPLIANCE_REASONS, TITRATION_TYPES
} from '../../../constants/chart'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'

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
    studyType: {
      type: String,
      required: true
    },
    delayReason: {
      type: String,
      required: true
    },
    nonComplianceReason: {
      type: String,
      required: true
    },
    dateCompleted: {
      type: Object,
      validator: function (value) {
        return value instanceof Date
      }
    },
    devices: {
      type: Array,
      required: true
    },
    letters: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      delayReasons: DELAY_REASONS,
      nonComplianceReasons: NON_COMPLIANCE_REASONS,
      titrationTypes: TITRATION_TYPES,
      baselineTypes: BASELINE_TYPES
    }
  },
  computed: {
    defaultDeviceId () {
      for (let device of this.$store.state.flowsheet[symbols.state.devices]) {
        if (device.hasOwnProperty('default') && device.default) {
          return device.id
        }
      }
      return this.deviceId
    },
    defaultStudyType () {
      return this.$store.state[symbols.state.defaultStudyType]
    },
    rowLetters () {
      const rowLetters = []
      for (let letter of this.letters) {
        if (letter.infoId === this.elementId) {
          rowLetters.push(letter)
        }
      }
      return rowLetters
    },
    segmentName () {
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === this.segmentId) {
          return segment.text
        }
      }
      return ''
    },
    letterCount () {
      let result = 0
      for (let letter of this.rowLetters) {
        let toPatient = 0
        if (letter.toPatient) {
          toPatient = 1
        }
        let mdNumber = 0
        if (letter.mdList.length) {
          mdNumber = letter.mdList.split(',').length
        }
        let mdReferralNumber = 0
        if (letter.mdReferralList.length) {
          mdReferralNumber = letter.mdReferralList.split(',').length
        }
        result += toPatient + mdNumber + mdReferralNumber
      }
      return result
    }
  },
  methods: {
    openFlowsheetModal () {
      const modalData = {
        name: 'flowsheetReason',
        params: {
          flowId: this.elementId,
          patientId: this.patientId
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    },
    deleteStep () {
      for (let letter of this.rowLetters) {
        if (letter.status === 1) {
          const alertText = 'Letters have been sent. Unable to delete step.'
          Alerter.alert(alertText)
          return
        }
      }
      this.$store.dispatch(symbols.actions.deleteAppointmentSummary, this.elementId)
    }
  }
}
