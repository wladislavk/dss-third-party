import Vue from 'vue'
import Router from 'vue-router'
import Hello from 'components/Hello'

// include the manage main template
import ManageTemplate from 'components/header/header'
Vue.component('manage-template', ManageTemplate)

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Hello',
      component: Hello
    }
  ]
})
