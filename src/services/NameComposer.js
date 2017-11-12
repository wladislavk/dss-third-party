import GeneralError from '../exceptions/GeneralError'

export default {
  composeName (element) {
    if (!element.hasOwnProperty('firstname') || !element.hasOwnProperty('lastname')) {
      throw new GeneralError('Element must have firstname and lastname properties')
    }
    let middleName = ''
    if (element.hasOwnProperty('middlename') && element.middlename) {
      middleName = element.middlename
    }
    return `${element.lastname}, ${element.firstname} ${middleName}`
  }
}
