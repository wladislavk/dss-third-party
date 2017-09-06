import Vue from 'vue'
import Router from 'vue-router'
import VueMoment from 'vue-moment'
import MintUI from 'mint-ui'
import MaskedInput from 'vue-masked-input'
import ManageTemplate from 'components/header/header.vue'
import Login from 'components/manage/login/login.vue'
import Index from 'components/manage/dashboard/dashboard.vue'
import Patients from 'components/manage/patients/patients.vue'
import Contacts from 'components/manage/contacts/contacts.vue'
import EditingPatients from 'components/manage/patients/editing/editingPatients.vue'
import Vobs from 'components/manage/vobs/vobs.vue'
import ReferredBy from 'components/manage/referredby/referredby.vue'
import PrintReferredByContact from 'components/manage/referredby/print/printReferredByContact.vue'
import Sleeplabs from 'components/manage/sleeplabs/sleeplabs.vue'
import CorporateContacts from 'components/manage/corporate-contacts/corporateContacts.vue'
import LedgerReportFull from 'components/manage/ledgers/report-full/ledgerReportFull.vue'
import PageNotFound from 'components/services/pageNotFound.vue'

Vue.use(Router)
Vue.use(VueMoment)
Vue.use(MintUI)

Vue.component('manage-template', ManageTemplate)
Vue.component('masked-input', MaskedInput)

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
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/patients',
      name: 'patients',
      component: Patients,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/contacts',
      name: 'contacts',
      component: Contacts,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/edit-patient',
      name: 'edit-patient',
      component: EditingPatients,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/vobs',
      name: 'vobs',
      component: Vobs,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/referredby',
      name: 'referredby',
      component: ReferredBy,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/sleeplabs',
      name: 'sleeplabs',
      component: Sleeplabs,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/corporate-contacts',
      name: 'corporate-contacts',
      component: CorporateContacts,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/ledger-report-full',
      name: 'ledger-report-full',
      component: LedgerReportFull,
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '/manage/print-referred-by-contact',
      name: 'print-referred-by-contact',
      component: PrintReferredByContact,
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
