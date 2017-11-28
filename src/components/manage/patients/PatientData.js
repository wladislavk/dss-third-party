import symbols from '../../../symbols'
import PatientWarningsComponent from './PatientWarnings.vue'
import { LEGACY_URL } from '../../../constants/main'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      legacyUrl: LEGACY_URL,
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings]
    }
  },
  components: {
    patientWarnings: PatientWarningsComponent
  }
}
