import symbols from '../../symbols'

export default {
  [symbols.getters.trackerStepsFirst] (state) {
    const steps = []
    for (let element of state[symbols.state.trackerSteps]) {
      if (element.sectionId === 1) {
        steps.push(element)
      }
    }
    return steps
  },
  [symbols.getters.trackerStepsSecond] (state) {
    const steps = []
    for (let element of state[symbols.state.trackerSteps]) {
      if (element.sectionId === 2) {
        steps.push(element)
      }
    }
    return steps
  },
  [symbols.getters.trackerStepSchedule] () {
    return {}
  }
}
