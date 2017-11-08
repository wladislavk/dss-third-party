import { LEGACY_URL } from '../../../constants/main'
import symbols from '../../../symbols'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      medicare: this.$store.state.main[symbols.state.medicare],
      alertText: this.$store.state.main[symbols.state.headerAlertText],
      headerTitle: this.$store.state.main[symbols.state.headerTitle],
      patientName: this.$store.state.main[symbols.state.patientName],
      patientId: this.$store.state.main[symbols.state.patientId]
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
