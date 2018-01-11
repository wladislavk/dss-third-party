import TasksModule from '../../../../src/store/tasks'
import symbols from '../../../../src/symbols'

describe('Tasks module mutations', () => {
  describe('responsibleUsers mutation', () => {
    it('sets responsible users', function () {
      const state = {
        [symbols.state.responsibleUsers]: []
      }
      const data = [
        {
          userid: '1',
          first_name: 'John',
          last_name: 'Smith'
        },
        {
          userid: '2',
          first_name: 'Jane',
          last_name: 'Doe'
        }
      ]
      TasksModule.mutations[symbols.mutations.responsibleUsers](state, data)
      const expected = [
        {
          id: 1,
          fullName: 'John Smith'
        },
        {
          id: 2,
          fullName: 'Jane Doe'
        }
      ]
      expect(state[symbols.state.responsibleUsers]).toEqual(expected)
    })
  })

  describe('getTask mutation', () => {
    it('retrieves task without patient name', function () {
      const state = {
        currentTask: {}
      }
      const task = {
        id: 1,
        due_date: new Date('2014-06-03'),
        task: 'test task',
        responsibleid: 2,
        status: 1,
        firstname: '',
        lastname: '',
        patientid: '0'
      }
      TasksModule.mutations[symbols.mutations.getTask](state, task)
      const expected = {
        id: 1,
        dueDate: new Date('2014-06-03'),
        task: 'test task',
        responsible: 2,
        status: true,
        patientId: 0,
        patientName: ''
      }
      expect(state[symbols.state.currentTask]).toEqual(expected)
    })
    it('retrieves task with patient name', function () {
      const state = {
        currentTask: {}
      }
      const task = {
        id: 1,
        due_date: new Date('2014-06-03'),
        task: 'test task',
        responsibleid: 2,
        status: 1,
        firstname: 'John',
        lastname: 'Doe',
        patientid: '3'
      }
      TasksModule.mutations[symbols.mutations.getTask](state, task)
      const expected = {
        id: 1,
        dueDate: new Date('2014-06-03'),
        task: 'test task',
        responsible: 2,
        status: true,
        patientId: 3,
        patientName: 'John Doe'
      }
      expect(state[symbols.state.currentTask]).toEqual(expected)
    })
  })
})
