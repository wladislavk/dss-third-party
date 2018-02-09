import Vue from 'vue'
import VueRouter from 'vue-router'
import endpoints from '../../../src/endpoints'
import http from '../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../src/symbols'
import ScreenerLoginComponent from '../../../src/components/screener/ScreenerLogin.vue'
import store from '../../../src/store'

describe('ScreenerLogin', () => {
  beforeEach(function () {
    moxios.install()

    const routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    const Component = Vue.extend(ScreenerLoginComponent)
    this.mount = function () {
      return new Component({
        store: store,
        router: new VueRouter({routes})
      }).$mount()
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
  })

  it('should log in properly', function (done) {
    moxios.stubRequest(process.env.HEADLESS_API_ROOT + 'auth', {
      status: 200,
      responseText: {
        token: 'token'
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.users.current), {
      status: 200,
      responseText: {
        data: {
          userid: 1,
          docid: 2
        }
      }
    })

    const vm = this.mount()
    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = vm.$el.querySelector('button#loginbut')
    loginButton.click()

    moxios.wait(() => {
      expect(store.state.screener[symbols.state.screenerToken]).toBe('token')
      moxios.wait(() => {
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
    moxios.stubRequest(process.env.HEADLESS_API_ROOT + 'auth', {
      status: 403,
      responseText: {
        error: 'error'
      }
    })

    const vm = this.mount()
    const usernameInput = vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = vm.$el.querySelector('button#loginbut')
    loginButton.click()

    moxios.wait(() => {
      expect(store.state.screener[symbols.state.screenerToken]).toBe('')
      const errorDiv = vm.$el.querySelector('span.error')
      expect(errorDiv).not.toBeNull()
      done()
    })
  })

  it('should redirect if token is set', function (done) {
    const vm = this.mount()
    store.commit(symbols.mutations.screenerToken, 'token')

    vm.$nextTick(() => {
      expect(vm.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
