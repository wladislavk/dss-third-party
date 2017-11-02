import symbols from '../../symbols'
import logoutTimerMixin from '../../modules/logout/LogoutTimerMixin'

export default {
  mixins: [logoutTimerMixin],
  created () {
    this.setLogoutTimer()
  },
  methods: {
    logout () {
      this.$store.dispatch(symbols.actions.logout)
      this.$router.push({ name: 'main-login' })
    }
  }
}
