import symbols from '../../symbols'

export default {
  [symbols.mutations.documentCategories] (state, data) {
    state[symbols.state.documentCategories] = data
  },
  [symbols.mutations.memos] (state, data) {
    state[symbols.state.memos] = data
  }
}
