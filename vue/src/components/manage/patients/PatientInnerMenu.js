import symbols from '../../../symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    }
  },
  computed: {
    longPatientName () {
      if (this.patientName.length > 20) {
        return true
      }
      return false
    },
    displayNotes () {
      const displayAlert = this.$store.state.patients[symbols.state.displayAlert]
      if (displayAlert && this.alertText) {
        return true
      }
      return false
    },
    displayMed () {
      const allergen = this.$store.state.patients[symbols.state.allergen]
      const premedCheck = this.$store.state.patients[symbols.state.premedCheck]
      if (premedCheck === 1) {
        return true
      }
      if (allergen) {
        return true
      }
      return false
    },
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    },
    medicare () {
      return this.$store.state.patients[symbols.state.medicare]
    },
    alertText () {
      return this.$store.state.patients[symbols.state.headerAlertText]
    },
    headerTitle () {
      return this.$store.state.patients[symbols.state.headerTitle]
    }
  }
}
