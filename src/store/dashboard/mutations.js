import symbols from '../../symbols'

export default {
  [symbols.mutations.documentCategories] (state, data) {
    const categories = []
    for (let element of data) {
      categories.push({
        id: element.categoryid,
        name: element.name
      })
    }
    state[symbols.state.documentCategories] = categories
  },
  [symbols.mutations.memos] (state, data) {
    state[symbols.state.memos] = data
  }
}
