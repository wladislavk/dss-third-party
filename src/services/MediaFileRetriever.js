import endpoints from '../endpoints'
import http from './http'
import FileRetrievalError from '../exceptions/FileRetrievalError'

export default {
  getMediaFile (filename) {
    return http.get(endpoints.displayFile + '/' + filename).then((response) => {
      const data = response.data.data
      return data.image
    }).catch((response) => {
      throw new FileRetrievalError(response)
    })
  }
}
