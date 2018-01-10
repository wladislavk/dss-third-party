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
  data () {
    return {
      stepsFirst: [],
      stepsSecond: [],
      arrowHeight: 0
    }
  },
  components: {
    trackerStep: TrackerStepComponent
  }
}
