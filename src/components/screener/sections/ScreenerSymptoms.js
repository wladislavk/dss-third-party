import $ from 'jquery'
import 'jquery-ui/ui/widgets/button'
import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      symptoms: this.$store.state.screener[symbols.state.symptoms]
    }
  },
  created () {
    $(function () {
      $('.buttonset').buttonset()
    })
  },
  methods: {
    updateValue (event) {
      for (let symptom of this.symptoms) {
        if (event.target.name === symptom.name) {
          symptom.selected = event.target.value
          return
        }
      }
    },
    onSubmit () {
      this.nextDisabled = true

      for (let symptom of this.symptoms) {
        if (symptom.selected === false) {
          symptom.error = true
          this.hasError = true
        } else {
          symptom.error = false
        }
      }

      if (this.hasError) {
        this.nextDisabled = false
        return
      }

      this.$store.commit(symbols.mutations.symptoms, this.symptoms)

      this.$router.push({ name: 'screener-diagnoses' })
    }
  }
}
