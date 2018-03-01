import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.getEdxCertificatesData] ({commit, dispatch}) {
    console.log('getEdxCertificatesData')
    http.get(endpoints.education.edxCertificates).then((response) => {
      console.log('response', response.data.data)
      const data = response.data.data
      commit(symbols.mutations.edxCertificatesData, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getEdxCertificatesData', response: response})
    })
  }
}
