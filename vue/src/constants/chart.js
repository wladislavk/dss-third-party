import symbols from 'src/symbols'

export const INITIAL_CONTACT_ID = 1
export const CONSULT_ID = 2
export const TITRATION_STUDY_ID = 3
export const IMPRESSIONS_ID = 4
export const DELAYING_ID = 5
export const REFUSED_ID = 6
export const DEVICE_DELIVERY_ID = 7
export const FOLLOW_UP_ID = 8
export const NON_COMPLIANT_ID = 9
export const TREATMENT_COMPLETE_ID = 11
export const ANNUAL_RECALL_ID = 12
export const TERMINATION_ID = 13
export const NOT_CANDIDATE_ID = 14
export const BASELINE_TEST_ID = 15

export const APPOINTMENT_SUMMARY_SEGMENTS = [
  {
    number: INITIAL_CONTACT_ID,
    text: 'Initial Contact',
    modal: null,
    action: null
  },
  {
    number: CONSULT_ID,
    text: 'Consult',
    modal: null,
    action: null
  },
  {
    number: TITRATION_STUDY_ID,
    text: 'Titration Sleep Study',
    modal: symbols.modals.flowsheetStudyType,
    action: null
  },
  {
    number: IMPRESSIONS_ID,
    text: 'Impressions',
    modal: symbols.modals.impressionDevice,
    action: symbols.actions.setExistingDevice
  },
  {
    number: DELAYING_ID,
    text: 'Delaying Tx / Waiting',
    modal: symbols.modals.flowsheetDelayTreatment,
    action: null
  },
  {
    number: REFUSED_ID,
    text: 'Refused Treatment',
    modal: null,
    action: null
  },
  {
    number: DEVICE_DELIVERY_ID,
    text: 'Device Delivery',
    modal: symbols.modals.impressionDevice,
    action: symbols.actions.setExistingDevice
  },
  {
    number: FOLLOW_UP_ID,
    text: 'Check / Follow Up',
    modal: null,
    action: null
  },
  {
    number: NON_COMPLIANT_ID,
    text: 'Pt. Non-Compliant',
    modal: symbols.modals.flowsheetNonCompliance,
    action: null
  },
  {
    number: TREATMENT_COMPLETE_ID,
    text: 'Treatment Complete',
    modal: null,
    action: null
  },
  {
    number: ANNUAL_RECALL_ID,
    text: 'Annual Recall',
    modal: null,
    action: null
  },
  {
    number: TERMINATION_ID,
    text: 'Termination',
    modal: null,
    action: null
  },
  {
    number: NOT_CANDIDATE_ID,
    text: 'Not a Candidate',
    modal: null,
    action: null
  },
  {
    number: BASELINE_TEST_ID,
    text: 'Baseline Sleep Test',
    modal: symbols.modals.flowsheetStudyType,
    action: null
  }
]

export const DELAY_REASONS = [
  {
    value: 'insurance',
    text: 'Insurance'
  },
  {
    value: 'dental work',
    text: 'Dental Work'
  },
  {
    value: 'deciding',
    text: 'Deciding'
  },
  {
    value: 'sleep study',
    text: 'Sleep Study'
  },
  {
    value: 'other',
    text: 'Other'
  }
]

export const NON_COMPLIANCE_REASONS = [
  {
    value: 'pain/discomfort',
    text: 'Pain/Discomfort'
  },
  {
    value: 'lost device',
    text: 'Lost Device'
  },
  {
    value: 'device not working',
    text: 'Device Not Working'
  },
  {
    value: 'other',
    text: 'Other'
  }
]

export const TITRATION_TYPES = [
  'HST Titration',
  'PSG Titration'
]

export const BASELINE_TYPES = [
  'HST Baseline',
  'PSG Baseline'
]

export const INITIAL_FUTURE_APPOINTMENT = {
  id: 0,
  segmentId: 0,
  dateScheduled: null,
  dateUntil: null
}
