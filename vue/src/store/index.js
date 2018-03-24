import Vue from 'vue'
import Vuex from 'vuex'
import MainModule from './main'
import DashboardModule from './dashboard'
import ContactModule from './contacts'
import EducationModule from './education'
import PatientsModule from './patients'
import ScreenerModule from './screener'
import TasksModule from './tasks'

Vue.use(Vuex)

const modules = {
  main: MainModule,
  contacts: ContactModule,
  education: EducationModule,
  dashboard: DashboardModule,
  patients: PatientsModule,
  screener: ScreenerModule,
  tasks: TasksModule
}

export default new Vuex.Store({ modules: modules })
