import moxios from 'moxios'
import symbols from '../../../../../src/symbols'
import DeviceResultsComponent from '../../../../../src/components/manage/modal/device-selector/DeviceResults.vue'
import store from '../../../../../src/store'
import endpoints from '../../../../../src/endpoints'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceResults component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.fakeData = [
      {
        name: 'SUAD Ultra Elite',
        id: 13,
        value: 34,
        image_path: 'dummy.jpg'
      },
      {
        name: 'SUAD Hard',
        id: 14,
        value: 33,
        image_path: ''
      }
    ]
    store.commit(symbols.mutations.deviceGuideResults, this.fakeData)

    this.props = {
      patientName: 'John'
    }

    this.testCase.setComponent(DeviceResultsComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should show correct device results', function () {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
    expect(deviceResultsItems.length).toBe(2)
    const firstResult = deviceResultsItems[0]
    const secondResult = deviceResultsItems[1]
    expect(firstResult.className).toBe('box_go')
    expect(secondResult.className).toBe('')
    const firstLink = firstResult.querySelector('a')
    expect(firstLink).not.toBeNull()
    expect(firstLink.textContent).toBe('SUAD Ultra Elite (34)')
    const firstSpan = firstResult.querySelector('span')
    expect(firstSpan).toBeNull()
  })

  it('should show device results without patient', function () {
    this.props.patientName = ''
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
    expect(deviceResultsItems.length).toBe(2)
    const firstResult = deviceResultsItems[0]
    const firstLink = firstResult.querySelector('a')
    expect(firstLink).toBeNull()
    const firstSpan = firstResult.querySelector('span')
    expect(firstSpan).not.toBeNull()
    expect(firstSpan.textContent).toBe('SUAD Ultra Elite (34)')
  })

  it('should update device', function (done) {
    this.testCase.stubRequest({
      url: endpoints.tmjClinicalExams.updateFlowDevice + '/' + 13,
      dataKey: 'message',
      response: 'foo'
    })
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const firstLink = vm.$el.querySelector('div#device-results-div > ul > li:first-child > a')
    expect(firstLink).not.toBeNull()
    firstLink.click()
    moxios.wait(() => {
      expect(this.testCase.confirmText).toBe('Do you want to select SUAD Ultra Elite for John')
      expect(this.testCase.alertText).toBe('foo')
      done()
    })
  })

  it('should update device without confirmation', function (done) {
    this.testCase.confirmDialog = false
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const firstLink = vm.$el.querySelector('div#device-results-div > ul > li:first-child > a')
    firstLink.click()
    vm.$nextTick(() => {
      expect(this.testCase.alertText).toBe('')
      done()
    })
  })

  it('should retrieve device results', function (done) {
    store.commit(symbols.mutations.deviceGuideResults, [])
    this.testCase.stubRequest({
      url: endpoints.guideDevices.withImages,
      response: this.fakeData
    })
    const vm = this.testCase.mount()

    const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
    expect(deviceResultsItems.length).toBe(0)
    const sortDevicesButton = vm.$el.querySelector('div#sort-devices-button > a')
    sortDevicesButton.click()
    moxios.wait(() => {
      const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
      expect(deviceResultsItems.length).toBe(2)
      done()
    })
  })

  it('should reset device results', function (done) {
    const vm = this.testCase.mount()

    const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
    expect(deviceResultsItems.length).toBe(2)
    const resetLink = vm.$el.querySelector('a#reset-link')
    expect(resetLink).not.toBeNull()
    resetLink.click()
    vm.$nextTick(() => {
      const deviceResultsItems = vm.$el.querySelectorAll('div#device-results-div > ul > li')
      expect(deviceResultsItems.length).toBe(0)
      done()
    })
  })
})
