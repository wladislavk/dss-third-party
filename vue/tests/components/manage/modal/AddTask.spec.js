import moxios from 'moxios'
import store from '../../../../src/store'
import AddTaskComponent from '../../../../src/components/manage/modal/AddTask.vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import symbols from '../../../../src/symbols'
import Alerter from '../../../../src/services/Alerter'
import LocationWrapper from '../../../../src/wrappers/LocationWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('AddTask component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    const users = [
      {
        userid: 1,
        first_name: 'John',
        last_name: 'Doe'
      },
      {
        userid: 2,
        first_name: 'Jane',
        last_name: 'Jones'
      }
    ]
    moxios.stubRequest(http.formUrl(endpoints.users.responsible), {
      status: 200,
      responseText: {
        data: users
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.tasks.index), {
      status: 200,
      responseText: {
        data: []
      }
    })
    store.state.main[symbols.state.modal].name = 'addTask'
    store.state.main[symbols.state.userInfo].plainUserId = 1

    this.testCase.setComponent(AddTaskComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows HTML for new task', function (done) {
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const header = vm.$el.querySelector('td.cat_head')
      expect(header.textContent.trim()).toBe('Add new task')
      const validationRow = vm.$el.querySelector('tr#validation-error')
      expect(validationRow.style.display).toBe('none')
      const taskInput = vm.$el.querySelector('input#task')
      expect(taskInput.getAttribute('value')).toBeNull()
      const datePicker = vm.$el.querySelector('input#due_date')
      expect(datePicker.getAttribute('value')).toBeNull()
      const responsible = vm.$el.querySelector('select#responsibleid')
      expect(responsible.selectedIndex).toBe(0)
      const responsibleOptions = responsible.querySelectorAll('option')
      expect(responsibleOptions.length).toBe(2)
      expect(responsibleOptions[0].getAttribute('value')).toBe('1')
      expect(responsibleOptions[0].textContent).toBe('John Doe')
      const statusCheckbox = vm.$el.querySelector('input#status')
      expect(statusCheckbox.checked).toBe(false)
      const deleteLink = vm.$el.querySelector('a.delete-task')
      expect(deleteLink).toBeNull()
      done()
    })
  })

  it('shows HTML for existing task', function (done) {
    const taskId = 1
    const taskData = {
      id: 1,
      due_date: '2014-08-06',
      task: 'test task',
      responsibleid: 2,
      status: 1,
      firstname: '',
      lastname: ''
    }
    moxios.stubRequest(http.formUrl(endpoints.tasks.show + '/' + taskId), {
      status: 200,
      responseText: {
        data: taskData
      }
    })
    store.state.main[symbols.state.modal].params.id = taskId
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const header = vm.$el.querySelector('td.cat_head')
      expect(header.textContent.trim()).toBe('Add new task')
      const taskInput = vm.$el.querySelector('input#task')
      expect(taskInput.value).toBe('test task')
      const datePicker = vm.$el.querySelector('input#due_date')
      expect(datePicker.value).toBe('08/06/2014')
      const responsible = vm.$el.querySelector('select#responsibleid')
      expect(responsible.selectedIndex).toBe(1)
      const statusCheckbox = vm.$el.querySelector('input#status')
      expect(statusCheckbox.checked).toBe(true)
      const deleteLink = vm.$el.querySelector('a.delete-task')
      expect(deleteLink).not.toBeNull()
      done()
    })
  })

  it('shows HTML for existing task with patient', function (done) {
    const taskId = 1
    const taskData = {
      id: 1,
      due_date: '2014-08-06',
      task: 'test task',
      responsibleid: 2,
      status: 1,
      firstname: 'John',
      lastname: 'Doe'
    }
    moxios.stubRequest(http.formUrl(endpoints.tasks.show + '/' + taskId), {
      status: 200,
      responseText: {
        data: taskData
      }
    })
    store.state.main[symbols.state.modal].params.id = taskId
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const header = vm.$el.querySelector('td.cat_head')
      expect(header.textContent.trim()).toBe('Add new task (John Doe)')
      done()
    })
  })

  it('edits task', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.tasks.store), {
      status: 200,
      responseText: {}
    })
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const taskInput = vm.$el.querySelector('input#task')
      taskInput.value = 'new task'
      taskInput.dispatchEvent(new Event('change'))
      const datePicker = vm.$el.querySelector('input#due_date')
      datePicker.value = '12/03/2020'
      datePicker.dispatchEvent(new Event('change'))
      // Datepicker component does not react to external events
      vm.currentTask.dueDate = new Date('12/03/2020')
      const responsible = vm.$el.querySelector('select#responsibleid')
      responsible.value = '2'
      responsible.dispatchEvent(new Event('change'))
      const submitButton = vm.$el.querySelector('input.addButton')
      submitButton.click()
      moxios.wait(() => {
        expect(store.state.main[symbols.state.modal].name).toBe('')
        const validationRow = vm.$el.querySelector('tr#validation-error')
        expect(validationRow.style.display).toBe('none')
        done()
      })
    })
  })

  it('edits task with validation error', function (done) {
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const submitButton = vm.$el.querySelector('input.addButton')
      submitButton.click()
      moxios.wait(() => {
        expect(store.state.main[symbols.state.modal].name).toBe('addTask')
        const validationRow = vm.$el.querySelector('tr#validation-error')
        expect(validationRow.style.display).toBe('')
        expect(validationRow.textContent).toBe('Task is required')
        done()
      })
    })
  })

  it('deletes task', function (done) {
    this.testCase.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })
    // @todo: uncomment after this page is migrated
    // let redirected = false
    this.testCase.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake(() => {
      // @todo: uncomment after this page is migrated
      // redirected = true
    })
    const taskId = 1
    const taskData = {
      id: 1,
      due_date: '2014-08-06',
      task: 'test task',
      responsibleid: 2,
      status: 1,
      firstname: '',
      lastname: ''
    }
    moxios.stubRequest(http.formUrl(endpoints.tasks.show + '/' + taskId), {
      status: 200,
      responseText: {
        data: taskData
      }
    })
    moxios.stubRequest(http.formUrl(endpoints.tasks.destroy + '/' + taskId), {
      status: 200,
      responseText: {}
    })
    store.state.main[symbols.state.modal].params.id = taskId
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const deleteLink = vm.$el.querySelector('a.delete-task')
      deleteLink.click()
      moxios.wait(() => {
        expect(store.state.main[symbols.state.modal].name).toBe('')
        // @todo: uncomment after this page is migrated
        // expect(redirected).toBe(true)
        done()
      })
    })
  })

  it('deletes task without confirmation', function (done) {
    this.testCase.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })
    const taskId = 1
    const taskData = {
      id: 1,
      due_date: '2014-08-06',
      task: 'test task',
      responsibleid: 2,
      status: 1,
      firstname: '',
      lastname: ''
    }
    moxios.stubRequest(http.formUrl(endpoints.tasks.show + '/' + taskId), {
      status: 200,
      responseText: {
        data: taskData
      }
    })
    store.state.main[symbols.state.modal].params.id = taskId
    const vm = this.testCase.mount()

    moxios.wait(() => {
      const deleteLink = vm.$el.querySelector('a.delete-task')
      deleteLink.click()
      moxios.wait(() => {
        expect(store.state.main[symbols.state.modal].name).toBe('addTask')
        done()
      })
    })
  })
})
