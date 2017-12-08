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

  describe('has resetDeviceGuideSettingOptions mutation', () => {
    it('which resets device guide setting options', function () {
      const state = {
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 3,
            impression: 1,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            setting_type: 0,
            number: 3
          },
          {
            id: 3,
            checkedOption: 2,
            impression: 0,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            setting_type: 0,
            number: 5
          }
        ]
      }

      DashboardModule.mutations[symbols.mutations.resetDeviceGuideSettingOptions](state)

      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 0,
            impression: 0,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            setting_type: 0,
            number: 3
          },
          {
            id: 3,
            checkedOption: 0,
            impression: 0,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            setting_type: 0,
            number: 5
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('has updateGuideSetting mutation', () => {
    it('which updates guide setting', function () {
      const state = {
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 0,
            impression: 0,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            setting_type: 0,
            number: 3
          },
          {
            id: 3,
            checkedOption: 0,
            impression: 0,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            setting_type: 0,
            number: 5
          }
        ]
      }

      const data = {
        id: 13,
        values: {
          impression: 1,
          checkedOption: 1
        }
      }
      DashboardModule.mutations[symbols.mutations.updateGuideSetting](state, data)

      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 1,
            impression: 1,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            setting_type: 0,
            number: 3
          },
          {
            id: 3,
            checkedOption: 0,
            impression: 0,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            setting_type: 0,
            number: 5
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })
})
