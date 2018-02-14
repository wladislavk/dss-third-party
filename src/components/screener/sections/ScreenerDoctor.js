import symbols from '../../../symbols'
import SectionHeaderComponent from '../common/SectionHeader.vue'
import ScreenerNavigationComponent from '../common/ScreenerNavigation.vue'
import ScreenerDoctorResultsComponent from './ScreenerDoctorResults.vue'
import LowRiskImage from '../../../assets/images/risk/screener-low_risk.png'
import ModerateRiskImage from '../../../assets/images/risk/screener-moderate_risk.png'
import HighRiskImage from '../../../assets/images/risk/screener-high_risk.png'
import SevereRiskImage from '../../../assets/images/risk/screener-severe_risk.png'

export default {
  data () {
    return {
      resultsShown: false
    }
  },
  computed: {
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
    sectionHeader: SectionHeaderComponent,
    screenerNavigation: ScreenerNavigationComponent,
    screenerDoctorResults: ScreenerDoctorResultsComponent
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
