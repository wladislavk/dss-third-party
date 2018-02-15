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
    }
  },
  computed: {
    hasScheduledAppointment () {
      const schedule = this.$store.getters[symbols.getters.trackerStepSchedule]
      if (schedule.segmentid && schedule.date_scheduled) {
        return true
      }
      return false
    },
    stepClass () {
      if (this.section === 1 && this.completed) {
        return true
      }
      return false
    }
  },
  methods: {
    addAction () {
      const postData = {
        segmentId: this.id,
        patientId: this.patientId,
      }
      this.$store.dispatch(symbols.actions.addAppointmentSummary, postData)
      this.$store.commit(symbols.mutations.hasScheduledAppointment, this.hasScheduledAppointment)
    }
  }
}
