import symbols from '../../../symbols'

export default {
  data () {
    return {
      nextDisabled: false,
      communicationError: false,
      cpap: this.$store.state[symbols.state.cpap],
      conditions: this.$store.state[symbols.state.coMorbidityData]
    }
  },
  created () {
    if (!this.$store.state[symbols.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      this.$store.commit(symbols.mutations.coMorbidity, this.conditions)
      this.$store.commit(symbols.mutations.cpap, this.cpap)

      this.$store.dispatch(symbols.actions.submitScreener).then(
        (response) => {
          this.$store.dispatch(symbols.actions.parseScreenerResults, response)
          this.$router.push({ name: 'screener-results' })
        },
        () => {
          this.nextDisabled = false
          alert('There was an error communicating with the server, please try again in a few minutes')
        }
      )
    }
  }
}
