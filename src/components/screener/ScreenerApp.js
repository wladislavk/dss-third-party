import $ from 'jquery'
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
    isIntro: function () {
      return this.$router.currentRoute.name === 'screener-intro'
    }
  },
  created () {
    if (!this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' })
      return
    }
    $.mask.definitions['~'] = '[2-9]'
    $('.extphonemask').mask('(~99) 999-9999? ext99999')
    $('.phonemask').mask('(~99) 999-9999')
    $('.ssnmask').mask('999-99-9999')
    $('.datemask').mask('99/99/9999')
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
