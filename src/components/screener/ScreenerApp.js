import alerter from '../../services/alerter'
import symbols from '../../symbols'
import HealthAssessment from './common/HealthAssessment.vue'

export default {
  data: function () {
    return {
      currentYear: (new Date()).getFullYear()
    }
  },
  computed: {
    showReset: function () {
      return this.$route.name !== 'screener-intro'
    }
  },
  mounted () {
    if (!this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' })
    }
    // @todo: remake for Vue
    /*
    $.mask.definitions['~'] = '[2-9]'
    $('.extphonemask').mask('(~99) 999-9999? ext99999')
    $('.phonemask').mask('(~99) 999-9999')
    $('.ssnmask').mask('999-99-9999')
    $('.datemask').mask('99/99/9999')
    */
  },
  components: {
    'health-assessment': HealthAssessment
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
