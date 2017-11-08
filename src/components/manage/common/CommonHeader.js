import symbols from '../../../symbols'
import PatientTaskMenuComponent from '../tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../tasks/TaskMenu.vue'
import PatientDataComponent from './PatientData.vue'
import { LEGACY_URL } from '../../../constants/main'
import LocationWrapper from '../../../wrappers/LocationWrapper'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      username: this.$store.state.main[symbols.state.userInfo].username,
      patientId: this.$store.state.main[symbols.state.patientId],
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings]
    }
  },
  computed: {
    companyLogo () {
      return this.$store.state.main[symbols.state.companyLogo]
    }
  },
  components: {
    taskMenu: TaskMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent,
    patientData: PatientDataComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.companyLogo)
  },
  methods: {
    showWarnings () {
      this.$store.commit(symbols.mutations.showAllWarnings)
    },
    hideWarnings () {
      this.$store.commit(symbols.mutations.hideAllWarnings)
    },
    goToAddPatient () {
      LocationWrapper.goToPage(LEGACY_URL + 'add_patient.php')
    },
    addTaskPopup () {
      const props = {
        patientId: this.patientId
      }
      this.$store.commit(symbols.mutations.modal, { name: 'add-task', params: props })
    }
  }
}
