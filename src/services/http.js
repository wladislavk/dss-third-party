import axios from 'axios'

export default {
  post (path, data) {
    return axios.post(this._formUrl(path), data)
  },

  _formUrl (path) {
    return process.env.API_PATH + path
  }
}
