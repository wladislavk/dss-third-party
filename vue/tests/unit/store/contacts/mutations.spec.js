import ContactModule from '../../../../src/store/contacts'
import symbols from '../../../../src/symbols'

describe('Contacts module mutations', () => {
  describe('setContact mutation', () => {
    it('should modify contact', function () {
      const state = {
        [symbols.state.contact]: 'foo'
      }
      const payload = {data: 'bar'}
      ContactModule.mutations[symbols.mutations.setContact](state, payload)
      expect(state[symbols.state.contact]).toBe('bar')
    })
  })
})
