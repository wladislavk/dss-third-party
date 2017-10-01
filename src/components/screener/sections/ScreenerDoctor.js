import symbols from '../../../symbols'
import HealthAssessmentComponent from '../common/HealthAssessment.vue'
import LowRiskImage from '../../../assets/images/risk/screener-low_risk.png'
import ModerateRiskImage from '../../../assets/images/risk/screener-moderate_risk.png'
import HighRiskImage from '../../../assets/images/risk/screener-high_risk.png'
import SevereRiskImage from '../../../assets/images/risk/screener-severe_risk.png'

export default {
  data () {
    return {
      symptoms: this.$store.state.screener[symbols.state.symptoms],
      coMorbidityData: this.$store.state.screener[symbols.state.coMorbidityData],
      cpap: this.$store.state.screener[symbols.state.cpap],
      resultsShown: false
    }
  },
  computed: {
    epworthProps: function () {
      return this.$store.state.screener[symbols.state.epworthProps]
    },
    epworthWeight: function () {
      return this.$store.state.screener[symbols.state.screenerWeights].epworth
    },
    contactData: function () {
      return this.$store.state.screener[symbols.state.contactData]
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
    }
  },
  components: {
    'health-assessment': HealthAssessmentComponent
  },
  created () {
    if (!this.$store.state.screener[symbols.state.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  methods: {
    showResults () {
      this.resultsShown = true
    },
    openFancybox () {
      this.$store.commit(symbols.mutations.showFancybox)
    }
  }
}
