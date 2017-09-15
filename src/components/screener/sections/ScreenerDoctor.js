import symbols from '../../../symbols'

export default {
  data () {
    return {
      epworthWeight: this.$store.state[symbols.state.screenerWeights].epworthWeight
    }
  },
  computed: {
    contactData: function () {
      return this.$store.getters[symbols.getters.fullContactData]
    },
    riskLevel: function () {
      return this.$store.getters[symbols.getters.calculateRisk]
    }
  }
}
