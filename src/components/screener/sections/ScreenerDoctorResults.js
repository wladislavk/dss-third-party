import symbols from '../../../symbols'

export default {
  data () {
    return {
      symptoms: this.$store.state.screener[symbols.state.symptoms],
      coMorbidityData: this.$store.state.screener[symbols.state.coMorbidityData],
      cpap: this.$store.state.screener[symbols.state.cpap]
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
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  }
}
