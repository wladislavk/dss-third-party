import symbols from '../../../symbols'

export default {
  computed: {
    username () {
      return this.$store.state.main[symbols.state.userInfo].username
    }
  }
}
