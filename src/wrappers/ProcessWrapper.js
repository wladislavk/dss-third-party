export default {
  getApiRoot: function () {
    let apiRoot = process.env.API_ROOT
    if (this._checkForHeadless()) {
      apiRoot = process.env.HEADLESS_API_ROOT
    }
    return apiRoot
  },
  getApiPath: function () {
    let apiPath = process.env.API_PATH
    if (this._checkForHeadless()) {
      apiPath = process.env.HEADLESS_API_PATH
    }
    return apiPath
  },
  getImagePath: function () {
    return process.env.IMAGE_PATH
  },
  getNodeEnv: function () {
    return process.env.NODE_ENV
  },
  _checkForHeadless: function () {
    return (window.location.protocol === 'http:')
  }
}
