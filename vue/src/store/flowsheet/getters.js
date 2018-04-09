import symbols from '../../symbols'

export default {
  [symbols.getters.trackerStepsFirst] (state) {
    const firstSteps = []
    for (let step of state[symbols.state.trackerSteps]) {
      if (step.section === 1) {
        firstSteps.push(step)
      }
    }
    return firstSteps
  },

  [symbols.getters.trackerStepsSecond] (state) {
    const secondSteps = []
    for (let step of state[symbols.state.trackerSteps]) {
      if (step.section === 2) {
        secondSteps.push(step)
      }
    }
    return secondSteps
  },

  [symbols.getters.shouldPreventFlowsheetModal] (state) {
    return !!state[symbols.state.existingDeviceId]
  }
}
