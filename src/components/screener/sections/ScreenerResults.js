import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      patientName: this.$store.state[symbols.state.contactProperties].firstName
    }
  },
  computed: {
    riskLevel: function () {
      return this.$store.getters[symbols.getters.calculateRisk]
    },
    doctorName: function () {
      return this.$store.state[symbols.state.doctorName]
    }
  },
  created () {
    if (!this.$store.state[symbols.state.doctorName]) {
      const userId = 0
      this.$store.dispatch(symbols.actions.getDoctorData, { userId: userId })
    }
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()
      this.$router.push({ name: 'screener-doctor' })
    }
  }
}
