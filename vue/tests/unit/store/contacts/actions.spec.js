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
      this.testCase.stubRequest({response: response})

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.contacts.withContactType,
            payload: { contact_id: 1 }
          },
          mutations: [
            {
              type: symbols.mutations.setContact,
              payload: { data: response }
            }
          ],
          actions: [
            {
              type: symbols.actions.disablePopupEdit,
              payload: {}
            }
          ]
        })
        done()
      })
    })

    it('should not set contact if promise resolves without data', function (done) {
      this.testCase.stubRequest({message: 'foo'})

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.contacts.withContactType,
            payload: { contact_id: 1 }
          },
          mutations: [],
          actions: [
            {
              type: symbols.actions.disablePopupEdit,
              payload: {}
            }
          ]
        })
        done()
      })
    })

    it('should handle error if promise rejects', function (done) {
      this.testCase.stubErrorRequest()

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, { contactId: 1 })

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.contacts.withContactType,
            payload: { contact_id: 1 }
          },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getContactById')
          ]
        })
        done()
      })
    })
  })
})
