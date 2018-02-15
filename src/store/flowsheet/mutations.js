import symbols from '../../symbols'

export default {
  [symbols.mutations.getAppointmentSummary] (state, element) {
    let newSummary = {
      id: parseInt(element.id),
      segmentId: parseInt(element.segmentid),
      deviceId: parseInt(element.device_id),
      description: element.description,
      type: '',
      studyType: '',
      delayReason: '',
      nonComplianceReason: '',
      dateCompleted: new Date(element.date_completed)
    }
    if (element.study_type) {
      newSummary.type = 'study_type'
      newSummary.studyType = element.study_type
    }
    if (element.delay_reason) {
      newSummary.type = 'delay_reason'
      newSummary.delayReason = element.delay_reason
    }
    if (element.noncomp_reason) {
      newSummary.type = 'noncomp_reason'
      newSummary.nonComplianceReason = element.noncomp_reason
    }
    state[symbols.state.appointmentSummaries].push(newSummary)
  },

  [symbols.mutations.addAppointmentSummary] (state, data) {
    // @todo: transform data into new summary
    const newSummary = data
    state[symbols.state.appointmentSummaries].push(newSummary)
  },

  [symbols.mutations.updateAppointmentSummary] (state, {id, data}) {
    for (let summary of state[symbols.state.appointmentSummaries]) {
      if (summary.id === id) {
        // @todo: transform data into new summary
        summary = data
      }
    }
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

  [symbols.mutations.letters] (state, data) {
    const letters = []
    for (let element of data) {
      let newLetter = {
        infoId: parseInt(element.info_id),
        toPatient: !!element.topatient,
        mdList: element.md_list,
        mdReferralList: element.md_referral_list,
        status: parseInt(element.status)
      }
      letters.push(newLetter)
    }
    state[symbols.state.letters] = letters
  },

  [symbols.mutations.stepsByRank] (state, data) {
    const steps = []
    for (let element of data) {
      let newStep = {
        id: parseInt(element.id),
        name: element.name,
        completed: !!element.completed
      }
      steps.push(newStep)
    }
    state[symbols.state.trackerSteps] = steps
  },

  [symbols.mutations.hasScheduledAppointment] (state, data) {
    state[symbols.state.hasScheduledAppointment] = data
  }
}
