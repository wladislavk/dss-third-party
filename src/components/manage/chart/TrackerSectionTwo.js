import moment from 'moment'

export default {
  props: {
    scheduledAppointment: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      trackerNotes: [],
      nextSteps: []
    }
  },
  computed: {
    dateAfterSchedule () {
      if (!this.secondSchedule.date_scheduled) {
        return ''
      }
      return moment(this.secondSchedule.date_scheduled).format('MM/DD/YYYY')
    }
  }
}
