// @todo: uncomment when migrating patients
/*
import Vue from 'vue'
import { TASK_TYPES } from '../../../../src/constants/main'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import PatientTaskMenuComponent from '../../../../src/components/manage/tasks/PatientTaskMenu.vue'

describe('PatientTaskMenu component', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('task-data', {
      template: '<div class="task_data"></div>'
    })
    const Component = Vue.extend(PatientTaskMenuComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }

    moxios.stubRequest(http.formUrl(endpoints.tasks.indexForPatient + '/1'), {
      status: 200,
      responseText: {
        data: [
          {
            id: 1,
            type: TASK_TYPES.OVERDUE
          },
          {
            id: 2,
            type: TASK_TYPES.FUTURE
          }
        ]
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.tasks.indexForPatient + '/2'), {
      status: 200,
      responseText: {
        data: []
      }
    })
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should not show HTML without tasks', function (done) {
    const props = {
      patientId: 2
    }
    const vm = this.mount(props)
    moxios.wait(function () {
      const taskMenu = vm.$el
      expect(taskMenu.style.display).toBe('none')
      done()
    })
  })

  it('should show HTML', function (done) {
    const props = {
      patientId: 1
    }
    const vm = this.mount(props)
    moxios.wait(function () {
      const request = moxios.requests.mostRecent()
      expect(request.url).toBe('http://api/api/v1/tasks-for-patient/1')

      const taskMenu = vm.$el
      expect(taskMenu.style.display).toBe('')
      const taskCount = vm.$el.querySelector('span#pat_task_header')
      expect(taskCount.textContent).toBe('Tasks(2)')
      const children = vm.$el.querySelectorAll('div.task_data')
      expect(children.length).toBe(4)

      vm.$props.patientId = 2
      moxios.wait(function () {
        const request = moxios.requests.mostRecent()
        expect(request.url).toBe('http://api/api/v1/tasks-for-patient/2')
        done()
      })
    })
  })

  it('should fire onMouseEnter and onMouseLeave', function (done) {
    const props = {
      patientId: 1
    }
    const vm = this.mount(props)
    moxios.wait(function () {
      const taskMenu = vm.$el
      const taskList = vm.$el.querySelector('div#pat_task_list')
      expect(taskList.style.display).toBe('none')
      const mouseEnterEvent = new Event('mouseenter')
      const mouseLeaveEvent = new Event('mouseleave')
      taskMenu.dispatchEvent(mouseEnterEvent)
      vm.$nextTick(() => {
        expect(taskList.style.display).toBe('')
        taskMenu.dispatchEvent(mouseLeaveEvent)
        vm.$nextTick(() => {
          expect(taskList.style.display).toBe('none')
          done()
        })
      })
    })
  })
})
*/
