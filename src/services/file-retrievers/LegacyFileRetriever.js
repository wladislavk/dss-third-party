import BaseFileRetriever from './BaseFileRetriever'
import LegacyModifier from '../LegacyModifier'

export default class LegacyFileRetriever extends BaseFileRetriever {
  fetchFile (filename, token) {
    const url = 'manage/display_file.php?f=' + filename
    return LegacyModifier.modifyLegacyLink(url, token)
  }
}
