import symbols from '../../../symbols'
import helpers from '../../../services/helpers'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      epworthOptions: this.$store.state.screener[symbols.state.epworthOptions],
      storedProps: {},
      errors: []
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
      const fieldId = event.target.id.replace('epworth_', '')
      this.storedProps[fieldId] = event.target.value
    },
    onSubmit () {
      this.nextDisabled = true
      this.hasError = false

      for (let epworth of this.epworthProps) {
        if (this.storedProps.hasOwnProperty(epworth.id)) {
          this.errors = helpers.arrayRemove(this.errors, epworth.epworth)
        } else {
          this.errors = helpers.arrayAddUnique(this.errors, epworth.epworth)
          this.hasError = true
        }
      }

      if (this.hasError) {
        this.nextDisabled = false
        this.$store.commit(symbols.mutations.setEpworthErrors, this.errors)
        return
      }

      this.$store.commit(symbols.mutations.modifyEpworthProps, this.storedProps)

      this.$router.push({ name: 'screener-symptoms' })
    }
  }
}
