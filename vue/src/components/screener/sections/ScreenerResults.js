import symbols from '../../../symbols'
import HealthAssessmentComponent from '../common/HealthAssessment.vue'
import LowRiskImage from '../../../assets/images/risk/screener-low_risk.png'
import ModerateRiskImage from '../../../assets/images/risk/screener-moderate_risk.png'
import HighRiskImage from '../../../assets/images/risk/screener-high_risk.png'
import SevereRiskImage from '../../../assets/images/risk/screener-severe_risk.png'

export default {
  computed: {
    patientName: function () {
      const contactData = this.$store.state.screener[symbols.state.contactData]
      for (let property of contactData) {
        if (property.camelName === 'firstName') {
          return property.value
        }
      }
      return ''
    },
    riskLevel: function () {
      return this.$store.getters[symbols.getters.calculateRisk]
    },
    riskLevelImage: function () {
      const images = {
        low: LowRiskImage,
        moderate: ModerateRiskImage,
        high: HighRiskImage,
        severe: SevereRiskImage
      }
      const riskLevel = this.$store.getters[symbols.getters.calculateRisk]
      if (images.hasOwnProperty(riskLevel)) {
        return images[riskLevel]
      }
      return LowRiskImage
    },
    doctorName: function () {
      return this.$store.state.screener[symbols.state.doctorName]
    }
  },
  components: {
    'health-assessment': HealthAssessmentComponent
  },
  created () {
    if (!this.$store.state.screener[symbols.state.doctorName]) {
      this.$store.dispatch(symbols.actions.getDoctorData)
    }
  }
}
