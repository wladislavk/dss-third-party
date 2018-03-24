import Alerter from '../../../services/Alerter'
import LocationWrapper from '../../../wrappers/LocationWrapper'
import symbols from '../../../symbols'
import { HST_STATUSES } from '../../../constants/main'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    isHSTCompany () {
      if (this.$store.state.main[symbols.state.companyData].length > 0) {
        return true
      }
      return false
    },
    incompleteHSTs () {
      return this.$store.state.patients[symbols.state.incompleteHomeSleepTests]
    },
    hstStatus () {
      if (!this.incompleteHSTs.length) {
        return ''
      }
      const lastHST = this.incompleteHSTs[this.incompleteHSTs.length - 1]
      if (!HST_STATUSES.hasOwnProperty(lastHST)) {
        return ''
      }
      return HST_STATUSES[lastHST]
    }
  },
  created () {
    const isScreener = false
    this.$store.dispatch(symbols.actions.getCompanyData, isScreener)
  },
  methods: {
    orderHst () {
      const alertText = 'Patient has existing HST with status ' + this.hstStatus + '. Only one HST can be requested at a time.'
      Alerter.alert(alertText)
    },
    requestHst () {
      const confirmText = 'Click OK to initiate a Home Sleep Test request. The HST request must be electronically signed by an authorized provider before it can be transmitted. You can view and save/update the request on the next screen.'
      if (Alerter.isConfirmed(confirmText)) {
        const legacyUrl = 'manage/hst_request_co.php?ed=' + this.patientId
        LocationWrapper.goToLegacyPage(legacyUrl, this.$store.state.main[symbols.state.mainToken])
      }
    }
  }
}
