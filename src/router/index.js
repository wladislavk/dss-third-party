import Vue from 'vue'
import Router from 'vue-router'
import VueMoment from 'vue-moment'
import MintUI from 'mint-ui'
import axios from 'axios'
import ManageTemplate from '../components/header/header.vue'
import Login from '../components/manage/login/login.vue'
import Index from '../components/manage/dashboard/dashboard.vue'
import Patients from '../components/manage/patients/patients.vue'
import Contacts from '../components/manage/contacts/contacts.vue'
import EditingPatients from '../components/manage/patients/editing/editingPatients.vue'
import Vobs from '../components/manage/vobs/vobs.vue'
import ReferredBy from '../components/manage/referredby/referredby.vue'
import PrintReferredByContact from '../components/manage/referredby/print/printReferredByContact.vue'
import Sleeplabs from '../components/manage/sleeplabs/sleeplabs.vue'
import CorporateContacts from '../components/manage/corporate-contacts/corporateContacts.vue'
import LedgerReportFull from '../components/manage/ledgers/report-full/ledgerReportFull.vue'
import ScreenerRoot from '../components/screener/ScreenerRoot.vue'
import ScreenerLogin from '../components/screener/ScreenerLogin.vue'
import ScreenerApp from '../components/screener/ScreenerApp.vue'
import ScreenerIntro from '../components/screener/sections/ScreenerIntro.vue'
import ScreenerEpworth from '../components/screener/sections/ScreenerEpworth.vue'
import ScreenerSymptoms from '../components/screener/sections/ScreenerSymptoms.vue'
import ScreenerDiagnoses from '../components/screener/sections/ScreenerDiagnoses.vue'
import ScreenerResults from '../components/screener/sections/ScreenerResults.vue'
import ScreenerDoctor from '../components/screener/sections/ScreenerDoctor.vue'
import ScreenerHst from '../components/screener/sections/ScreenerHst.vue'
import PageNotFound from '../components/services/pageNotFound.vue'

Vue.use(Router)
Vue.use(VueMoment)
Vue.use(MintUI)

Vue.component('manage-template', ManageTemplate)

export default new Router({
  mode: 'history',
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
      path: '/screener',
      name: 'screener-root',
      component: ScreenerRoot,
      children: [
        {
          path: 'login',
          name: 'screener-login',
          component: ScreenerLogin
        },
        {
          path: 'main',
          name: 'screener-main',
          component: ScreenerApp,
          children: [
            {
              path: 'intro',
              name: 'screener-intro',
              component: ScreenerIntro
            },
            {
              path: 'epworth',
              name: 'screener-epworth',
              component: ScreenerEpworth
            },
            {
              path: 'symptoms',
              name: 'screener-symptoms',
              component: ScreenerSymptoms
            },
            {
              path: 'diagnoses',
              name: 'screener-diagnoses',
              component: ScreenerDiagnoses
            },
            {
              path: 'results',
              name: 'screener-results',
              component: ScreenerResults
            },
            {
              path: 'doctor',
              name: 'screener-doctor',
              component: ScreenerDoctor
            },
            {
              path: 'hst',
              name: 'screener-hst',
              component: ScreenerHst
            }
          ],
          meta: {
            requiresAuth: true,
            requiresManageTemplate: true
          }
        }
      ]
    },
    {
      path: '*',
      component: PageNotFound
    }
  ],
  beforeEach (to, from, next) {
    if (to.matched.some(record => record.meta.requiresAuth) && !window.storage.get('token')) {
      next({ name: 'login' })
    } else {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + window.storage.get('token')
      next()
    }
  }
})
