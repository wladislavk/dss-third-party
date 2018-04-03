import symbols from '../../../symbols'

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    patientId: {
      type: Number,
      required: true
    },
    section: {
      type: Number,
      required: true
    },
    completed: {
      type: Boolean,
      required: true
    },
    last: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    hasScheduledAppointment () {
      return this.$store.getters[symbols.getters.hasScheduledAppointment]
    },
    showLast () {
      if (this.last && this.section === 1) {
        return true
      }
      return false
    }
  },
  methods: {
    addAction () {
      const postData = {
        segmentId: this.id,
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.addAppointmentSummary, postData)
    }
  }
}
