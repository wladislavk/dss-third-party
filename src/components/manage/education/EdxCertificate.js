import http from '../../../services/http'

export default {
  name: 'edx-certificate',
  data () {
    return {
      edxCertificates: []
    }
  },
  mounted () {
    this.getCertificates()
  },
  methods: {
    getCertificates () {
      let that = this
      http.get('edx-certificates').then((response) => {
        that.edxCertificates = response.data.data
      })
    }
  }
}
