import symbols from '../../symbols'
import HeaderComponent from './common/CommonHeader.vue'
import FooterComponent from './common/CommonFooter.vue'

export default {
  components: {
    commonHeader: HeaderComponent,
    commonFooter: FooterComponent
  },
  mounted () {
    if (!this.$store.state.main[symbols.state.mainToken]) {
      this.$router.push({ name: 'main-login' })
    }
  }
}
