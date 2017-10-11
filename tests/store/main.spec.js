import symbols from '../../src/symbols'
import MainModule from '../../src/store/main'
import TestCase from '../cases/StoreTestCase'

describe('Main Module', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  describe('disablePopupEdit action', () => {
    it('disables popup edit', function (done) {
      MainModule.actions[symbols.actions.disablePopupEdit](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.popupEdit,
          payload: {
            value: false
          }
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
      done()
    })
  })

  describe('handleErrors action', () => {
    it('handles 401 error code', function () {
      // @todo: add a wrapper and write the test
    })
    it('handles other error codes', function () {
      // @todo: add a wrapper and write the test
    })
  })
})
