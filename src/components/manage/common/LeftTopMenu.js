import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL
    }
  },
  computed: {
    showOnlineCEAndSnoozleHelp: function () {
      if (
        this.$store.getters[symbols.getters.isUserDoctor] &&
        this.$store.state.main[symbols.state.userInfo].useCourse === 1
      ) {
        return true
      }
      if (
        !this.$store.getters[symbols.getters.isUserDoctor] &&
        this.$store.state.main[symbols.state.courseStaff].useCourse === 1 &&
        this.$store.state.main[symbols.state.courseStaff].useCourseStaff === 1
      ) {
        return true
      }
      return false
    }
  },
  methods: {
    // @todo: check why these are needed
    /*
    removeCECookies () {
      this.removeCookie('edxloggin')
      this.removeCookie('sessionid')
    },
    removeCookie (name) {
      document.cookie = encodeURIComponent(name) + '=; domain=dentalsleepsolutions.com; path=/; max-age=0; expires=Mon, 03 Jul 2006 21:44:38 GMT'
    }
    */
  }
}
