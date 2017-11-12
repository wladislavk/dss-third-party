export default class GeneralError extends Error {
  constructor () {
    super()
    Error.captureStackTrace(this, GeneralError)
  }
}
