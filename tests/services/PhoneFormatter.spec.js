import PhoneFormatter from '../../src/services/PhoneFormatter'

describe('PhoneFormatter', () => {
  it('returns empty string when phoneDisplaying called without arguments', function () {
    const result = PhoneFormatter.methods.phoneForDisplaying()
    expect(result).toBe('')
  })

  it('returns formatted phone number when phoneDisplaying called', function () {
    const phone = '123abc456def7890'
    const result = PhoneFormatter.methods.phoneForDisplaying(phone)
    const expectedPhone = '(123) 456-7890'
    expect(result).toBe(expectedPhone)
  })

  it('returns empty string when phoneStoring called without arguments', function () {
    const result = PhoneFormatter.methods.phoneForStoring()
    expect(result).toBe('')
  })

  it('returns phone number as integer when phoneStoring called', function () {
    const phone = '123abc456def7890'
    const result = PhoneFormatter.methods.phoneForStoring(phone)
    const expectedPhone = '1234567890'
    expect(result).toBe(expectedPhone)
  })
})
