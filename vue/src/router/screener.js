import { STANDARD_META } from '../constants/main'
import ScreenerLoginComponent from '../components/screener/ScreenerLogin.vue'
import ScreenerAppComponent from '../components/screener/ScreenerApp.vue'
import ScreenerIntroComponent from '../components/screener/sections/ScreenerIntro.vue'
import ScreenerEpworthComponent from '../components/screener/sections/ScreenerEpworth.vue'
import ScreenerSymptomsComponent from '../components/screener/sections/ScreenerSymptoms.vue'
import ScreenerDiagnosesComponent from '../components/screener/sections/ScreenerDiagnoses.vue'
import ScreenerResultsComponent from '../components/screener/sections/ScreenerResults.vue'
import ScreenerDoctorComponent from '../components/screener/sections/ScreenerDoctor.vue'
import ScreenerHstComponent from '../components/screener/sections/ScreenerHst.vue'

export default [
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
