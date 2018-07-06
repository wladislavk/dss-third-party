import store from '../../../../src/store'
import ImpressionDeviceComponent from '../../../../src/components/manage/modal/ImpressionDevice.vue'
import symbols from '../../../../src/symbols'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('ImpressionDevice component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.flowsheet[symbols.state.devices] = []
    store.state.patients[symbols.state.patientId] = 42
    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.impressionDevice,
      params: {
        patientId: 42,
        flowId: 1
      }
    }

    this.testCase.setComponent(ImpressionDeviceComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows devices', function (done) {
    this.testCase.stubRequest({
      url: endpoints.devices.byStatus,
      response: [
        {
          deviceid: '1',
          device: 'first'
        },
        {
          deviceid: '2',
          device: 'second'
        }
      ]
    })
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What device will you make for John Doe?')
    const helpMeLink = vm.$el.querySelector('a')
    expect(helpMeLink.getAttribute('href')).toContain('manage/device_guide.php?pid=42&id=1')
    let deviceOptions = vm.$el.querySelectorAll('option')
    expect(deviceOptions.length).toBe(1)
    this.testCase.wait(() => {
      deviceOptions = vm.$el.querySelectorAll('option')
      expect(deviceOptions.length).toBe(3)
      const firstDevice = deviceOptions[1]
      expect(firstDevice.getAttribute('value')).toBe('1')
      expect(firstDevice.textContent).toBe('first')
      done()
    })
  })

  it('selects a device', function (done) {
    this.testCase.stubRequest({
      url: endpoints.devices.byStatus,
      response: [
        {
          deviceid: '2',
          device: 'first'
        },
        {
          deviceid: '3',
          device: 'second'
        }
      ]
    })
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.update + '/1'
    })
    this.testCase.stubRequest({
      url: endpoints.tmjClinicalExams.storeForPatient
    })
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const deviceSelect = vm.$el.querySelector('select')
      deviceSelect.value = '2'
      deviceSelect.dispatchEvent(new Event('change'))
      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        const submitButton = vm.$el.querySelector('input')
        submitButton.click()
        this.testCase.waitForRequest = true
        this.testCase.wait(() => {
          const requestResults = this.testCase.getRequestResults()
          expect(requestResults.length).toBe(4)
          const expectedSecond = {
            url: endpoints.appointmentSummaries.update + '/1',
            body: {
              device_id: 2
            }
          }
          expect(requestResults[1]).toEqual(expectedSecond)
          const expectedFourth = {
            url: endpoints.tmjClinicalExams.storeForPatient,
            body: {
              dentaldevice: 2,
              patientid: 42
            }
          }
          expect(requestResults[3]).toEqual(expectedFourth)

          const expectedModal = {
            name: '',
            params: {}
          }
          expect(store.state.main[symbols.state.modal]).toEqual(expectedModal)
          done()
        })
      })
    })
  })
})
