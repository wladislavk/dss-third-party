export default class BaseFileRetriever {
  getMediaFile (filename, token) {
    return this.fetchFile(filename, token)
  }

  fetchFile () {
    throw new Error('This class cannot be used directly')
  }
}
