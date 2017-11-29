import symbols from '../../symbols'

export default {
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
  },
  [symbols.mutations.getTask] (state, task) {
    const taskData = {
      id: task.id,
      dueDate: new Date(task.due_date),
      task: task.task,
      responsible: task.responsibleid,
      status: !!task.status,
      patientName: ''
    }
    if (task.firstname && task.lastname) {
      taskData.patientName = task.firstname + ' ' + task.lastname
    }
    state[symbols.state.currentTask] = taskData
  }
}
