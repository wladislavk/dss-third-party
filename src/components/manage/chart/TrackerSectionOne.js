import TrackerStepComponent from './TrackerStep.vue'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    scheduledAppointment: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    stepsFirst () {
      return this.$store.getters['stepsFirst']
    },
    stepsSecond () {
      return this.$store.getters['stepsSecond']
    },
    arrowHeight () {
      let completedSteps = 0
      for (let step of this.stepsFirst) {
        if (step.completed) {
          completedSteps++
        }
      }
      const stepHeight = 20
      return completedSteps * stepHeight
    }
  },
  components: {
    trackerStep: TrackerStepComponent
  }
}
