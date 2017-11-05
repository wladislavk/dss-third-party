import endpoints from '../endpoints'
import http from '../services/http'
import symbols from '../symbols'

export default {
  state: {
    [symbols.state.tasks]: [],
    [symbols.state.tasksForPatient]: []
  },
  getters: {
    [symbols.getters.tasksNumber] (state) {
      return state[symbols.state.tasks].length
    },
    [symbols.getters.tasksByType] (state) {
      return (type) => {
        const tasks = []
        for (let task of state[symbols.state.tasks]) {
          if (task.type === type) {
            tasks.push(task)
          }
        }
        return tasks
      }
    },
    [symbols.getters.tasksPatientNumber] (state) {
      return state[symbols.state.tasksForPatient].length
    },
    [symbols.getters.tasksPatientByType] (state) {
      return (type) => {
        const tasks = []
        for (let task of state[symbols.state.tasksForPatient]) {
          if (task.type === type) {
            tasks.push(task)
          }
        }
        return tasks
      }
    }
  },
  mutations: {
    [symbols.mutations.setTasks] (state, tasks) {
      state[symbols.state.tasks] = tasks
    },
    [symbols.mutations.removeTask] (state, removedTask) {
      for (let [index, task] of state[symbols.state.tasks].entries()) {
        if (task.id === removedTask.id) {
          state[symbols.state.tasks].splice(index, 1)
        }
      }
    },
    [symbols.mutations.setTasksForPatient] (state, tasks) {
      state[symbols.state.tasksForPatient] = tasks
    },
    [symbols.mutations.removeTaskForPatient] (state, removedTask) {
      for (let [index, task] of state[symbols.state.tasksForPatient].entries()) {
        if (task.id === removedTask.id) {
          state[symbols.state.tasksForPatient].splice(index, 1)
        }
      }
    }
  },
  actions: {
    [symbols.actions.retrieveTasks] ({ commit, dispatch }) {
      http.get(endpoints.tasks.index).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.setTasks, data)
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getTasks', response: response})
      })
    },
    [symbols.actions.retrieveTasksForPatient] ({ commit, dispatch }, patientId) {
      http.get(endpoints.tasks.indexForPatient + '/' + patientId).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.setTasksForPatient, data)
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getPatientTasks', response: response})
      })
    }
  }
}
