import sinon from 'sinon'
import symbols from '../../src/symbols'
import TasksModule from '../../src/store/tasks'
import TestCase from '../cases/StoreTestCase'

describe('Tasks Module', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('tasksNumber getter', () => {
    it('gets number of tasks', function () {
      const state = {
        [symbols.state.tasks]: [
          { id: 1 },
          { id: 2 }
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
          { id: 1 },
          { id: 2 }
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

  describe('removeTask mutation', () => {
    it('should remove a task by id', function () {
      const state = {
        [symbols.state.tasks]: [
          { id: 1 },
          { id: 2 },
          { id: 3 }
        ]
      }
      const removedTask = { id: 2 }
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
          { id: 1 },
          { id: 2 },
          { id: 3 }
        ]
      }
      const removedTask = { id: 2 }
      TasksModule.mutations[symbols.mutations.removeTaskForPatient](state, removedTask)
      const tasks = state[symbols.state.tasksForPatient]
      expect(tasks.length).toBe(2)
      expect(tasks[0].id).toBe(1)
      expect(tasks[1].id).toBe(3)
    })
  })

  describe('retrieveTasks action', () => {
    it('should retrieve tasks successfully', function () {

    })

    it('should retrieve tasks with error', function () {

    })
  })

  describe('retrieveTasksForPatient action', () => {
    it('should retrieve patient tasks successfully', function () {

    })

    it('should retrieve patient tasks with error', function () {

    })
  })
})
