import Vue from 'vue'
import { TASK_TYPES } from '../../../../src/constants/main'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import TaskMenuComponent from '../../../../src/components/manage/tasks/TaskMenu.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import symbols from '../../../../src/symbols'

describe('TaskMenu component', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('task-data', {
      template: '<div class="task_data"></div>'
    })
    store.state.tasks[symbols.state.tasks] = []
    const Component = Vue.extend(TaskMenuComponent)
    this.mount = function () {
      return new Component({
        store: store
      }).$mount()
    }

    moxios.stubRequest(http.formUrl(endpoints.tasks.index), {
      status: 200,
      responseText: {
        data: [
          {
            id: 1,
            type: TASK_TYPES.OVERDUE
          },
          {
            id: 2,
            type: TASK_TYPES.THIS_WEEK
          }
        ]
      }
    })
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should show HTML', function (done) {
    const vm = this.mount()
    moxios.wait(function () {
      const taskCount = vm.$el.querySelector('span#task_count')
      expect(taskCount.textContent).toBe('2')
      const children = vm.$el.querySelectorAll('div.task_data')
      expect(children.length).toBe(6)
      const viewAllButton = vm.$el.querySelector('a.task_view_all')
      expect(viewAllButton.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/manage_tasks.php')
      done()
    })
  })

  it('should fire onMouseEnter and onMouseLeave', function (done) {
    const vm = this.mount()
    moxios.wait(function () {
      const taskMenu = vm.$el
      const taskList = vm.$el.querySelector('div#task_list')
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
