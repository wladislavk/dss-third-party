import PatientMenuComponent from './PatientMenu.vue'
import PatientInnerMenuComponent from './PatientInnerMenu.vue'
import PatientTaskMenuComponent from '../tasks/PatientTaskMenu.vue'
import WelcomeTextComponent from '../common/WelcomeText.vue'
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    showAllWarnings () {
      return this.$store.state.patients[symbols.state.showAllWarnings]
    }
  },
  components: {
    patientMenu: PatientMenuComponent,
    patientInnerMenu: PatientInnerMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent,
    welcomeText: WelcomeTextComponent
  },
  methods: {
    showWarnings () {
      this.$store.commit(symbols.mutations.showAllWarnings)
    },
    hideWarnings () {
      this.$store.commit(symbols.mutations.hideAllWarnings)
    }
  }
}
