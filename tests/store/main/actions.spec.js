/* eslint-disable prefer-promise-reject-errors */
import symbols from '../../../src/symbols'
import sinon from 'sinon'
import MainModule from '../../../src/store/main'
import TestCase from '../../cases/StoreTestCase'
import SwalWrapper from '../../../src/wrappers/SwalWrapper'
import http from '../../../src/services/http'
import storage from '../../../src/modules/storage'
import endpoints from '../../../src/endpoints'
import RouterKeeper from '../../../src/services/RouterKeeper'
import ProcessWrapper from '../../../src/wrappers/ProcessWrapper'

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
      this.sandbox.stub(storage, 'remove').callsFake((argument) => {
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
    beforeEach(function () {
      this.testCase.setState({
        [symbols.state.userInfo]: {
          docId: 2
        }
      })
    })
    it('should get patient data', function (done) {
      const patientId = 1
      const postData = []
      const result = {
        data: {
          data: [
            {
              p_m_ins_type: '1',
              premedcheck: '1',
              premed: 'foo',
              alert_text: 'alert',
              display_alert: true,
              firstname: 'John',
              lastname: 'Doe'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.headerTitle]: 'My title\n',
        [symbols.state.userInfo]: {
          docId: 2
        }
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      const expectedMutations = [
        {
          type: symbols.mutations.medicare,
          payload: true
        },
        {
          type: symbols.mutations.premedCheck,
          payload: 1
        },
        {
          type: symbols.mutations.headerTitle,
          payload: 'My title\nPre-medication: foo\n'
        },
        {
          type: symbols.mutations.headerAlertText,
          payload: 'alert'
        },
        {
          type: symbols.mutations.displayAlert,
          payload: true
        },
        {
          type: symbols.mutations.patientName,
          payload: {
            firstName: 'John',
            lastName: 'Doe'
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.patients.withFilter,
            payload: {
              where: {
                docid: 2,
                patientid: 1
              }
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should get patient data without medicare', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: [
            {
              p_m_ins_type: '2',
              premedcheck: '1',
              premed: 'foo',
              alert_text: 'alert',
              display_alert: true,
              firstname: 'John',
              lastname: 'Doe'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.headerTitle]: 'My title\n',
        [symbols.state.userInfo]: {
          docId: 2
        }
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      const expectedMutation = {
        type: symbols.mutations.medicare,
        payload: false
      }

      setTimeout(() => {
        expect(this.testCase.mutations[0]).toEqual(expectedMutation)
        done()
      }, 100)
    })
    it('should get patient data without premed check', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: [
            {
              p_m_ins_type: '1',
              premedcheck: '0',
              premed: 'foo',
              alert_text: 'alert',
              display_alert: true,
              firstname: 'John',
              lastname: 'Doe'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.headerTitle]: 'My title\n',
        [symbols.state.userInfo]: {
          docId: 2
        }
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      setTimeout(() => {
        expect(this.testCase.mutations.length).toBe(5)
        done()
      }, 100)
    })
    it('should get patient data without data', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: []
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.headerTitle]: 'My title\n',
        [symbols.state.userInfo]: {
          docId: 2
        }
      })

      MainModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual([])
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.sandbox.stub(http, 'post').callsFake(() => {
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

  describe('healthHistoryForPatient action', () => {
    it('should get health history with allergen', function (done) {
      const patientId = 1
      this.testCase.setState({
        [symbols.state.headerTitle]: 'My title\n'
      })
      const postData = []
      const result = {
        data: {
          data: [
            {
              allergenscheck: 1,
              other_allergens: 'foo, bar'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.healthHistoryForPatient](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.allergen,
            payload: 1
          },
          {
            type: symbols.mutations.headerTitle,
            payload: 'My title\nAllergens: foo, bar'
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.healthHistories.withFilter,
            payload: {
              fields: ['other_allergens', 'allergenscheck'],
              where: { patientid: patientId }
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should get health history without allergen', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: [
            {
              allergenscheck: 0,
              other_allergens: 'foo, bar'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.healthHistoryForPatient](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.allergen,
            payload: 0
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('should get health history without data', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: []
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.healthHistoryForPatient](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = []
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.healthHistoryForPatient](this.testCase.mocks, patientId)

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getHealthHistoryByPatientId',
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

  describe('incompleteHomeSleepTests action', () => {
    it('should get incomplete HSTs', function (done) {
      const patientId = 1
      const postData = []
      const result = {
        data: {
          data: [
            {
              status: 1
            },
            {
              status: 2
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.incompleteHomeSleepTests](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.incompleteHomeSleepTests,
            payload: [
              {
                status: 1
              },
              {
                status: 2
              }
            ]
          },
          {
            type: symbols.mutations.patientHomeSleepTestStatus,
            payload: 'Scheduled'
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.homeSleepTests.incomplete,
            payload: {
              patientId: patientId
            }
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should get incomplete HSTs with bad status', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: [
            {
              status: 1
            },
            {
              status: 99
            }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.incompleteHomeSleepTests](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.incompleteHomeSleepTests,
            payload: [
              {
                status: 1
              },
              {
                status: 99
              }
            ]
          },
          {
            type: symbols.mutations.patientHomeSleepTestStatus,
            payload: ''
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('should get incomplete HSTs without data', function (done) {
      const patientId = 1
      const result = {
        data: {
          data: []
        }
      }
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.resolve(result)
      })

      MainModule.actions[symbols.actions.incompleteHomeSleepTests](this.testCase.mocks, patientId)

      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.incompleteHomeSleepTests,
            payload: []
          },
          {
            type: symbols.mutations.patientHomeSleepTestStatus,
            payload: ''
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
      })

      MainModule.actions[symbols.actions.incompleteHomeSleepTests](this.testCase.mocks, patientId)

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getIncompleteHomeSleepTests',
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
})
