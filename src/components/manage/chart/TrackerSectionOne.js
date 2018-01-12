import TrackerStepComponent from './TrackerStep.vue'
import symbols from '../../../symbols'

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
      return this.$store.getters[symbols.getters.trackerStepsFirst]
    },
    stepsSecond () {
      return this.$store.getters[symbols.getters.trackerStepsSecond]
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
