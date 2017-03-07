import Vue from 'vue'
import Router from 'vue-router'
import VueResource from 'vue-resource'
import VueMoment from 'vue-moment'
import MintUI from 'mint-ui'

Vue.use(Router)
Vue.use(VueResource)
Vue.use(VueMoment)
Vue.use(MintUI)

// include the main template
import ManageTemplate from 'components/header/header.vue'
Vue.component('manage-template', ManageTemplate)

// components for routing
import Login from 'components/manage/login/login.vue'
import Index from 'components/manage/dashboard/dashboard.vue'
import Patients from 'components/manage/patients/patients.vue'
import Contacts from 'components/manage/contacts/contacts.vue'
import EditingPatients from 'components/manage/patients/editing/editingPatients.vue'
import Vobs from 'components/manage/vobs/vobs.vue'
import ReferredBy from 'components/manage/referredby/referredby.vue'

// service routes
import PageNotFound from 'components/services/pageNotFound.vue'

const router = new Router({
  routes: [
    {
      path: '/manage/login',
      name: 'login',
      component: Login
    },
    {
      path: '/manage/index',
      name: 'dashboard',
      component: Index,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/manage/patients',
      name: 'patients',
      component: Patients,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/manage/contacts',
      name: 'contacts',
      component: Contacts,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/manage/edit-patient',
      name: 'edit-patient',
      component: EditingPatients,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/manage/vobs',
      name: 'vobs',
      component: Vobs,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/manage/referredby',
      name: 'referredby',
      component: ReferredBy,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '*',
      component: PageNotFound
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && !window.storage.get('token')) {
    next({ name: 'login' })
  } else {
    Vue.http.headers.common['Authorization'] = 'Bearer ' + window.storage.get('token')

    next()
  }
})

export { router as default }
