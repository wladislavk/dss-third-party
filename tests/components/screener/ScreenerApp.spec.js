import Vue from 'vue'
import endpoints from '../../../src/endpoints'
import http from '../../../src/services/http'
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
        screenerLogin: ScreenerAppComponent
      }
    }

    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    this.vue.$router.push({ name: 'screener-epworth' })
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should go to login if no token present', function (done) {
    this.vm.$nextTick(() => {
      expect(this.vue.$router.currentRoute.name).toBe('screener-login')
      done()
    })
  })

  it('should go to login if logged out', function (done) {

  })

  it('should reset state except session and token', function (done) {

  })
})
