import symbols from '../../../symbols'

export default {
  name: 'edx-certificate',
  computed: {
    edxCertificates () {
      let value = this.$store.getters[symbols.getters.edxCertificates]
      console.log('computing: ', value)
      return value
    }
  },
  mounted() {
    console.log('------------mounted', this.edxCertificates)
  },
  created () {
    this.$store.dispatch(symbols.actions.getEdxCertificatesData)
    console.log('------------created', this.edxCertificates)
  }
}
