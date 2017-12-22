import symbols from '../../../src/symbols'
import TasksModule from '../../../src/store/tasks'

describe('Tasks module getters', () => {
  describe('tasksNumber getter', () => {
    it('gets number of tasks', function () {
      const state = {
        [symbols.state.tasks]: [
          {id: 1},
          {id: 2}
        ]
      }
      const tasksNumber = TasksModule.getters[symbols.getters.tasksNumber](state)
      expect(tasksNumber).toBe(2)
    })
  })

  describe('tasksByType getter', () => {
    it('gets tasks by type', function () {
      const state = {
        [symbols.state.tasks]: [
          {
            id: 1,
            type: 'foo'
          },
          {
            id: 2,
            type: 'foo'
          },
          {
            id: 3,
            type: 'bar'
          }
        ]
      }
      const tasks = TasksModule.getters[symbols.getters.tasksByType](state)('foo')
      expect(tasks.length).toBe(2)
      expect(tasks[0].id).toBe(1)
      expect(tasks[1].id).toBe(2)
    })
  })

  describe('tasksPatientNumber getter', () => {
    it('gets number of tasks for patient', function () {
      const state = {
        [symbols.state.tasksForPatient]: [
          {id: 1},
          {id: 2}
        ]
      }
      const tasksNumber = TasksModule.getters[symbols.getters.tasksPatientNumber](state)
      expect(tasksNumber).toBe(2)
    })
  })

  describe('tasksPatientByType getter', () => {
    it('gets patient tasks by type', function () {
      const state = {
        [symbols.state.tasksForPatient]: [
          {
            id: 1,
            type: 'foo'
          },
          {
            id: 2,
            type: 'foo'
          },
          {
            id: 3,
            type: 'bar'
          }
        ]
      }
      const tasks = TasksModule.getters[symbols.getters.tasksPatientByType](state)('foo')
      expect(tasks.length).toBe(2)
      expect(tasks[0].id).toBe(1)
      expect(tasks[1].id).toBe(2)
    })
  })
})
