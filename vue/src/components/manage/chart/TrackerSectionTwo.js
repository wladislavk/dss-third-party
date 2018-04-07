import moment from 'moment'
import Datepicker from 'vuejs-datepicker'
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      currentScheduledDate: '',
      currentSelectedStep: 0,
      currentTrackerNote: ''
    }
  },
  computed: {
    isDisabled () {
      if (this.currentSelectedStep) {
        return false
      }
      return true
    },
    futureAppointment () {
      return this.$store.state.flowsheet[symbols.state.futureAppointment]
    },
    nextSteps () {
      return this.$store.state.flowsheet[symbols.state.trackerStepsNext]
    },
    currentInterval () {
      if (!this.currentScheduledDate) {
        return ''
      }
      const dateObject = moment(this.currentScheduledDate, 'MM/DD/YYYY')
      if (dateObject.diff(moment()) > 0) {
        return dateObject.fromNow(true)
      }
      return ''
    }
  },
  components: {
    datepicker: Datepicker
  },
  created () {
    this.$store.dispatch(symbols.actions.futureAppointment, this.patientId).then(() => {
      this.currentSelectedStep = this.$store.state.flowsheet[symbols.state.futureAppointment].segmentId
      this.currentScheduledDate = this.scheduledDate()
      this.currentTrackerNote = this.$store.state.flowsheet[symbols.state.patientTrackerNotes]
    })
  },
  methods: {
    scheduledDate () {
      if (!this.futureAppointment || !this.futureAppointment.dateScheduled) {
        return ''
      }
      return moment(this.futureAppointment.dateScheduled).format('MM/DD/YYYY')
    },
    updateScheduledDate (newDate) {
      this.currentScheduledDate = moment(newDate).format('MM/DD/YYYY')
      const postData = {
        id: this.futureAppointment.id,
        data: {
          scheduled: moment(newDate).format('YYYY-MM-DD')
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    },
    updateNextAppointment (event) {
      const nextStep = +event.target.value
      if (!nextStep) {
        return
      }
      this.currentSelectedStep = nextStep
      if (this.futureAppointment.id) {
        this.$store.dispatch(symbols.actions.deleteFutureAppointment, this.futureAppointment.id)
        this.currentScheduledDate = ''
      }
      const postData = {
        segmentId: nextStep,
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.addFutureAppointment, postData)
    },
    updateTrackerNotes (event) {
      const newNote = event.target.value
      this.currentTrackerNote = newNote
      const payload = {
        patientId: this.patientId,
        trackerNotes: newNote
      }
      this.$store.dispatch(symbols.actions.updateTrackerNotes, payload)
    }
  }
}
