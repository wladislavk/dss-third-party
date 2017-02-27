import Vue from 'vue'
import Router from 'vue-router'

// include the manage main template
// import ManageTemplate from 'components/header/header'
// Vue.component('manage-template', ManageTemplate)

// components for routing
import Login from 'components/manage/login/login.vue'
import Index from 'components/manage/dashboard/dashboard.vue'
import Patients from 'components/manage/patients/patients.vue'
import Contacts from 'components/manage/contacts/contacts.vue'
import EditingPatients from 'components/manage/patients/editing/editingPatients.vue'
import Vobs from 'components/manage/vobs/vobs.vue'

// service routes
import PageNotFound from 'components/services/pageNotFound.vue'

Vue.use(Router)

export default new Router({
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
      auth: true
    },
    {
      path: '/manage/patients',
      name: 'patients',
      component: Patients,
      auth: true
    },
    {
      path: '/manage/contacts',
      name: 'contacts',
      component: Contacts,
      auth: true
    },
    {
      path: '/manage/edit-patient',
      name: 'edit-patient',
      component: EditingPatients,
      auth: true
    },
    {
      path: '/manage/vobs',
      name: 'vobs',
      component: Vobs,
      auth: true
    },
    {
      path: '*',
      component: PageNotFound
    }
  ]
})
