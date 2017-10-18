import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'
import HeaderComponent from '../../header/header.vue'
import DashboardTaskMenuComponent from '../tasks/DashboardTaskMenu.vue'

// include static libs
require('../../../../static/third-party/sucker-tree-horizontal-menu/sucker_tree_home.js')

export default {
  data: function () {
    return {
      // need to change logic for global values
      constants: window.constants,
      legacyUrl: LEGACY_URL,
      screenerUrl: '/screener',
      headerInfo: {
        unmailedLettersNumber: 0,
        pendingClaimsNumber: 0,
        pendingNodssClaimsNumber: 0,
        unmailedClaimsNumber: 0,
        rejectedClaimsNumber: 0,
        preauthNumber: 0,
        rejectedPreAuthNumber: 0,
        alertsNumber: 0,
        hstNumber: 0,
        requestedHSTNumber: 0,
        rejectedHSTNumber: 0,
        patientContactsNumber: 0,
        patientInsurancesNumber: 0,
        patientChangesNumber: 0,
        pendingDuplicatesNumber: 0,
        emailBouncesNumber: 0,
        paymentReportsNumber: 0,
        unsignedNotesNumber: 0,
        faxAlertsNumber: 0,
        usePaymentReports: false,
        useLetters: false,
        pendingLetters: [],
        user: {},
        docInfo: {},
        courseStaff: {
          use_course: 0,
          use_course_staff: 0
        }
      },
      documentCategories: [],
      memos: []
    }
  },
  components: {
    headerComponent: HeaderComponent,
    dashboardTaskMenu: DashboardTaskMenuComponent
  },
  mixins: [handlerMixin],
  watch: {
    'headerInfo.docInfo.homepage': 'redirectToIndex2',
    'headerInfo.user.id': function () {
      http.token = this.$store.state.main[symbols.state.mainToken]
      const userId = this.headerInfo.user.id.replace('u_', '') || '0'
      http.get(endpoints.users.show + '/' + userId).then((response) => {
        const data = response.data.data
        if (data) {
          this.headerInfo.user['manage_staff'] = data.manage_staff || 0
        }
      }).catch((response) => {
        this.handleErrors('getManageStaffOfCurrentUser', response)
      })
    }
  },
  created () {
    window.eventHub.$on('update-header-info', this.onUpdateHeaderInfo)
    window.eventHub.$emit('get-header-info')

    const token = this.$store.state.main[symbols.state.mainToken]
    if (!token) {
      this.$router.push({ name: 'login' })
      return
    }

    http.token = token

    http.post(endpoints.documentCategories.active).then((response) => {
      this.documentCategories = response.data.data
    }).catch((response) => {
      this.handleErrors('getDocumentCategories', response)
    })

    http.post(endpoints.memos.current).then((response) => {
      this.memos = response.data.data
    }).catch((response) => {
      this.handleErrors('getCurrentMemos', response)
    })
  },
  beforeDestroy () {
    window.eventHub.$off('update-header-info', this.onUpdateHeaderInfo)
  },
  computed: {
    notificationsNumber () {
      return +this.headerInfo.patientContactsNumber +
        +this.headerInfo.patientInsurancesNumber +
        +this.headerInfo.patientChangesNumber
    },
    isUserDoctor () {
      return (this.headerInfo.user.docid === this.headerInfo.user.id)
    },
    showInvoices () {
      return (this.headerInfo.user.docid === this.headerInfo.user.id || this.headerInfo.docInfo.manage_staff === 1)
    },
    showTransactionCode () {
      return (this.headerInfo.user.id === this.headerInfo.user.docid || this.headerInfo.user.manage_staff === 1)
    },
    showEnrollments () {
      return (this.headerInfo.docInfo.use_eligible_api === 1)
    },
    showDSSFranchiseOperationsManual () {
      return (this.headerInfo.user.user_type === this.constants.DSS_USER_TYPE_FRANCHISEE)
    },
    showGetCE () {
      return (
        (this.isUserDoctor && this.headerInfo.docInfo.use_course === 1) ||
        (
          !this.isUserDoctor &&
          this.headerInfo.courseStaff.use_course === 1 && this.headerInfo.courseStaff.use_course_staff === 1
        )
      )
    },
    showUnmailedLettersNumber () {
      return (this.headerInfo.useLetters && this.headerInfo.user.user_type === window.constants.DSS_USER_TYPE_SOFTWARE)
    },
    showUnmailedClaims () {
      return (this.headerInfo.user.user_type === this.constants.DSS_USER_TYPE_SOFTWARE)
    }
  },
  methods: {
    onUpdateHeaderInfo (headerInfo) {
      this.headerInfo = headerInfo
    },
    redirectToIndex2 () {
      if (this.headerInfo.docInfo.homepage !== 1) {
        // @todo: there is no such route
        // this.$router.push('/manage/index2')
      }
    },
    onClickExportMD () {
      window.swal({
        title: '',
        text: 'Enter your password',
        type: 'input',
        inputType: 'password',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: 'slide-from-top',
        inputPlaceholder: 'Enter password'
      }, function (inputValue) {
        if (inputValue === '') {
          window.swal.showInputError('You need to write the password!')
          return false
        }

        if (inputValue === '1234') {
          window.swal.close()
          window.location.href = this.legacyUrl + '/manage/export_md.php'
        } else if (inputValue.length > 0) {
          window.swal('Oops...', 'Wrong password!', 'error')
          return false
        }
        return true
      })
    },
    onClickDataImport () {
      window.swal(
        {
          title: '',
          text: 'Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3CB371',
          confirmButtonText: 'Ok',
          cancelButtonText: 'Cancel',
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function (isConfirm) {
          if (isConfirm) {
            window.location.href = this.legacyUrl + '/manage/data_import.php'
          }
        }
      )
    }
  }
}
