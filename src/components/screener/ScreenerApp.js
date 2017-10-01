import alerter from '../../services/alerter'
import symbols from '../../symbols'
import FancyboxScreenerComponent from './common/FancyboxScreener.vue'

export default {
  data: function () {
    return {
      currentYear: (new Date()).getFullYear(),
    }
  },
  computed: {
    showReset: function () {
      return this.$route.name !== 'screener-intro'
    },
    showFancybox: function () {
      return this.$store.state.screener[symbols.state.showFancybox]
    }
  },
  components: {
    'fancybox-screener': FancyboxScreenerComponent
  },
  mounted () {
    if (!this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' })
    }
  },
  methods: {
    onLogout () {
      if (alerter.isConfirmed('Are you sure you want to logout?')) {
        this.$store.commit(symbols.mutations.screenerToken, '')
        this.$router.push({ name: 'screener-login' })
      }
    },
    onReset () {
      if (alerter.isConfirmed('Are you sure? All current progress will be lost.')) {
        this.$store.commit(symbols.mutations.restoreInitialScreenerKeepSession)
        this.$router.push({ name: 'screener-intro' })
      }
    }
  }
}
