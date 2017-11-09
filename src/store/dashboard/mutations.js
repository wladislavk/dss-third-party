import symbols from '../../symbols'

export default {
  [symbols.mutations.documentCategories] (state, data) {
    state[symbols.state.documentCategories] = data
  },
  [symbols.mutations.memos] (state, data) {
    state[symbols.state.memos] = data
  },
  [symbols.mutations.deviceGuideSettingOptions] (state, data) {
    state[symbols.state.deviceGuideSettingOptions] = data
  },
  [symbols.mutations.updateGuideSetting] (state, data) {
    let foundGuideSetting = state[symbols.state.deviceGuideSettingOptions].find(el => el.id === data.id)

    if (foundGuideSetting) {
      for (let field in data.values) {
        foundGuideSetting[field] = data.values[field]
      }
    }
  }
}
