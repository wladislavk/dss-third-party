import Vue from 'vue'
import VueRouter from 'vue-router'
import symbols from '../../../../src/symbols'
import FancyboxScreenerComponent from '../../../../src/components/screener/common/FancyboxScreener.vue'
import store from '../../../../src/store'

describe('FancyboxScreener', () => {
  beforeEach(function () {
    const routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    store.commit(symbols.mutations.screenerToken, 'token')
    store.commit(symbols.mutations.sessionData, { docId: 1, userId: 2 })
    store.commit(symbols.mutations.coMorbidityWeight, 10)
    store.commit(symbols.mutations.showFancybox)

    const Component = Vue.extend(FancyboxScreenerComponent)
    this.mount = function () {
      const vm = new Component({
        store: store,
        router: new VueRouter({routes})
      }).$mount()
      return vm
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should close fancybox', function (done) {
    const vm = this.mount()
    expect(store.state.screener[symbols.state.showFancybox]).toBe(true)
    const closeLink = vm.$el.querySelector('a#fancybox-close')
    closeLink.click()
    vm.$nextTick(() => {
      expect(store.state.screener[symbols.state.showFancybox]).toBe(false)
      done()
    })
  })

  it('should reset state', function (done) {
    const vm = this.mount()
    const finishLink = vm.$el.querySelector('a#finish_ok')
    finishLink.click()
    vm.$nextTick(() => {
      expect(store.state.screener[symbols.state.showFancybox]).toBe(false)
      expect(store.state.screener[symbols.state.sessionData]).toEqual({ docId: 1, userId: 2 })
      expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
      expect(store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      expect(vm.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
