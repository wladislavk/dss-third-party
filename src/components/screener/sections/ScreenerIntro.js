import symbols from '../../../symbols'
import AwesomeMask from 'awesome-mask'

export default {
  data () {
    return {
      nextDisabled: false,
      contactData: this.$store.state.screener[symbols.state.contactData],
      errors: {}
    }
  },
  directives: {
    mask: AwesomeMask
  },
  methods: {
    updateValue (event) {
      const payload = {
        name: event.target.id,
        value: event.target.value
      }
      this.$store.commit(symbols.mutations.addStoredContact, payload)
    },
    onSubmit () {
      this.nextDisabled = true

      let hasError = false

      const storedContactData = this.$store.state.screener[symbols.state.storedContactData]
      for (let nameField of this.contactData) {
        if (
          nameField.firstPage &&
          (!storedContactData.hasOwnProperty(nameField.name) || storedContactData[nameField.name] === '')
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

      this.$store.commit(symbols.mutations.contactData)

      this.$router.push({ name: 'screener-epworth' })
    }
  }
}
