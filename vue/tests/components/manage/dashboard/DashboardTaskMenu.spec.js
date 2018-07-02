import { TASK_TYPES } from '../../../../src/constants/main'
import endpoints from '../../../../src/endpoints'
import moxios from 'moxios'
import DashboardTaskMenuComponent from '../../../../src/components/manage/dashboard/DashboardTaskMenu.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('DashboardTaskMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(DashboardTaskMenuComponent)
    this.testCase.setChildComponents(['task-data'])

    this.testCase.stubRequest({
      url: endpoints.tasks.index,
      response: [
        {
          id: 1,
          type: TASK_TYPES.OVERDUE
        },
        {
          id: 2,
          type: TASK_TYPES.THIS_WEEK
        }
      ]
    })
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should show HTML', function (done) {
    const vm = this.testCase.mount()

    moxios.wait(function () {
      const children = vm.$el.querySelectorAll('div.task-data')
      expect(children.length).toBe(6)
      const viewAllButton = vm.$el.querySelector('a.task_view_all')
      expect(viewAllButton.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/manage_tasks.php')
      done()
    })
  })
})
