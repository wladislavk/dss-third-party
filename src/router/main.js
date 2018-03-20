import { STANDARD_META } from '../constants/main'
import ManageLoginComponent from '../components/manage/ManageLogin.vue'
import ManageAppComponent from '../components/manage/ManageApp.vue'
import DashboardRootComponent from '../components/manage/dashboard/DashboardRoot.vue'
import PatientRootComponent from '../components/manage/patients/PatientRoot.vue'
import ManagePatientComponent from '../components/manage/patients/patients.vue'
import Contacts from '../components/manage/contacts/contacts.vue'
import EditingPatients from '../components/manage/patients/editing/editingPatients.vue'
import Vobs from '../components/manage/vobs/vobs.vue'
import ReferredBy from '../components/manage/referredby/referredby.vue'
import PrintReferredByContact from '../components/manage/referredby/print/printReferredByContact.vue'
import Sleeplabs from '../components/manage/sleeplabs/sleeplabs.vue'
import CorporateContacts from '../components/manage/corporate-contacts/corporateContacts.vue'
import LedgerReportFull from '../components/manage/ledgers/report-full/ledgerReportFull.vue'
import ProceduresManualComponent from '../components/manage/education/ProceduresManual.vue'
import MedicineManualComponent from '../components/manage/education/MedicineManual.vue'
import QuickFactsReferenceComponent from '../components/manage/education/QuickFacts.vue'
import EducationVideosComponent from '../components/manage/education/EducationVideos.vue'
import EdxCertificateComponent from '../components/manage/education/EdxCertificate.vue'
import SoftwareTutorialsComponent from '../components/manage/SoftwareTutorials.vue'
import PatientTrackerComponent from '../components/manage/chart/PatientTracker.vue'

export default [
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
        component: PatientRootComponent,
        children: [
          {
            path: 'tracker',
            name: 'patient-tracker',
            component: PatientTrackerComponent,
            meta: STANDARD_META
          },
          {
            path: 'manage',
            name: 'manage-patients',
            component: ManagePatientComponent,
            meta: STANDARD_META
          },
          {
            path: 'edit-patient',
            name: 'edit-patient',
            component: EditingPatients,
            meta: STANDARD_META
          }
        ]
      },
      {
        path: 'contacts',
        name: 'contacts',
        component: Contacts,
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
      },
      {
        path: 'manual',
        name: 'manual',
        component: ProceduresManualComponent,
        meta: STANDARD_META
      },
      {
        path: 'medicine-manual',
        name: 'medicine-manual',
        component: MedicineManualComponent,
        meta: STANDARD_META
      },
      {
        path: 'quick-facts',
        name: 'quick-facts',
        component: QuickFactsReferenceComponent,
        meta: STANDARD_META
      },
      {
        path: 'videos',
        name: 'videos',
        component: EducationVideosComponent,
        meta: STANDARD_META
      },
      {
        path: 'edx-certificate',
        name: 'edx-certificate',
        component: EdxCertificateComponent,
        meta: STANDARD_META
      },
      {
        path: 'sw-tutorials',
        name: 'sw-tutorials',
        component: SoftwareTutorialsComponent,
        meta: STANDARD_META
      }
    ]
  }
]
