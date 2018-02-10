import Alerter from '../../../services/Alerter'
import symbols from '../../../symbols'

export default {
  computed: {
    showReset: function () {
      return this.$route.name !== 'screener-intro'
    }
  },
  methods: {
    onLogout () {
      const logoutAlert = 'Are you sure you want to logout?'
      if (Alerter.isConfirmed(logoutAlert)) {
        this.$store.commit(symbols.mutations.restoreInitialScreener)
        this.$router.push({ name: 'screener-login' })
      }
    },
    onReset () {
      const resetAlert = 'Are you sure? All current progress will be lost.'
      if (Alerter.isConfirmed(resetAlert)) {
        this.$store.commit(symbols.mutations.restoreInitialScreenerKeepSession)
        this.$router.push({ name: 'screener-intro' })
      }
    }
  }
}
