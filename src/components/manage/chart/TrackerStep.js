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
    schedule () {
      return this.$store.getters[symbols.getters.trackerStepSchedule]
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
      /*
      const postData = {
        id: this.id,
        pid: this.patientId
      }
      this.$store.dispatch('updateAppointmentToday', postData).then((response) => {
        const responseData = response.data.data
        this.updateCurrentStep()
        this.nextSteps = responseData.next_steps
        this.schedule.segmentid = ''
        this.$store.dispatch(symbols.actions.insertTrackerStep, responseData)
        this.$store.commit('updateSegmentId', 0)
        const data = {
          dateAfter: null,
          dateUntil: null
        }
        this.$store.commit('updateNextStep', data)
      })
      */
    },
    updateCurrentStep () {
      let hasScheduledAppointment = false
      if (this.schedule.segmentid && this.schedule.date_scheduled) {
        hasScheduledAppointment = true
      }
      this.$store.commit(symbols.mutations.hasScheduledAppointment, hasScheduledAppointment)
    }
  }
}
