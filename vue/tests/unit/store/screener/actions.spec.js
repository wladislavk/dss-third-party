import axios from 'axios'
import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/StoreTestCase'
import ScreenerModule from '../../../../src/store/screener'

describe('Screener module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('getDoctorData action', () => {
    it('should set doctor data', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        response: {
          first_name: 'John'
        }
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

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.users.show + '/1' }
        ]
        expect(this.testCase.postData).toEqual(expectedHttp)
        done()
      })
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
      this.testCase.stubRequest({
        method: 'post'
      })

      ScreenerModule.actions[symbols.actions.submitScreener](this.testCase.mocks)

      this.testCase.wait(() => {
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
        expect(this.testCase.postData).toEqual(expectedPost)
        done()
      })
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
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({
        method: 'get',
        response: response
      })
      this.testCase.setState({
        token: 'token'
      })

      ScreenerModule.actions[symbols.actions.setEpworthProps](this.testCase.mocks)

      this.testCase.wait(() => {
        const expectedPost = [
          { path: endpoints.epworthSleepinessScale.index + '?status=1&order=sortby' }
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
        expect(this.testCase.postData).toEqual(expectedPost)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      })
    })
  })

  describe('submitHST action', () => {
    it('should submit home sleep request to API', function (done) {
      this.testCase.stubRequest({
        method: 'post'
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
      this.testCase.wait(() => {
        expect(this.testCase.postData).toEqual(expectedPost)
        done()
      })
    })
  })

  describe('authenticateScreener action', () => {
    beforeEach(function () {
      this.postData = []
      this.response = null
      this.testCase.sandbox.stub(axios, 'post').callsFake((path, payload) => {
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

      this.testCase.wait(() => {
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
      })
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

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual([])
        expect(outcome instanceof Error).toBe(true)
        expect(outcome.message).toBe('No token retrieved')
        done()
      })
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

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual([])
        expect(this.testCase.actions).toEqual([])
        expect(outcome instanceof Error).toBe(true)
        expect(outcome.message).toBe('Authentication failed')
        done()
      })
    })
  })

  describe('setSessionData action', () => {
    it('should set session data', function (done) {
      const response = {
        userid: 1,
        docid: 2
      }
      this.testCase.stubRequest({
        method: 'get',
        response: response
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

      this.testCase.wait(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.users.current }
        ]
        expect(this.testCase.postData).toEqual(expectedHttp)
        done()
      })
    })
    it('should throw error while setting session data', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 500
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
