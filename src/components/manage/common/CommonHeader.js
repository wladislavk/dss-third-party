import symbols from '../../../symbols'
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
    // @todo: this is not likely to work in legacy, migrate after other modules are migrated
    // this.$store.dispatch(symbols.actions.companyLogo)
  },
  methods: {
    goToAddPatient () {
      LocationWrapper.goToLegacyPage('manage/add_patient.php')
    },
    addTaskPopup () {
      const props = {
        id: 0,
        patientId: this.patientId
      }
      this.$store.commit(symbols.mutations.modal, { name: 'addTask', params: props })
    }
  }
}
