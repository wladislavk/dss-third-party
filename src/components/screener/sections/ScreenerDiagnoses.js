import alerter from '../../../services/alerter'
import symbols from '../../../symbols'

export default {
  data () {
    return {
      nextDisabled: false,
      communicationError: false,
      cpap: this.$store.state.screener[symbols.state.cpap],
      storedCpap: 0,
      conditions: this.$store.state.screener[symbols.state.coMorbidityData],
      storedConditions: {}
    }
  },
  methods: {
    updateValue (event) {
      this.storedConditions[event.target.name] = false
      if (event.target.checked) {
        this.storedConditions[event.target.name] = true
      }
    },
    updateCpap (event) {
      this.storedCpap = event.target.value
    },
    onSubmit () {
      this.nextDisabled = true

      this.$store.commit(symbols.mutations.coMorbidity, this.storedConditions)
      this.$store.commit(symbols.mutations.cpap, this.storedCpap)

      this.$store.dispatch(symbols.actions.submitScreener).then(
        (response) => {
          this.$store.dispatch(symbols.actions.parseScreenerResults, response)
          this.$router.push({ name: 'screener-results' })
        },
        () => {
          this.nextDisabled = false
          const alertText = 'There was an error communicating with the server, please try again in a few minutes'
          alerter.alert(alertText)
        }
      )
    }
  }
}
