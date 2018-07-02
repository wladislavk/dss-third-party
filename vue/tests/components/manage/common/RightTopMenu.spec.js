import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import RightMenuComponent from '../../../../src/components/manage/common/RightTopMenu.vue'
import { NOTIFICATION_NUMBERS } from '../../../../src/constants/main'
import TestCase from '../../../cases/ComponentTestCase'

describe('RightTopMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingLetters] = 0
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets] = 0

    this.testCase.setComponent(RightMenuComponent)
    this.testCase.setRoutes([
      {
        name: 'dashboard',
        path: '/'
      },
      {
        name: 'main-login',
        path: '/login'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows menu without support tickets', function () {
    const vm = this.testCase.mount()
    const links = vm.$el.querySelectorAll('ul#topmenu2 > li')
    expect(links[0].textContent).toBe('Notifications(0)')
    expect(links[1].textContent.trim()).toBe('Support')
  })

  it('shows menu with support tickets', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingLetters] = 2
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets] = 3
    const vm = this.testCase.mount()
    const links = vm.$el.querySelectorAll('ul#topmenu2 > li')
    expect(links[0].textContent).toBe('Notifications(2)')
    expect(links[1].textContent.trim()).toBe('Support (3)')
  })

  it('logs out', function (done) {
    const vm = this.testCase.mount()
    const logoutButton = vm.$el.querySelector('a#logout')
    logoutButton.click()
    vm.$nextTick(() => {
      expect(this.testCase.alertText).toBe('Logout successfully')
      expect(vm.$router.currentRoute.name).toBe('main-login')
      done()
    })
  })
})
