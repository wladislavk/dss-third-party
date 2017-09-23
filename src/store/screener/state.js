import symbols from '../../symbols'
import * as constants from '../../constants'

export default {
  [symbols.state.sessionData]: {
    docId: 0,
    userId: 0
  },
  [symbols.state.companyData]: [],
  [symbols.state.doctorName]: '',
  [symbols.state.screenerWeights]: {
    coMorbidity: 0,
    epworth: 0,
    survey: 0
  },
  [symbols.state.contactData]: constants.INITIAL_CONTACT_DATA,
  [symbols.state.epworthProps]: [],
  [symbols.state.epworthOptions]: constants.EPWORTH_OPTIONS,
  [symbols.state.symptoms]: constants.INITIAL_SYMPTOMS,
  [symbols.state.coMorbidityData]: constants.INITIAL_CO_MORBIDITY,
  [symbols.state.cpap]: {
    name: 'rx_cpap',
    label: 'Have you ever used CPAP before?',
    weight: 4,
    selected: 0
  },
  [symbols.state.screenerToken]: ''
}
