import Vue from 'vue'
import Router from 'vue-router'
import MintUI from 'mint-ui'
import axios from 'axios'
import ManageRootComponent from '../components/manage/ManageRoot.vue'
import ManageLoginComponent from '../components/manage/ManageLogin.vue'
import ManageAppComponent from '../components/manage/ManageApp.vue'
import DashboardRootComponent from '../components/manage/dashboard/DashboardRoot.vue'
import Patients from '../components/manage/patients/patients.vue'
import Contacts from '../components/manage/contacts/contacts.vue'
import EditingPatients from '../components/manage/patients/editing/editingPatients.vue'
import Vobs from '../components/manage/vobs/vobs.vue'
import ReferredBy from '../components/manage/referredby/referredby.vue'
import PrintReferredByContact from '../components/manage/referredby/print/printReferredByContact.vue'
import Sleeplabs from '../components/manage/sleeplabs/sleeplabs.vue'
import CorporateContacts from '../components/manage/corporate-contacts/corporateContacts.vue'
import LedgerReportFull from '../components/manage/ledgers/report-full/ledgerReportFull.vue'
import ScreenerRootComponent from '../components/screener/ScreenerRoot.vue'
import ScreenerLoginComponent from '../components/screener/ScreenerLogin.vue'
import ScreenerAppComponent from '../components/screener/ScreenerApp.vue'
import ScreenerIntroComponent from '../components/screener/sections/ScreenerIntro.vue'
import ScreenerEpworthComponent from '../components/screener/sections/ScreenerEpworth.vue'
import ScreenerSymptomsComponent from '../components/screener/sections/ScreenerSymptoms.vue'
import ScreenerDiagnosesComponent from '../components/screener/sections/ScreenerDiagnoses.vue'
import ScreenerResultsComponent from '../components/screener/sections/ScreenerResults.vue'
import ScreenerDoctorComponent from '../components/screener/sections/ScreenerDoctor.vue'
import ScreenerHstComponent from '../components/screener/sections/ScreenerHst.vue'
import PageNotFound from '../components/errors/pageNotFound.vue'
import storage from '../modules/storage'
import { STANDARD_META } from '../constants'

Vue.use(Router)
Vue.use(MintUI)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/manage',
      name: 'manage-root',
      component: ManageRootComponent,
      children: [
        {
          path: 'login',
          name: 'main-login',
          component: ManageLoginComponent
        },
        {
          path: 'main',
          name: 'manage-main',
          component: ManageAppComponent,
          children: [
            {
              path: 'index',
              name: 'dashboard',
              component: DashboardRootComponent,
              meta: STANDARD_META
            },
            {
              path: 'patients',
              name: 'patients',
              component: Patients,
              meta: STANDARD_META
            },
            {
              path: 'contacts',
              name: 'contacts',
              component: Contacts,
              meta: STANDARD_META
            },
            {
              path: 'edit-patient',
              name: 'edit-patient',
              component: EditingPatients,
              meta: STANDARD_META
            },
            {
              path: 'vobs',
              name: 'vobs',
              component: Vobs,
              meta: STANDARD_META
            },
            {
              path: 'referredby',
              name: 'referredby',
              component: ReferredBy,
              meta: STANDARD_META
            },
            {
              path: 'sleeplabs',
              name: 'sleeplabs',
              component: Sleeplabs,
              meta: STANDARD_META
            },
            {
              path: 'corporate-contacts',
              name: 'corporate-contacts',
              component: CorporateContacts,
              meta: STANDARD_META
            },
            {
              path: 'ledger-report-full',
              name: 'ledger-report-full',
              component: LedgerReportFull,
              meta: STANDARD_META
            },
            {
              path: 'print-referred-by-contact',
              name: 'print-referred-by-contact',
              component: PrintReferredByContact,
              meta: {
                requiresAuth: true
              }
            }
          ]
        }
      ]
    },
    {
      path: '/screener',
      name: 'screener-root',
      component: ScreenerRootComponent,
      children: [
        {
          path: 'login',
          name: 'screener-login',
          component: ScreenerLoginComponent
        },
        {
          path: 'main',
          name: 'screener-main',
          component: ScreenerAppComponent,
          children: [
            {
              path: 'intro',
              name: 'screener-intro',
              component: ScreenerIntroComponent
            },
            {
              path: 'epworth',
              name: 'screener-epworth',
              component: ScreenerEpworthComponent
            },
            {
              path: 'symptoms',
              name: 'screener-symptoms',
              component: ScreenerSymptomsComponent
            },
            {
              path: 'diagnoses',
              name: 'screener-diagnoses',
              component: ScreenerDiagnosesComponent
            },
            {
              path: 'results',
              name: 'screener-results',
              component: ScreenerResultsComponent
            },
            {
              path: 'doctor',
              name: 'screener-doctor',
              component: ScreenerDoctorComponent
            },
            {
              path: 'hst',
              name: 'screener-hst',
              component: ScreenerHstComponent
            }
          ],
          meta: STANDARD_META
        }
      ]
    },
    {
      path: '*',
      component: PageNotFound
    }
  ],
  beforeEach (to, from, next) {
    if (to.matched.some(record => record.meta.requiresAuth) && !storage.get('token')) {
      // next({ name: 'login' })
    } else {
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + storage.get('token')
      next()
    }
  }
})
