import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      contactData: this.$store.state.screener[symbols.state.contactData]
    }
  },
  methods: {
    updateValue (event) {
      for (let nameField of this.contactData) {
        if (nameField.name === event.target.id) {
          nameField.value = event.target.value
          return
        }
      }
    },
    onSubmit () {
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
