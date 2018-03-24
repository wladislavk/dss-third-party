import symbols from '../../symbols'
import { INITIAL_CO_MORBIDITY, INITIAL_CONTACT_DATA, EPWORTH_OPTIONS, INITIAL_SYMPTOMS } from '../../constants/screener'

export default {
  [symbols.state.sessionData]: {
    docId: 0,
    userId: 0
  },
  [symbols.state.doctorName]: '',
  [symbols.state.screenerWeights]: {
    coMorbidity: 0,
    epworth: 0,
    survey: 0
  },
  [symbols.state.contactData]: INITIAL_CONTACT_DATA,
  [symbols.state.storedContactData]: {},
  [symbols.state.epworthProps]: [],
  [symbols.state.epworthOptions]: EPWORTH_OPTIONS,
  [symbols.state.symptoms]: INITIAL_SYMPTOMS,
  [symbols.state.storedSymptoms]: {},
  [symbols.state.storedCpap]: 0,
  [symbols.state.coMorbidityData]: INITIAL_CO_MORBIDITY,
  [symbols.state.cpap]: {
    name: 'rx_cpap',
    label: 'Have you ever used CPAP before?',
    weight: 4,
    selected: 0
  },
  [symbols.state.screenerToken]: '',
  [symbols.state.showFancybox]: false
}
