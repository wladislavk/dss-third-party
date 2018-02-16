import symbols from '../../symbols'

export default {
  [symbols.getters.firstDevice] (state) {
    let firstDevice = ''
    for (let device of state[symbols.state.devices]) {
      firstDevice = device.dentaldevice
    }
    return firstDevice
  },

  [symbols.getters.hasScheduledAppointment] (state) {
    const appointmentSummaries = state[symbols.state.appointmentSummaries]
    for (let summary of appointmentSummaries) {
      if (summary.appointment_type === 0 && summary.segmentid !== 0 && summary.date_scheduled) {
        return true
      }
    }
    return false
  }
}
