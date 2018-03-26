import Vue from 'vue'
import VueRouter from 'vue-router'
import sinon from 'sinon'
import moxios from 'moxios'
import store from '../../../src/store'
import ManageLoginComponent from '../../../src/components/manage/ManageLogin.vue'
import Alerter from '../../../src/services/Alerter'
import http from '../../../src/services/http'
import endpoints from '../../../src/endpoints'
import ProcessWrapper from '../../../src/wrappers/ProcessWrapper'
import symbols from '../../../src/symbols'

describe('ManageLogin component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.alert = ''
    this.sandbox.stub(Alerter, 'alert').callsFake((text) => {
      this.alert = text
    })
    moxios.install()

    store.state.main[symbols.state.mainToken] = ''

    Vue.component('site-seal', {
      template: '<div class="site-seal"></div>'
    })
    Vue.use(VueRouter)
    const Component = Vue.extend(ManageLoginComponent)
    const Router = new VueRouter({
      routes: [
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
      ]
    })
    this.mount = function () {
      const vm = new Component({
        store: store,
        router: Router
      }).$mount()
      vm.$router.push({name: 'login'})
      vm.$mount()
      return vm
    }
  })

  afterEach(function () {
    moxios.uninstall()
    this.sandbox.restore()
  })

  it('logs in successfully', function (done) {
    moxios.stubRequest(ProcessWrapper.getApiRoot() + 'auth', {
      status: 200,
      responseText: {
        token: 'token'
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.users.check), {
      status: 200,
      responseText: {
        data: {
          type: 'foo'
        }
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.loginDetails.store), {
      status: 200,
      responseText: {
        data: []
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.users.current), {
      status: 200,
      responseText: {
        data: []
      }
    })

    const vm = this.mount()
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
      expect(this.alert).toBe('')
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

    const vm = this.mount()
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
    const vm = this.mount()
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    vm.$nextTick(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage).toBeNull()
      expect(this.alert).toBe('Username is Required')
      expect(vm.focusUser).toBe(true)
      expect(vm.focusPassword).toBe(false)
      expect(vm.$router.currentRoute.name).toBe('login')
      done()
    })
  })

  it('logs in without password', function (done) {
    const vm = this.mount()
    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('change'))
    const submitButton = vm.$el.querySelector('input#btnsubmit')
    submitButton.click()
    vm.$nextTick(() => {
      const errorMessage = vm.$el.querySelector('span.red')
      expect(errorMessage).toBeNull()
      expect(this.alert).toBe('Password is Required')
      expect(vm.focusUser).toBe(false)
      expect(vm.focusPassword).toBe(true)
      expect(vm.$router.currentRoute.name).toBe('login')
      done()
    })
  })

  it('redirects if token exists', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.loginDetails.store), {
      status: 200,
      responseText: {
        data: []
      }
    })
    store.state.main[symbols.state.mainToken] = 'token'
    const vm = this.mount()
    moxios.wait(() => {
      expect(vm.$router.currentRoute.name).toBe('dashboard')
      done()
    })
  })
})
