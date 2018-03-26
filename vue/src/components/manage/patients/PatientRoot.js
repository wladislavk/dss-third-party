import symbols from '../../../symbols'
import PatientDataComponent from './PatientData.vue'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

export default {
  data () {
    return {
      legacyUrl: ProcessWrapper.getLegacyRoot(),
      patientId: this.$store.state.patients[symbols.state.patientId]
    }
  },
  components: {
    patientData: PatientDataComponent
  },
  beforeRouteUpdate (to, from, next) {
    let toPatientId = 0
    if (to.params.hasOwnProperty('pid')) {
      toPatientId = parseInt(to.params.pid)
    }
    if (!toPatientId) {
      this.clearPatientData()
      next()
      return
    }
    let fromPatientId = 0
    if (from.params.hasOwnProperty('pid')) {
      fromPatientId = parseInt(from.params.pid)
    }
    if (toPatientId !== fromPatientId) {
      this.updatePatientData(toPatientId)
    }
    next()
  },
  methods: {
    updatePatientData (patientId) {
      this.$store.dispatch(symbols.actions.patientData, patientId)
    },
    clearPatientData () {
      this.$store.dispatch(symbols.actions.clearPatientData)
    }
  }
}
