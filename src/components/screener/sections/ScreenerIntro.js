import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      contactData: this.$store.state[symbols.state.contactData]
    }
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      let returnVal = true

      for (let nameField of this.contactData) {
        if (nameField.firstPage && nameField.value === '') {
          nameField.error = true
          returnVal = false
        } else {
          nameField.error = false
        }
      }

      if (!returnVal) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.contactData, this.contactData)

      this.$router.push({ name: 'screener-epworth' })
    }
  }
}
