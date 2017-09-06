import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'

export default {
  init () {
    Vue.use(VueRouter)
    Vue.prototype.$http = axios
    window.eventHub = new Vue()
  },

  getVue (options, routes) {
    options = Object.assign({
      router: this.getRouter(routes)
    }, options)
    return new Vue(options)
  },

  getRouter (routes) {
    routes = routes || []
    return new VueRouter({ routes })
  }
}
