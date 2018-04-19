import TrackerStepComponent from './TrackerStep.vue'
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    hasScheduledAppointment () {
      return this.$store.getters[symbols.getters.hasScheduledAppointment]
    },
    stepsFirst () {
      return this.$store.getters[symbols.getters.trackerStepsFirst]
    },
    stepsSecond () {
      return this.$store.getters[symbols.getters.trackerStepsSecond]
    },
    finalRank () {
      return this.$store.state.flowsheet[symbols.state.finalTrackerRank]
    },
    arrowHeight () {
      const stepHeight = 20
      return this.finalRank * stepHeight
    }
  },
  components: {
    trackerStep: TrackerStepComponent
  },
  methods: {
    isCompleted (step) {
      if (step.rank < this.finalRank) {
        return true
      }
      return false
    },
    isFinal (step) {
      if (step.id === this.$store.state.flowsheet[symbols.state.finalTrackerSegment]) {
        return true
      }
      return false
    },
    isLast (step) {
      if (step.id === this.$store.state.flowsheet[symbols.state.lastTrackerSegment]) {
        return true
      }
      return false
    }
  }
}
