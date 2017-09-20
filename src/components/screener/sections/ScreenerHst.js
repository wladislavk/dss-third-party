import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      contactData: this.$store.state.screener[symbols.state.contactData],
      currentCompanyId: 0,
      storedContacts: {}
    }
  },
  computed: {
    companies: function () {
      return this.$store.state.screener[symbols.state.companyData]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getCompanyData)
    if (!this.$store.state.screener[symbols.state.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  methods: {
    updateCompany (event) {
      this.currentCompanyId = event.target.value
    },
    updateContact (event) {
      const contactName = event.target.id.replace('hst_', '')
      this.storedContacts[contactName] = event.target.value
    },
    onSubmit () {
      this.$store.commit(symbols.mutations.contactData, this.storedContacts)

      let hasMissingField = false
      for (let nameField of this.contactData) {
        if (nameField.value === '') {
          hasMissingField = true
        }
      }

      if (hasMissingField || !this.currentCompanyId) {
        alert('All fields are required.')
        return
      }

      const payload = {
        companyId: this.currentCompanyId,
        contactData: this.contactData
      }
      this.$store.dispatch(symbols.actions.submitHst, payload).then(
        () => {
          alert('HST submitted for approval and is in your Pending HST queue.')
          this.$store.commit(symbols.mutations.restoreInitialScreener)
          this.$router.push({ name: 'screener-intro' })
        },
        () => {
          alert('There was an error communicating with the server, please try again in a few minutes')
        }
      )
    }
  }
}
