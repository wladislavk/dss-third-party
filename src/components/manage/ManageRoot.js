import ModalRootComponent from './modal/ModalRoot.vue'
import symbols from '../../symbols'

export default {
  components: {
    modalRoot: ModalRootComponent
  },
  created () {
    document.body.className += ' main-template'
    this.$store.dispatch(symbols.actions.userInfo)
    this.$store.dispatch(symbols.actions.courseStaff)
  },
  watch: {
    '$route.query.pid': function () {
      const patientId = this.$route.query.pid || 0
      this.$store.dispatch(symbols.actions.patientData, patientId)
      this.$store.dispatch(symbols.actions.healthHistoryForPatient, patientId)
      this.$store.dispatch(symbols.actions.incompleteHomeSleepTests, patientId)
    }
  }
}
