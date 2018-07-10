import axios from 'axios'
import ProcessWrapper from '../wrappers/ProcessWrapper'

export default {
  token: '',

  get (path, data, config) {
    config = config || {}
    this._addToken(config)
    return axios.get(this.formUrl(path), config)
  },

  post (path, data, config) {
    config = config || {}
    this._addToken(config)
    return axios.post(this.formUrl(path), data, config)
  },

  put (path, data, config) {
    config = config || {}
    this._addToken(config)
    return axios.put(this.formUrl(path), data, config)
  },

  delete (path, data, config) {
    config = config || {}
    this._addToken(config)
    return axios.delete(this.formUrl(path), config)
  },

  formUrl (path) {
    let apiPath = ProcessWrapper.getApiPath()
    let resultingPath = path
    if (apiPath.charAt(apiPath.length - 1) === '/' && path.charAt(0) === '/') {
      resultingPath = path.substr(1)
    }
    return apiPath + resultingPath
  },

  deformUrl (url) {
    const apiPath = ProcessWrapper.getApiPath()
    return '/' + url.replace(apiPath, '')
  },

  _addToken (config) {
    config.headers = config.headers || {}
    config.headers.Authorization = 'Bearer ' + this.token
  }
}
