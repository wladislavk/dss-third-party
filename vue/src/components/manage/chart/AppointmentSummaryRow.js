import Datepicker from 'vuejs-datepicker'
import moment from 'moment'
import { APPOINTMENT_SUMMARY_SEGMENTS } from '../../../constants/chart'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'
import SleepStudyRowComponent from './summary-rows/SleepStudyRow.vue'
import ReasonRowComponent from './summary-rows/ReasonRow.vue'
import DeviceRowComponent from './summary-rows/DeviceRow.vue'

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
      currentDateCompleted: this.dateCompleted
    }
  },
  computed: {
    segmentData () {
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === this.segmentId) {
          return segment
        }
      }
      return null
    },
    segmentName () {
      if (this.segmentData) {
        return this.segmentData.text
      }
      return ''
    },
    reason () {
      if (this.delayReason) {
        return this.delayReason
      }
      if (this.nonComplianceReason) {
        return this.nonComplianceReason
      }
      return ''
    }
  },
  components: {
    datepicker: Datepicker,
    sleepStudyRow: SleepStudyRowComponent,
    reasonRow: ReasonRowComponent,
    deviceRow: DeviceRowComponent
  },
  methods: {
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
    updateCompletedDate (newDate) {
      const momentDate = moment(newDate)
      const postData = {
        id: this.elementId,
        data: {
          comp_date: momentDate.format('YYYY-MM-DD')
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    }
  }
}
