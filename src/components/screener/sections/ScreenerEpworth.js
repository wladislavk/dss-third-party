import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      epworthProps: [],
      epworthOptions: this.$store.state[symbols.state.epworthOptions]
    }
  },
  created () {
    if (!this.$store.state[symbols.state.epworthProps].length) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
    this.epworthProps = this.$store.state[symbols.state.epworthProps]
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      for (let epworth of this.epworthProps) {
        if (epworth.selected === '') {
          epworth.error = true
          this.nextDisabled = false
          this.hasError = true
        } else {
          epworth.error = false
        }
      }

      if (this.hasError) {
        return
      }

      this.$store.commit(symbols.mutations.setEpworthProps, this.epworthProps)

      this.$router.push({ name: 'screener-symptoms' })
    }
  }
}
