import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'
import HealthAssessmentComponent from '../common/HealthAssessment.vue'
import SymptomButtonsComponent from './SymptomButtons.vue'

export default {
  data () {
    return {
      nextDisabled: false,
      communicationError: false,
      cpap: this.$store.state.screener[symbols.state.cpap],
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
    healthAssessment: HealthAssessmentComponent,
    symptomButtons: SymptomButtonsComponent
  },
  methods: {
    updateValue (event) {
      this.storedConditions[event.target.name] = false
      if (event.target.checked) {
        this.storedConditions[event.target.name] = true
      }
    },
    onSubmit () {
      this.nextDisabled = true

      this.$store.commit(symbols.mutations.coMorbidity, this.storedConditions)
      this.$store.commit(symbols.mutations.cpap)

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
