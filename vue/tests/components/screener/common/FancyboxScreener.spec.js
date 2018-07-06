import symbols from '../../../../src/symbols'
import FancyboxScreenerComponent from '../../../../src/components/screener/common/FancyboxScreener.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('FancyboxScreener', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.commit(symbols.mutations.screenerToken, 'token')
    store.commit(symbols.mutations.sessionData, { docId: 1, userId: 2 })
    store.commit(symbols.mutations.coMorbidityWeight, 10)
    store.commit(symbols.mutations.showFancybox)

    this.testCase.setComponent(FancyboxScreenerComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should close fancybox', function (done) {
    const vm = this.testCase.mount()

    expect(store.state.screener[symbols.state.showFancybox]).toBe(true)
    const closeLink = vm.$el.querySelector('a#fancybox-close')
    closeLink.click()
    this.testCase.wait(() => {
      expect(store.state.screener[symbols.state.showFancybox]).toBe(false)
      done()
    })
  })

  it('should reset state', function (done) {
    const vm = this.testCase.mount()

    const finishLink = vm.$el.querySelector('a#finish_ok')
    finishLink.click()
    this.testCase.wait(() => {
      expect(store.state.screener[symbols.state.showFancybox]).toBe(false)
      expect(store.state.screener[symbols.state.sessionData]).toEqual({ docId: 1, userId: 2 })
      expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
      expect(store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      expect(vm.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
