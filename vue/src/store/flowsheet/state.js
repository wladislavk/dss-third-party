import symbols from '../../symbols'

export default {
  [symbols.state.appointmentSummaries]: [],
  [symbols.state.devices]: [],
  [symbols.state.letters]: [],
  [symbols.state.trackerSteps]: [],
  [symbols.state.trackerStepsNext]: [],
  [symbols.state.currentAppointmentSummary]: {
    id: 0,
    segmentId: 0
  },
  [symbols.state.futureAppointment]: {
    id: 0,
    segmentId: 0,
    dateScheduled: null,
    dateUntil: null
  },
  [symbols.state.finalTrackerRank]: 0,
  [symbols.state.lastTrackerSegment]: 0,
  [symbols.state.finalTrackerSegment]: 0,
  [symbols.state.patientTrackerNotes]: ''
}
