import BaseFileRetriever from './BaseFileRetriever'
import ProcessWrapper from '../../wrappers/ProcessWrapper'

export default class LegacyFileRetriever extends BaseFileRetriever {
  fetchFile (filename) {
    return ProcessWrapper.getLegacyRoot() + 'manage/display_file.php?f=' + filename
  }
}
