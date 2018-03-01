import symbols from '../../symbols'

export default {
  [symbols.mutations.edxCertificatesData] (state, data) {
    console.log('mutation', data)
    state[symbols.state.edxCertificates] = data
  }
}
