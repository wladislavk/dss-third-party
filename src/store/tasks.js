import endpoints from '../endpoints'
import http from '../services/http'
import symbols from '../symbols'

export default {
  state: {
    [symbols.state.responsibleUsers]: [],
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
    [symbols.mutations.responsibleUsers] (state, data) {
      const revisedData = []
      for (let user of data) {
        revisedData.push({
          id: parseInt(user.userid),
          fullName: user.first_name + ' ' + user.last_name
        })
      }
      state[symbols.state.responsibleUsers] = revisedData
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
    [symbols.actions.retrieveTasks] ({ state, commit, dispatch }) {
      http.token = state[symbols.state.screenerToken]
      http.get(endpoints.tasks.index).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.setTasks, data)
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getTasks', response: response})
      })
    },
    [symbols.actions.retrieveTasksForPatient] ({ state, commit, dispatch }, patientId) {
      http.token = state[symbols.state.screenerToken]
      http.get(endpoints.tasks.indexForPatient + '/' + patientId).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.setTasksForPatient, data)
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getPatientTasks', response: response})
      })
    },
    [symbols.actions.addTask] ({ state, dispatch }, data) {
      return new Promise((resolve, reject) => {
        // @todo: move to API to prevent timezone inconsistency
        data.due_date = new Date().toISOString().substr(0, 10)
        data.userid = state[symbols.state.userInfo].plainUserId
        http.token = state[symbols.state.screenerToken]
        http.post(endpoints.tasks.store, data).then(() => {
          resolve()
        }).catch((response) => {
          dispatch(symbols.actions.handleErrors, {title: 'addTask', response: response})
          reject(new Error())
        })
      })
    },
    [symbols.actions.responsibleUsers] ({ state, commit, dispatch }) {
      http.token = state[symbols.state.screenerToken]
      http.get(endpoints.users.responsible).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.responsibleUsers, data)
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getResponsibleUsers', response: response})
      })
    }
  }
}
