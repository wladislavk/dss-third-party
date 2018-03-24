export default class FileRetrievalError extends Error {
  constructor (response) {
    super()
    this.title = 'getFileForDisplaying'
    this.response = response
    Error.captureStackTrace(this, FileRetrievalError)
  }
}
