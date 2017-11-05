import symbols from '../../../symbols'

export default {
  computed: {
    memos () {
      return this.$store.state.dashboard[symbols.state.memos]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.memos)
  }
}
