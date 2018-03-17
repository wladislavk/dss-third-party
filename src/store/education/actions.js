import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.getEdxCertificatesData] ({commit, dispatch}) {
    http.get(endpoints.edxCertificates.byUser).then((response) => {
      const edxData = []
      const data = response.data.data
      for (let element of data) {
        const certificate = {
          id: parseInt(element.id),
          url: element.url,
          courseName: element.course_name,
          courseSection: element.course_section,
          courseSubsection: element.course_subsection,
          numberCe: parseInt(element.number_ce)
        }
        edxData.push(certificate)
      }
      commit(symbols.mutations.edxCertificatesData, edxData)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getEdxCertificatesData', response: response})
    })
  }
}
