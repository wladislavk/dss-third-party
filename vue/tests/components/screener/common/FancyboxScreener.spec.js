import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import FancyboxScreenerComponent from '../../../../src/components/screener/common/FancyboxScreener.vue'

describe('FancyboxScreener', () => {
  beforeEach(function () {
    const routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    const vueOptions = {
      template: '<div><fancybox-screener></fancybox-screener></div>',
      components: {
        fancyboxScreener: FancyboxScreenerComponent
      },
      created: function () {
        this.$store.commit(symbols.mutations.screenerToken, 'token')
        this.$store.commit(symbols.mutations.sessionData, { docId: 1, userId: 2 })
        this.$store.commit(symbols.mutations.coMorbidityWeight, 10)
        this.$store.commit(symbols.mutations.showFancybox)
      }
    }

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should close fancybox', function () {
    expect(this.vue.$store.state.screener[symbols.state.showFancybox]).toBe(true)
    const closeLink = this.vm.$el.querySelector('a#fancybox-close')
    closeLink.click()
    expect(this.vue.$store.state.screener[symbols.state.showFancybox]).toBe(false)
  })

  it('should reset state', function (done) {
    const finishLink = this.vm.$el.querySelector('a#finish_ok')
    finishLink.click()
    this.vm.$nextTick(() => {
      expect(this.vue.$store.state.screener[symbols.state.showFancybox]).toBe(false)
      expect(this.vue.$store.state.screener[symbols.state.sessionData]).toEqual({ docId: 1, userId: 2 })
      expect(this.vue.$store.state.screener[symbols.state.screenerToken]).toBe('token')
      expect(this.vue.$store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      expect(this.vue.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
