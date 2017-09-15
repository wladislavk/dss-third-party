import Vue from 'vue'
import Router from 'vue-router'
import ScreenerLogin from '../components/screener/ScreenerLogin.vue'
import ScreenerApp from '../components/screener/ScreenerApp.vue'
import ScreenerIntro from '../components/screener/sections/ScreenerIntro.vue'
import ScreenerEpworth from '../components/screener/sections/ScreenerEpworth.vue'
import ScreenerSymptoms from '../components/screener/sections/ScreenerSymptoms.vue'
import ScreenerDiagnoses from '../components/screener/sections/ScreenerDiagnoses.vue'
import ScreenerResults from '../components/screener/sections/ScreenerResults.vue'
import ScreenerDoctor from '../components/screener/sections/ScreenerDoctor.vue'
import ScreenerHst from '../components/screener/sections/ScreenerHst.vue'
import PageNotFound from 'components/services/pageNotFound.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/login',
      name: 'screener-login',
      component: ScreenerLogin
    },
    {
      path: '/screener',
      name: 'screener-main',
      component: ScreenerApp,
      children: [
        {
          path: '/intro',
          name: 'screener-intro',
          component: ScreenerIntro
        },
        {
          path: '/epworth',
          name: 'screener-epworth',
          component: ScreenerEpworth
        },
        {
          path: '/symptoms',
          name: 'screener-symptoms',
          component: ScreenerSymptoms
        },
        {
          path: '/diagnoses',
          name: 'screener-diagnoses',
          component: ScreenerDiagnoses
        },
        {
          path: '/results',
          name: 'screener-results',
          component: ScreenerResults
        },
        {
          path: '/doctor',
          name: 'screener-doctor',
          component: ScreenerDoctor
        },
        {
          path: '/hst',
          name: 'screener-hst',
          component: ScreenerHst
        }
      ],
      meta: {
        requiresAuth: true,
        requiresManageTemplate: true
      }
    },
    {
      path: '*',
      component: PageNotFound
    }
  ]
})
