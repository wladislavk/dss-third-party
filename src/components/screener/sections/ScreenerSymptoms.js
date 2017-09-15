import $ from 'jquery'

export default {
  data: function () {
    return {
      nextDisabled: false,
      hasError: false
    }
  },
  created () {
    $(function () {
      $('.buttonset').buttonset()
    })
    this.symptoms = []
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      for (let symptom of this.symptoms) {
        if (symptom.checked === null) {
          symptom.error = true
          this.nextDisabled = false
          this.hasError = true
        } else {
          symptom.error = false
        }
      }

      this.$router.push({ name: 'screener-diagnoses' })
    }
  }
}
