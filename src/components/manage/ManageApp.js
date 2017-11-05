import symbols from '../../symbols'
import HeaderComponent from './common/CommonHeader.vue'

export default {
  components: {
    headerComponent: HeaderComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.userInfo).then(() => {
      this.$store.dispatch(symbols.actions.docInfo)
    })
    this.$store.dispatch(symbols.actions.courseStaff)
  },
  mounted () {
    if (!this.$store.state.main[symbols.state.mainToken]) {
      this.$router.push({ name: 'main-login' })
    }
  },
}
