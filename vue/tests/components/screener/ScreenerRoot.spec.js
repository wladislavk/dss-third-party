import Vue from 'vue'
import VueRouter from 'vue-router'
import symbols from '../../../src/symbols'
import ScreenerRootComponent from '../../../src/components/screener/ScreenerRoot.vue'
import store from '../../../src/store'

describe('ScreenerRoot', () => {
  beforeEach(function () {
    const routes = [
      {
        name: 'screener-main',
        path: '/main'
      },
      {
        name: 'screener-login',
        path: '/login'
      }
    ]

    const Component = Vue.extend(ScreenerRootComponent)
    this.mount = function () {
      return new Component({
        store: store,
        router: new VueRouter({routes})
      }).$mount()
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should go to login if no token present', function (done) {
    const vm = this.mount()
    expect(document.title).toBe('Dental Sleep Solutions :: Screener')
    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should go to main if token is present', function (done) {
    store.commit(symbols.mutations.screenerToken, 'token')
    const vm = this.mount()

    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-main')
      done()
    })
  })
})
