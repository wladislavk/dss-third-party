import endpoints from '../../src/endpoints'
import http from '../../src/services/http'
import sinon from 'sinon'
import symbols from '../../src/symbols'
import ErrorHandler from '../../src/modules/handler/HandlerMixin'
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
    it('should retrieve tasks successfully', function (done) {
      const postData = []
      const tasks = {
        data: {
          data: [
            { id: 1 }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(tasks)
      })

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)
      const expectedData = [
        {
          path: endpoints.tasks.index
        }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.setTasks,
          payload: [
            { id: 1 }
          ]
        }
      ]

      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })

    it('should retrieve tasks with error', function (done) {
      const postData = []
      const error = {
        status: 401
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.reject(error)
      })
      const errorData = {
        label: '',
        status: ''
      }
      this.sandbox.stub(ErrorHandler.methods, 'handleErrors').callsFake((label, error) => {
        errorData.label = label
        errorData.status = error.status
      })

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)

      const expectedData = [
        {
          path: endpoints.tasks.index
        }
      ]
      const expectedErrorData = {
        label: 'getTasks',
        status: 401
      }
      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(errorData).toEqual(expectedErrorData)
        done()
      }, 100)
    })
  })

  describe('retrieveTasksForPatient action', () => {
    it('should retrieve patient tasks successfully', function (done) {
      const postData = []
      const tasks = {
        data: {
          data: [
            { id: 1 }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(tasks)
      })

      const patientId = 2
      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, patientId)

      const expectedData = [
        {
          path: endpoints.tasks.indexForPatient + '/2'
        }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.setTasksForPatient,
          payload: [
            { id: 1 }
          ]
        }
      ]

      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })

    it('should retrieve patient tasks with error', function (done) {
      const postData = []
      const error = {
        status: 401
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.reject(error)
      })
      const errorData = {
        label: '',
        status: ''
      }
      this.sandbox.stub(ErrorHandler.methods, 'handleErrors').callsFake((label, error) => {
        errorData.label = label
        errorData.status = error.status
      })

      const patientId = 2
      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, patientId)

      const expectedData = [
        {
          path: endpoints.tasks.indexForPatient + '/2'
        }
      ]
      const expectedErrorData = {
        label: 'getPatientTasks',
        status: 401
      }
      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(errorData).toEqual(expectedErrorData)
        done()
      }, 100)
    })
  })
})
