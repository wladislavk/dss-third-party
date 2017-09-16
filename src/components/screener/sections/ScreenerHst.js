import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      contactData: this.$store.state[symbols.state.contactData],
      company: {},
      hstCompany: 0
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getCompanyData)
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      let hasMissingField = false
      for (let contact of this.contactData) {
        if (contact.value === '') {
          hasMissingField = true
        }
      }

      if (hasMissingField || !this.hstCompany) {
        alert('All fields are required.')
        return
      }

      this.$store.commit(symbols.mutations.contactData, this.contactData)

      const payload = {
        hstCompany: this.hstCompany
      }
      this.$store.dispatch(symbols.actions.submitHst, payload).then(
        () => {
          alert('HST submitted for approval and is in your Pending HST queue.')
          this.$router.push({ name: 'screener-intro' })
        },
        () => {
          alert('There was an error communicating with the server, please try again in a few minutes')
        }
      )
    }
  }
}
