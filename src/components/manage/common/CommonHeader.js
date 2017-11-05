import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import PatientTaskMenuComponent from '../../manage/tasks/PatientTaskMenu.vue'
import TaskMenuComponent from '../../manage/tasks/TaskMenu.vue'
import { LEGACY_URL } from '../../../constants'

// include static libs
require('../../../../static/third-party/dynamic-drive-dhtml/ddlevelsmenu.js')

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      username: this.$store.state.main[symbols.state.userInfo].username,
      companyLogo: '',
      patientId: this.$store.state.main[symbols.state.patientId],
      showAllWarnings: this.$store.state.main[symbols.state.showAllWarnings]
    }
  },
  components: {
    taskMenu: TaskMenuComponent,
    patientTaskMenu: PatientTaskMenuComponent
  },
  created () {
    http.token = this.$store.state.main[symbols.state.mainToken]

    if (this.$store.state.main[symbols.state.userInfo].hasOwnProperty('loginId') && this.$store.state.main[symbols.state.userInfo].loginId) {
      const loginData = {
        loginid: this.$store.state.main[symbols.state.userInfo].loginId,
        userid: this.$store.state.main[symbols.state.userInfo].userId,
        cur_page: this.$route.query || ''
      }
      http.post(endpoints.loginDetails.store, loginData).then(() => {
        // @todo: add handler
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'setLoginDetails', response: response})
      })
    }

    http.get(endpoints.companies.companyByUser).then((response) => {
      const data = response.data.data
      if (data) {
        http.get(endpoints.displayFile + '/' + data.logo).then((response) => {
          const data = response.data.data
          this.companyLogo = data.image
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getFileForDisplaying', response: response})
        })
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCompanyByUser', response: response})
    })
  },
  methods: {
    showWarnings () {
      this.$store.commit(symbols.mutations.showAllWarnings)
    },
    hideWarnings () {
      this.$store.commit(symbols.mutations.hideAllWarnings)
    },
    goToAddPatient () {
      window.location.href = LEGACY_URL + 'add_patient.php'
    },
    addTaskPopup () {
      loadPopup(LEGACY_URL + 'add_task.php?pid=' + this.patientId)
    }
  }
}
