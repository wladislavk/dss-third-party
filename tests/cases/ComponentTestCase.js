import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../../src/store'

export default {
  getVue (options, routes) {
    Vue.use(VueRouter)
    options = Object.assign({
      store,
      router: this.getRouter(routes)
    }, options)
    return new Vue(options)
  },

  getRouter (routes) {
    routes = routes || []
    return new VueRouter({ routes })
  }
}
