import symbols from '../../symbols'

export default {
  [symbols.mutations.appointmentSummaries] (state, data) {
    const appointmentSummaries = []
    for (let element of data) {
      let newSummary = {
        id: parseInt(element.id),
        segmentId: parseInt(element.segmentid),
        deviceId: parseInt(element.device_id),
        description: element.description,
        studyType: element.study_type,
        delayReason: element.delay_reason,
        nonComplianceReason: element.noncomp_reason,
        dateCompleted: new Date(element.date_completed)
      }
      appointmentSummaries.push(newSummary)
    }
    state[symbols.state.appointmentSummaries] = appointmentSummaries
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
  }
}
