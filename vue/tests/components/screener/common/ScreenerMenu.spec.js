import store from '../../../../src/store'
import ScreenerMenuComponent from '../../../../src/components/screener/common/ScreenerMenu.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerMenuComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-login',
        path: '/login'
      },
      {
        name: 'screener-intro',
        path: '/intro'
      },
      {
        name: 'screener-epworth',
        path: '/epworth'
      }
    ])
    this.testCase.setActiveRoute('screener-epworth')
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows menu', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const firstItem = vm.$el.querySelector('li:first-child')
      expect(firstItem.style.display).toBe('')
      done()
    })
  })

  it('shows menu for intro', function (done) {
    this.testCase.setActiveRoute('screener-intro')
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const firstItem = vm.$el.querySelector('li:first-child')
      expect(firstItem.style.display).toBe('none')
      done()
    })
  })

  it('logs out the user', function (done) {
    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const logoutLink = vm.$el.querySelector('a#logout_link')
      logoutLink.click()
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-login')
        expect(store.state.screener[symbols.state.doctorName]).toBe('')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('')
        done()
      })
    })
  })

  it('logs out without confirmation', function (done) {
    this.testCase.confirmDialog = false

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const logoutLink = vm.$el.querySelector('a#logout_link')
      logoutLink.click()
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-epworth')
        expect(store.state.screener[symbols.state.doctorName]).toBe('John')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })

  it('resets screener', function (done) {
    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const resetLink = vm.$el.querySelector('a#reset_link')
      resetLink.click()
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-intro')
        expect(store.state.screener[symbols.state.doctorName]).toBe('')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })

  it('resets without confirmation', function (done) {
    this.testCase.confirmDialog = false

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const resetLink = vm.$el.querySelector('a#reset_link')
      resetLink.click()
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-epworth')
        expect(store.state.screener[symbols.state.doctorName]).toBe('John')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })
})
