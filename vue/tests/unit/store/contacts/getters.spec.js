import ContactModule from '../../../../src/store/contacts'
import symbols from '../../../../src/symbols'

describe('Contacts module getters', () => {
  describe('filteredContact getter', () => {
    it('should modify phone fields', function () {
      const state = {
        [symbols.state.contact]: {
          id: 1,
          phone1: '1234567890',
          fax: 'fre123i$R&456cfdkm7890'
        }
      }
      const contact = ContactModule.getters[symbols.getters.filteredContact](state)
      const expected = {
        id: 1,
        phone1: '(123) 456-7890',
        fax: '(123) 456-7890'
      }
      expect(contact).toEqual(expected)
    })
  })
})
