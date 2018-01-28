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

export const RISK_LEVELS = {
  LOW: 'low',
  MODERATE: 'moderate',
  HIGH: 'high',
  SEVERE: 'severe'
}

export const RISK_LEVEL_TEXTS = {
  [RISK_LEVELS.LOW]: 'thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at low risk for sleep apnea, indicating a normal amount of sleepiness. Should any of your symptoms change, please let us know so we can reassess your sleepiness and risk for sleep apnea. Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.',
  [RISK_LEVELS.MODERATE]: 'thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at moderate risk for sleep apnea, indicating that some of your symptoms may be signs of Obstructive Sleep Apnea (OSA). Please talk to %s or any of our staff to find out about our advanced tools for diagnosing sleep apnea. We are here to answer your questions and help you breathe and sleep better! Sleep apnea is a life-threatening disease, and education and understanding of the condition is of utmost importance. Please mention this during your visit - we would love to help you learn more.',
  [RISK_LEVELS.HIGH]: 'thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at high risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness, and medical attention should be sought. Please talk to %s or any of our staff to find out about our advanced tools for diagnosing sleep apnea. Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your HIGH risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We\'re here to help!',
  [RISK_LEVELS.SEVERE]: 'thank you for completing the Dental Sleep Solutions questionnaire. Based on your input, your results indicate that you are at severe risk for sleep apnea, indicating that your symptoms are likely signs of Obstructive Sleep Apnea (OSA) and excessive sleepiness and medical attention should be sought. Please talk to %s or any of our staff to find out about our advanced tools for diagnosing sleep apnea. Sleep apnea is a life-threatening disease. Please mention this during your visit - we would love to help you learn more. Due to your SEVERE risk of sleep apnea, it is IMPORTANT that you discuss sleep apnea and treatment options with us. We\'re here to help!'
}
