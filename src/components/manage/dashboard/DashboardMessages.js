import symbols from '../../../symbols'

export default {
  data () {
    return {
      memos: this.$store.state.dashboard[symbols.state.memos]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.memos)
  }
}
