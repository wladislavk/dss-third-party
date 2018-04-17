import Alerter from '../../../services/Alerter'
import LocationWrapper from '../../../wrappers/LocationWrapper'
import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    isHstCompany () {
      return this.$store.getters[symbols.getters.isHSTCompany]
    },
    incompleteHsts () {
      return this.$store.state.patients[symbols.state.incompleteHomeSleepTests]
    },
    hstStatus () {
      return this.$store.getters[symbols.getters.hstStatus]
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
