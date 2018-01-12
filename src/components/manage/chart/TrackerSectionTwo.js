import moment from 'moment'
import Datepicker from 'vuejs-datepicker'

export default {
  props: {
    scheduledAppointment: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    schedule () {
      return this.$store.getters['schedule']
    },
    nextSteps () {
      return this.$store.getters['nextSteps']
    },
    trackerNotes () {
      return this.$store.state.flowsheet['trackerNotesByPatient']
    },
    dateAfterSchedule () {
      if (!this.schedule.date_scheduled) {
        return ''
      }
      return moment(this.schedule.date_scheduled).format('MM/DD/YYYY')
    }
  },
  components: {
    datepicker: Datepicker
  },
  created () {
    this.$store.dispatch('trackerNotesByPatient', this.patientId)
  }
}
