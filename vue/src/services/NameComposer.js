import GeneralError from '../exceptions/GeneralError'

export default {
  composeName (element) {
    if (!element.hasOwnProperty('firstname') || !element.hasOwnProperty('lastname')) {
      throw new GeneralError('Element must have firstname and lastname properties')
    }
    let fullName = `${element.lastname}, ${element.firstname}`
    if (element.hasOwnProperty('middlename') && element.middlename) {
      fullName += ` ${element.middlename}`
    }
    return fullName
  }
}
