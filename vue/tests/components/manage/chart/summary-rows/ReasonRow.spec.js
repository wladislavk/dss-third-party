import moxios from 'moxios'
import ReasonRowComponent from '../../../../../src/components/manage/chart/summary-rows/ReasonRow.vue'
import { DELAYING_ID } from '../../../../../src/constants/chart'
import symbols from '../../../../../src/symbols'
import endpoints from '../../../../../src/endpoints'
import http from '../../../../../src/services/http'
import Alerter from '../../../../../src/services/Alerter'
import TestCase from '../../../../cases/ComponentTestCase'

describe('ReasonRow component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ReasonRowComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows reasons', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'deciding'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    expect(selector.id).toBe('delay_reason_1')
    expect(selector.getAttribute('name')).toBe('data[1][delay_reason]')
    expect(selector.className).toBe('form-control delay_reason')
    const options = selector.querySelectorAll('option')
    expect(options.length).toBe(5)
    expect(options[1].getAttribute('value')).toBe('dental work')
    expect(options[1].innerText).toBe('Dental Work')
    expect(selector.value).toBe('deciding')
    const link = vm.$el.querySelector('a')
    expect(link.id).toBe('reason_btn_1')
    expect(link.style.display).toBe('none')
  })

  it('shows other reason', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'other'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    expect(link.style.display).toBe('')
  })

  it('shows without current reason', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: ''
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    expect(selector.value).toBe('insurance')
  })

  it('shows without current reason and reason data', function () {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: 99,
      reason: ''
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    expect(selector.value).toBe('')
  })

  it('updates reason', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    let confirmation = false
    this.testCase.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      confirmation = true
      return true
    })
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'deciding'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = 'dental work'
    selector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.config.data).not.toBeUndefined()
      const expectedData = {
        delay_reason: 'dental work'
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      expect(confirmation).toBe(false)
      done()
    })
  })

  it('updates reason and erases description', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.update + '/1'), {
      status: 200,
      responseText: {
        data: []
      }
    })
    let confirmation = false
    this.testCase.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      confirmation = true
      return true
    })
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'other'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = 'dental work'
    selector.dispatchEvent(new Event('change'))
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.config.data).not.toBeUndefined()
      expect(confirmation).toBe(true)
      done()
    })
  })

  it('updates to empty data', function (done) {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'deciding'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const selector = vm.$el.querySelector('select')
    selector.value = ''
    selector.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      expect(moxios.requests.count()).toBe(0)
      done()
    })
  })

  it('opens flowsheet modal', function (done) {
    const props = {
      patientId: 42,
      elementId: 1,
      segmentId: DELAYING_ID,
      reason: 'other'
    }
    this.testCase.setPropsData(props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    link.click()
    vm.$nextTick(() => {
      const expectedModal = {
        name: symbols.modals.flowsheetReason,
        params: {
          flowId: 1,
          segmentId: DELAYING_ID,
          patientId: 42
        }
      }
      expect(vm.$store.state.main[symbols.state.modal]).toEqual(expectedModal)
      done()
    })
  })

  afterEach(function () {
    moxios.uninstall()
  })
})
