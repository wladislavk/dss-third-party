import symbols from '../../../symbols'
import AwesomeMask from 'awesome-mask'

export default {
  data: function () {
    return {
      nextDisabled: false,
      contactData: this.$store.state.screener[symbols.state.contactData],
      storedContacts: {},
      errors: {}
    }
  },
  directives: {
    mask: AwesomeMask
  },
  methods: {
    updateValue (event) {
      this.storedContacts[event.target.id] = event.target.value
    },
    onSubmit () {
      this.nextDisabled = true

      let hasError = false

      for (let nameField of this.contactData) {
        if (
          nameField.firstPage &&
          (!this.storedContacts.hasOwnProperty(nameField.name) || this.storedContacts[nameField.name] === '')
        ) {
          this.errors[nameField.name] = true
          hasError = true
        } else {
          this.errors[nameField.name] = false
        }
      }

      if (hasError) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.contactData, this.storedContacts)

      this.$router.push({ name: 'screener-epworth' })
    }
  }
}
