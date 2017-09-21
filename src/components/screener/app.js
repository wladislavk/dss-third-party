import Vue from 'vue'
import router from 'vue-router'
import axios from 'axios'
import store from '../../store'
import ScreenerApp from './ScreenerApp'

window.$ = require('jquery/dist/jquery.min.js')
window.jQuery = window.$
window.fancybox = require('../../../static/third-party/jquery.fancybox')

Vue.prototype.$http = axios

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {
    ScreenerApp
  }
})
