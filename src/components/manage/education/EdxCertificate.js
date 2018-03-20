import symbols from '../../../symbols'

export default {
  name: 'edx-certificate',
  computed: {
    edxCertificates () {
      return this.$store.state.education[symbols.state.edxCertificates]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getEdxCertificatesData)
  }
}
