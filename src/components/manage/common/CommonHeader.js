import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants/main'
import LocationWrapper from '../../../wrappers/LocationWrapper'
import PatientHeaderComponent from '../patients/PatientHeader.vue'
import PatientSearchComponent from './PatientSearch.vue'
import TaskMenuComponent from '../tasks/TaskMenu.vue'
import WelcomeTextComponent from './WelcomeText.vue'
import RightTopMenuComponent from './RightTopMenu.vue'
import LeftTopMenuComponent from './LeftTopMenu.vue'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      patientId: this.$store.state.patients[symbols.state.patientId],
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings]
    }
  },
  computed: {
    companyLogo () {
      return this.$store.state.main[symbols.state.companyLogo]
    }
  },
  components: {
    rightTopMenu: RightTopMenuComponent,
    leftTopMenu: LeftTopMenuComponent,
    taskMenu: TaskMenuComponent,
    patientHeader: PatientHeaderComponent,
    patientSearch: PatientSearchComponent,
    welcomeText: WelcomeTextComponent
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
