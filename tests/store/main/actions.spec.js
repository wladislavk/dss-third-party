/* eslint-disable prefer-promise-reject-errors */
import symbols from '../../../src/symbols'
import sinon from 'sinon'
import MainModule from '../../../src/store/main'
import TestCase from '../../cases/StoreTestCase'
import SwalWrapper from '../../../src/wrappers/SwalWrapper'
import http from '../../../src/services/http'
import LocalStorageManager from '../../../src/services/LocalStorageManager'
import endpoints from '../../../src/endpoints'
import RouterKeeper from '../../../src/services/RouterKeeper'
import ProcessWrapper from '../../../src/wrappers/ProcessWrapper'
import MediaFileRetriever from '../../../src/services/MediaFileRetriever'
import { LEGACY_URL } from '../../../src/constants/main'
import NameComposer from '../../../src/services/NameComposer'
import Alerter from '../../../src/services/Alerter'

describe('Main module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('userInfo action', () => {
    it('should set user info', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            id: 'u_1',
            docid: 2,
            manage_staff: 3,
            user_type: '4',
            use_course: '5',
            loginid: 'foo',
            username: 'John',
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
            loginId: 'foo',
            username: 'John'
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
    it('should handle error', function (done) {
      this.sandbox.stub(http, 'post').callsFake(() => {
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

  describe('docInfo action', () => {
    beforeEach(function () {
      this.testCase.setState({
        [symbols.state.userInfo]: {
          docId: 1
        }
      })
    })

    it('should set doc info', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            homepage: 'foo',
            manage_staff: 3,
            use_eligible_api: 4,
            use_letters: '5',
            use_patient_portal: 6,
            use_payment_reports: 7
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.docInfo](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.docInfo,
          payload: {
            homepage: 'foo',
            manageStaff: 3,
            useEligibleApi: 4,
            useLetters: 5,
            usePatientPortal: 6,
            usePaymentReports: 7
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.users.show + '/1'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.docInfo](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getUser',
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

  describe('courseStaff action', () => {
    it('should set course staff', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            use_course: '1',
            use_course_staff: '2'
          }
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.courseStaff](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.courseStaff,
          payload: {
            useCourse: 1,
            useCourseStaff: 2
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.users.courseStaff
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.courseStaff](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getCourseStaff',
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

  describe('patientData action', () => {
    it('should get patient data', function (done) {
      const patientId = 1
      const postData = []
      const result = {
        data: {
          data: {
            insurance_type: '2',
            premedcheck: '3',
            premed: 'foo',
            alert_text: 'alert',
            display_alert: '1',
            firstname: 'John',
            lastname: 'Doe',
            questionnaire_data: {
              symptoms_status: '4',
              treatments_status: '5',
              history_status: '6'
            },
            is_email_bounced: '0',
            patient_contacts_number: '7',
            patient_insurances_number: '8',
            sub_patients_number: '9',
            rejected_claims: ['foo', 'bar'],
            has_allergen: '1',
            other_allergens: 'other',
            hst_status: '10',
            incomplete_hsts: ['baz']
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      const expectedMutations = [
        {
          type: symbols.mutations.patientId,
          payload: 1
        },
        {
          type: symbols.mutations.patientData,
          payload: {
            insuranceType: '2',
            preMed: 'foo',
            preMedCheck: '3',
            alertText: 'alert',
            displayAlert: '1',
            firstName: 'John',
            lastName: 'Doe',
            questionnaireData: {
              symptomsStatus: '4',
              treatmentsStatus: '5',
              historyStatus: '6'
            },
            isEmailBounced: '0',
            patientContactsNumber: '7',
            patientInsurancesNumber: '8',
            subPatientsNumber: '9',
            rejectedClaims: ['foo', 'bar'],
            hasAllergen: '1',
            otherAllergens: 'other',
            hstStatus: '10',
            incompleteHomeSleepTests: ['baz']
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.patients.patientData + '/1'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getPatientByIdAndDocId',
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

  describe('clearPatientData action', () => {
    it('clears patient data', function () {
      MainModule.actions[symbols.actions.clearPatientData](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.clearPatientData,
          payload: {}
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })

  describe('logout action', () => {
    it('logs out successfully', function (done) {
      const postData = []
      const swalData = []
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve({})
      })
      this.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        swalData.push(data)
        func()
      })
      MainModule.actions[symbols.actions.logout](this.testCase.mocks)
      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.mainToken,
            payload: ''
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.logout
          }
        ]
        expect(postData).toEqual(expectedHttp)
        const expectedSwal = [
          {
            title: '',
            text: 'Logout Successfully!',
            type: 'success'
          }
        ]
        expect(swalData).toEqual(expectedSwal)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      let errorMessage = ''
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject({status: 400})
      })
      this.sandbox.stub(console, 'error').callsFake((message) => {
        errorMessage = message
      })
      MainModule.actions[symbols.actions.logout](this.testCase.mocks)
      setTimeout(() => {
        expect(errorMessage).toBe('invalidateToken [status]: 400')
        done()
      }, 100)
    })
  })

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
                name: 'No Matches',
                patientType: 'no',
                link: ''
              },
              {
                name: 'Add patient with this name\u2026',
                patientType: 'new',
                link: LEGACY_URL + 'add_patient.php?search=John'
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
              patientId: 1,
              name: 'John Doe',
              patientInfo: 0
            },
            {
              patientId: 2,
              name: 'John Little',
              patientInfo: 1
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
                name: 'John Doe',
                patientType: 'json',
                link: LEGACY_URL + 'manage/add_patient.php?pid=1&ed=1'
              },
              {
                name: 'John Little',
                patientType: 'json',
                link: LEGACY_URL + 'manage/manage_flowsheet3.php?pid=2'
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
