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
      return this.$store.state[symbols.state.trackerSteps].first
    },
    stepsSecond () {
      return this.$store.state[symbols.state.trackerSteps].second
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
  created () {
    this.$store.dispatch(symbols.actions.finalTrackerRank, this.patientId)

  },
  methods: {
    isCompleted (step) {
      if (step.rank < this.finalRank) {
        return true
      }
      return false
    }
  }
}
