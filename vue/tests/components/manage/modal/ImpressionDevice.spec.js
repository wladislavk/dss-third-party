import moxios from 'moxios'
import store from '../../../../src/store'
import ImpressionDeviceComponent from '../../../../src/components/manage/modal/ImpressionDevice.vue'
import symbols from '../../../../src/symbols'
import http from 'src/services/http'
import endpoints from 'src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('ImpressionDevice component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
    moxios.install()

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
    store.state.patients[symbols.state.patientId] = 0
    store.state.patients[symbols.state.patientName] = ''
    store.state.flowsheet[symbols.state.devices] = []
    store.state.main[symbols.state.modal] = {
      name: '',
      params: {}
    }

    moxios.uninstall()
  })

  it('shows devices', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.devices.byStatus), {
      status: 200,
      responseText: {
        data: [
          {
            deviceid: '1',
            device: 'first'
          },
          {
            deviceid: '2',
            device: 'second'
          }
        ]
      }
    })
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What device will you make for John Doe?')
    const helpMeLink = vm.$el.querySelector('a')
    expect(helpMeLink.getAttribute('href')).toContain('manage/device_guide.php?pid=42&id=1')
    let deviceOptions = vm.$el.querySelectorAll('option')
    expect(deviceOptions.length).toBe(1)
    moxios.wait(() => {
      deviceOptions = vm.$el.querySelectorAll('option')
      expect(deviceOptions.length).toBe(3)
      const firstDevice = deviceOptions[1]
      expect(firstDevice.getAttribute('value')).toBe('1')
      expect(firstDevice.textContent).toBe('first')
      done()
    })
  })

  it('selects a device', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.devices.byStatus), {
      status: 200,
      responseText: {
        data: [
          {
            deviceid: '2',
            device: 'first'
          },
          {
            deviceid: '3',
            device: 'second'
          }
        ]
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })
    moxios.stubRequest(http.formUrl(endpoints.tmjClinicalExams.storeForPatient), {
      status: 200,
      responseText: {}
    })
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const deviceSelect = vm.$el.querySelector('select')
      deviceSelect.value = '2'
      deviceSelect.dispatchEvent(new Event('change'))
      vm.$nextTick(() => {
        const submitButton = vm.$el.querySelector('input')
        submitButton.click()
        moxios.wait(() => {
          expect(moxios.requests.count()).toBe(4)
          const firstRequest = moxios.requests.at(1)
          expect(firstRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.update + '/1'))
          const expectedFirstData = {
            device_id: 2
          }
          expect(JSON.parse(firstRequest.config.data)).toEqual(expectedFirstData)
          const secondRequest = moxios.requests.at(3)
          expect(secondRequest.url).toBe(http.formUrl(endpoints.tmjClinicalExams.storeForPatient))
          const expectedSecondData = {
            dentaldevice: 2,
            patientid: 42
          }
          expect(JSON.parse(secondRequest.config.data)).toEqual(expectedSecondData)
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
