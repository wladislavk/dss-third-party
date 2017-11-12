import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants/main'

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
      this.removeCookie('edxloggin')
      this.removeCookie('sessionid')
    },
    removeCookie (name) {
      document.cookie = encodeURIComponent(name) + '=; domain=dentalsleepsolutions.com; path=/; max-age=0; expires=Mon, 03 Jul 2006 21:44:38 GMT'
    }
  }
}
