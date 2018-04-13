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
      currentTrackerNote: '',
      currentSelectedStep: 0
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
    },
    selectedStep () {
      return this.futureAppointment.segmentId
    },
    trackerNote () {
      return this.$store.state.flowsheet[symbols.state.patientTrackerNotes]
    },
    scheduledDate () {
      if (!this.futureAppointment || !this.futureAppointment.dateScheduled) {
        return ''
      }
      return moment(this.futureAppointment.dateScheduled).format('MM/DD/YYYY')
    }
  },
  components: {
    datepicker: Datepicker
  },
  created () {
    this.currentScheduledDate = this.scheduledDate
    this.currentTrackerNote = this.trackerNote
    this.currentSelectedStep = this.selectedStep
  },
  watch: {
    scheduledDate (newValue) {
      this.currentScheduledDate = newValue
    },
    trackerNote (newValue) {
      this.currentTrackerNote = newValue
    },
    selectedStep (newValue) {
      this.currentSelectedStep = newValue
    }
  },
  methods: {
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
