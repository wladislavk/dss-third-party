import moxios from 'moxios'
import store from '../../../../../src/store'
import DeviceRowComponent from '../../../../../src/components/manage/chart/summary-rows/DeviceRow.vue'
import symbols from '../../../../../src/symbols'
import http from '../../../../../src/services/http'
import endpoints from '../../../../../src/endpoints'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceRow component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.flowsheet[symbols.state.devices] = [
      {
        id: 1,
        device: 'device 1'
      },
      {
        id: 2,
        device: 'device 2'
      },
      {
        id: 3,
        device: 'device 3'
      }
    ]

    const props = {
      patientId: 42,
      elementId: 1,
      deviceId: 2
    }

    this.testCase.setComponent(DeviceRowComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows devices', function () {
    const vm = this.testCase.mount()

    const selector = vm.$el
    expect(selector.id).toBe('dentaldevice_1')
    const options = selector.querySelectorAll('option')
    expect(options.length).toBe(4)
    expect(options[1].getAttribute('value')).toBe('1')
    expect(options[1].innerText).toBe('device 1')
    expect(selector.value).toBe('2')
  })

  it('shows devices with default', function (done) {
    store.state.flowsheet[symbols.state.devices] = [
      {
        id: 1,
        device: 'device 1'
      },
      {
        id: 2,
        device: 'device 2'
      },
      {
        id: 3,
        device: 'device 3',
        default: true
      }
    ]
    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const selector = vm.$el
      expect(selector.value).toBe('3')
      done()
    })
  })

  it('updates device', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = '1'
    selector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.config.data).not.toBeUndefined()
      const expectedData = {
        device_id: '1'
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      done()
    })
  })

  it('updates to empty data', function (done) {
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = ''
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      expect(moxios.requests.count()).toBe(0)
      done()
    })
  })
})
