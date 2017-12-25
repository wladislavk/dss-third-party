import Vue from 'vue'
import Vuex from 'vuex'
import MainModule from './main'
import DashboardModule from './dashboard'
import ContactModule from './contacts'
import PatientsModule from './patients'
import ScreenerModule from './screener'
import TasksModule from './tasks'
import FlowsheetModule from './flowsheet'

Vue.use(Vuex)

const modules = {
  main: MainModule,
  contacts: ContactModule,
  dashboard: DashboardModule,
  flowsheet: FlowsheetModule,
  patients: PatientsModule,
  screener: ScreenerModule,
  tasks: TasksModule
}

export default new Vuex.Store({ modules: modules })
