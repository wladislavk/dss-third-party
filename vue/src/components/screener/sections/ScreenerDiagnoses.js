import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'
import HealthAssessmentComponent from '../common/HealthAssessment.vue'

export default {
  data () {
    return {
      nextDisabled: false,
      communicationError: false,
      cpap: this.$store.state.screener[symbols.state.cpap],
      storedCpap: 0,
      conditions: this.$store.state.screener[symbols.state.coMorbidityData],
      storedConditions: {}
    }
  },
  mounted () {
    window.$(function () {
      window.$('.buttonset').buttonset()
    })
  },
  components: {
    'health-assessment': HealthAssessmentComponent
  },
  methods: {
    updateValue (event) {
      this.storedConditions[event.target.name] = false
      if (event.target.checked) {
        this.storedConditions[event.target.name] = true
      }
    },
    updateCpap (event) {
      this.storedCpap = parseInt(event.target.value)
    },
    onSubmit () {
      this.nextDisabled = true

      this.$store.commit(symbols.mutations.coMorbidity, this.storedConditions)
      this.$store.commit(symbols.mutations.cpap, this.storedCpap)

      this.$store.dispatch(symbols.actions.submitScreener).then((response) => {
        const data = response.data.data
        this.$store.dispatch(symbols.actions.parseScreenerResults, data)
        this.$router.push({ name: 'screener-results' })
      }).catch(() => {
        this.nextDisabled = false
        const alertText = 'There was an error communicating with the server, please try again in a few minutes'
        Alerter.alert(alertText)
      })
    }
  }
}
