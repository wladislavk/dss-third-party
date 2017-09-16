import $ from 'jquery'
import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false,
      symptoms: []
    }
  },
  created () {
    $(function () {
      $('.buttonset').buttonset()
    })
    this.symptoms = this.$store.state[symbols.state.symptoms]
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      for (let symptom of this.symptoms) {
        if (symptom.selected === false) {
          symptom.error = true
          this.nextDisabled = false
          this.hasError = true
        } else {
          symptom.error = false
        }
      }

      if (this.hasError) {
        return
      }

      this.$store.commit(symbols.mutations.symptoms, this.symptoms)

      this.$router.push({ name: 'screener-diagnoses' })
    }
  }
}
