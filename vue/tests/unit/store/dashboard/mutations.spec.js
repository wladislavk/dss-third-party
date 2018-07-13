import DashboardModule from '../../../../src/store/dashboard'
import symbols from '../../../../src/symbols'

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

  describe('deviceGuideSettingOptions mutation', () => {
    it('sets device guide setting options', function () {
      const state = {
        [symbols.state.deviceGuideSettingOptions]: []
      }
      const data = [
        {
          id: '1',
          name: 'foo',
          labels: ['label 1', 'label 2']
        },
        {
          id: '2',
          name: 'bar',
          labels: ['label 3', 'label 4']
        }
      ]
      DashboardModule.mutations[symbols.mutations.deviceGuideSettingOptions](state, data)
      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 1,
            name: 'foo',
            labels: ['label 1', 'label 2'],
            checkedOption: 0,
            checked: false
          },
          {
            id: 2,
            name: 'bar',
            labels: ['label 3', 'label 4'],
            checkedOption: 0,
            checked: false
          }
        ]
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('resetDeviceGuideSettingOptions mutation', () => {
    it('resets device guide setting options', function () {
      const data = [
        {
          id: 13,
          checkedOption: 3,
          checked: true,
          labels: ['Not Important', 'Neutral', 'Very Important'],
          name: 'Comfort',
          number: 3
        },
        {
          id: 3,
          checkedOption: 2,
          checked: false,
          labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
          name: 'Bruxism',
          number: 5
        }
      ]
      const state = {
        [symbols.state.deviceGuideSettingOptions]: data
      }
      DashboardModule.mutations[symbols.mutations.resetDeviceGuideSettingOptions](state)
      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: data
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('checkGuideSetting mutation', () => {
    it('checks guide setting', function () {
      const initialData = [
        {
          id: 13,
          checkedOption: 0,
          checked: false,
          labels: ['Not Important', 'Neutral', 'Very Important'],
          name: 'Comfort',
          number: 3
        },
        {
          id: 3,
          checkedOption: 0,
          checked: false,
          labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
          name: 'Bruxism',
          number: 5
        }
      ]
      const state = {
        [symbols.state.deviceGuideSettingOptions]: initialData
      }
      const data = {
        id: 3,
        isChecked: true
      }
      DashboardModule.mutations[symbols.mutations.checkGuideSetting](state, data)
      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: initialData
      }
      expect(state).toEqual(expectedState)
    })
  })

  describe('moveGuideSettingSlider mutation', () => {
    it('moves slider', function () {
      const initialData = [
        {
          id: 13,
          checkedOption: 0,
          checked: false,
          labels: ['Not Important', 'Neutral', 'Very Important'],
          name: 'Comfort',
          number: 3
        },
        {
          id: 3,
          checkedOption: 0,
          checked: false,
          labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
          name: 'Bruxism',
          number: 5
        }
      ]
      const state = {
        [symbols.state.deviceGuideSettingOptions]: initialData
      }
      const data = {
        id: 3,
        value: 2
      }
      DashboardModule.mutations[symbols.mutations.moveGuideSettingSlider](state, data)
      const expectedState = {
        [symbols.state.deviceGuideSettingOptions]: initialData
      }
      expect(state).toEqual(expectedState)
    })
  })
})
