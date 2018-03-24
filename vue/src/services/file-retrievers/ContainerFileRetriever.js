import BaseFileRetriever from './BaseFileRetriever'
import ProcessWrapper from '../../wrappers/ProcessWrapper'

export default class ContainerFileRetriever extends BaseFileRetriever {
  fetchFile (filename) {
    return ProcessWrapper.getStaticRoot() + filename
  }
}
