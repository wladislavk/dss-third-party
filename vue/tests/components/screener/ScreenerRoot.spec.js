import symbols from '../../../src/symbols'
import ScreenerRootComponent from '../../../src/components/screener/ScreenerRoot.vue'
import store from '../../../src/store'
import TestCase from '../../cases/ComponentTestCase'

describe('ScreenerRoot', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerRootComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-main',
        path: '/main'
      },
      {
        name: 'screener-login',
        path: '/login'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should go to login if no token present', function (done) {
    const vm = this.testCase.mount()

    expect(document.title).toBe('Dental Sleep Solutions :: Screener')
    this.testCase.wait(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should go to main if token is present', function (done) {
    store.commit(symbols.mutations.screenerToken, 'token')
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-main')
      done()
    })
  })
})
