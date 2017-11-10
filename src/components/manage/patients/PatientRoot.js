import { LEGACY_URL } from '../../../constants/main'
import symbols from '../../../symbols'
import PatientDataComponent from './PatientData.vue'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      patientId: this.$store.state.main[symbols.state.patientId]
    }
  },
  components: {
    patientData: PatientDataComponent
  }
}
