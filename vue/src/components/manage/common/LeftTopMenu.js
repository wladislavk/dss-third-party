import symbols from '../../../symbols'
import CookieManager from '../../../services/CookieManager'

export default {
  computed: {
    showOnlineCEAndSnoozleHelp: function () {
      return this.$store.getters[symbols.getters.shouldShowGetCE]
    }
  },
  methods: {
    removeCECookies () {
      CookieManager.removeCookie('edxloggin')
      CookieManager.removeCookie('sessionid')
    }
  }
}
