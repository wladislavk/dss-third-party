import axios from 'axios'

export default {
  request (method, path, data) {
    if (!this.hasOwnProperty(method)) {
      throw new Error(`HTTP method ${method} not found`)
    }
    return new Promise((resolve, reject) => {
      this[method](path, data).then(
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

  get (path, data) {
    return axios.get(this._formUrl(path), data)
  },

  post (path, data) {
    return axios.post(this._formUrl(path), data)
  },

  _formUrl (path) {
    return process.env.API_PATH + path
  }
}
