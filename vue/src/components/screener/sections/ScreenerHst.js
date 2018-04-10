import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'
import SectionHeaderComponent from '../common/SectionHeader.vue'
import HstContactComponent from './HstContact.vue'
import ScreenerNavigationComponent from '../common/ScreenerNavigation.vue'
import FileRetrieverFactory from '../../../services/file-retrievers/FileRetrieverFactory'

export default {
  data () {
    return {
      currentCompanyId: 0
    }
  },
  computed: {
    contactData () {
      return this.$store.state.screener[symbols.state.contactData]
    },
    companies () {
      return this.$store.state.screener[symbols.state.companyData]
    }
  },
  components: {
    sectionHeader: SectionHeaderComponent,
    hstContact: HstContactComponent,
    screenerNavigation: ScreenerNavigationComponent
  },
  created () {
    const isScreener = true
    this.$store.dispatch(symbols.actions.getCompanyData, isScreener)
  },
  methods: {
    updateCompany (event) {
      this.currentCompanyId = event.target.value
    },
    getLogo (logoName) {
      const token = this.$store.state.screener[symbols.state.screenerToken]
      const factory = new FileRetrieverFactory()
      return factory.getFileRetriever().getMediaFile(logoName, token)
    },
    onSubmit () {
      this.$store.commit(symbols.mutations.contactData)

      let hasMissingField = false
      for (let nameField of this.contactData) {
        if (nameField.value === '') {
          hasMissingField = true
        }
      }

      let alertText
      if (hasMissingField || !this.currentCompanyId) {
        alertText = 'All fields are required.'
        Alerter.alert(alertText)
        return
      }

      const payload = {
        companyId: this.currentCompanyId,
        contactData: this.contactData
      }
      this.$store.dispatch(symbols.actions.submitHst, payload).then(() => {
        alertText = 'HST submitted for approval and is in your Pending HST queue.'
        Alerter.alert(alertText)
        this.$store.commit(symbols.mutations.restoreInitialScreener)
        this.$router.push({ name: 'screener-intro' })
      }).catch(() => {
        const alertText = 'There was an error communicating with the server, please try again in a few minutes'
        Alerter.alert(alertText)
      })
    }
  }
}
