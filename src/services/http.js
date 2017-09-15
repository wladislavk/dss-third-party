import axios from 'axios'

export default {
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
