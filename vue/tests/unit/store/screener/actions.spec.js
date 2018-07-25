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
      const docId = 1
      const firstName = 'John'
      this.testCase.stubRequest({
        response: {
          first_name: firstName
        }
      })
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token',
        [symbols.state.sessionData]: {
          docId: docId
        }
      })

      ScreenerModule.actions[symbols.actions.getDoctorData](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.show + '/' + docId },
          mutations: [
            {
              type: symbols.mutations.doctorName,
              payload: firstName
            }
          ],
          actions: []
        })
        done()
      })
    })
  })

  describe('submitScreener action', () => {
    it('should submit screener data', function (done) {
      const epworthProps = [
        {
          id: 'epworth1',
          value: 1
        },
        {
          id: 'epworth2',
          value: 2
        }
      ]

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
        [symbols.state.epworthProps]: epworthProps,
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
      this.testCase.stubRequest({})

      ScreenerModule.actions[symbols.actions.submitScreener](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: endpoints.screeners.store,
            payload: {
              docid: 1,
              userid: 2,
              rx_cpap: 3,
              epworth: epworthProps,
              first_name: 'John',
              last_name: 'Doe',
              phone: '2233223223',
              symptom1: 1,
              symptom2: 2,
              coMorbidity1: 2,
              coMorbidity2: 0
            }
          },
          mutations: [],
          actions: []
        })
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

      expect(this.testCase.getResults()).toEqual({
        http: {},
        mutations: [
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
        ],
        actions: []
      })
    })
  })

  describe('setEpworthProps action', () => {
    it('should set epworth props', function (done) {
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({response: response})
      this.testCase.setState({
        token: 'token'
      })

      ScreenerModule.actions[symbols.actions.setEpworthProps](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.epworthSleepinessScale.index + '?status=1&order=sortby' },
          mutations: [
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
          ],
          actions: []
        })
        done()
      })
    })
  })

  describe('submitHST action', () => {
    it('should submit home sleep request to API', function (done) {
      this.testCase.stubRequest({})
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

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
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
          },
          mutations: [],
          actions: []
        })
        done()
      })
    })
  })

  describe('authenticateScreener action', () => {
    beforeEach(function () {
      this.setOutcome = function (promise) {
        promise.then((response) => {
          this.outcome = response
        }).catch((error) => {
          this.outcome = error
        })
      }
      this.expectedUrl = 'http://api/auth'
    })
    it('should authenticate screener', function (done) {
      this.testCase.stubRawRequest({
        response: {
          data: {
            token: 'token'
          }
        }
      })
      const payload = {
        foo: 'bar'
      }

      this.setOutcome(ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, payload))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: this.expectedUrl,
            payload: payload
          },
          mutations: [
            {
              type: symbols.mutations.screenerToken,
              payload: 'token'
            }
          ],
          actions: [
            {
              type: symbols.actions.setSessionData,
              payload: {}
            }
          ]
        })
        expect(this.outcome instanceof Error).toBe(false)
        done()
      })
    })
    it('should handle token retrieval failure', function (done) {
      this.testCase.stubRawRequest({
        response: {
          data: {
            foo: 'bar'
          }
        }
      })

      this.setOutcome(ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, {}))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: this.expectedUrl,
            payload: {}
          },
          mutations: [],
          actions: []
        })
        expect(this.outcome instanceof Error).toBe(true)
        expect(this.outcome.message).toBe('No token retrieved')
        done()
      })
    })
    it('should handle authentication failure', function (done) {
      this.testCase.stubRawRequest({error: ''})

      this.setOutcome(ScreenerModule.actions[symbols.actions.authenticateScreener](this.testCase.mocks, {}))

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: {
            path: this.expectedUrl,
            payload: {}
          },
          mutations: [],
          actions: []
        })
        expect(this.outcome instanceof Error).toBe(true)
        expect(this.outcome.message).toBe('Authentication failed')
        done()
      })
    })
  })

  describe('setSessionData action', () => {
    beforeEach(function () {
      this.testCase.setState({
        [symbols.state.screenerToken]: 'token'
      })
    })
    it('should set session data', function (done) {
      const response = {
        userid: 1,
        docid: 2
      }
      this.testCase.stubRequest({response: response})

      ScreenerModule.actions[symbols.actions.setSessionData](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.current },
          mutations: [
            {
              type: symbols.mutations.sessionData,
              payload: {
                userId: 1,
                docId: 2
              }
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('should throw error while setting session data', function (done) {
      this.testCase.stubErrorRequest()

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
