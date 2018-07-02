import moxios from 'moxios'
import store from '../../../src/store'
import ManageLoginComponent from '../../../src/components/manage/ManageLogin.vue'
import endpoints from '../../../src/endpoints'
import ProcessWrapper from '../../../src/wrappers/ProcessWrapper'
import symbols from '../../../src/symbols'
import TestCase from '../../cases/ComponentTestCase'

describe('ManageLogin component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.mainToken] = ''

    this.testCase.setComponent(ManageLoginComponent)
    this.testCase.setChildComponents(['site-seal'])
    this.testCase.setRoutes([
      {
        name: 'login',
        path: '/login'
      },
      {
        name: 'dashboard',
        path: '/'
      },
      {
        name: 'screener-root',
        path: '/screener'
      }
    ])
    this.testCase.setActiveRoute('login')
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('logs in successfully', function (done) {
    moxios.stubRequest(ProcessWrapper.getApiRoot() + 'auth', {
      status: 200,
      responseText: {
        token: 'token'
      }
    })
    this.testCase.stubRequest({
      url: endpoints.users.check,
      response: {
        type: 'foo'
      }
    })
    this.testCase.stubRequest({
      url: endpoints.loginDetails.store
    })
    this.testCase.stubRequest({
      url: endpoints.users.current
    })

    const vm = this.testCase.mount()

    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('change'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    moxios.wait(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage).toBeNull()
      expect(this.testCase.alertText).toBe('')
      expect(vm.focusUser).toBe(false)
      expect(vm.focusPassword).toBe(false)
      expect(vm.$router.currentRoute.name).toBe('dashboard')
      done()
    })
  })

  it('logs in with wrong password', function (done) {
    moxios.stubRequest(ProcessWrapper.getApiRoot() + 'auth', {
      status: 403,
      responseText: {}
    })

    const vm = this.testCase.mount()

    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('change'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    moxios.wait(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage.textContent).toBe('Username or password not found. This account may be inactive.')
      expect(vm.$router.currentRoute.name).toBe('login')
      done()
    })
  })

  it('logs in without username', function (done) {
    const vm = this.testCase.mount()

    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    vm.$nextTick(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage).toBeNull()
      expect(this.testCase.alertText).toBe('Username is Required')
      expect(vm.focusUser).toBe(true)
      expect(vm.focusPassword).toBe(false)
      expect(vm.$router.currentRoute.name).toBe('login')
      done()
    })
  })

  it('logs in without password', function (done) {
    const vm = this.testCase.mount()

    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    vm.$nextTick(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage).toBeNull()
      expect(this.testCase.alertText).toBe('Password is Required')
      expect(vm.focusUser).toBe(false)
      expect(vm.focusPassword).toBe(true)
      expect(vm.$router.currentRoute.name).toBe('login')
      done()
    })
  })

  it('redirects if token exists', function (done) {
    this.testCase.stubRequest({
      url: endpoints.loginDetails.store
    })
    store.state.main[symbols.state.mainToken] = 'token'
    const vm = this.testCase.mount()

    moxios.wait(() => {
      expect(vm.$router.currentRoute.name).toBe('dashboard')
      done()
    })
  })
})
