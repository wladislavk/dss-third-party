import Vue from 'vue'
import Vuex from 'vuex'
import mainModule from './main'
import contactModule from './contacts'
import screenerModule from './screener'
import tasksModule from './tasks'

Vue.use(Vuex)

const modules = {
  main: mainModule,
  contacts: contactModule,
  screener: screenerModule,
  tasks: tasksModule
}

export default new Vuex.Store({ modules: modules })
