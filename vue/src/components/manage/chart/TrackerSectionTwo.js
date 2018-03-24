import moment from 'moment'
import Datepicker from 'vuejs-datepicker'
import symbols from '../../../symbols'

export default {
  computed: {
    hasScheduledAppointment () {
      return this.$store.getters[symbols.getters.hasScheduledAppointment]
    },
    futureAppointment () {
      return this.$store.state.flowsheet[symbols.state.futureAppointment]
    },
    nextSteps () {
      return this.$store.state.flowsheet[symbols.state.trackerStepsNext]
    },
    trackerNotes () {
      return this.$store.state.flowsheet[symbols.state.patientTrackerNotes]
    },
    dateAfterSchedule () {
      if (!this.futureAppointment.dateScheduled) {
        return ''
      }
      return moment(this.futureAppointment.dateScheduled).format('MM/DD/YYYY')
    }
  },
  components: {
    datepicker: Datepicker
  },
  created () {
    this.$store.dispatch(symbols.actions.patientTrackerNotes)
    this.$store.dispatch(symbols.actions.futureAppointment)
  }
}
