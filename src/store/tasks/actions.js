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

  [symbols.actions.retrieveTasksForPatient] ({ rootState, commit, dispatch }, patientId) {
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.tasks.indexForPatient + '/' + patientId).then((response) => {
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
      if (!data.dueDate) {
        reject(new Error('Date is required'))
        return
      }
      if (!data.responsible) {
        reject(new Error('User is required'))
        return
      }
      http.token = rootState.main[symbols.state.mainToken]
      const parsedData = {
        task: data.task,
        due_date: data.dueDate.toISOString().substr(0, 10),
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
  }
}
