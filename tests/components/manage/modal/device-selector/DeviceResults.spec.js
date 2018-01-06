import Vue from 'vue'
import sinon from 'sinon'
import moxios from 'moxios'
import symbols from '../../../../../src/symbols'
import DeviceResultsComponent from '../../../../../src/components/manage/modal/device-selector/DeviceResults.vue'
import store from '../../../../../src/store'
import Alerter from '../../../../../src/services/Alerter'
import endpoints from '../../../../../src/endpoints'
import http from '../../../../../src/services/http'

describe('DeviceResults component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    moxios.install()
    const fakeData = [
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
    store.commit(symbols.mutations.deviceGuideResults, fakeData)

    const Component = Vue.extend(DeviceResultsComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('should show correct device results', function () {
    const vm = this.mount({
      patientName: 'John'
    })
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
    const vm = this.mount({
      patientName: ''
    })
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
    const vm = this.mount({
      patientName: 'John'
    })
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
    const vm = this.mount({
      patientName: 'John'
    })
    const firstLink = vm.$el.querySelector('div#device-results-div > ul > li:first-child > a')
    firstLink.click()
    vm.$nextTick(() => {
      expect(alertText).toBe('')
      done()
    })
  })

  it('should reset device results', function (done) {
    const vm = this.mount({})
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
