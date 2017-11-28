import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants/main'
import CookieManager from '../../../services/CookieManager'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL
    }
  },
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
