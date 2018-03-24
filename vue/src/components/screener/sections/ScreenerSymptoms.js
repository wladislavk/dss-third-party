import symbols from '../../../symbols'
import helpers from '../../../services/helpers'
import SectionHeaderComponent from '../common/SectionHeader.vue'
import SymptomButtonsComponent from './SymptomButtons.vue'
import ScreenerNavigationComponent from '../common/ScreenerNavigation.vue'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      symptoms: this.$store.state.screener[symbols.state.symptoms],
      errors: []
    }
  },
  components: {
    sectionHeader: SectionHeaderComponent,
    symptomButtons: SymptomButtonsComponent,
    screenerNavigation: ScreenerNavigationComponent
  },
  methods: {
    onSubmit () {
      this.hasError = false

      const storedSymptoms = this.$store.state.screener[symbols.state.storedSymptoms]
      for (let symptom of this.symptoms) {
        if (storedSymptoms.hasOwnProperty(symptom.name)) {
          this.errors = helpers.arrayRemove(this.errors, symptom.short)
          symptom.error = false
        } else {
          this.errors = helpers.arrayAddUnique(this.errors, symptom.short)
          this.hasError = true
          symptom.error = true
        }
      }

      if (this.hasError) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.symptoms)
      this.$router.push({ name: 'screener-diagnoses' })
    }
  }
}
