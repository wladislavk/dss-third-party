import symbols from '../../symbols'
import FancyboxScreenerComponent from './common/FancyboxScreener.vue'
import ScreenerFooterComponent from './common/ScreenerFooter.vue'
import ScreenerMenuComponent from './common/ScreenerMenu.vue'

export default {
  computed: {
    showFancybox: function () {
      return this.$store.state.screener[symbols.state.showFancybox]
    }
  },
  components: {
    screenerFooter: ScreenerFooterComponent,
    screenerMenu: ScreenerMenuComponent,
    fancyboxScreener: FancyboxScreenerComponent
  },
  mounted () {
    if (!this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({ name: 'screener-login' })
    }
  }
}
