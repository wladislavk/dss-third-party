import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.getEdxCertificatesData] ({commit, dispatch}) {
    http.get(endpoints.education.edxCertificates).then((response) => {
      const data = response.data.data
      const edxData = []
      console.log('data', data)
      response.data.data.forEach((data) => {
        const certificate = {
          id: data.id,
          url: data.url,
          courseName: data.course_name,
          courseSection: data.course_section,
          courseSubsection: data.course_subsection,
          numberCe: data.number_ce,
          addDate: data.adddate,
          ipAddress: data.ip_address
        }
        edxData.push(certificate)
      })

      commit(symbols.mutations.edxCertificatesData, edxData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getEdxCertificatesData', response: response})
    })
  }
}
