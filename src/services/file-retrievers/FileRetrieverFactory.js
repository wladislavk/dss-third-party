import ProcessWrapper from '../../wrappers/ProcessWrapper'
import BaseFileRetriever from './BaseFileRetriever'
import LegacyFileRetriever from './LegacyFileRetriever'
import S3FileRetriever from './S3FileRetriever'

export default class FileRetrieverFactory {
  getFileRetriever () {
    const fileStorage = ProcessWrapper.getFileStorage()
    let fileRetriever = null
    switch (fileStorage) {
      case 's3':
        fileRetriever = new S3FileRetriever()
        break
      default:
        fileRetriever = new LegacyFileRetriever()
    }
    if (!(fileRetriever instanceof BaseFileRetriever)) {
      throw new Error('File retriever must exist and extend BaseFileRetriever')
    }
    return fileRetriever
  }
}
