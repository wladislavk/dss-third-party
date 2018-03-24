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
    validateSleeplabData (sleeplab) {
      var messages = {
        company: 'Lab Name is Required',
        firstname: 'Firstname is Required',
        lastname: 'Lastname is Required',
        add1: 'Address1 is Required',
        city: 'City is Required',
        state: 'State is Required',
        zip: 'Zip is Required'
      }

      if (!this.walkThroughMessages(messages, sleeplab)) {
        return false
      }

      if (!this.isEmail(sleeplab.email)) {
        alert('In-Valid Email')
        this.$refs.email.focus()

        return false
      }

      return true
    }
  }
}
