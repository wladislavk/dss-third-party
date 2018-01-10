export default class BaseFileRetriever {
  getMediaFile (filename) {
    return this.fetchFile(filename)
  }

  fetchFile () {
    throw new Error('This class cannot be used directly')
  }
}
