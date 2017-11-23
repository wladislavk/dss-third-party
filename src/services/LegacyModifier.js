import { LEGACY_URL } from '../constants/main'

export default {
  modifyLegacyLink (currentHref, token) {
    if (currentHref === '#') {
      return currentHref
    }
    let newHref = LEGACY_URL + currentHref
    let separator = '?'
    if (currentHref.indexOf('?') > -1) {
      separator = '&'
    }
    if (token) {
      newHref += separator + 'token=' + token
    }
    return newHref
  }
}
