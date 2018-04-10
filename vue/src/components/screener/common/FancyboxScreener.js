import symbols from '../../../symbols'
import ScreenerNavigationComponent from './ScreenerNavigation.vue'

export default {
  components: {
    screenerNavigation: ScreenerNavigationComponent
  },
  methods: {
    closeFancybox () {
      this.$store.commit(symbols.mutations.hideFancybox)
    },
    closeAndReset () {
      this.$store.commit(symbols.mutations.restoreInitialScreenerKeepSession)
      this.$store.commit(symbols.mutations.hideFancybox)
      this.$router.push({ name: 'screener-intro' })
    }
  }
}
