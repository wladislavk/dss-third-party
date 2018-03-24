import { DSS_CONSTANTS, HST_STATUSES } from '../../../constants/main'

export default {
  props: {
    status: {
      type: Number,
      required: true
    },
    hstId: {
      type: Number,
      required: true
    },
    patientId: {
      type: Number,
      required: true
    },
    dateAdded: {
      validator: function (value) {
        return value instanceof Date
      }
    },
    dateRejected: {
      validator: function (value) {
        if (!value) {
          return true
        }
        return value instanceof Date
      }
    },
    officeNotes: {
      type: String,
      required: true
    },
    rejectedReason: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      scheduledHst: DSS_CONSTANTS.DSS_HST_SCHEDULED,
      rejectedHst: DSS_CONSTANTS.DSS_HST_REJECTED
    }
  },
  computed: {
    hstStatusLabel () {
      if (HST_STATUSES.hasOwnProperty(this.status)) {
        return HST_STATUSES[this.status]
      }
      return ''
    },
    rejectedWithDate () {
      if (this.status !== this.rejectedHst) {
        return false
      }
      if (!this.dateRejected) {
        return false
      }
      return true
    }
  }
}
