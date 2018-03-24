import axios from 'axios'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import sinon from 'sinon'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/StoreTestCase'
import ScreenerModule from '../../../../src/store/screener'

describe('Screener module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('getDoctorData action', () => {
    it('should set doctor data', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            first_name: 'John'
          }
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token',
        [symbols.state.sessionData]: {
          docId: 1
        }
      })

      ScreenerModule.actions[symbols.actions.getDoctorData](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.doctorName,
          payload: 'John'
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
  })

  describe('getCompanyData action', () => {
    it('should set company data', function (done) {
      const postData = []
      const payload = [
        {
          id: 1,
          name: 'first'
        },
        {
          id: 2,
          name: 'second'
        }
      ]
      const result = {
        data: {
          data: payload
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token'
      })

      ScreenerModule.actions[symbols.actions.getCompanyData](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.companyData,
          payload: payload
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.companies.homeSleepTest
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
  })

  describe('submitScreener action', () => {
    it('should submit screener data', function (done) {
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token',
        [symbols.state.sessionData]: {
          docId: 1,
          userId: 2
        },
        [symbols.state.contactData]: [
          {
            camelName: 'firstName',
            value: 'John'
          },
          {
            camelName: 'lastName',
            value: 'Doe'
          },
          {
            camelName: 'phone',
            value: '2233223223'
          }
        ],
        [symbols.state.epworthProps]: [
          {
            id: 'epworth1',
            value: 1
          },
          {
            id: 'epworth2',
            value: 2
          }
        ],
        [symbols.state.symptoms]: [
          {
            name: 'symptom1',
            selected: 1
          },
          {
            name: 'symptom2',
            selected: 2
          }
        ],
        [symbols.state.coMorbidityData]: [
          {
            name: 'coMorbidity1',
            weight: 2,
            checked: true
          },
          {
            name: 'coMorbidity2',
            weight: 3,
            checked: false
          }
        ],
        [symbols.state.cpap]: {
          selected: 3
        }
      })
      const postData = []
      this.sandbox.stub(http, 'request').callsFake((method, path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
      })
      ScreenerModule.actions[symbols.actions.submitScreener](this.testCase.mocks)
      setTimeout(() => {
        const expectedPost = [
          {
            path: endpoints.screeners.store,
            payload: {
              docid: 1,
              userid: 2,
              rx_cpap: 3,
              epworth: [
                {
                  id: 'epworth1',
                  value: 1
                },
                {
                  id: 'epworth2',
                  value: 2
                }
              ],
              first_name: 'John',
              last_name: 'Doe',
              phone: '2233223223',
              symptom1: 1,
              symptom2: 2,
              coMorbidity1: 2,
              coMorbidity2: 0
            }
          }
        ]
        expect(postData).toEqual(expectedPost)
        done()
      }, 100)
    })
  })

  describe('parseScreenerResults action', () => {
    it('should parse screener results', function () {
      this.testCase.setState({
        [symbols.state.epworthProps]: [
          {
            id: 1,
            selected: '2'
          },
          {
            id: 2,
            selected: '3'
          }
        ],
        [symbols.state.coMorbidityData]: [
          {
            id: 1,
            weight: '2',
            checked: false
          },
          {
            id: 2,
            weight: '3',
            checked: true
          },
          {
            id: 3,
            weight: '4',
            checked: true
          }
        ],
        [symbols.state.cpap]: {
          weight: '4',
          selected: true
        },
        [symbols.state.symptoms]: [
          {
            id: 1,
            selected: '4'
          },
          {
            id: 2,
            selected: '5'
          },
          {
            id: 3,
            selected: ''
          }
        ]
      })
      const payload = {
        id: 1
      }
      ScreenerModule.actions[symbols.actions.parseScreenerResults](this.testCase.mocks, payload)
      const expectedMutations = [
        {
          type: symbols.mutations.screenerId,
          payload: 1
        },
        {
          type: symbols.mutations.epworthWeight,
          payload: 5
        },
        {
          type: symbols.mutations.coMorbidityWeight,
          payload: 11
        },
        {
          type: symbols.mutations.surveyWeight,
          payload: 9
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })

  describe('setEpworthProps action', () => {
    it('should set epworth props', function (done) {
      const postData = []
      const result = {
        data: {
          data: [
            {
              id: 1
            },
            {
              id: 2
            }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      this.testCase.setState({
        token: 'token'
      })
      ScreenerModule.actions[symbols.actions.setEpworthProps](this.testCase.mocks)
      setTimeout(() => {
        const expectedPost = [
          {
            path: endpoints.epworthSleepinessScale.index + '?status=1&order=sortby'
          }
        ]
        const expectedMutations = [
          {
            type: symbols.mutations.setEpworthProps,
            payload: [
              {
                id: 1,
                selected: '',
                error: false
              },
              {
                id: 2,
                selected: '',
                error: false
              }
            ]
          }
        ]
        expect(postData).toEqual(expectedPost)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
  })

  describe('submitHST action', () => {
    it('should submit home sleep request to API', function (done) {
      const postData = []
      this.sandbox.stub(http, 'request').callsFake((method, path, payload) => {
        postData.push({
          path: path,
          payload: payload
        })
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token',
        [symbols.state.screenerId]: 1,
        [symbols.state.sessionData]: {
          docId: 3,
          userId: 4
        }
      })
      const payload = {
        companyId: 2,
        contactData: [
          {
            camelName: 'firstName',
            value: 'John'
          },
          {
            camelName: 'lastName',
            value: 'Doe'
          },
          {
            camelName: 'phone',
            value: '2233223223'
          }
        ]
      }
      ScreenerModule.actions[symbols.actions.submitHst](this.testCase.mocks, payload)
      const expectedPost = [
        {
          path: endpoints.homeSleepTests.store,
          payload: {
            screener_id: 1,
            doc_id: 3,
            user_id: 4,
            company_id: 2,
            patient_firstname: 'John',
            patient_lastname: 'Doe',
            patient_cell_phone: '2233223223',
            patient_email: '',
            patient_dob: ''
          }
        }
      ]
      setTimeout(() => {
        expect(postData).toEqual(expectedPost)
        done()
      }, 100)
    })
  })

  describe('authenticateScreener action', () => {
    beforeEach(function () {
      this.postData = []
      this.response = null
      this.sandbox.stub(axios, 'post').callsFake((path, payload) => {
        this.postData.push({
          path: path,
          payload: payload
        })
        return this.response
      })
    })
    it('should authenticate screener', function (done) {
      this.response = Promise.resolve({
        data: {
          token: 'token'
        }
      })
      const payload = {
        foo: 'bar'
      }
      let outcome
      const promise = ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, payload)
      promise.then(
        (response) => {
          outcome = response
        },
        (error) => {
          outcome = error
        }
      )
      setTimeout(() => {
        const expectedMutations = [
          {
            type: symbols.mutations.screenerToken,
            payload: 'token'
          }
        ]
        const expectedActions = [
          {
            type: symbols.actions.setSessionData,
            payload: {}
          }
        ]
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.actions).toEqual(expectedActions)
        const expectedPostData = [
          {
            path: 'http://api/auth',
            payload: {
              foo: 'bar'
            }
          }
        ]
        expect(this.postData).toEqual(expectedPostData)
        expect(outcome instanceof Error).toBe(false)
        done()
      }, 100)
    })
    it('should handle token retrieval failure', function (done) {
      this.response = Promise.resolve({
        data: {
          foo: 'bar'
        }
      })
      let outcome
      const promise = ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, {})
      promise.then(
        (response) => {
          outcome = response
        },
        (error) => {
          outcome = error
        }
      )
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual([])
        expect(outcome instanceof Error).toBe(true)
        expect(outcome.message).toBe('No token retrieved')
        done()
      }, 100)
    })
    it('should handle authentication failure', function (done) {
      this.response = Promise.reject(new Error())
      let outcome
      const promise = ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, {})
      promise.then(
        (response) => {
          outcome = response
        },
        (error) => {
          outcome = error
        }
      )
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual([])
        expect(outcome instanceof Error).toBe(true)
        expect(outcome.message).toBe('Authentication failed')
        done()
      }, 100)
    })
  })

  describe('setSessionData action', () => {
    it('should set session data', function (done) {
      const postData = []
      const result = {
        data: {
          data: {
            userid: 1,
            docid: 2
          }
        }
      }
      this.sandbox.stub(http, 'request').callsFake((method, path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token'
      })

      const expectedMutations = [
        {
          type: symbols.mutations.sessionData,
          payload: {
            userId: 1,
            docId: 2
          }
        }
      ]

      ScreenerModule.actions[symbols.actions.setSessionData](this.testCase.mocks)

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
    it('should throw error while setting session data', function (done) {
      const postData = []
      this.sandbox.stub(http, 'request').callsFake((method, path) => {
        postData.push({
          path: path
        })
        return Promise.reject(new Error())
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token'
      })

      const promise = ScreenerModule.actions[symbols.actions.setSessionData](this.testCase.mocks)
      promise.then(() => {
        fail('Exception should happen')
      }).catch((error) => {
        expect(error.message).toBe('No user ID retrieved')
        done()
      })
    })
  })
})
