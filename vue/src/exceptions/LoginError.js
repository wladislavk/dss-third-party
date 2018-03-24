export default class LoginError extends Error {
  constructor (response) {
    super()
    this.response = response
    Error.captureStackTrace(this, LoginError)
  }
}
