import Vue from 'vue'
import moxios from 'moxios'
import store from '../../../../../src/store'
import FlowsheetDelayTreatmentComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetDelayTreatment.vue'
import symbols from '../../../../../src/symbols'
import http from '../../../../../src/services/http'
import endpoints from '../../../../../src/endpoints'
import { DELAYING_ID } from '../../../../../src/constants/chart'

describe('FlowsheetDelayTreatment component', () => {
  beforeEach(function () {
    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.flowsheetDelayTreatment,
      params: {
        patientId: 42,
        flowId: 1
      }
    }

    moxios.install()

    const Component = Vue.extend(FlowsheetDelayTreatmentComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()

    store.state.patients[symbols.state.patientName] = ''
    store.state.main[symbols.state.modal] = {
      name: '',
      params: {}
    }
  })

  it('shows modal', function () {
    const vm = this.mount()
    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What is the reason for delaying treatment for John Doe?')
    const treatmentOptions = vm.$el.querySelectorAll('option')
    expect(treatmentOptions.length).toBe(5)
    const secondTreatment = treatmentOptions[1]
    expect(secondTreatment.getAttribute('value')).toBe('dental work')
    expect(secondTreatment.textContent).toBe('Dental Work')
  })

  it('sets treatment', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })
    const vm = this.mount()
    const selector = vm.$el.querySelector('select')
    selector.value = 'dental work'
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        expect(moxios.requests.count()).toBe(2)
        const firstRequest = moxios.requests.at(0)
        expect(firstRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.update + '/1'))
        const expectedData = {
          delay_reason: 'dental work'
        }
        expect(JSON.parse(firstRequest.config.data)).toEqual(expectedData)
        const expectedModal = {
          name: '',
          params: {}
        }
        expect(store.state.main[symbols.state.modal]).toEqual(expectedModal)
        done()
      })
    })
  })

  it('sets treatment with reason', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })
    const vm = this.mount()
    const selector = vm.$el.querySelector('select')
    selector.value = 'other'
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        const expectedModal = {
          name: symbols.modals.flowsheetReason,
          params: {
            flowId: 1,
            segmentId: DELAYING_ID,
            patientId: 42
          }
        }
        expect(store.state.main[symbols.state.modal]).toEqual(expectedModal)
        done()
      })
    })
  })
})
