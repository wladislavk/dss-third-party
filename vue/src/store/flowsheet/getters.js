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
  },

  [symbols.getters.appointmentLetterCount] (state) {
    const letters = state[symbols.state.appointmentSummaryLetters]
    const results = {}
    for (let letter of letters) {
      results[letter.infoId] = 0
    }
    for (let letter of letters) {
      let toPatient = 0
      if (letter.toPatient) {
        toPatient = 1
      }
      const mdNumber = letter.mdList.length
      const mdReferralNumber = letter.mdReferralList.length
      results[letter.infoId] += toPatient + mdNumber + mdReferralNumber
    }
    return results
  },

  [symbols.getters.appointmentLettersSent] (state) {
    const letters = state[symbols.state.appointmentSummaryLetters]
    const results = {}
    for (let letter of letters) {
      results[letter.infoId] = false
    }
    for (let letter of letters) {
      if (letter.status === 1) {
        results[letter.infoId] = true
      }
    }
    return results
  },

  [symbols.getters.hasScheduledAppointment] (state) {
    const futureAppointment = state[symbols.state.futureAppointment]
    if (futureAppointment.segmentId && futureAppointment.dateScheduled) {
      return true
    }
    return false
  }
}
