import symbols from '../../../../src/symbols'
import MainModule from '../../../../src/store/main'
import TestCase from '../../../cases/StoreTestCase'
import LocalStorageManager from '../../../../src/services/LocalStorageManager'
import endpoints from '../../../../src/endpoints'
import RouterKeeper from '../../../../src/services/RouterKeeper'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import NameComposer from '../../../../src/services/NameComposer'

describe('Main module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('mainLogin action', () => {
    beforeEach(function () {
      this.testCase.sandbox.stub(ProcessWrapper, 'getApiRoot').callsFake(() => {
        return 'root/'
      })
      this.credentials = {foo: 'bar'}
      this.expectedHttp = {
        path: 'root/auth',
        payload: this.credentials
      }
    })
    it('resolves login', function (done) {
      const token = 'token'
      this.testCase.stubRawRequest({
        response: {
          data: {
            token: token
          }
        }
      })

      MainModule.actions[symbols.actions.mainLogin](this.testCase.mocks, this.credentials)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.dualAppLogin,
              payload: token
            }
          ]
        })
        done()
      })
    })
    it('throws if auth fails', function (done) {
      const errorMessage = 'auth error'
      this.testCase.stubRawRequest({error: errorMessage})

      MainModule.actions[symbols.actions.mainLogin](this.testCase.mocks, this.credentials)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {title: 'getToken', response: errorMessage}
            }
          ]
        })
        done()
      })
    })
    // @todo: devise a way to test it
    it('throws with 422 status', function () {})
  })

  describe('dualAppLogin action', () => {
    it('approves login', function (done) {
      const response = {
        type: 'OK'
      }
      this.testCase.stubRequest({response: response})
      const token = 'token'

      MainModule.actions[symbols.actions.dualAppLogin](this.testCase.mocks, token)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.check },
          mutations: [
            {
              type: symbols.mutations.mainToken,
              payload: token
            }
          ],
          actions: [
            {
              type: symbols.actions.userInfo,
              payload: {}
            }
          ]
        })
        done()
      })
    })
    it('throws if check user fails', function (done) {
      this.testCase.stubErrorRequest()
      const token = 'token'

      MainModule.actions[symbols.actions.dualAppLogin](this.testCase.mocks, token)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.check },
          mutations: [
            {
              type: symbols.mutations.mainToken,
              payload: ''
            }
          ],
          actions: [
            this.testCase.getErrorHandler('getUserByToken')
          ]
        })
        done()
      })
    })
    // @todo: devise a way to test it
    it('throws if account suspended', function () {})
  })

  describe('userInfo action', () => {
    it('sets user info', function (done) {
      const response = {
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
      this.testCase.stubRequest({response: response})

      MainModule.actions[symbols.actions.userInfo](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.current },
          mutations: [
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
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      MainModule.actions[symbols.actions.userInfo](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.current },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getCurrentUser')
          ]
        })
        done()
      })
    })
  })

  describe('disablePopupEdit action', () => {
    it('disables popup edit', function (done) {
      MainModule.actions[symbols.actions.disablePopupEdit](this.testCase.mocks)

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [
          {
            type: symbols.mutations.popupEdit,
            payload: {
              value: false
            }
          }
        ],
        actions: []
      })
      done()
    })
  })

  describe('handleErrors action', () => {
    it('handles 401 error code', function () {
      const dataRemoved = []
      this.testCase.sandbox.stub(LocalStorageManager, 'remove').callsFake((argument) => {
        dataRemoved.push(argument)
      })
      const routes = []
      this.testCase.sandbox.stub(RouterKeeper, 'getRouter').callsFake(() => {
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
      this.testCase.sandbox.stub(ProcessWrapper, 'getNodeEnv').returns('development')
      let errorMessage = ''
      this.testCase.sandbox.stub(console, 'error').callsFake((message) => {
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
    beforeEach(function () {
      this.searchTerm = 'John'
      this.expectedHttp = {
        path: endpoints.patients.list,
        payload: {
          partial_name: this.searchTerm
        }
      }
    })
    it('shows list without patients', function (done) {
      this.testCase.stubRequest({response: []})

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, this.searchTerm)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
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
                  link: 'add_patient.php?search=' + this.searchTerm
                }
              ]
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('shows list with patients', function (done) {
      const firstId = 1
      const secondId = 2
      const firstName = 'John Doe'
      const secondName = 'John Little'
      const response = [
        {
          patientid: firstId,
          name: firstName,
          patient_info: 0
        },
        {
          patientid: secondId,
          name: secondName,
          patient_info: 1
        }
      ]
      this.testCase.stubRequest({response: response})
      this.testCase.sandbox.stub(NameComposer, 'composeName').callsFake((element) => {
        return element.name
      })

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, this.searchTerm)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.patientSearchList,
              payload: [
                {
                  id: firstId,
                  name: firstName,
                  patientType: 'json',
                  link: 'manage/add_patient.php?pid=' + firstId + '&ed=1',
                  route: {
                    name: ''
                  }
                },
                {
                  id: secondId,
                  name: secondName,
                  patientType: 'json',
                  link: '',
                  route: {
                    name: 'patient-tracker',
                    query: {
                      pid: secondId
                    }
                  }
                }
              ]
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      MainModule.actions[symbols.actions.patientSearchList](this.testCase.mocks, this.searchTerm)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: []
        })
        expect(this.testCase.alertText).toBe('Could not select patient from database')
        done()
      })
    })
  })
})
