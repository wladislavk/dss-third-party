import moxios from 'moxios'
import DeviceSelectorComponent from '../../../../../src/components/manage/modal/device-selector/DeviceSelector.vue'
import store from '../../../../../src/store'
import endpoints from '../../../../../src/endpoints'
import symbols from '../../../../../src/symbols'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceSelector component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.modal].params.patientName = ''

    this.testCase.setComponent(DeviceSelectorComponent)
    this.testCase.skipChildren(['deviceSlider'])

    this.testCase.stubRequest({
      url: endpoints.guideSettingOptions.settingIds,
      response: [
        {
          id: '1',
          name: 'foo',
          labels: ['first', 'second']
        },
        {
          id: '2',
          name: 'bar',
          labels: ['third', 'fourth']
        }
      ]
    })
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows device selector', function (done) {
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const deviceSelectorTitle = vm.$el.querySelector('h2#device-selector-title')
      const expectedTitle = 'Device C-Lect'
      expect(deviceSelectorTitle.textContent).toBe(expectedTitle)
      const form = vm.$el.querySelector('form#device_form')
      expect(form.childElementCount).toBe(2)
      done()
    })
  })

  it('shows device selector for patient', function (done) {
    store.state.main[symbols.state.modal].params.patientName = 'John'
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const deviceSelectorTitle = vm.$el.querySelector('h2#device-selector-title')
      const expectedTitle = 'Device C-Lect for John?'
      expect(deviceSelectorTitle.textContent).toBe(expectedTitle)
      done()
    })
  })

  it('shows and hides instructions', function (done) {
    const vm = this.testCase.mount()

    const instructionDiv = vm.$el.querySelector('div#instructions')
    expect(instructionDiv.style.display).toBe('none')
    const showLink = vm.$el.querySelector('a#ins_show')
    expect(showLink.style.display).toBe('')
    showLink.click()
    vm.$nextTick(() => {
      expect(instructionDiv.style.display).toBe('')
      expect(showLink.style.display).toBe('none')
      const hideLink = instructionDiv.querySelector('a')
      hideLink.click()
      vm.$nextTick(() => {
        expect(instructionDiv.style.display).toBe('none')
        expect(showLink.style.display).toBe('')
        done()
      })
    })
  })
})
