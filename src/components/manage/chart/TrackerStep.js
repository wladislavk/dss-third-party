import symbols from '../../../symbols'
import http from '../../../services/http'

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    rank: {
      type: Number,
      required: true
    },
    patientId: {
      type: Number,
      required: true
    },
    section: {
      type: Number,
      required: true
    }
  },
  computed: {
    firstStep () {
      if (this.id === 1) {
        return true
      }
      return false
    },
    stepClass () {
      if (this.section === 1) {
        if (this.id === this.finalElement.segmentid) {
          return 'last'
        }
        if (this.rank < this.finalRank) {
          return 'completed_step'
        }
      } else {
        if (this.id === this.lastElement.segmentid) {
          return 'last'
        }
      }
      return ''
    }
  },
  methods: {
    addAction () {
      const postData = {
        id: this.id,
        pid: this.patientId
      }
      http.post('manage/includes/update_appt_today.php', postData).then((response) => {
        const responseData = response.data.data
        this.updateCurrentStep()
        this.nextSteps = responseData.next_steps
        this.secondSchedule.segmentid = ''
        this.$store.dispatch(symbols.actions.insertTrackerStep, responseData)
        $('#next_step_date').val('')
        $('#next_step_until').text('')
      })
    },
    updateCurrentStep () {
      let hasScheduledAppointment = false
      if (this.secondSchedule.segmentid && $('#next_step_date').val() !== '') {
        hasScheduledAppointment = true
      }
      this.hasScheduledAppointment = hasScheduledAppointment
    },
    updateCompletedDate (cid) {
      const id = cid.substring(15)
      const compDate = $('#completed_date_' + id).val()
      const postData = {
        id: id,
        comp_date: compDate,
        pid: this.patientId
      }
      http.post('manage/includes/update_appt.php', postData)
    }
  }
}
