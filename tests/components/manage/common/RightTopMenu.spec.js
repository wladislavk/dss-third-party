import Vue from 'vue'
import VueRouter from 'vue-router'
import moxios from 'moxios'
import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import RightMenuComponent from '../../../../src/components/manage/common/RightTopMenu.vue'
import { NOTIFICATION_NUMBERS } from '../../../../src/constants/main'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'

describe('RightTopMenu component', () => {
  beforeEach(function () {
    moxios.install()

    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingLetters] = 0
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets] = 0

    Vue.use(VueRouter)
    const Component = Vue.extend(RightMenuComponent)
    const Router = new VueRouter({
      routes: [
        {
          name: 'dashboard',
          path: '/'
        },
        {
          name: 'main-login',
          path: '/login'
        }
      ]
    })
    this.mount = function () {
      return new Component({
        store: store,
        router: Router
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('shows menu without support tickets', function () {
    const vm = this.mount()
    const links = vm.$el.querySelectorAll('ul#topmenu2 > li')
    expect(links[0].textContent).toBe('Notifications(0)')
    expect(links[1].textContent.trim()).toBe('Support')
  })

  it('shows menu with support tickets', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingLetters] = 2
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets] = 3
    const vm = this.mount()
    const links = vm.$el.querySelectorAll('ul#topmenu2 > li')
    expect(links[0].textContent).toBe('Notifications(2)')
    expect(links[1].textContent.trim()).toBe('Support (3)')
  })

  it('logs out', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.logout), {
      status: 200,
      responseText: {}
    })

    const vm = this.mount()
    const logoutButton = vm.$el.querySelector('a#logout')
    logoutButton.click()
    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('main-login')
      done()
    })
  })
})
