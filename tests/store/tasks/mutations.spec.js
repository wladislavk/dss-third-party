import symbols from '../../../src/symbols'
import TasksModule from '../../../src/store/tasks'

describe('Tasks module mutations', () => {
  describe('removeTask mutation', () => {
    it('should remove a task by id', function () {
      const state = {
        [symbols.state.tasks]: [
          {id: 1},
          {id: 2},
          {id: 3}
        ]
      }
      const removedTask = {id: 2}
      TasksModule.mutations[symbols.mutations.removeTask](state, removedTask)
      const tasks = state[symbols.state.tasks]
      expect(tasks.length).toBe(2)
      expect(tasks[0].id).toBe(1)
      expect(tasks[1].id).toBe(3)
    })
  })

  describe('removeTaskForPatient mutation', () => {
    it('should remove a patient task by id', function () {
      const state = {
        [symbols.state.tasksForPatient]: [
          {id: 1},
          {id: 2},
          {id: 3}
        ]
      }
      const removedTask = {id: 2}
      TasksModule.mutations[symbols.mutations.removeTaskForPatient](state, removedTask)
      const tasks = state[symbols.state.tasksForPatient]
      expect(tasks.length).toBe(2)
      expect(tasks[0].id).toBe(1)
      expect(tasks[1].id).toBe(3)
    })
  })
})
