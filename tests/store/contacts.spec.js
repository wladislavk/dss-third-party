import ContactModule from '../../src/store/contacts'
import TestCase from '../cases/StoreTestCase'
import endpoints from '../../src/endpoints'
import http from '../../src/services/http'
import sinon from 'sinon'
import symbols from '../../src/symbols'

const sandbox = sinon.createSandbox()

describe('Contacts Module', () => {
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

  describe('setCurrentContact action', () => {
    beforeEach(function () {
      this.testCase = new TestCase()
      this.payload = {
        contactId: 1
      }

      this.postData = []
      sandbox.stub(http, 'post').callsFake((path, payload) => {
        this.postData.push({
          path: path,
          payload: payload
        })

        if (this.shouldResolve) {
          return Promise.resolve(this.result)
        }

        const error = new Error({ status: 404 })
        return Promise.reject(error)
      })
    })

    afterEach(function () {
      sandbox.restore()
    })

    it('should set contact if promise resolves', function (done) {
      this.shouldResolve = true
      this.result = {
        data: {
          data: {
            foo: 'bar'
          }
        }
      }

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      const expectedMutations = [
        {
          type: symbols.mutations.setContact,
          payload: { data: { foo: 'bar' } }
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

      expect(this.postData).toEqual(expectedHttp)
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })

    it('should not set contact if promise resolves without data', function (done) {
      this.shouldResolve = true
      this.result = {
        data: {}
      }

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      const expectedActions = [
        {
          type: symbols.actions.disablePopupEdit,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })

    it('should handle error if promise rejects', function (done) {
      this.shouldResolve = false

      ContactModule.actions[symbols.actions.setCurrentContact](this.testCase.mocks, this.payload)

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getContactById',
            response: new Error({ status: 404 })
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })
})
