import Vue from 'vue'
import store from '../../../../src/store'
import TrackerSectionOneComponent from '../../../../src/components/manage/chart/TrackerSectionOne.vue'
import symbols from '../../../../src/symbols'
import { INITIAL_FUTURE_APPOINTMENT } from '../../../../src/constants/chart'

describe('TrackerSectionOne component', () => {
  beforeEach(function () {
    store.state.flowsheet[symbols.state.trackerSteps] = [
      {
        id: 1,
        rank: 1,
        name: 'first',
        section: 1
      },
      {
        id: 2,
        rank: 2,
        name: 'second',
        section: 1
      },
      {
        id: 3,
        rank: 3,
        name: 'third',
        section: 1
      },
      {
        id: 4,
        rank: 4,
        name: 'fourth',
        section: 2
      },
      {
        id: 5,
        rank: 5,
        name: 'fifth',
        section: 2
      }
    ]
    store.state.flowsheet[symbols.state.finalTrackerRank] = 3
    store.state.flowsheet[symbols.state.finalTrackerSegment] = 3
    store.state.flowsheet[symbols.state.lastTrackerSegment] = 5
    store.state.flowsheet[symbols.state.futureAppointment] = INITIAL_FUTURE_APPOINTMENT

    Vue.component('tracker-step', {
      template: '<div class="tracker-step"></div>'
    })

    const Component = Vue.extend(TrackerSectionOneComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    store.state.flowsheet[symbols.state.futureAppointment] = INITIAL_FUTURE_APPOINTMENT
  })

  it('shows tracker steps', function () {
    const props = {
      patientId: 42
    }
    const vm = this.mount(props)
    const rootDiv = vm.$el
    expect(rootDiv.className).toBe('treatment_list')
    const arrowDiv = rootDiv.querySelector('div.arrow_div')
    expect(arrowDiv.style.height).toBe('60px')
    const firstSteps = rootDiv.querySelectorAll('ul.sect1 div.tracker-step')
    expect(firstSteps.length).toBe(3)
    const secondStep = firstSteps[1]
    expect(secondStep.getAttribute('step-id')).toBe('2')
    expect(secondStep.getAttribute('name')).toBe('second')
    expect(secondStep.getAttribute('patient-id')).toBe('42')
    expect(secondStep.getAttribute('completed')).toBe('true')
    expect(secondStep.getAttribute('last')).toBeNull()
    const thirdStep = firstSteps[2]
    expect(thirdStep.getAttribute('completed')).toBeNull()
    expect(thirdStep.getAttribute('last')).toBe('true')
    const secondSteps = rootDiv.querySelectorAll('ul.sect2 div.tracker-step')
    expect(secondSteps.length).toBe(2)
    const fourthStep = secondSteps[0]
    expect(fourthStep.getAttribute('last')).toBeNull()
    const fifthStep = secondSteps[1]
    expect(fifthStep.getAttribute('last')).toBe('true')
  })

  it('shows with scheduled appointment', function () {
    store.state.flowsheet[symbols.state.futureAppointment] = {
      id: 1,
      segmentId: 1,
      dateScheduled: new Date('2016-01-01'),
      dateUntil: null
    }
    const props = {
      patientId: 42
    }
    const vm = this.mount(props)
    const rootDiv = vm.$el
    expect(rootDiv.className).toBe('treatment_list current_step')
  })
})
