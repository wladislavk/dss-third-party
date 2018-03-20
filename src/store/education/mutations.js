import symbols from '../../symbols'

export default {
  [symbols.mutations.edxCertificatesData] (state, data) {
    state[symbols.state.edxCertificates] = data
  }
}
