import symbols from '../../../symbols'
import SectionHeaderComponent from '../common/SectionHeader.vue'
import ScreenerNavigationComponent from '../common/ScreenerNavigation.vue'
import LowRiskImage from '../../../assets/images/risk/screener-low_risk.png'
import ModerateRiskImage from '../../../assets/images/risk/screener-moderate_risk.png'
import HighRiskImage from '../../../assets/images/risk/screener-high_risk.png'
import SevereRiskImage from '../../../assets/images/risk/screener-severe_risk.png'
import { RISK_LEVEL_TEXTS, RISK_LEVELS } from '../../../constants/screener'

export default {
  computed: {
    patientName () {
      const contactData = this.$store.state.screener[symbols.state.contactData]
      for (let property of contactData) {
        if (property.camelName === 'firstName') {
          return property.value
        }
      }
      return ''
    },
    doctorName () {
      return this.$store.state.screener[symbols.state.doctorName]
    },
    riskLevel () {
      return this.$store.getters[symbols.getters.calculateRisk]
    },
    riskLevelImage () {
      const images = {
        [RISK_LEVELS.LOW]: LowRiskImage,
        [RISK_LEVELS.MODERATE]: ModerateRiskImage,
        [RISK_LEVELS.HIGH]: HighRiskImage,
        [RISK_LEVELS.SEVERE]: SevereRiskImage
      }
      const riskLevel = this.$store.getters[symbols.getters.calculateRisk]
      if (images.hasOwnProperty(riskLevel)) {
        return images[riskLevel]
      }
      return LowRiskImage
    },
    riskLevelText () {
      const riskLevel = this.$store.getters[symbols.getters.calculateRisk]
      const doctorName = this.$store.state.screener[symbols.state.doctorName]
      const parsedText = RISK_LEVEL_TEXTS[riskLevel].replace(/%s/g, doctorName)
      return parsedText
    }
  },
  components: {
    sectionHeader: SectionHeaderComponent,
    screenerNavigation: ScreenerNavigationComponent
  },
  created () {
    if (!this.$store.state.screener[symbols.state.doctorName]) {
      this.$store.dispatch(symbols.actions.getDoctorData)
    }
  }
}
