import DeviceSliderComponent from '../../../../../src/components/manage/modal/device-selector/DeviceSlider.vue'
import store from '../../../../../src/store'
import symbols from '../../../../../src/symbols'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceSlider component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      id: 13,
      name: 'Comfort',
      labels: ['Not Important', 'Neutral', 'Very Important'],
      checkedOption: 1,
      checked: false
    }
    store.state.dashboard[symbols.state.deviceGuideSettingOptions] = [this.props]

    this.testCase.setComponent(DeviceSliderComponent)
    this.testCase.setChildComponents(['vue-slider'])
    this.testCase.setPropsData(this.props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows device settings', function () {
    const vm = this.testCase.mount()

    const rootDiv = vm.$el
    expect(rootDiv.id).toBe('setting_13')
    const header = rootDiv.querySelector('strong.device-guide-setting-name')
    expect(header.textContent).toBe('Comfort')
    const label = rootDiv.querySelector('div.label')
    expect(label.textContent).toBe('Neutral')
  })

  it('changes label when the slider is moved', function (done) {
    store.state.dashboard[symbols.state.deviceGuideResults] = ['foo', 'bar']
    const vm = this.testCase.mount()

    const newValue = 'Very Important'
    vm.moveSlider(newValue)
    vm.$nextTick(() => {
      // we cannot use HTML because it gets refreshed during the re-rendering of the parent component
      expect(store.state.dashboard[symbols.state.deviceGuideSettingOptions][0].checkedOption).toBe(2)
      expect(store.state.dashboard[symbols.state.deviceGuideResults]).toEqual([])
      done()
    })
  })

  it('resets results when the checkbox is clicked', function (done) {
    store.state.dashboard[symbols.state.deviceGuideSettingOptions] = [this.props]
    store.state.dashboard[symbols.state.deviceGuideResults] = ['foo', 'bar']
    const vm = this.testCase.mount()

    const checkbox = vm.$el.querySelector('input.imp_chk')
    checkbox.checked = true
    const changeEvent = new Event('change')
    checkbox.dispatchEvent(changeEvent)
    vm.$nextTick(() => {
      expect(store.state.dashboard[symbols.state.deviceGuideResults]).toEqual([])
      expect(store.state.dashboard[symbols.state.deviceGuideSettingOptions][0].checked).toBe(true)
      checkbox.checked = false
      checkbox.dispatchEvent(changeEvent)
      vm.$nextTick(() => {
        expect(store.state.dashboard[symbols.state.deviceGuideSettingOptions][0].checked).toBe(false)
        done()
      })
    })
  })
})
