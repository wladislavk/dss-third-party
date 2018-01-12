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
      hasScheduledAppointment: false,
      letterCount: 0
    }
  },
  computed: {
    scheduledAppointment () {
      if (this.hasScheduledAppointment) {
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
    this.$store.dispatch('stepsByRank', this.patientId)
  }
}
