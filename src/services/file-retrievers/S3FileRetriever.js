import BaseFileRetriever from './BaseFileRetriever'
import ProcessWrapper from '../../wrappers/ProcessWrapper'

export default class S3FileRetriever extends BaseFileRetriever {
  fetchFile (filename) {
    return ProcessWrapper.getBucketUrl() + filename
  }
}
