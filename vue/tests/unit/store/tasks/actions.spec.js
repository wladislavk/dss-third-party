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
      this.testCase.stubRequest({response: tasks})

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.tasks.index },
          mutations: [
            {
              type: symbols.mutations.setTasks,
              payload: tasks
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('should retrieve tasks with error', function (done) {
      this.testCase.stubRequest({status: 401})

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.tasks.index },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getTasks', 401)
          ]
        })
        done()
      })
    })
  })

  describe('retrieveTasksForPatient action', () => {
    beforeEach(function () {
      this.patientId = 2
      this.expectedHttp = { path: endpoints.tasks.indexForPatient + '/' + this.patientId }
    })
    it('should retrieve patient tasks successfully', function (done) {
      const tasks = [
        { id: 1 }
      ]
      this.testCase.stubRequest({response: tasks})

      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.setTasksForPatient,
              payload: tasks
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('should retrieve patient tasks with error', function (done) {
      this.testCase.stubRequest({status: 401})

      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, this.patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getPatientTasks', 401)
          ]
        })
        done()
      })
    })
  })

  describe('addTask action', () => {
    beforeEach(function () {
      this.taskId = 1
      this.userId = 2
      this.responsibleId = 3
      this.patientId = 4
      this.taskName = 'test task'
      this.testCase.setRootState({
        main: {
          [symbols.state.userInfo]: {
            plainUserId: this.userId
          }
        }
      })
      this.newTaskData = {
        id: 0,
        task: this.taskName,
        dueDate: new Date('01/03/2014'),
        responsible: this.responsibleId,
        status: false,
        patientId: 0
      }
      this.existingTaskData = {
        id: this.taskId,
        task: this.taskName,
        dueDate: new Date('01/03/2014'),
        responsible: this.responsibleId,
        status: false,
        patientId: this.patientId
      }
      this.expectedAddHttp = {
        path: endpoints.tasks.store,
        payload: {
          task: this.taskName,
          due_date: '2014-01-03',
          status: 0,
          responsibleid: this.responsibleId,
          userid: this.userId,
          patientid: 0
        }
      }
      this.expectedUpdateHttp = {
        path: endpoints.tasks.update + '/' + this.taskId,
        payload: {
          task: this.taskName,
          due_date: '2014-01-03',
          status: 0,
          responsibleid: this.responsibleId,
          userid: this.userId,
          patientid: this.patientId
        }
      }
      this.retrieveTasksAction = {
        type: symbols.actions.retrieveTasks,
        payload: {}
      }
    })
    it('should add new task', function (done) {
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.newTaskData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedAddHttp,
          mutations: [],
          actions: [
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('should add new task with error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.newTaskData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedAddHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('addTask')
          ]
        })
        done()
      })
    })
    it('should edit existing task', function (done) {
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.existingTaskData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedUpdateHttp,
          mutations: [],
          actions: [
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('should edit existing task with error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.existingTaskData)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedUpdateHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('updateTask')
          ]
        })
        done()
      })
    })
    it('should trigger error if task is not set', function (done) {
      this.newTaskData.task = ''
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.newTaskData).catch((reason) => {
        message = reason.message
      })

      this.testCase.wait(() => {
        expect(message).toBe('Task is required')
        done()
      })
    })
    it('should trigger error if date is not set', function (done) {
      this.newTaskData.dueDate = ''
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.newTaskData).catch((reason) => {
        message = reason.message
      })

      this.testCase.wait(() => {
        expect(message).toBe('Date is required')
        done()
      })
    })
    it('should trigger error if user is not set', function (done) {
      this.newTaskData.responsible = 0
      let message = ''
      TasksModule.actions[symbols.actions.addTask](this.testCase.mocks, this.newTaskData).catch((reason) => {
        message = reason.message
      })

      this.testCase.wait(() => {
        expect(message).toBe('User is required')
        done()
      })
    })
  })

  describe('responsibleUsers action', () => {
    it('gets responsible users', function (done) {
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({response: response})

      TasksModule.actions[symbols.actions.responsibleUsers](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.responsible },
          mutations: [
            {
              type: symbols.mutations.responsibleUsers,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.responsibleUsers](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.users.responsible },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getResponsibleUsers')
          ]
        })
        done()
      })
    })
  })

  describe('getTask action', () => {
    beforeEach(function () {
      this.taskId = 1
      this.expectedHttp = { path: endpoints.tasks.show + '/' + this.taskId }
    })
    it('gets task by id', function (done) {
      const response = {
        id: this.taskId,
        due_date: '2018-02-03',
        task: 'test task',
        responsibleid: 2,
        status: 1,
        firstname: 'John',
        lastname: 'Doe'
      }
      this.testCase.stubRequest({response: response})

      TasksModule.actions[symbols.actions.getTask](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [
            {
              type: symbols.mutations.getTask,
              payload: response
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.getTask](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getTask')
          ]
        })
        done()
      })
    })
  })

  describe('updateTaskStatus action', () => {
    beforeEach(function () {
      this.taskId = 1
      this.expectedHttp = {
        path: endpoints.tasks.update + '/' + this.taskId,
        payload: { status: 1 }
      }
      this.retrieveTasksAction = {
        type: symbols.actions.retrieveTasks,
        payload: {}
      }
    })
    it('updates status without patient', function (done) {
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 0
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('updates status with patient', function (done) {
      const patientId = 2
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = patientId
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.retrieveTasksForPatient,
              payload: patientId
            },
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.updateTaskStatus](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('updateTaskToActive')
          ]
        })
        done()
      })
    })
  })

  describe('deleteTask action', () => {
    beforeEach(function () {
      this.taskId = 1
      this.expectedHttp = { path: endpoints.tasks.destroy + '/' + this.taskId }
      this.retrieveTasksAction = {
        type: symbols.actions.retrieveTasks,
        payload: {}
      }
    })
    it('deletes task', function (done) {
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = 0
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('deletes task for patient', function (done) {
      const patientId = 2
      this.testCase.mocks.rootState.patients[symbols.state.patientId] = patientId
      this.testCase.stubRequest({})

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            {
              type: symbols.actions.retrieveTasksForPatient,
              payload: patientId
            },
            this.retrieveTasksAction
          ]
        })
        done()
      })
    })
    it('handles error', function (done) {
      this.testCase.stubErrorRequest()

      TasksModule.actions[symbols.actions.deleteTask](this.testCase.mocks, this.taskId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: this.expectedHttp,
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('deleteTask')
          ]
        })
        done()
      })
    })
  })
})
