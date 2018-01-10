import symbols from '../../../symbols'
import LocationWrapper from '../../../wrappers/LocationWrapper'
import PatientHeaderComponent from '../patients/PatientHeader.vue'
import PatientSearchComponent from './PatientSearch.vue'
import TaskMenuComponent from '../tasks/TaskMenu.vue'
import WelcomeTextComponent from './WelcomeText.vue'
import RightTopMenuComponent from './RightTopMenu.vue'
import LeftTopMenuComponent from './LeftTopMenu.vue'
import http from '../../../services/http'
import endpoints from '../../../endpoints'
import FileRetrieverFactory from '../../../services/file-retrievers/FileRetrieverFactory'

export default {
  data () {
    return {
      patientId: this.$store.state.patients[symbols.state.patientId],
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings],
      companyLogo: ''
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
    http.token = this.$store.state.main[symbols.state.mainToken]
    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data.hasOwnProperty('logo') && data.logo) {
        const factory = new FileRetrieverFactory()
        this.companyLogo = factory.getFileRetriever().getMediaFile(data.logo)
      }
    })
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
