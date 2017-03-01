// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

// global variables
window.constants = require('./modules/constants.js')
window.storage = require('./modules/storage.js')
window.$ = require('jquery/dist/jquery.min.js')
window.swal = require('sweetalert')
window.moment = require('moment')

// centralized event hub
window.eventHub = new Vue()

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
