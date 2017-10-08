export const INITIAL_CONTACT_DATA = [
  {
    name: 'first_name',
    camelName: 'firstName',
    label: 'First Name',
    resultLabel: 'First name',
    mask: '',
    firstPage: true,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'last_name',
    camelName: 'lastName',
    label: 'Last Name',
    resultLabel: 'Last name',
    mask: '',
    firstPage: true,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'dob',
    camelName: 'dob',
    label: 'Date of Birth',
    resultLabel: '',
    mask: '99/99/9999',
    firstPage: false,
    hstColumn: 'left',
    value: ''
  },
  {
    name: 'phone',
    camelName: 'phone',
    label: 'Phone Number',
    resultLabel: 'Phone',
    mask: '(999) 999-9999',
    firstPage: true,
    hstColumn: 'right',
    value: ''
  },
  {
    name: 'email',
    camelName: 'email',
    label: 'Email',
    resultLabel: '',
    mask: '',
    firstPage: false,
    hstColumn: 'right',
    value: ''
  }
]

export const EPWORTH_OPTIONS = [
  {
    option: '0',
    label: 'No chance of dozing'
  },
  {
    option: '1',
    label: 'Slight chance of dozing'
  },
  {
    option: '2',
    label: 'Moderate chance of dozing'
  },
  {
    option: '3',
    label: 'High chance of dozing'
  }
]

export const INITIAL_SYMPTOMS = [
  {
    name: 'breathing',
    label: 'Have you ever been told you stop breathing while asleep?',
    weight: 8,
    selected: false
  },
  {
    name: 'driving',
    label: 'Have you ever fallen asleep or nodded off while driving?',
    weight: 6,
    selected: false
  },
  {
    name: 'gasping',
    label: 'Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?',
    weight: 6,
    selected: false
  },
  {
    name: 'sleepy',
    label: 'Do you feel excessively sleepy during the day?',
    weight: 4,
    selected: false
  },
  {
    name: 'snore',
    label: 'Do you snore or have you ever been told that you snore?',
    weight: 4,
    selected: false
  },
  {
    name: 'weight_gain',
    label: 'Have you had weight gain and found it difficult to lose?',
    weight: 2,
    selected: false
  },
  {
    name: 'blood_pressure',
    label: 'Have you taken medication for, or been diagnosed with high blood pressure?',
    weight: 2,
    selected: false
  },
  {
    name: 'jerk',
    label: 'Do you kick or jerk your legs while sleeping?',
    weight: 3,
    selected: false
  },
  {
    name: 'burning',
    label: 'Do you feel burning, tingling or crawling sensations in your legs when you wake up?',
    weight: 3,
    selected: false
  },
  {
    name: 'headaches',
    label: 'Do you wake up with headaches during the night or in the morning?',
    weight: 3,
    selected: false
  },
  {
    name: 'falling_asleep',
    label: 'Do you have trouble falling asleep?',
    weight: 4,
    selected: false
  },
  {
    name: 'staying_asleep',
    label: 'Do you have trouble staying asleep once you fall asleep?',
    weight: 4,
    selected: false
  }
]

export const INITIAL_CO_MORBIDITY = [
  {
    name: 'rx_heart_disease',
    label: 'Heart Failure',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_stroke',
    label: 'Stroke',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_hypertension',
    label: 'Hypertension',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_diabetes',
    label: 'Diabetes',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_metabolic_syndrome',
    label: 'Metabolic Syndrome',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_obesity',
    label: 'Obesity',
    weight: 2,
    checked: false
  },
  {
    name: 'rx_heartburn',
    label: 'Heartburn (Gastroesophageal Reflux)',
    weight: 1,
    checked: false
  },
  {
    name: 'rx_afib',
    label: 'Atrial Fibrillation',
    weight: 2,
    checked: false
  }
]

export const TASK_TYPES = {
  OVERDUE: 'overdue',
  TODAY: 'today',
  TOMORROW: 'tomorrow',
  THIS_WEEK: 'thisWeek',
  NEXT_WEEK: 'nextWeek',
  LATER: 'later',
  FUTURE: 'future'
}

export const LEGACY_URL = 'http://legacy/'
