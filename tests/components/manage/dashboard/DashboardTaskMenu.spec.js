import Vue from 'vue'
import { TASK_TYPES } from '../../../../src/constants/main'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import DashboardTaskMenuComponent from '../../../../src/components/manage/dashboard/DashboardTaskMenu.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'

describe('DashboardTaskMenu component', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('task-data', {
      template: '<div class="task_data"></div>'
    })
    const Component = Vue.extend(DashboardTaskMenuComponent)
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
      const children = vm.$el.querySelectorAll('div.task_data')
      expect(children.length).toBe(6)
      const viewAllButton = vm.$el.querySelector('a.task_view_all')
      expect(viewAllButton.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/manage_tasks.php')
      done()
    })
  })
})
