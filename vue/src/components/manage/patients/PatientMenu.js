import { PATIENT_MENU } from '../../../constants/main'
import PatientMenuElementComponent from './PatientMenuElement.vue'

export default {
  computed: {
    menuElements () {
      const elements = []
      for (let menuElement of PATIENT_MENU) {
        const newElement = menuElement
        if (!menuElement.hasOwnProperty('active')) {
          newElement.active = ''
        }
        if (!menuElement.hasOwnProperty('activeLike')) {
          newElement.activeLike = []
        }
        elements.push(newElement)
      }
      return elements
    }
  },
  components: {
    patientMenuElement: PatientMenuElementComponent
  }
}
