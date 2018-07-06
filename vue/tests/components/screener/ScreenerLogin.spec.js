import endpoints from '../../../src/endpoints'
import symbols from '../../../src/symbols'
import ScreenerLoginComponent from '../../../src/components/screener/ScreenerLogin.vue'
import store from '../../../src/store'
import TestCase from '../../cases/ComponentTestCase'
import ProcessWrapper from 'src/wrappers/ProcessWrapper'

describe('ScreenerLogin', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerLoginComponent)
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

  it('should log in properly', function (done) {
    this.testCase.stubRequest({
      url: ProcessWrapper.getApiRoot() + 'auth',
      rawUrl: true,
      dataKey: 'token',
      response: 'token'
    })
    this.testCase.stubRequest({
      url: endpoints.users.current,
      response: {
        userid: 1,
        docid: 2
      }
    })

    const vm = this.testCase.mount()

    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = vm.$el.querySelector('button#loginbut')
    loginButton.click()

    this.testCase.wait(() => {
      expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
      this.testCase.wait(() => {
        expect(vm.$router.currentRoute.name).toBe('screener-intro')
        expect(store.state.screener[symbols.state.sessionData].userId).toBe(1)
        expect(store.state.screener[symbols.state.sessionData].docId).toBe(2)
        const errorDiv = vm.$el.querySelector('span.error')
        expect(errorDiv).toBeNull()
        done()
      })
    })
  })

  it('should log in unsuccessfully', function (done) {
    this.testCase.stubRequest({
      url: ProcessWrapper.getApiRoot() + 'auth',
      rawUrl: true,
      status: 403,
      dataKey: 'error',
      response: 'error'
    })
    const vm = this.testCase.mount()

    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = vm.$el.querySelector('button#loginbut')
    loginButton.click()

    this.testCase.wait(() => {
      expect(store.state.screener[symbols.state.screenerToken]).toBe('')
      const errorDiv = vm.$el.querySelector('span.error')
      expect(errorDiv).not.toBeNull()
      done()
    })
  })

  it('should redirect if token is set', function (done) {
    store.commit(symbols.mutations.screenerToken, 'token')
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
