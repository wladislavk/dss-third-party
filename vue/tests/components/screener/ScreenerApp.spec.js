import Vue from 'vue'
import VueRouter from 'vue-router'
import symbols from '../../../src/symbols'
import ScreenerAppComponent from '../../../src/components/screener/ScreenerApp.vue'
import store from '../../../src/store'

describe('ScreenerApp component', () => {
  beforeEach(function () {
    const routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      },
      {
        name: 'screener-epworth',
        path: '/epworth'
      },
      {
        name: 'screener-login',
        path: '/login'
      }
    ]

    const Component = Vue.extend(ScreenerAppComponent)
    this.mount = function (isMounted = true) {
      const vm = new Component({
        store: store,
        router: new VueRouter({routes})
      })
      vm.$router.push({ name: 'screener-epworth' })
      if (isMounted) {
        return vm.$mount()
      }
      return vm
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should go to login if no token present', function () {
    const vm = this.mount(false)
    expect(vm.$router.currentRoute.name).not.toBe('screener-login')
    vm.$mount()
    expect(vm.$router.currentRoute.name).toBe('screener-login')
  })

  it('should go to login if logged out', function (done) {
    store.commit(symbols.mutations.screenerToken, 'token')
    const vm = this.mount()

    expect(vm.$router.currentRoute.name).toBe('screener-epworth')
    const logoutLink = vm.$el.querySelector('a#logout_link')
    expect(logoutLink).not.toBeNull()
    spyOn(window, 'confirm').and.returnValue(true)
    logoutLink.click()
    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should reset state except session and token', function (done) {
    store.commit(symbols.mutations.screenerToken, 'token')
    store.commit(symbols.mutations.sessionData, { docId: 1, userId: 2 })
    store.commit(symbols.mutations.coMorbidityWeight, 10)
    const vm = this.mount()

    expect(vm.$router.currentRoute.name).toBe('screener-epworth')
    const resetLink = vm.$el.querySelector('a#reset_link')
    let resetNav = vm.$el.querySelector('li#reset_nav')
    expect(resetNav.style.display).toBe('')
    spyOn(window, 'confirm').and.returnValue(true)
    resetLink.click()
    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-intro')
      resetNav = vm.$el.querySelector('li#reset_nav')
      expect(resetNav.style.display).toBe('none')
      expect(store.state.screener[symbols.state.sessionData]).toEqual({ docId: 1, userId: 2 })
      expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
      expect(store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      done()
    })
  })
})
