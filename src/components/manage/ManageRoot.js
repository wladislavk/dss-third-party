import ModalRootComponent from './modal/ModalRoot.vue'
import symbols from '../../symbols'

export default {
  components: {
    modalRoot: ModalRootComponent
  },
  created () {
    document.body.className += ' main-template'
    // @todo: this generates too much overhead, need to be replaced by fewer calls
    this.$store.dispatch(symbols.actions.userInfo)
    this.$store.dispatch(symbols.actions.courseStaff)
    this.$store.dispatch(symbols.actions.usePaymentReports)
    this.$store.dispatch(symbols.actions.pendingClaimsNumber)
    this.$store.dispatch(symbols.actions.patientContactsNumber)
    this.$store.dispatch(symbols.actions.unmailedLettersNumber)
    this.$store.dispatch(symbols.actions.unmailedClaimsNumber)
    this.$store.dispatch(symbols.actions.rejectedClaimsNumber)
    this.$store.dispatch(symbols.actions.preauthNumber)
    this.$store.dispatch(symbols.actions.pendingPreauthNumber)
    this.$store.dispatch(symbols.actions.rejectedPreauthNumber)
    this.$store.dispatch(symbols.actions.supportTicketsNumber)
    this.$store.dispatch(symbols.actions.faxAlertsNumber)
    this.$store.dispatch(symbols.actions.unsignedNotesNumber)
    this.$store.dispatch(symbols.actions.emailBouncesNumber)
    this.$store.dispatch(symbols.actions.pendingDuplicatesNumber)
    this.$store.dispatch(symbols.actions.patientChangesNumber)
    this.$store.dispatch(symbols.actions.hstNumber)
    this.$store.dispatch(symbols.actions.requestedHstNumber)
    this.$store.dispatch(symbols.actions.rejectedHstNumber)
    this.$store.dispatch(symbols.actions.patientInsurancesNumber)
    this.$store.dispatch(symbols.actions.pendingLettersNumber)
  }
}
