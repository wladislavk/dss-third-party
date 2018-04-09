import symbols from '../../symbols'
import { INITIAL_FUTURE_APPOINTMENT } from '../../constants/chart'

export default {
  [symbols.state.appointmentSummaries]: [],
  [symbols.state.devices]: [],
  [symbols.state.appointmentSummaryLetters]: [],
  [symbols.state.trackerSteps]: [],
  [symbols.state.trackerStepsNext]: [],
  [symbols.state.currentAppointmentSummary]: {
    id: 0,
    segmentId: 0
  },
  [symbols.state.futureAppointment]: INITIAL_FUTURE_APPOINTMENT,
  [symbols.state.finalTrackerRank]: 0,
  [symbols.state.lastTrackerSegment]: 0,
  [symbols.state.finalTrackerSegment]: 0,
  [symbols.state.patientTrackerNotes]: '',
  [symbols.state.existingDeviceId]: 0
}
