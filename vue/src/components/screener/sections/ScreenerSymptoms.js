import symbols from '../../../symbols'
import helpers from '../../../services/helpers'
import HealthAssessmentComponent from '../common/HealthAssessment.vue'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      symptoms: this.$store.state.screener[symbols.state.symptoms],
      storedSymptoms: {},
      errors: []
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
      this.storedSymptoms[event.target.name] = event.target.value
    },
    onSubmit () {
      this.hasError = false
      this.nextDisabled = true

      for (let symptom of this.symptoms) {
        if (this.storedSymptoms.hasOwnProperty(symptom.name)) {
          this.errors = helpers.arrayRemove(this.errors, symptom.label)
        } else {
          this.errors = helpers.arrayAddUnique(this.errors, symptom.label)
          this.hasError = true
        }
      }

      if (this.hasError) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.symptoms, this.storedSymptoms)

      this.$router.push({ name: 'screener-diagnoses' })
    }
  }
}
