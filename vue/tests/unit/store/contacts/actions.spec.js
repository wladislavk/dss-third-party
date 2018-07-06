import ContactModule from '../../../../src/store/contacts'
import TestCase from '../../../cases/StoreTestCase'
import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'

describe('Contacts Module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('setCurrentContact action', () => {
    it('should set contact if promise resolves', function (done) {
      const response = {
        foo: 'bar'
      }
      this.testCase.stubRequest({
        method: 'post',
        response: response
      })

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      const expectedMutations = [
        {
          type: symbols.mutations.setContact,
          payload: { data: response }
        }
      ]
      const expectedActions = [
        {
          type: symbols.actions.disablePopupEdit,
          payload: {}
        }
      ]
      const expectedHttp = [
        {
          path: endpoints.contacts.withContactType,
          payload: { contact_id: 1 }
        }
      ]
      this.testCase.wait(() => {
        expect(this.testCase.postData).toEqual(expectedHttp)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      })
    })

    it('should not set contact if promise resolves without data', function (done) {
      this.testCase.stubRequest({
        method: 'post',
        message: 'foo'
      })

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      const expectedActions = [
        {
          type: symbols.actions.disablePopupEdit,
          payload: {}
        }
      ]

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      })
    })

    it('should handle error if promise rejects', function (done) {
      this.testCase.stubRequest({
        method: 'post',
        status: 404
      })

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getContactById',
            response: new Error({ status: 404 })
          }
        }
      ]

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      })
    })
  })
})
