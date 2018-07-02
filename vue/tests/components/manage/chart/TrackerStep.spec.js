import moxios from 'moxios'
import TrackerStepComponent from '../../../../src/components/manage/chart/TrackerStep.vue'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('TrackerStep component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      stepId: 3,
      patientId: 42,
      name: 'foo',
      section: 1,
      completed: false,
      last: false
    }

    this.testCase.setComponent(TrackerStepComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows normal step', function () {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const root = vm.$el
    expect(root.className).toBe('')
    const link = root.querySelector('a')
    expect(link).not.toBeNull()
    expect(link.textContent).toBe('foo')
    expect(link.id).toBe('completed_3')
  })

  it('shows completed step', function () {
    this.props.completed = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const root = vm.$el
    expect(root.className).toBe('completed_step')
  })

  it('shows first step', function () {
    this.props.stepId = 1
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    expect(link).toBeNull()
    const span = vm.$el.querySelector('span')
    expect(span).not.toBeNull()
    expect(span.textContent).toBe('foo')
  })

  it('shows last step', function () {
    this.props.last = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const root = vm.$el
    expect(root.className).toBe('last')
  })

  it('adds new step', function (done) {
    this.testCase.stubRequest({
      url: endpoints.appointmentSummaries.store
    })
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    link.click()
    moxios.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(2)
      const expectedFirst = {
        url: endpoints.appointmentSummaries.store,
        body: {
          step_id: 3,
          patient_id: 42,
          appt_type: 1
        }
      }
      expect(requestResults[0]).toEqual(expectedFirst)
      done()
    })
  })
})
