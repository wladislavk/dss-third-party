import symbols from '../../../symbols'

export default {
  data () {
    return {
      epworthWeight: this.$store.state[symbols.state.screenerWeights].epworthWeight,
      epworthProps: this.$store.state[symbols.state.epworthProps],
      symptoms: this.$store.state[symbols.state.symptoms],
      cpap: this.$store.state[symbols.state.cpap],
      resultsShown: false
    }
  },
  computed: {
    contactData: function () {
      return this.$store.getters[symbols.getters.fullContactData]
    },
    riskLevel: function () {
      return this.$store.getters[symbols.getters.calculateRisk]
    }
  },
  created () {
    if (!this.$store.state[symbols.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  methods: {
    showResults () {
      this.resultsShown = true
    },
    requestHst () {
      this.$router.push({ name: 'screener-hst' })
    }
  }
}
