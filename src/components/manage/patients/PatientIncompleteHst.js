import { DSS_CONSTANTS, LEGACY_URL, PREAUTH_STATUS_LABELS } from '../../../constants/main'

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
      type: String,
      required: true
    },
    dateRejected: {
      type: String,
      required: true
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
      legacyUrl: LEGACY_URL,
      scheduledHst: DSS_CONSTANTS.DSS_HST_SCHEDULED,
      rejectedHst: DSS_CONSTANTS.DSS_HST_REJECTED,
      preauthLabels: PREAUTH_STATUS_LABELS
    }
  },
  computed: {
    preAuthStatusLabel () {
      if (PREAUTH_STATUS_LABELS.hasOwnProperty(this.status)) {
        return PREAUTH_STATUS_LABELS[this.status]
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
