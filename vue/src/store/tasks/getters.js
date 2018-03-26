import symbols from '../../symbols'

export default {
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
}
