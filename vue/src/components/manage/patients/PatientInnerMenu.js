import symbols from '../../../symbols'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      legacyUrl: ProcessWrapper.getLegacyRoot(),
      medicare: this.$store.state.main[symbols.state.medicare],
      alertText: this.$store.state.main[symbols.state.headerAlertText],
      headerTitle: this.$store.state.main[symbols.state.headerTitle],
      patientName: this.$store.state.main[symbols.state.patientName]
    }
  },
  computed: {
    longPatientFont () {
      const longFontSize = '14px'
      if (this.patientName.length > 20) {
        return longFontSize
      }
      return ''
    },
    displayNotes () {
      const displayAlert = this.$store.state.main[symbols.state.displayAlert]
      if (displayAlert && this.alertText) {
        return true
      }
      return false
    },
    displayMed () {
      const allergen = this.$store.state.main[symbols.state.allergen]
      const premedCheck = this.$store.state.main[symbols.state.premedCheck]
      if (premedCheck === 1) {
        return true
      }
      if (allergen === 1) {
        return true
      }
      return false
    }
  }
}
