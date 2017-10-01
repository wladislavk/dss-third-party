import axios from 'axios'

export default {
  token: '',
  request (method, path, data, config) {
    if (!this.hasOwnProperty(method)) {
      throw new Error(`HTTP method ${method} not found`)
    }
    return new Promise((resolve, reject) => {
      this[method](path, data, config).then(
        (response) => {
          if (response.error) {
            reject(new Error())
            return
          }
          resolve(response)
        },
        () => {
          reject(new Error())
        }
      )
    })
  },

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
    let apiPath = process.env.API_PATH
    if (window.location.protocol === 'http:') {
      apiPath = process.env.HEADLESS_API_PATH
    }
    if (apiPath.charAt(apiPath.length - 1) === '/' && path.charAt(0) === '/') {
      path = path.substr(1)
    }
    return apiPath + path
  },

  _addToken (config) {
    config.headers = config.headers || {}
    config.headers.Authorization = 'Bearer ' + this.token
  }
}
