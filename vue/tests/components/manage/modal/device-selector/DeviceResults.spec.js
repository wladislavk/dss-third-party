import sinon from 'sinon'
import moxios from 'moxios'
import symbols from '../../../../../src/symbols'
import DeviceResultsComponent from '../../../../../src/components/manage/modal/device-selector/DeviceResults.vue'
import store from '../../../../../src/store'
import Alerter from '../../../../../src/services/Alerter'
import endpoints from '../../../../../src/endpoints'
import http from '../../../../../src/services/http'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceResults component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    moxios.install()
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

    this.testCase.setComponent(DeviceResultsComponent)
  })

  afterEach(function () {
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('should show correct device results', function () {
    const props = {
      patientName: 'John'
    }
    this.testCase.setPropsData(props)
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
    const props = {
      patientName: ''
    }
    this.testCase.setPropsData(props)
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
    moxios.stubRequest(http.formUrl(endpoints.tmjClinicalExams.updateFlowDevice + '/' + 13), {
      status: 200,
      responseText: {
        message: 'foo'
      }
    })
    let alertText = ''
    let confirmText = ''
    this.sandbox.stub(Alerter, 'alert').callsFake((text) => {
      alertText = text
    })
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake((text) => {
      confirmText = text
      return true
    })
    const props = {
      patientName: 'John'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const firstLink = vm.$el.querySelector('div#device-results-div > ul > li:first-child > a')
    expect(firstLink).not.toBeNull()
    firstLink.click()
    moxios.wait(() => {
      expect(confirmText).toBe('Do you want to select SUAD Ultra Elite for John')
      expect(alertText).toBe('foo')
      done()
    })
  })

  it('should update device without confirmation', function (done) {
    let alertText = ''
    this.sandbox.stub(Alerter, 'alert').callsFake((text) => {
      alertText = text
    })
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })
    const props = {
      patientName: 'John'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const firstLink = vm.$el.querySelector('div#device-results-div > ul > li:first-child > a')
    firstLink.click()
    vm.$nextTick(() => {
      expect(alertText).toBe('')
      done()
    })
  })

  it('should retrieve device results', function (done) {
    store.commit(symbols.mutations.deviceGuideResults, [])
    moxios.stubRequest(http.formUrl(endpoints.guideDevices.withImages), {
      status: 200,
      responseText: {
        data: this.fakeData
      }
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
