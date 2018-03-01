import symbols from '../../../symbols'

export default {
  name: 'edx-certificate',
  computed: {
    edxCertificates () {
      return this.$store.getters[symbols.getters.edxCertificates]
    }
  },
  mounted () {
    this.$store.dispatch(symbols.actions.getEdxCertificatesData)
  }
}
