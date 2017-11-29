// import endpoints from '../endpoints'
// import http from './http'
// import FileRetrievalError from '../exceptions/FileRetrievalError'

export default {
  getMediaFile (/* filename */) {
    // @todo: this is not likely to work in legacy, migrate after other modules are migrated
    /*
    return http.get(endpoints.displayFile + '/' + filename).then((response) => {
      const data = response.data.data
      return data.image
    }).catch((response) => {
      throw new FileRetrievalError(response)
    })
    */
  }
}
