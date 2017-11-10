import PatientMenuComponent from './PatientMenu.vue'
import PatientInnerMenuComponent from './PatientInnerMenu.vue'
import PatientTaskMenuComponent from '../tasks/PatientTaskMenu.vue'

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
  }
}
