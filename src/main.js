// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import AppComponent from './components/App.vue'
import router from './router'
import axios from 'axios'
import store from './store'
import constants from './modules/constants'
import $ from 'jquery'
import VueMoment from 'vue-moment'

window.constants = constants
window.$ = $
window.jQuery = $
const buttonUI = require('jquery-ui/button')
window.$.fn.extend = buttonUI
window.swal = require('sweetalert')
window.moment = require('moment')
window.accounting = require('accounting')

// centralized event hub
window.eventHub = new Vue()

Vue.prototype.$http = axios

Vue.use(VueMoment)

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
