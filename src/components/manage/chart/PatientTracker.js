import symbols from '../../../symbols'
import AppointmentSummaryComponent from './AppointmentSummary.vue'
import ChartButtonsComponent from './ChartButtons.vue'
import TrackerSectionOneComponent from './TrackerSectionOne.vue'
import TrackerSectionTwoComponent from './TrackerSectionTwo.vue'

export default {
  data () {
    return {
      patientId: this.$store.state.patients[symbols.state.patientId],
      schedules: [],
      letterCount: 0
    }
  },
  computed: {
    scheduledAppointment () {
      if (this.$store.state.flowsheet[symbols.state.hasScheduledAppointment]) {
        return true
      }
      if (this.schedules.length > 0) {
        return true
      }
      return false
    }
  },
  components: {
    appointmentSummary: AppointmentSummaryComponent,
    chartButtons: ChartButtonsComponent,
    trackerSectionOne: TrackerSectionOneComponent,
    trackerSectionTwo: TrackerSectionTwoComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.stepsByRank, this.patientId)
  }
}
