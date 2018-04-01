import symbols from '../../../symbols'
import AppointmentSummaryComponent from './AppointmentSummary.vue'
import ChartButtonsComponent from './ChartButtons.vue'
import TrackerSectionOneComponent from './TrackerSectionOne.vue'
import TrackerSectionTwoComponent from './TrackerSectionTwo.vue'

export default {
  computed: {
    patientId () {
      return this.$store.state.patients[symbols.state.patientId]
    }
  },
  components: {
    appointmentSummary: AppointmentSummaryComponent,
    chartButtons: ChartButtonsComponent,
    trackerSectionOne: TrackerSectionOneComponent,
    trackerSectionTwo: TrackerSectionTwoComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.trackerSteps)
    this.$store.dispatch(symbols.actions.finalTrackerRank, this.patientId)
  },
  watch: {
    patientId (newPatientId) {
      this.$store.dispatch(symbols.actions.finalTrackerRank, newPatientId)
    }
  }
}
