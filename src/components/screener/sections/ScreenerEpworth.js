import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false
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

      const epworthProps = this.$store.state[symbols.state.epworthProps]
      for (let epworth of epworthProps) {
        if (epworth.selected === '') {
          epworth.error = true
          this.nextDisabled = false
          this.hasError = true
        } else {
          epworth.error = false
        }
      }

      this.$router.push({ name: 'screener-symptoms' })
    }
  }
}
