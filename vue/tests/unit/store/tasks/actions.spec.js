import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import TasksModule from '../../../../src/store/tasks'
import TestCase from '../../../cases/StoreTestCase'

describe('Tasks module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('retrieveTasks action', () => {
    it('should retrieve tasks successfully', function (done) {
      const tasks = [
        { id: 1 }
      ]
      this.testCase.stubRequest({
        method: 'get',
        response: tasks
      })

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)
      const expectedData = [
        { path: endpoints.tasks.index }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.setTasks,
          payload: tasks
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })

    it('should retrieve tasks with error', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 401
      })

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getTasks',
            response: new Error({status: 401})
          }
        }
      ]

      const expectedData = [
        { path: endpoints.tasks.index }
      ]
      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('retrieveTasksForPatient action', () => {
    it('should retrieve patient tasks successfully', function (done) {
      const tasks = [
        { id: 1 }
      ]
      this.testCase.stubRequest({
        method: 'get',
        response: tasks
      })

      const patientId = 2
      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, patientId)

      const expectedData = [
        { path: endpoints.tasks.indexForPatient + '/2' }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.setTasksForPatient,
          payload: tasks
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })

    it('should retrieve patient tasks with error', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 401
      })

      const patientId = 2
      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getPatientTasks',
            response: new Error({status: 401})
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('addTask action', () => {
    beforeEach(function () {
      this.testCase.setRootState({
        main: {
          [symbols.state.userInfo]: {
            plainUserId: 2
          }
        }
      })
    })

    it('should add new task', function (done) {
      const data = {
        id: 0,
        task: 'test task',
        dueDate: new Date('01/03/2014'),
        responsible: 3,
        status: false,
        patientId: 0
      }
      this.testCase.stubRequest({
        method: 'post'
      })

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data)

      const expectedData = [
        {
          path: endpoints.tasks.store,
          payload: {
            task: 'test task',
            due_date: '2014-01-03',
            status: 0,
            responsibleid: 3,
            userid: 2,
            patientid: 0
          }
        }
      ]
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('should add new task with error', function (done) {
      const data = {
        id: 0,
        task: 'test task',
        dueDate: new Date('01/03/2014'),
        responsible: 3,
        status: false
      }
      this.testCase.stubRequest({
        method: 'post',
        status: 500
      })

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data)

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'addTask',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('should edit existing task', function (done) {
      const data = {
        id: 1,
        task: 'test task',
        dueDate: new Date('01/03/2014'),
        responsible: 3,
        status: false,
        patientId: 4
      }
      this.testCase.stubRequest({
        method: 'put'
      })

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data)

      const expectedData = [
        {
          path: endpoints.tasks.update + '/1',
          payload: {
            task: 'test task',
            due_date: '2014-01-03',
            status: 0,
            responsibleid: 3,
            userid: 2,
            patientid: 4
          }
        }
      ]
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('should edit existing task with error', function (done) {
      const data = {
        id: 1,
        task: 'test task',
        dueDate: new Date('01/03/2014'),
        responsible: 3,
        status: false
      }
      this.testCase.stubRequest({
        method: 'put',
        status: 500
      })

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data)

      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'updateTask',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('should trigger error if task is not set', function (done) {
      const data = {
        id: 0,
        task: '',
        dueDate: new Date('01/03/2014'),
        responsible: 3,
        status: false
      }
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data).catch((reason) => {
        message = reason.message
      })
      setTimeout(() => {
        expect(message).toBe('Task is required')
        done()
      }, 100)
    })
    it('should trigger error if date is not set', function (done) {
      const data = {
        id: 0,
        task: 'test task',
        dueDate: '',
        responsible: 3,
        status: false
      }
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data).catch((reason) => {
        message = reason.message
      })
      setTimeout(() => {
        expect(message).toBe('Date is required')
        done()
      }, 100)
    })
    it('should trigger error if user is not set', function (done) {
      const data = {
        id: 0,
        task: 'test task',
        dueDate: new Date('01/03/2014'),
        responsible: 0,
        status: false
      }
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, data).catch((reason) => {
        message = reason.message
      })
      setTimeout(() => {
        expect(message).toBe('User is required')
        done()
      }, 100)
    })
  })

  describe('responsibleUsers action', () => {
    it('gets responsible users', function (done) {
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({
        method: 'get',
        response: response
      })

      TasksModule.actions[symbols.actions.responsibleUsers](this.testCase.mocks)
      const expectedData = [
        {
          path: endpoints.users.responsible
        }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.responsibleUsers,
          payload: response
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 500
      })

      TasksModule.actions[symbols.actions.responsibleUsers](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getResponsibleUsers',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('getTask action', () => {
    it('gets task by id', function (done) {
      const taskId = 1
      const response = {
        id: 1,
        due_date: '2018-02-03',
        task: 'test task',
        responsibleid: 2,
        status: 1,
        firstname: 'John',
        lastname: 'Doe'
      }
      this.testCase.stubRequest({
        method: 'get',
        response: response
      })

      TasksModule.actions[symbols.actions.getTask](this.testCase.mocks, taskId)
      const expectedData = [
        {
          path: endpoints.tasks.show + '/1'
        }
      ]
      const expectedMutations = [
        {
          type: symbols.mutations.getTask,
          payload: response
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.mutations).toEqual(expectedMutations)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const taskId = 1
      this.testCase.stubRequest({
        method: 'get',
        status: 500
      })

      TasksModule.actions[symbols.actions.getTask](this.testCase.mocks, taskId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getTask',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('updateTaskStatus action', () => {
    it('updates status without patient', function (done) {
      const taskId = 1
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 0
      this.testCase.stubRequest({
        method: 'put'
      })

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, taskId)
      const expectedData = [
        {
          path: endpoints.tasks.update + '/1',
          payload: { status: 1 }
        }
      ]
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('updates status with patient', function (done) {
      const taskId = 1
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 2
      this.testCase.stubRequest({
        method: 'put'
      })

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, taskId)
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasksForPatient,
          payload: 2
        },
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const taskId = 1
      this.testCase.stubRequest({
        method: 'put',
        status: 500
      })

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, taskId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'updateTaskToActive',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('deleteTask action', () => {
    it('deletes task', function (done) {
      const taskId = 1
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 0
      this.testCase.stubRequest({
        method: 'delete'
      })

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, taskId)
      const expectedData = [
        { path: endpoints.tasks.destroy + '/1' }
      ]
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('deletes task for patient', function (done) {
      const taskId = 1
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 2
      this.testCase.stubRequest({
        method: 'delete'
      })

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, taskId)
      const expectedActions = [
        {
          type: symbols.actions.retrieveTasksForPatient,
          payload: 2
        },
        {
          type: symbols.actions.retrieveTasks,
          payload: {}
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const taskId = 1
      this.testCase.stubRequest({
        method: 'delete',
        status: 500
      })

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, taskId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'deleteTask',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })
})
