import symbols from '../../symbols'

export default {
  [symbols.mutations.getAppointmentSummary] (state, element) {
    let newSummary = {
      id: parseInt(element.id),
      segmentId: parseInt(element.segmentid),
      deviceId: parseInt(element.device_id),
      description: element.description,
      studyType: '',
      delayReason: '',
      nonComplianceReason: '',
      dateCompleted: null,
      dateScheduled: null
    }
    if (element.study_type) {
      newSummary.studyType = element.study_type
    }
    if (element.delay_reason) {
      newSummary.delayReason = element.delay_reason
    }
    if (element.noncomp_reason) {
      newSummary.nonComplianceReason = element.noncomp_reason
    }
    if (element.date_completed) {
      newSummary.dateCompleted = new Date(element.date_completed)
    }
    if (element.date_scheduled) {
      newSummary.dateScheduled = new Date(element.date_scheduled)
    }
    state[symbols.state.appointmentSummaries].push(newSummary)
  },

  [symbols.mutations.clearAppointmentSummary] (state) {
    state[symbols.state.appointmentSummaries] = []
  },

  [symbols.mutations.removeAppointmentSummary] (state, id) {
    const newArray = []
    for (let summary of state[symbols.state.appointmentSummaries]) {
      if (summary.id !== id) {
        newArray.push(summary)
      }
    }
    state[symbols.state.appointmentSummaries] = newArray
  },

  [symbols.mutations.devices] (state, data) {
    const devices = []
    for (let element of data) {
      let newDevice = {
        id: parseInt(element.deviceid),
        device: element.device
      }
      devices.push(newDevice)
    }
    state[symbols.state.devices] = devices
  },

  [symbols.mutations.appointmentSummaryLetters] (state, data) {
    const letters = []
    for (let element of data) {
      let newLetter = {
        id: parseInt(element.letterid),
        infoId: parseInt(element.info_id),
        toPatient: !!(+element.topatient),
        mdList: element.md_list,
        mdReferralList: element.md_referral_list,
        status: parseInt(element.status)
      }
      letters.push(newLetter)
    }
    state[symbols.state.appointmentSummaryLetters] = letters
  },

  [symbols.mutations.finalTrackerRank] (state, rank) {
    state[symbols.state.finalTrackerRank] = rank
  },

  [symbols.mutations.finalTrackerSegment] (state, data) {
    state[symbols.state.finalTrackerSegment] = data
  },

  [symbols.mutations.lastTrackerSegment] (state, data) {
    state[symbols.state.lastTrackerSegment] = data
  },

  [symbols.mutations.trackerSteps] (state, {data, section}) {
    const steps = []
    for (let element of data) {
      let newStep = {
        id: parseInt(element.id),
        name: element.name,
        rank: parseInt(element.rank),
        section: section
      }
      steps.push(newStep)
    }
    state[symbols.state.trackerSteps] = state[symbols.state.trackerSteps].concat(steps)
  },

  [symbols.mutations.clearTrackerSteps] (state) {
    state[symbols.state.trackerSteps] = []
  },

  [symbols.mutations.trackerStepsNext] (state, data) {
    state[symbols.state.trackerStepsNext] = data
  },

  [symbols.mutations.patientTrackerNotes] (state, data) {
    state[symbols.state.patientTrackerNotes] = data
  },

  [symbols.mutations.futureAppointment] (state, data) {
    const transformed = {
      id: parseInt(data.id),
      segmentId: parseInt(data.segmentid),
      dateScheduled: null
    }
    if (data.date_scheduled) {
      transformed.dateScheduled = new Date(data.date_scheduled)
    }
    state[symbols.state.futureAppointment] = transformed
  },

  [symbols.mutations.setExistingDevice] (state, data) {
    state[symbols.state.existingDeviceId] = data
  }
}
