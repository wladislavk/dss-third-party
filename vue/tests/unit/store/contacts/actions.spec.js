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
    beforeEach(function () {
      this.contactId = 1
      this.payload = { contactId: this.contactId }
      this.expectedHttp = {
        path: endpoints.contacts.withContactType,
        payload: { contact_id: this.contactId }
      }
      this.disablePopupAction = {
        type: symbols.actions.disablePopupEdit,
        payload: {}
      }
    })
    it('should set contact if promise resolves', function (done) {
      const response = {
        foo: 'bar'
      }
      this.testCase.stubRequest({response: response})

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.setContact,
              payload: { data: response }
            }
          ],
          actions: [
            this.disablePopupAction
          ]
        })
        done()
      })
    })

    it('should not set contact if promise resolves without data', function (done) {
      this.testCase.stubRequest({message: 'foo'})

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.disablePopupAction
          ]
        })
        done()
      })
    })

    it('should handle error if promise rejects', function (done) {
      this.testCase.stubErrorRequest()

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
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
