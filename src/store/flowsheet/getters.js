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
  },

  [symbols.getters.firstDevice] (state) {
    let firstDevice = ''
    for (let device of state[symbols.state.devices]) {
      firstDevice = device.dentaldevice
    }
    return firstDevice
  }
}
