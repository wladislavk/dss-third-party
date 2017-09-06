// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'

// global variables
import constants from './modules/constants.js'

window.constants = constants
window.storage = require('./modules/storage.js')
window.$ = require('jquery/dist/jquery.min.js')
window.jQuery = window.$
window.swal = require('sweetalert')
window.moment = require('moment')
window.accounting = require('accounting')

// centralized event hub
window.eventHub = new Vue()

Vue.prototype.$http = axios

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
