import { TASK_TYPES } from '../../../../src/constants/main'
import endpoints from '../../../../src/endpoints'
import moxios from 'moxios'
import store from '../../../../src/store'
import TaskMenuComponent from '../../../../src/components/manage/tasks/TaskMenu.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('TaskMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.tasks[symbols.state.tasks] = []

    this.testCase.setComponent(TaskMenuComponent)
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
      const taskCount = vm.$el.querySelector('span#task_count')
      expect(taskCount.textContent).toBe('2')
      const children = vm.$el.querySelectorAll('div.task-data')
      expect(children.length).toBe(6)
      const viewAllButton = vm.$el.querySelector('a.task_view_all')
      expect(viewAllButton.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/manage_tasks.php')
      done()
    })
  })

  it('should fire onMouseEnter and onMouseLeave', function (done) {
    const vm = this.testCase.mount()

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
