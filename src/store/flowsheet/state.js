import symbols from '../../symbols'

export default {
  [symbols.state.appointmentSummaries]: [],
  [symbols.state.devices]: [],
  [symbols.state.letters]: [],
  [symbols.state.trackerSteps]: [],
  [symbols.state.hasScheduledAppointment]: false,
  [symbols.state.currentAppointmentSummary]: {
    id: 0,
    segmentId: 0
  }
}
