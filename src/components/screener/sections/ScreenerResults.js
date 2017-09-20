import symbols from '../../../symbols'

export default {
  computed: {
    patientName: function () {
      const contactData = this.$store.state.screener[symbols.state.contactData]
      for (let property of contactData) {
        if (property.camelName === 'firstName') {
          return property.value
        }
      }
      return ''
    },
    riskLevel: function () {
      return this.$store.getters[symbols.getters.calculateRisk]
    },
    doctorName: function () {
      return this.$store.state.screener[symbols.state.doctorName]
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.doctorName]) {
      const userId = 0
      this.$store.dispatch(symbols.actions.getDoctorData, { userId: userId })
    }
  }
}
