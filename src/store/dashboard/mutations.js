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
    const options = []
    for (let element of data) {
      const newOption = {
        id: parseInt(element.id),
        name: element.name,
        labels: element.labels,
        checkedOption: 0,
        checked: false
      }
      options.push(newOption)
    }
    state[symbols.state.deviceGuideSettingOptions] = options
  },

  [symbols.mutations.resetDeviceGuideSettingOptions] (state) {
    const options = []
    for (let element of state[symbols.state.deviceGuideSettingOptions]) {
      element.checkedOption = 0
      element.checked = false
      options.push(element)
    }
    state[symbols.state.deviceGuideSettingOptions] = options
  },

  [symbols.mutations.checkGuideSetting] (state, { id, isChecked }) {
    for (let setting of state[symbols.state.deviceGuideSettingOptions]) {
      if (id === setting.id) {
        setting.checked = isChecked
        return
      }
    }
  },

  [symbols.mutations.moveGuideSettingSlider] (state, { id, value }) {
    for (let setting of state[symbols.state.deviceGuideSettingOptions]) {
      if (id === setting.id) {
        setting.checkedOption = value
        return
      }
    }
  }
}
