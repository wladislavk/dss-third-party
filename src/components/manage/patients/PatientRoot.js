import { LEGACY_URL } from '../../../constants/main'
import symbols from '../../../symbols'
import PatientDataComponent from './PatientData.vue'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      patientId: 0
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
      this.patientId = patientId
      this.$store.dispatch(symbols.actions.patientData, patientId)
    },
    clearPatientData () {
      this.patientId = 0
      this.$store.dispatch(symbols.actions.clearPatientData)
    }
  }
}
