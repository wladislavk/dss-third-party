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
    epworthProps () {
      return this.$store.state.screener[symbols.state.epworthProps]
    },
    epworthWeight () {
      return this.$store.state.screener[symbols.state.screenerWeights].epworth
    },
    contactData () {
      return this.$store.state.screener[symbols.state.contactData]
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  }
}
