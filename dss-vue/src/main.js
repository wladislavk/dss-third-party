import Vue         from 'vue'
import VueRouter   from 'vue-router'
import VueResource from 'vue-resource'

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(require('vue-moment'))

// include the manage main template
import ManageTemplate from './components/header/header.vue'

Vue.component('manage-template', ManageTemplate);

// components for routing
import Login from './components/manage/login/login.vue'
import Index from './components/manage/dashboard/dashboard.vue'

// global variables
window.config    = require('./modules/config.js');
window.constants = require('./modules/constants.js');
window.storage   = require('./modules/storage.js');

/*
 * The router needs a root component to render.
 * For demo purposes, we will just use an empty one
 * because we are using the HTML as the app template.
 * !! Note that the App is not a Vue instance.
*/
var App = Vue.extend({})

/* 
 * Create a router instance.
 * You can pass in additional options here.
*/
var router = new VueRouter({
    hashbang: false
})

/*
 * Define some routes.
 * Each route should map to a component. The "component" can
 * either be an actual component constructor created via
 * Vue.extend(), or just a component options object.
*/
router.map({
    '/manage/index': {
        component : Index,
        auth      : true
    },
    '/manage/login': {
        component : Login
    }
})

router.beforeEach(function (transition) {
    if (transition.to.auth && !window.storage.get('token')) {
        transition.redirect('/manage/login');
    } else {
        Vue.http.headers.common['Authorization'] = 'Bearer ' + window.storage.get('token');

        transition.next();
    }
})

/*
 * Now we can start the app!
 * The router will create an instance of App and mount to
 * the element matching the selector #app.
*/
router.start(App, '#app')
