import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'

export default {
  data () {
    return {
      constants: window.constants,
      legacyUrl: LEGACY_URL,
      showAllLink: true,
      showActiveLink: false,
      headerInfo: {
        unmailedLettersNumber: 0,
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
        docInfo: {}
      }
    }
  },
  computed: {
    notificationsNumber () {
      return +this.headerInfo.patientContactsNumber +
        +this.headerInfo.patientInsurancesNumber +
        +this.headerInfo.patientChangesNumber
    },
    showUnmailedLettersNumber () {
      return (this.headerInfo.useLetters && this.headerInfo.user.user_type === this.constants.DSS_USER_TYPE_SOFTWARE)
    },
    showUnmailedClaims () {
      return (this.headerInfo.user.user_type === this.constants.DSS_USER_TYPE_SOFTWARE)
    }
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
  },
  beforeDestroy () {
    window.eventHub.$off('update-header-info', this.onUpdateHeaderInfo)
  },
  methods: {
    redirectToIndex2 () {
      if (this.headerInfo.docInfo.homepage !== 1) {
        // @todo: there is no such route
        // this.$router.push('/manage/index2')
      }
    },
    onUpdateHeaderInfo (headerInfo) {
      this.headerInfo = headerInfo
    },
    showAllNotifications () {
      $('.notification.count_0').css('display', 'block')
      this.showAllLink = false
      this.showActiveLink = true
    },
    showActiveNotifications () {
      $('.notification.count_0').hide()
      this.showActiveLink = false
      this.showAllLink = true
    }
  }
}
