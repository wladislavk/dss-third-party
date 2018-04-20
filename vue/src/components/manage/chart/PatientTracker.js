import symbols from '../../../symbols'
import AppointmentSummaryComponent from './AppointmentSummary.vue'
import ChartButtonsComponent from './ChartButtons.vue'
import TrackerSectionOneComponent from './TrackerSectionOne.vue'
import TrackerSectionTwoComponent from './TrackerSectionTwo.vue'

export default {
  computed: {
    patientId () {
      if (this.$route.query.hasOwnProperty('pid')) {
        return parseInt(this.$route.query.pid)
      }
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
    if (this.$route.query.hasOwnProperty('token')) {
      this.$store.commit(symbols.mutations.mainToken, this.$route.query.token)
    }
    this.$store.dispatch(symbols.actions.trackerSteps)
    this.$store.dispatch(symbols.actions.finalTrackerRank, this.patientId)
    this.$store.dispatch(symbols.actions.futureAppointment, this.patientId)
  },
  watch: {
    patientId (newPatientId) {
      this.$store.dispatch(symbols.actions.finalTrackerRank, newPatientId)
    }
  }
}
