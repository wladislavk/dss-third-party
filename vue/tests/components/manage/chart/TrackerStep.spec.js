import moxios from 'moxios'
import Vue from 'vue'
import store from '../../../../src/store'
import TrackerStepComponent from '../../../../src/components/manage/chart/TrackerStep.vue'
import http from 'src/services/http'
import endpoints from 'src/endpoints'

describe('TrackerStep component', () => {
  beforeEach(function () {
    moxios.install()

    const Component = Vue.extend(TrackerStepComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('shows normal step', function () {
    const props = {
      stepId: 3,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: false,
      last: false
    }
    const vm = this.mount(props)
    const root = vm.$el
    expect(root.className).toBe('')
    const link = root.querySelector('a')
    expect(link).not.toBeNull()
    expect(link.textContent).toBe('foo')
    expect(link.id).toBe('completed_3')
  })

  it('shows completed step', function () {
    const props = {
      stepId: 3,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: true,
      last: false
    }
    const vm = this.mount(props)
    const root = vm.$el
    expect(root.className).toBe('completed_step')
  })

  it('shows first step', function () {
    const props = {
      stepId: 1,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: false,
      last: false
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('a')
    expect(link).toBeNull()
    const span = vm.$el.querySelector('span')
    expect(span).not.toBeNull()
    expect(span.textContent).toBe('foo')
  })

  it('shows last step', function () {
    const props = {
      stepId: 3,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: false,
      last: true
    }
    const vm = this.mount(props)
    const root = vm.$el
    expect(root.className).toBe('last')
  })

  it('adds new step', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.appointmentSummaries.store), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const props = {
      stepId: 3,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: false,
      last: false
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('a')
    link.click()
    moxios.wait(() => {
      expect(moxios.requests.count()).toBe(2)
      const request = moxios.requests.at(0)
      expect(request.url).toBe(http.formUrl(endpoints.appointmentSummaries.store))
      const expectedData = {
        step_id: 3,
        patient_id: 42,
        appt_type: 1
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedData)
      done()
    })
  })
})
