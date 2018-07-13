import store from '../../../../../src/store'
import DeviceRowComponent from '../../../../../src/components/manage/chart/summary-rows/DeviceRow.vue'
import symbols from '../../../../../src/symbols'
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

    this.testCase.wait(() => {
      const selector = vm.$el
      expect(selector.value).toBe('3')
      done()
    })
  })

  it('updates device', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.update + '/1'
    })
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = '1'
    selector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(2)
      const firstRequest = requestResults[0]
      expect(firstRequest.hasOwnProperty('body')).toBe(true)
      const expectedData = {
        device_id: '1'
      }
      expect(firstRequest.body).toEqual(expectedData)
      done()
    })
  })

  it('updates to empty data', function (done) {
    const vm = this.testCase.mount()

    const selector = vm.$el
    selector.value = ''
    selector.dispatchEvent(new Event('change'))
    this.testCase.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(0)
      done()
    })
  })
})
