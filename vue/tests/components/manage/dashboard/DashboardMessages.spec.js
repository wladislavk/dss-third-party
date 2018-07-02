import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import DashboardMessagesComponent from '../../../../src/components/manage/dashboard/DashboardMessages.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('DashboardMessages component', () => {
  beforeEach(function () {
    moxios.install()
    this.testCase = new TestCase()

    this.testCase.setComponent(DashboardMessagesComponent)
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should show tasks', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.memos.current), {
      status: 200,
      responseText: {
        data: [
          {
            id: 1,
            memo: 'memo 1'
          },
          {
            id: 2,
            memo: '<b>memo 2</b>'
          }
        ]
      }
    })

    const vm = this.testCase.mount()

    moxios.wait(function () {
      const items = vm.$el.querySelectorAll('div.task_menu > ul > li')
      expect(items.length).toBe(2)
      expect(items[0].innerHTML).toBe('memo 1')
      expect(items[1].innerHTML).toBe('<b>memo 2</b>')
      done()
    })
  })
})
