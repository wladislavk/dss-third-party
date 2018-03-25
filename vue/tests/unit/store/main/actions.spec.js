/* eslint-disable prefer-promise-reject-errors */
import symbols from '../../../../src/symbols'
import sinon from 'sinon'
import MainModule from '../../../../src/store/main'
import TestCase from '../../../cases/StoreTestCase'
import axios from 'axios'
import http from '../../../../src/services/http'
import LocalStorageManager from '../../../../src/services/LocalStorageManager'
import endpoints from '../../../../src/endpoints'
import RouterKeeper from '../../../../src/services/RouterKeeper'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import NameComposer from '../../../../src/services/NameComposer'
import Alerter from '../../../../src/services/Alerter'

describe('Main module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('mainLogin action', () => {
    beforeEach(function () {
      this.postData = []
      this.sandbox.stub(ProcessWrapper, 'getApiRoot').callsFake(() => {
        return 'root/'
      })
    })
    it('resolves login', function (done) {
      this.sandbox.stub(axios, 'post').callsFake((path, payload) => {
        this.postData.push({
          path: path,
          payload: payload
        })
        const result = {
          data: {
            token: 'token'
          }
        }
        return Promise.resolve(result)
      })
      const credentials = {foo: 'bar'}
      MainModule.actions[symbols.actions.mainLogin](this.testCase.mocks, credentials)
      setTimeout(() => {
        const expectedHttp = [
          {
            path: 'root/auth',
            payload: {foo: 'bar'}
          }
        ]
        expect(this.postData).toEqual(expectedHttp)
        const expectedActions = [
          {
            type: symbols.actions.dualAppLogin,
            payload: 'token'
          }
        ]
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('throws if auth fails', function (done) {
      this.sandbox.stub(axios, 'post').callsFake((path, payload) => {
        this.postData.push({
          path: path,
          payload: payload
        })
        return Promise.reject('auth error')
      })
      const credentials = {foo: 'bar'}
      MainModule.actions[symbols.actions.mainLogin](this.testCase.mocks, credentials)
      setTimeout(() => {
        const expectedHttp = [
          {
            path: 'root/auth',
            payload: {foo: 'bar'}
          }
        ]
        expect(this.postData).toEqual(expectedHttp)
        const expectedActions = [
          {
            type: symbols.actions.handleErrors,
            payload: {title: 'getToken', response: 'auth error'}
          }
        ]
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    // @todo: devise a way to test it
    it('throws with 422 status', function () {})
  })

  describe('dualAppLogin action', () => {
    it('approves login', function (done) {
      const postData = []
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        const result = {
          data: {
            data: {
              type: 'OK'
            }
          }
        }
        return Promise.resolve(result)
      })
      const token = 'token'
      MainModule.actions[symbols.actions.dualAppLogin](this.testCase.mocks, token)
      setTimeout(() => {
        const expectedHttp = [
          {
            path: endpoints.users.check
          }
        ]
        expect(postData).toEqual(expectedHttp)
        const expectedMutations = [
          {
            type: symbols.mutations.mainToken,
            payload: 'token'
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedActions = [
          {
            type: symbols.actions.userInfo,
            payload: {}
          }
        ]
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('throws if check user fails', function (done) {
      const postData = []
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.reject('check user error')
      })
      const token = 'token'
      MainModule.actions[symbols.actions.dualAppLogin](this.testCase.mocks, token)
      setTimeout(() => {
        const expectedHttp = [
          {
            path: endpoints.users.check
          }
        ]
        expect(postData).toEqual(expectedHttp)
        const expectedMutations = [
          {
            type: symbols.mutations.mainToken,
            payload: ''
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedActions = [
          {
            type: symbols.actions.handleErrors,
            payload: {title: 'getUserByToken', response: 'check user error'}
          }
        ]
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    // @todo: devise a way to test it
    it('throws if account suspended', function () {})
  })

  describe('userInfo action', () => {
    it('sets user info', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            id: 'u_1',
            userid: '1',
            docid: '2',
            manage_staff: '3',
            user_type: '4',
            use_course: '5',
            username: 'John',
            doc_info: {
              homepage: '6',
              manage_staff: '7',
              use_eligible_api: '8',
              use_letters: '9',
              use_patient_portal: '10',
              use_payment_reports: '11',
              use_course_staff: '12'
            },
            numbers: {
              one: 1,
              two: 2
            }
          }
        }
      }
      this.sandbox.stub(http, 'request').callsFake((method, path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      MainModule.actions[symbols.actions.userInfo](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.userInfo,
          payload: {
            userId: 'u_1',
            plainUserId: 1,
            docId: 2,
            manageStaff: 3,
            userType: 4,
            useCourse: 5,
            username: 'John'
          }
        },
        {
          type: symbols.mutations.docInfo,
          payload: {
            homepage: 6,
            manageStaff: 7,
            useEligibleApi: 8,
            useLetters: 9,
            usePatientPortal: 10,
            usePaymentReports: 11,
            useCourseStaff: 12
          }
        },
        {
          type: symbols.mutations.notificationNumbers,
          payload: {
            one: 1,
            two: 2
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.users.current
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.sandbox.stub(http, 'request').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.userInfo](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getCurrentUser',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
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
      const dataRemoved = []
      this.sandbox.stub(LocalStorageManager, 'remove').callsFake((argument) => {
        dataRemoved.push(argument)
      })
      const routes = []
      this.sandbox.stub(RouterKeeper, 'getRouter').callsFake(() => {
        return routes
      })
      const payload = {
        title: '',
        response: {status: 401}
      }

      MainModule.actions[symbols.actions.handleErrors](this.testCase.mocks, payload)
      expect(dataRemoved).toEqual(['token'])
      expect(routes).toEqual(['/manage/login'])
    })
    it('handles other error codes', function () {
      this.sandbox.stub(ProcessWrapper, 'getNodeEnv').returns('development')
      let errorMessage = ''
      this.sandbox.stub(console, 'error').callsFake((message) => {
        errorMessage = message
      })
      const payload = {
        title: 'My title',
        response: {status: 400}
      }

      MainModule.actions[symbols.actions.handleErrors](this.testCase.mocks, payload)
      expect(errorMessage).toBe('My title [status]: 400')
    })
    it('handles errors in production environment', function () {
      // @todo: add code and write the test
    })
  })

  // @todo: add proper logging. currently logins are not stored
  /*
  describe('storeLoginDetails action', () => {
    it('stores login details', function (done) {
      const postData = []
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve({})
      })
      const queryString = '/foo'
      this.testCase.setState({
        [symbols.state.userInfo]: {
          loginId: 1,
          plainUserId: 2
        }
      })
      MainModule.actions[symbols.actions.storeLoginDetails](this.testCase.mocks, queryString)

      setTimeout(() => {
        const expectedHttp = [
          {
            path: endpoints.loginDetails.store,
            payload: {
              loginid: 1,
              userid: 2,
              cur_page: '/foo'
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('returns when there is no login ID', function (done) {
      const postData = []
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve({})
      })
      const queryString = '/foo'
      this.testCase.setState({
        [symbols.state.userInfo]: {
          plainUserId: 2
        }
      })
      MainModule.actions[symbols.actions.storeLoginDetails](this.testCase.mocks, queryString)

      setTimeout(() => {
        expect(postData).toEqual([])
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.setState({
        [symbols.state.userInfo]: {
          loginId: 1,
          plainUserId: 2
        }
      })
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })
      const queryString = '/foo'

      MainModule.actions[symbols.actions.storeLoginDetails](this.testCase.mocks, queryString)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'setLoginDetails',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })
  */

  // @todo: the code needs to be rewritten and acceptance-tested
  /*
  describe('companyLogo action', () => {
    it('gets company logo', function () {
    })
    it('stops execution if company does not have logo', function () {
    })
    it('handles error when getting company data', function () {
    })
    it('handles error when retrieving image', function () {
    })
  })
  */

  describe('patientSearchList action', () => {
    it('shows list without patients', function (done) {
      const searchTerm = 'John'
      const postData = []
      const result = {
        data: {
          data: []
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, searchTerm)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.patientSearchList,
            payload: [
              {
                id: 0,
                name: 'No Matches',
                patientType: 'no',
                link: ''
              },
              {
                id: 0,
                name: 'Add patient with this name\u2026',
                patientType: 'new',
                link: 'add_patient.php?search=John'
              }
            ]
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.patients.list,
            payload: {
              partial_name: 'John'
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('shows list with patients', function (done) {
      const searchTerm = 'John'
      const result = {
        data: {
          data: [
            {
              patientid: 1,
              name: 'John Doe',
              patient_info: 0
            },
            {
              patientid: 2,
              name: 'John Little',
              patient_info: 1
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })
      this.sandbox.stub(NameComposer, 'composeName').callsFake((element) => {
        return element.name
      })

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, searchTerm)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.patientSearchList,
            payload: [
              {
                id: 1,
                name: 'John Doe',
                patientType: 'json',
                link: 'manage/add_patient.php?pid=1&ed=1'
              },
              {
                id: 2,
                name: 'John Little',
                patientType: 'json',
                link: 'manage/manage_flowsheet3.php?pid=2'
              }
            ]
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const searchTerm = 'John'
      let alert = ''
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })
      this.sandbox.stub(Alerter, 'alert').callsFake((alertText) => {
        alert = alertText
      })

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, searchTerm)

      setTimeout(() => {
        expect(alert).toBe('Could not select patient from database')
        done()
      }, 100)
    })
  })
})
