import symbols from '../../../symbols'
import PatientDataComponent from './PatientData.vue'

export default {
  data () {
    return {
      patientId: this.$store.state.patients[symbols.state.patientId]
    }
  },
  components: {
    patientData: PatientDataComponent
  },
  created () {
    if (this.$route.query.hasOwnProperty('pid')) {
      const patientId = parseInt(this.$route.query.pid)
      this.updatePatientData(patientId)
    }
  },
  beforeRouteUpdate (to, from, next) {
    let toPatientId = 0
    if (to.query.hasOwnProperty('pid')) {
      toPatientId = parseInt(to.query.pid)
    }
    if (!toPatientId) {
      this.clearPatientData()
      next()
      return
    }
    let fromPatientId = 0
    if (from.query.hasOwnProperty('pid')) {
      fromPatientId = parseInt(from.query.pid)
    }
    if (toPatientId !== fromPatientId) {
      this.updatePatientData(toPatientId)
    }
    next()
  },
  beforeRouteLeave (to, from, next) {
    this.clearPatientData()
    next()
  },
  methods: {
    updatePatientData (patientId) {
      this.$store.dispatch(symbols.actions.patientData, patientId)
      this.$store.dispatch(symbols.actions.retrieveTasksForPatient, patientId)
    },
    clearPatientData () {
      this.$store.dispatch(symbols.actions.clearPatientData)
      this.$store.commit(symbols.mutations.setTasksForPatient, [])
    }
  }
}
