import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      epworthOptions: this.$store.state.screener[symbols.state.epworthOptions]
    }
  },
  computed: {
    epworthProps: function () {
      return this.$store.state.screener[symbols.state.epworthProps]
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.epworthProps].length) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  methods: {
    updateValue (event) {
      for (let epworth of this.epworthProps) {
        const propId = 'epworth_' + epworth.id
        if (event.target.id === propId) {
          epworth.selected = event.target.value
          return
        }
      }
    },
    onSubmit () {
      this.nextDisabled = true

      for (let epworth of this.epworthProps) {
        if (epworth.selected === '') {
          epworth.error = true
          this.hasError = true
        } else {
          epworth.error = false
        }
      }

      if (this.hasError) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.setEpworthProps, this.epworthProps)

      this.$router.push({ name: 'screener-symptoms' })
    }
  }
}
