import DashboardModule from '../../../src/store/dashboard'
import symbols from '../../../src/symbols'

describe('Dashboard module mutations', () => {
  describe('documentCategories mutation', () => {
    it('sets document categories', function () {
      const state = {
        [symbols.state.documentCategories]: []
      }
      const data = [
        {
          categoryid: 1,
          name: 'foo',
          other: '0'
        },
        {
          categoryid: 2,
          name: 'bar',
          other: '1'
        }
      ]
      DashboardModule.mutations[symbols.mutations.documentCategories](state, data)
      const expectedState = {
        [symbols.state.documentCategories]: [
          {
            id: 1,
            name: 'foo'
          },
          {
            id: 2,
            name: 'bar'
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })
})
