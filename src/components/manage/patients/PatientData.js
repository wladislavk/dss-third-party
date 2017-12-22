import symbols from '../../../symbols'
import PatientWarningsComponent from './PatientWarnings.vue'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      showAllWarnings: this.$store.state.patients[symbols.state.showAllWarnings]
    }
  },
  components: {
    patientWarnings: PatientWarningsComponent
  }
}
