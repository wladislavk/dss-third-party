export default {
  methods: {
    isEmail (email) {
      return email && email.match(/^[\w.+-]+@\w+\.\w+$/)
    },
    walkThroughMessages (messages, contact) {
      for (var property in messages) {
        if (messages.hasOwnProperty(property)) {
          if (contact[property] === undefined || contact[property].trim() === '') {
            alert(messages[property])
            this.$refs[property].focus()

            return false
          }
        }
      }

      return true
    },
    validateContactData (contact) {
      var messages = {
        firstname: 'First Name is Required',
        lastname: 'Last Name is Required'
      }

      if (!this.walkThroughMessages(messages, contact)) {
        return false
      }

      if (!this.isEmail(contact.email)) {
        alert('In-Valid Email')
        this.$refs.email.focus()

        return false
      }

      if (contact.preferredcontact === 'fax' && contact.fax === '') {
        alert('A fax number must be entered if preferred contact method is fax.')

        return false
      }

      if (!contact.add1 && !contact.city && !contact.state && !contact.zip) {
        return confirm('Warning! You have not entered an address for this contact. This contact will NOT receive correspondence from DSS. Are you sure you want to save without an address?')
      }

      return true
    }
  }
}
