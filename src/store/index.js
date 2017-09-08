import Vue from 'vue'
import Vuex from 'vuex'
import mainModule from './main'
import contactModule from './contacts'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    main: mainModule,
    contacts: contactModule
  }
})
