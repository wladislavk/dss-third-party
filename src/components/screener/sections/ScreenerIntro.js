import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      errors: {
        first_name: false,
        last_name: false,
        phone: false
      },
      nameFieldValues: {
        first_name: '',
        last_name: '',
        phone: ''
      }
    }
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      let returnVal = true

      const contactData = this.$store.state[symbols.state.contactData]
      for (let nameField of contactData) {
        if (this.nameFieldValues[nameField.name] === '') {
          this.errors[nameField.name] = true
          returnVal = false
        } else {
          this.errors[nameField.name] = false
        }
      }

      if (!returnVal) {
        this.nextDisabled = false
        return
      }

      const contactProperties = {
        firstName: this.nameFieldValues.first_name,
        last_name: this.nameFieldValues.last_name,
        phone: this.nameFieldValues.phone
      }
      this.$store.commit(symbols.mutations.contactProperties, contactProperties)

      const fullName = this.nameFieldValues.first_name + ' ' + this.nameFieldValues.last_name
      this.$store.commit(symbols.mutations.setAssessmentName, fullName)

      this.$router.push({ name: 'screener-epworth' })
    }
  }
}
