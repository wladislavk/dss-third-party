import symbols from '../../../../symbols'
import { APPOINTMENT_SUMMARY_SEGMENTS } from '../../../../../src/constants/chart'

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
    studyType: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      currentStudyType: this.studyType
    }
  },
  computed: {
    sleepStudyTypes () {
      for (let segment of APPOINTMENT_SUMMARY_SEGMENTS) {
        if (segment.number === this.segmentId) {
          return segment.types
        }
      }
      return []
    }
  },
  watch: {
    studyType (newVal) {
      this.currentStudyType = newVal
    }
  },
  methods: {
    updateStudyType (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      this.currentStudyType = newValue
      const postData = {
        id: this.elementId,
        data: {
          type: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    }
  }
}
