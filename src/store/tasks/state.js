import symbols from '../../symbols'

export default {
  [symbols.state.responsibleUsers]: [],
  [symbols.state.tasks]: [],
  [symbols.state.tasksForPatient]: [],
  [symbols.state.currentTask]: {
    id: 0,
    dueDate: null,
    task: '',
    responsible: 0,
    status: false,
    patientName: '',
    patientId: 0
  }
}
