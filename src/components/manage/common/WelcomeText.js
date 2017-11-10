import symbols from '../../../symbols'

export default {
  data () {
    return {
      username: this.$store.state.main[symbols.state.userInfo].username
    }
  }
}
