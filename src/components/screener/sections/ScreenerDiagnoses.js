import symbols from '../../../symbols'

export default {
  data () {
    return {
      nextDisabled: false,
      communicationError: false
    }
  },
  created () {
    if (!this.$store.state[symbols.epworthProps.length]) {
      this.$store.dispatch(symbols.actions.setEpworthProps)
    }
  },
  computed: {
    conditions () {
      return this.$store.getters[symbols.getters.diagnosisCoMorbidity]
    }
  },
  methods: {
    onSubmit (e) {
      e.preventDefault()

      this.nextDisabled = true

      const contactProperties = this.$store.state[symbols.state.contactProperties]

      const symptoms = this.$store.state[symbols.state.symptoms]

      for (let symptom of symptoms) {
        symptom.selector = $('input[name=' + symptom.name + ']:checked')
      }

      const epworthProps = this.$store.state[symbols.state.epworthProps]

      const screenerData = {
        docid: $('#docid').val(),
        userid: $('#userid').val(),
        first_name: contactProperties.firstName,
        last_name: contactProperties.lastName,
        phone: contactProperties.phone
      }

      for (let epworth of epworthProps) {
        const propertyName = 'epworth_' + epworth.id
        screenerData[propertyName] = $('#' + propertyName).val()
      }

      for (let symptom of symptoms) {
        screenerData[symptom.name] = symptom.selector.val()
      }

      for (let i = 1; i <= 5; i++) {
        let propertyName = 'snore_' + i
        screenerData[propertyName] = $('#' + propertyName).val()
      }

      const coMorbidityData = this.$store.state[symbols.state.coMorbidityData]
      for (let coMorbidity of coMorbidityData) {
        screenerData[coMorbidity.name] = 0
        if ($('input[name="' + coMorbidity.name + '"]:checked').val()) {
          screenerData[coMorbidity.name] = coMorbidity.weight
        }
      }

      this.$store.dispatch(symbols.actions.submitScreener, screenerData).then(
        (response) => {
          this.$store.dispatch(symbols.actions.parseScreenerResults, response)
          this.$router.push({ name: 'screener-results' })
        },
        () => {
          this.nextDisabled = false
          alert('There was an error communicating with the server, please try again in a few minutes')
        }
      )
    },

    _updateHstDiv (contactProperties) {
      $('#hst_first_name').val(contactProperties.firstName)
      $('#hst_last_name').val(contactProperties.lastName)
      $('#hst_phone').val(contactProperties.phone)
    }
  }
}
