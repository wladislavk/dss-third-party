import ModalRootComponent from './modal/ModalRoot.vue'
import symbols from '../../symbols'

export default {
  components: {
    modalRoot: ModalRootComponent
  },
  created () {
    document.body.className += ' main-template'
  },
  mounted () {
    if (this.$route.query.hasOwnProperty('token')) {
      this.$store.dispatch(symbols.actions.dualAppLogin, this.$route.query.token).then(() => {
        this.$router.push({ name: 'dashboard' })
      }).catch(() => {
        this.$router.push({ name: 'main-login' })
      })
      return
    }
    if (!this.$store.state.main[symbols.state.mainToken]) {
      this.$router.push({ name: 'main-login' })
      return
    }
    this.$router.push({ name: 'dashboard' })
  },
  methods: {
    hideSearchHints () {
      this.$store.commit(symbols.mutations.hideSearchHints)
    }
  }
}
