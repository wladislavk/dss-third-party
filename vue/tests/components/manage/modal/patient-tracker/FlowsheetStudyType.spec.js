import Vue from 'vue'
import moxios from 'moxios'
import store from '../../../../../src/store'
import symbols from '../../../../../src/symbols'
import FlowsheetStudyTypeComponent from '../../../../../src/components/manage/modal/patient-tracker/FlowsheetStudyType.vue'
import { BASELINE_TEST_ID, TITRATION_STUDY_ID } from '../../../../../src/constants/chart'
import http from '../../../../../src/services/http'
import endpoints from '../../../../../src/endpoints'

describe('FlowsheetStudyType component', () => {
  beforeEach(function () {
    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.main[symbols.state.modal] = {
      name: symbols.modals.flowsheetStudyType,
      params: {
        patientId: 42,
        segmentId: 0,
        flowId: 1
      }
    }

    moxios.install()

    const Component = Vue.extend(FlowsheetStudyTypeComponent)
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

  it('shows titration types', function () {
    store.state.main[symbols.state.modal].params.segmentId = TITRATION_STUDY_ID

    const vm = this.mount()
    const header = vm.$el.querySelector('h2')
    expect(header.textContent).toBe('What type of sleep test will be performed on John Doe?')
    const studyTypeOptions = vm.$el.querySelectorAll('option')
    expect(studyTypeOptions.length).toBe(3)
    const firstStudyType = studyTypeOptions[1]
    expect(firstStudyType.getAttribute('value')).toBe('HST Titration')
    expect(firstStudyType.textContent).toBe('HST Titration')
  })

  it('shows baseline types', function () {
    store.state.main[symbols.state.modal].params.segmentId = BASELINE_TEST_ID

    const vm = this.mount()
    const studyTypeOptions = vm.$el.querySelectorAll('option')
    expect(studyTypeOptions.length).toBe(3)
    const secondStudyType = studyTypeOptions[2]
    expect(secondStudyType.getAttribute('value')).toBe('PSG Baseline')
    expect(secondStudyType.textContent).toBe('PSG Baseline')
  })

  it('selects study type', function (done) {
    store.state.main[symbols.state.modal].params.segmentId = BASELINE_TEST_ID

    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {}
    })

    const vm = this.mount()
    const selector = vm.$el.querySelector('select')
    selector.value = 'PSG Baseline'
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      const submitButton = vm.$el.querySelector('input')
      submitButton.click()
      moxios.wait(() => {
        expect(moxios.requests.count()).toBe(2)
        const firstRequest = moxios.requests.at(0)
        expect(firstRequest.url).toBe(http.formUrl(endpoints.appointmentSummaries.update + '/1'))
        const expectedData = {
          type: 'PSG Baseline'
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
})
