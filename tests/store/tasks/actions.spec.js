import endpoints from '../../../src/endpoints'
import http from '../../../src/services/http'
import sinon from 'sinon'
import symbols from '../../../src/symbols'
import TasksModule from '../../../src/store/tasks'
import TestCase from '../../cases/StoreTestCase'

describe('Tasks module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
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

      TasksModule.actions[symbols.actions.retrieveTasks](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getTasks',
            response: {status: 401}
          }
        }
      ]

      const expectedData = [
        {
          path: endpoints.tasks.index
        }
      ]
      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
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

      const patientId = 2
      TasksModule.actions[symbols.actions.retrieveTasksForPatient](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getPatientTasks',
            response: {status: 401}
          }
        }
      ]

      const expectedData = [
        {
          path: endpoints.tasks.indexForPatient + '/2'
        }
      ]
      setTimeout(() => {
        expect(postData).toEqual(expectedData)
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })
})
