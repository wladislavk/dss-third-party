import symbols from '../../../src/symbols'
import TestCase from '../../cases/ComponentTestCase'
import ScreenerRootComponent from '../../../src/components/screener/ScreenerRoot.vue'

describe('ScreenerRoot', () => {
  beforeEach(function () {
    this.vueOptions = {
      template: '<div><screener-root></screener-root></div>',
      components: {
        screenerRoot: ScreenerRootComponent
      }
    }

    this.routes = [
      {
        name: 'screener-main',
        path: '/main'
      },
      {
        name: 'screener-login',
        path: '/login'
      }
    ]
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should go to login if no token present', function (done) {
    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    expect(document.title).toBe('Dental Sleep Solutions :: Screener')
    this.vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should go to main if token is present', function (done) {
    this.vueOptions.created = function () {
      this.$store.commit(symbols.mutations.screenerToken, 'token')
    }
    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    this.vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-main')
      done()
    })
  })
})
