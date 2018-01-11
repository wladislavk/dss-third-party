export default {
  getApiRoot () {
    let apiRoot = process.env.API_ROOT
    if (this._checkForHeadless()) {
      apiRoot = process.env.HEADLESS_API_ROOT
    }
    return apiRoot
  },
  getApiPath () {
    let apiPath = process.env.API_PATH
    if (this._checkForHeadless()) {
      apiPath = process.env.HEADLESS_API_PATH
    }
    return apiPath
  },
  getLegacyRoot () {
    let legacyRoot = process.env.LEGACY_ROOT
    if (this._checkForHeadless()) {
      legacyRoot = process.env.HEADLESS_LEGACY_ROOT
    }
    return legacyRoot
  },
  getStaticRoot () {
    let staticRoot = process.env.STATIC_ROOT
    if (this._checkForHeadless()) {
      staticRoot = process.env.HEADLESS_STATIC_ROOT
    }
    return staticRoot
  },
  getNodeEnv () {
    return process.env.NODE_ENV
  },
  getFileStorage () {
    return process.env.FILE_STORAGE
  },
  getBucketUrl () {
    return process.env.BUCKET_URL
  },
  _checkForHeadless: function () {
    return (window.location.protocol === 'http:')
  }
}
