import symbols from '../../../../src/symbols'
import ScreenerModule from '../../../../src/store/screener'

describe('Screener module mutations', () => {
  describe('restoreInitialScreener mutation', () => {
    it('should restore initial state', function () {
      const state = {
        [symbols.state.sessionData]: {
          docId: 1,
          userId: 2
        },
        [symbols.state.screenerToken]: 'token',
        [symbols.state.doctorName]: 'John',
        [symbols.state.showFancybox]: true
      }
      ScreenerModule.mutations[symbols.mutations.restoreInitialScreener](state)
      const expectedSession = {
        docId: 0,
        userId: 0
      }
      expect(state[symbols.state.sessionData]).toEqual(expectedSession)
      expect(state[symbols.state.screenerToken]).toBe('')
      expect(state[symbols.state.doctorName]).toBe('')
      expect(state[symbols.state.showFancybox]).toBe(false)
    })
  })

  describe('restoreInitialScreenerKeepSession mutation', () => {
    it('should restore initial state and keep session data', function () {
      const state = {
        [symbols.state.sessionData]: {
          docId: 1,
          userId: 2
        },
        [symbols.state.screenerToken]: 'token',
        [symbols.state.doctorName]: 'John',
        [symbols.state.showFancybox]: true
      }
      ScreenerModule.mutations[symbols.mutations.restoreInitialScreenerKeepSession](state)
      const expectedSession = {
        docId: 1,
        userId: 2
      }
      expect(state[symbols.state.sessionData]).toEqual(expectedSession)
      expect(state[symbols.state.screenerToken]).toBe('token')
      expect(state[symbols.state.doctorName]).toBe('')
      expect(state[symbols.state.showFancybox]).toBe(false)
    })
  })

  describe('contactData mutation', () => {
    it('should modify contact data', function () {
      const state = {
        [symbols.state.contactData]: [
          {
            name: 'name1',
            value: 'value1'
          },
          {
            name: 'name2',
            value: 'value2'
          }
        ],
        [symbols.state.storedContactData]: {
          name1: 'new value1',
          name3: 'new value3'
        }
      }
      ScreenerModule.mutations[symbols.mutations.contactData](state)
      const expectedContacts = [
        {
          name: 'name1',
          value: 'new value1'
        },
        {
          name: 'name2',
          value: 'value2'
        }
      ]
      expect(state[symbols.state.contactData]).toEqual(expectedContacts)
    })
  })

  describe('setEpworthErrors mutation', () => {
    it('sets epworth errors', function () {
      const state = {
        [symbols.state.epworthProps]: [
          {
            epworth: 'foo',
            error: false
          },
          {
            epworth: 'bar',
            error: false
          }
        ]
      }
      const errors = ['foo', 'baz']
      ScreenerModule.mutations[symbols.mutations.setEpworthErrors](state, errors)
      const expectedState = {
        [symbols.state.epworthProps]: [
          {
            epworth: 'foo',
            error: true
          },
          {
            epworth: 'bar',
            error: false
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('modifyEpworthProps mutation', () => {
    it('should modify epworth props', function () {
      const state = {
        [symbols.state.epworthProps]: [
          {
            epworthid: 1,
            selected: 0
          },
          {
            epworthid: 2,
            selected: 0
          }
        ]
      }
      const storedProps = {
        1: 1,
        3: 2
      }
      ScreenerModule.mutations[symbols.mutations.modifyEpworthProps](state, storedProps)
      const expectedState = {
        [symbols.state.epworthProps]: [
          {
            epworthid: 1,
            error: false,
            selected: 1
          },
          {
            epworthid: 2,
            error: false,
            selected: 0
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('symptoms mutation', () => {
    it('should modify symptoms', function () {
      const state = {
        [symbols.state.symptoms]: [
          {
            name: 'name1',
            selected: 0
          },
          {
            name: 'name2',
            selected: 0
          }
        ],
        [symbols.state.storedSymptoms]: {
          name1: 1,
          name3: 2
        }
      }
      ScreenerModule.mutations[symbols.mutations.symptoms](state)
      const expectedSymptoms = [
        {
          name: 'name1',
          selected: 1
        },
        {
          name: 'name2',
          selected: 0
        }
      ]
      expect(state[symbols.state.symptoms]).toEqual(expectedSymptoms)
    })
  })

  describe('coMorbidity mutation', () => {
    it('should modify co-morbidity', function () {
      const state = {
        [symbols.state.coMorbidityData]: [
          {
            name: 'name1',
            checked: 0
          },
          {
            name: 'name2',
            checked: 0
          }
        ]
      }
      const storedCoMorbidity = {
        name1: 1,
        name3: 2
      }
      ScreenerModule.mutations[symbols.mutations.coMorbidity](state, storedCoMorbidity)
      const expectedState = {
        [symbols.state.coMorbidityData]: [
          {
            name: 'name1',
            checked: 1
          },
          {
            name: 'name2',
            checked: 0
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('cpap mutation', () => {
    it('sets cpap', function () {
      const state = {
        [symbols.state.cpap]: {
          selected: 0
        },
        [symbols.state.storedCpap]: 4
      }
      ScreenerModule.mutations[symbols.mutations.cpap](state)
      const expectedCpap = {selected: 4}
      expect(state[symbols.state.cpap]).toEqual(expectedCpap)
    })
  })
})
