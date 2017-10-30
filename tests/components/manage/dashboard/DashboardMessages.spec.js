import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import DashboardMessagesComponent from '../../../../src/components/manage/dashboard/DashboardMessages.vue'

describe('DashboardMessages component', () => {
  beforeEach(function () {
    moxios.install()

    const Component = Vue.extend(DashboardMessagesComponent)
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

    const vm = this.mount({})

    moxios.wait(function () {
      const items = vm.$el.querySelectorAll('div.task_menu > ul > li')
      expect(items.length).toBe(2)
      expect(items[0].innerHTML).toBe('memo 1')
      expect(items[1].innerHTML).toBe('<b>memo 2</b>')
      done()
    })
  })
})
