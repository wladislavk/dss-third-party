/* global apiRoot */
/* global Vue */
/* global setApiToken */
/* exported RefreshTokenInterceptor */
function RefreshTokenInterceptor (request, next) {
  var maxAttempts = 1

  /**
   * Only intercept calls to the API
   */
  if (request.url.indexOf(apiRoot) === -1) {
    next()
    return
  }

  next(function (originalResponse) {
    if (originalResponse.ok) {
      return
    }

    if (
      !originalResponse.data ||
      !originalResponse.data.message ||
      originalResponse.data.message.indexOf('jwt_token') !== 0
    ) {
      return
    }

    /**
     * Alter the original request, to avoid loops
     */
    request.attempts = request.attempts || 0
    request.attempts++

    if (request.attempts > maxAttempts) {
      return
    }

    /**
     * Token expired. Return a promise that will resolve after requesting a new token.
     */
    return new Promise(function (resolve) {
      Vue.http.get('/manage/token.php').then(function (tokenResponse) {
        var data = tokenResponse.json()

        if (typeof data.token !== 'string' || data.token.length === 0) {
          resolve(originalResponse)
          return
        }

        setApiToken(data.token)

        /**
         * Alter the request to match the token
         */
        if (typeof request.headers.Authorization !== 'undefined') {
          request.headers.Authorization = 'Bearer ' + data.token
        }

        if (typeof request.params.token !== 'undefined') {
          request.params.token = data.token
        }

        Vue.http(request).then(resolve, resolve)
      }, function () {
        resolve(originalResponse)
      })
    })
  })
}
