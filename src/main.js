// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import AppComponent from './App.vue'
import SiteSealComponent from './components/SiteSeal.vue'
import router from './router'
import axios from 'axios'
import store from './store'
import constants from './modules/constants'

window.constants = constants
window.storage = require('./modules/storage.js')
window.$ = require('jquery/dist/jquery.min.js')
window.jQuery = window.$
window.swal = require('sweetalert')
window.moment = require('moment')
window.accounting = require('accounting')
// window.fancybox = require('../static/third-party/jquery.fancybox')

// centralized event hub
window.eventHub = new Vue()

Vue.prototype.$http = axios

Vue.component('site-seal', SiteSealComponent)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App></App>',
  components: {
    App: AppComponent
  }
})
