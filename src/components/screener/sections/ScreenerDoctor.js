import fancybox from '../../../services/fancybox'
import symbols from '../../../symbols'

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
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
    fancybox.screenerDoctor()
  },
  methods: {
    showResults () {
      this.resultsShown = true
    }
  }
}
