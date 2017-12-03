import moment from 'moment'
import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'

export default {
  [symbols.actions.retrieveTasks] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.tasks.index).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.setTasks, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getTasks', response: response})
    })
  },

  [symbols.actions.retrieveTasksForPatient] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.tasks.indexForPatient + '/' + rootState.main[symbols.state.patientId]).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.setTasksForPatient, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getPatientTasks', response: response})
    })
  },

  [symbols.actions.addTask] ({ rootState, dispatch }, data) {
    return new Promise((resolve, reject) => {
      if (!data.task) {
        reject(new Error('Task is required'))
        return
      }
      if (!data.dueDate || !(data.dueDate instanceof Date)) {
        reject(new Error('Date is required'))
        return
      }
      if (!data.responsible) {
        reject(new Error('User is required'))
        return
      }
      http.token = rootState.main[symbols.state.mainToken]
      const dueDate = moment(data.dueDate).format().substr(0, 10)
      const parsedData = {
        task: data.task,
        due_date: dueDate,
        status: +data.status,
        responsibleid: data.responsible,
        userid: rootState.main[symbols.state.userInfo].plainUserId,
        patientid: 0
      }
      if (data.id) {
        http.put(endpoints.tasks.update + '/' + data.id, parsedData).then(() => {
          dispatch(symbols.actions.retrieveTasks)
          resolve()
        }).catch((response) => {
          dispatch(symbols.actions.handleErrors, {title: 'updateTask', response: response})
          reject(new Error())
        })
        return
      }
      http.post(endpoints.tasks.store, parsedData).then(() => {
        dispatch(symbols.actions.retrieveTasks)
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'addTask', response: response})
        reject(new Error())
      })
    })
  },

  [symbols.actions.responsibleUsers] ({ rootState, commit, dispatch }) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.users.responsible).then((response) => {
      const data = response.data.data
      commit(symbols.mutations.responsibleUsers, data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getResponsibleUsers', response: response})
    })
  },

  [symbols.actions.getTask] ({ rootState, commit, dispatch }, taskId) {
    return new Promise((resolve, reject) => {
      http.token = rootState.main[symbols.state.mainToken]
      http.get(endpoints.tasks.show + '/' + taskId).then((response) => {
        const data = response.data.data
        commit(symbols.mutations.getTask, data)
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'getTask', response: response})
        reject(new Error())
      })
    })
  },

  [symbols.actions.updateTaskStatus] ({ rootState, dispatch }, taskId) {
    const data = {
      status: 1
    }
    return new Promise((resolve, reject) => {
      http.token = rootState.main[symbols.state.mainToken]
      http.put(endpoints.tasks.update + '/' + taskId, data).then(() => {
        if (rootState.main[symbols.state.patientId]) {
          dispatch(symbols.actions.retrieveTasksForPatient)
        }
        dispatch(symbols.actions.retrieveTasks)
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'updateTaskToActive', response: response})
        reject(new Error())
      })
    })
  },

  [symbols.actions.deleteTask] ({ rootState, dispatch }, taskId) {
    return new Promise((resolve, reject) => {
      http.token = rootState.main[symbols.state.mainToken]
      http.delete(endpoints.tasks.destroy + '/' + taskId).then(() => {
        if (rootState.main[symbols.state.patientId]) {
          dispatch(symbols.actions.retrieveTasksForPatient)
        }
        dispatch(symbols.actions.retrieveTasks)
        resolve()
      }).catch((response) => {
        dispatch(symbols.actions.handleErrors, {title: 'deleteTask', response: response})
        reject(new Error())
      })
    })
  }
}
