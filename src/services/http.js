import axios from 'axios'

export default {
  request (method, path, data, headers) {
    if (!this.hasOwnProperty(method)) {
      throw new Error(`HTTP method ${method} not found`)
    }
    return new Promise((resolve, reject) => {
      this[method](path, data, headers).then(
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

  get (path, data, headers) {
    return axios.get(this.formUrl(path), data, headers)
  },

  post (path, data, headers) {
    return axios.post(this.formUrl(path), data, headers)
  },

  put (path, data, headers) {
    return axios.put(this.formUrl(path), data, headers)
  },

  delete (path, data, headers) {
    return axios.delete(this.formUrl(path), data, headers)
  },

  formUrl (path) {
    const apiPath = process.env.API_PATH
    if (apiPath.charAt(apiPath.length - 1) === '/' && path.charAt(0) === '/') {
      path = path.substr(1)
    }
    return apiPath + path
  }
}
