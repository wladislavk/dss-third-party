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
  },
  [symbols.mutations.deviceGuideResults] (state, data) {
    state[symbols.state.deviceGuideResults] = data
  },
  [symbols.mutations.deviceGuideSettingOptions] (state, data) {
    state[symbols.state.deviceGuideSettingOptions] = data
  },
  [symbols.mutations.resetDeviceGuideSettingOptions] (state) {
    state[symbols.state.deviceGuideSettingOptions].forEach(el => {
      el.checkedOption = 0

      if (el.hasOwnProperty('impression')) {
        el.impression = 0
        return
      }

      el.checked = 0
    })
  },
  [symbols.mutations.updateGuideSetting] (state, data) {
    let foundGuideSetting = state[symbols.state.deviceGuideSettingOptions].find(el => el.id === data.id)

    if (!foundGuideSetting) {
      return
    }

    for (let field in data.values) {
      if (foundGuideSetting.hasOwnProperty(field)) {
        foundGuideSetting[field] = data.values[field]
      }
    }
  }
}
