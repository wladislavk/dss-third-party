import endpoints from '../endpoints'
import http from '../services/http'
import ErrorHandler from '../modules/handler/HandlerMixin'

export default {
  state: {
    tasks: [],
    tasksForPatient: []
  },
  getters: {
    tasksNumber (state) {
      return state.tasks.length
    },
    tasksByType (state, { type }) {

    }
  },
  mutations: {
    setTasks (state, tasks) {
      state.tasks = tasks
    }
  },
  actions: {
    retrieveTasks ({ commit }) {
      http.post(endpoints.tasks.all).then((response) => {
        const data = response.data.data
        commit('setTasks', data)
      }).catch((response) => {
        ErrorHandler.methods.handleErrors('getTasks', response)
      })
    }
  }
}
