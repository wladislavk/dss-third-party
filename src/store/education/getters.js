import symbols from '../../symbols'

export default {
  [symbols.getters.edxCertificates] (state) {
    return state[symbols.state.edxCertificates]
  }
}
