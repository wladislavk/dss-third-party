import Vue from 'vue'
import endpoints from '../../../src/endpoints'
import http from '../../../src/services/http'
import moxios from 'moxios'
import symbols from '../../../src/symbols'
import TestCase from '../../cases/ComponentTestCase'
import ScreenerLoginComponent from '../../../src/components/screener/ScreenerLogin.vue'

describe('ScreenerLogin', () => {
  beforeEach(function () {
    moxios.install()

    Vue.component('site-seal', {
      template: '<div></div>'
    })

    this.routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ]

    this.vueOptions = {
      template: '<div><screener-login></screener-login></div>',
      components: {
        screenerLogin: ScreenerLoginComponent
      }
    }

    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
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

    const usernameInput = this.vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = this.vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = this.vm.$el.querySelector('button#loginbut')
    loginButton.click()

    moxios.wait(() => {
      expect(this.vue.$store.state.screener[symbols.state.screenerToken]).toBe('token')
      moxios.wait(() => {
        expect(this.vue.$router.currentRoute.name).toBe('screener-intro')
        expect(this.vue.$store.state.screener[symbols.state.sessionData].userId).toBe(1)
        expect(this.vue.$store.state.screener[symbols.state.sessionData].docId).toBe(2)
        const errorDiv = this.vm.$el.querySelector('span.error')
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

    const usernameInput = this.vm.$el.querySelector('input#username')
    usernameInput.value = 'user'
    usernameInput.dispatchEvent(new Event('input'))
    const passwordInput = this.vm.$el.querySelector('input#password')
    passwordInput.value = 'password'
    passwordInput.dispatchEvent(new Event('input'))
    const loginButton = this.vm.$el.querySelector('button#loginbut')
    loginButton.click()

    moxios.wait(() => {
      expect(this.vue.$store.state.screener[symbols.state.screenerToken]).toBe('')
      const errorDiv = this.vm.$el.querySelector('span.error')
      expect(errorDiv).not.toBeNull()
      done()
    })
  })

  it('should redirect if token is set', function (done) {
    const vue = TestCase.getVue(this.vueOptions, this.routes)
    vue.$store.commit(symbols.mutations.screenerToken, 'token')

    const vm = vue.$mount()
    vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-intro')
      done()
    })
  })
})
