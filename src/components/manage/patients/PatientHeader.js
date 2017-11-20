import PatientMenuComponent from './PatientMenu.vue'
import PatientInnerMenuComponent from './PatientInnerMenu.vue'
import PatientTaskMenuComponent from '../tasks/PatientTaskMenu.vue'
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  components: {
    patientMenu: PatientMenuComponent,
    patientInnerMenu: PatientInnerMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent
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
