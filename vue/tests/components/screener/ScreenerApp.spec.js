import Vue from 'vue'
import symbols from '../../../src/symbols'
import TestCase from '../../cases/ComponentTestCase'
import ScreenerAppComponent from '../../../src/components/screener/ScreenerApp.vue'

describe('ScreenerApp', () => {
  beforeEach(function () {
    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    this.routes = [
      {
        name: 'screener-intro',
        path: '/intro'
      },
      {
        name: 'screener-epworth',
        path: '/epworth'
      },
      {
        name: 'screener-login',
        path: '/login'
      }
    ]

    this.vueOptions = {
      template: '<div><screener-app></screener-app></div>',
      components: {
        screenerApp: ScreenerAppComponent
      }
    }
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should go to login if no token present', function () {
    this.vueOptions.created = function () {
      this.$router.push({ name: 'screener-epworth' })
    }
    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    expect(this.vue.$router.currentRoute.name).not.toBe('screener-login')
    this.vm = this.vue.$mount()

    expect(this.vue.$router.currentRoute.name).toBe('screener-login')
  })

  it('should go to login if logged out', function (done) {
    this.vueOptions.created = function () {
      this.$router.push({ name: 'screener-epworth' })
      this.$store.commit(symbols.mutations.screenerToken, 'token')
    }
    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    expect(this.vue.$router.currentRoute.name).toBe('screener-epworth')
    const logoutLink = this.vm.$el.querySelector('a#logout_link')
    expect(logoutLink).not.toBeNull()
    spyOn(window, 'confirm').and.returnValue(true)
    logoutLink.click()
    this.vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should reset state except session and token', function (done) {
    this.vueOptions.created = function () {
      this.$router.push({ name: 'screener-epworth' })
      this.$store.commit(symbols.mutations.screenerToken, 'token')
      this.$store.commit(symbols.mutations.sessionData, { docId: 1, userId: 2 })
      this.$store.commit(symbols.mutations.coMorbidityWeight, 10)
    }
    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    expect(this.vue.$router.currentRoute.name).toBe('screener-epworth')
    const resetLink = this.vm.$el.querySelector('a#reset_link')
    let resetNav = this.vm.$el.querySelector('li#reset_nav')
    expect(resetNav.style.display).toBe('')
    spyOn(window, 'confirm').and.returnValue(true)
    resetLink.click()
    this.vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-intro')
      resetNav = this.vm.$el.querySelector('li#reset_nav')
      expect(resetNav.style.display).toBe('none')
      expect(this.vue.$store.state.screener[symbols.state.sessionData]).toEqual({ docId: 1, userId: 2 })
      expect(this.vue.$store.state.screener[symbols.state.screenerToken]).toBe('token')
      expect(this.vue.$store.state.screener[symbols.state.screenerWeights].coMorbidity).toBe(0)
      done()
    })
  })
})
