import symbols from '../../../symbols'
import PatientWarningsComponent from './PatientWarnings.vue'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      legacyUrl: ProcessWrapper.getLegacyRoot(),
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings]
    }
  },
  components: {
    patientWarnings: PatientWarningsComponent
  }
}
