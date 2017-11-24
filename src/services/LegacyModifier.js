import ProcessWrapper from '../wrappers/ProcessWrapper'

export default {
  modifyLegacyLink (currentHref, token) {
    if (currentHref === '#') {
      return currentHref
    }
    let newHref = ProcessWrapper.getLegacyRoot() + currentHref
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
