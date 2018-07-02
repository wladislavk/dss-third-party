import sinon from 'sinon'
import store from '../../../../src/store'
import ScreenerMenuComponent from '../../../../src/components/screener/common/ScreenerMenu.vue'
import Alerter from '../../../../src/services/Alerter'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerMenu component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
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
    store.commit(symbols.mutations.restoreInitialScreener)
    this.sandbox.restore()
  })

  it('shows menu', function (done) {
    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const firstItem = vm.$el.querySelector('li:first-child')
      expect(firstItem.style.display).toBe('')
      done()
    })
  })

  it('shows menu for intro', function (done) {
    this.testCase.setActiveRoute('screener-intro')
    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const firstItem = vm.$el.querySelector('li:first-child')
      expect(firstItem.style.display).toBe('none')
      done()
    })
  })

  it('logs out the user', function (done) {
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const logoutLink = vm.$el.querySelector('a#logout_link')
      logoutLink.click()
      vm.$nextTick(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-login')
        expect(store.state.screener[symbols.state.doctorName]).toBe('')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('')
        done()
      })
    })
  })

  it('logs out without confirmation', function (done) {
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const logoutLink = vm.$el.querySelector('a#logout_link')
      logoutLink.click()
      vm.$nextTick(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-epworth')
        expect(store.state.screener[symbols.state.doctorName]).toBe('John')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })

  it('resets screener', function (done) {
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const resetLink = vm.$el.querySelector('a#reset_link')
      resetLink.click()
      vm.$nextTick(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-intro')
        expect(store.state.screener[symbols.state.doctorName]).toBe('')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })

  it('resets without confirmation', function (done) {
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })

    store.state.screener[symbols.state.screenerToken] = 'token'
    store.state.screener[symbols.state.doctorName] = 'John'

    const vm = this.testCase.mount()

    vm.$nextTick(() => {
      const resetLink = vm.$el.querySelector('a#reset_link')
      resetLink.click()
      vm.$nextTick(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-epworth')
        expect(store.state.screener[symbols.state.doctorName]).toBe('John')
        expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
        done()
      })
    })
  })
})
