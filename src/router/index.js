import Vue from 'vue'
import Router from 'vue-router'
import MintUI from 'mint-ui'
import axios from 'axios'
import ManageRootComponent from '../components/manage/ManageRoot.vue'
import ScreenerRootComponent from '../components/screener/ScreenerRoot.vue'
import PageNotFoundComponent from '../components/errors/PageNotFound.vue'
import LocalStorageManager from '../services/LocalStorageManager'
import mainRoutes from './main'
import screenerRoutes from './screener'

Vue.use(Router)
Vue.use(MintUI)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/manage',
      name: 'manage-root',
      component: ManageRootComponent,
      children: mainRoutes
    },
    {
      path: '/screener',
      name: 'screener-root',
      component: ScreenerRootComponent,
      children: screenerRoutes
    },
    {
      path: '*',
      component: PageNotFoundComponent
    }
  ],
  beforeEach (to, from, next) {
    if (to.matched.some(record => record.meta.requiresAuth) && !LocalStorageManager.get('token')) {
      // next({ name: 'login' })
    } else {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + LocalStorageManager.get('token')
      next()
    }
  }
})
