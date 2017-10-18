import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'

require('../../../../static/third-party/sucker-tree-horizontal-menu/sucker_tree_home.js')

export default {
  data () {
    return {
      constants: window.constants,
      legacyUrl: LEGACY_URL,
      screenerUrl: '/screener',
      documentCategories: [],
      headerInfo: {
        pendingClaimsNumber: 0,
        docInfo: {},
        user: {},
        courseStaff: {
          use_course: 0,
          use_course_staff: 0
        }
      }
    }
  },
  computed: {
    isUserDoctor () {
      return (this.headerInfo.user.docid === this.headerInfo.user.id)
    },
    showEnrollments () {
      return (this.headerInfo.docInfo.use_eligible_api === 1)
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
    showDSSFranchiseOperationsManual () {
      return (this.headerInfo.user.user_type === this.constants.DSS_USER_TYPE_FRANCHISEE)
    },
    showInvoices () {
      return (this.headerInfo.user.docid === this.headerInfo.user.id || this.headerInfo.docInfo.manage_staff === 1)
    },
    showTransactionCode () {
      return (this.headerInfo.user.id === this.headerInfo.user.docid || this.headerInfo.user.manage_staff === 1)
    }
  },
  mixins: [handlerMixin],
  created () {
    window.eventHub.$on('update-header-info', this.onUpdateHeaderInfo)
    window.eventHub.$emit('get-header-info')

    http.token = this.$store.state.main[symbols.state.mainToken]

    http.post(endpoints.documentCategories.active).then((response) => {
      this.documentCategories = response.data.data
    }).catch((response) => {
      this.handleErrors('getDocumentCategories', response)
    })
  },
  beforeDestroy () {
    window.eventHub.$off('update-header-info', this.onUpdateHeaderInfo)
  },
  methods: {
    onUpdateHeaderInfo (headerInfo) {
      this.headerInfo = headerInfo
    },
    onClickDeviceSelector () {
      this.$parent.$refs.modal.display('device-selector')
    },
    onClickExportMD () {
      window.swal(
        {
          title: '',
          text: 'Enter your password',
          type: 'input',
          inputType: 'password',
          showCancelButton: true,
          closeOnConfirm: false,
          animation: 'slide-from-top',
          inputPlaceholder: 'Enter password'
        },
        (inputValue) => {
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
        }
      )
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
        (isConfirm) => {
          if (isConfirm) {
            window.location.href = this.legacyUrl + '/manage/data_import.php'
          }
        }
      )
    }
  }
}
