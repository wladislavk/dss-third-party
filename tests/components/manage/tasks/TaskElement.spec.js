import Vue from 'vue'
import VueMoment from 'vue-moment'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import TaskElementComponent from '../../../../src/components/manage/tasks/TaskElement.vue'
import { LEGACY_URL } from '../../../../src/constants/main'

describe('TaskElement component', () => {
  beforeEach(function () {
    moxios.install()
    Vue.use(VueMoment)
    const Component = Vue.extend(TaskElementComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
    this.task = {
      id: 1,
      patientid: 2,
      task: 'task 1',
      due_date: '2016-03-02 10:53:00',
      firstname: '',
      lastname: ''
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should display base HTML', function () {
    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    const input = vm.$el.querySelector('input')
    expect(input.getAttribute('value')).toBe('1')
    expect(input.getAttribute('class')).toBe('task_status task_status_general')
    const taskContent = vm.$el.querySelector('div.task_content')
    expect(taskContent.getAttribute('class')).toBe('task_content task_content_general')
    expect(taskContent.textContent.trim()).toBe('task 1')
  })

  it('should display HTML for patient', function () {
    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: true
    }
    const vm = this.mount(propsData)
    const input = vm.$el.querySelector('input')
    expect(input.getAttribute('class')).toBe('task_status')
    const taskContent = vm.$el.querySelector('div.task_content')
    expect(taskContent.getAttribute('class')).toBe('task_content task_content_patient')
  })

  it('should display HTML for due date', function () {
    const propsData = {
      task: this.task,
      dueDate: true,
      isPatient: false
    }
    const vm = this.mount(propsData)
    const dueDateSpan = vm.$el.querySelector('span.task_due_date')
    expect(dueDateSpan.textContent).toBe('03 02 - ')
  })

  it('should display HTML for first name and last name', function () {
    this.task.firstname = 'John'
    this.task.lastname = 'Doe'
    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    const nameSpan = vm.$el.querySelector('span.task_name')
    expect(nameSpan.textContent).toBe('(John Doe)')
    const nameLink = nameSpan.querySelector('a.task_name_link')
    expect(nameLink.getAttribute('href')).toBe(LEGACY_URL + 'add_patient.php?ed=2&addtopat=1&pid=2')
  })

  it('should display HTML for patient with first name and last name', function () {
    this.task.firstname = 'John'
    this.task.lastname = 'Doe'
    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: true
    }
    const vm = this.mount(propsData)
    const nameSpan = vm.$el.querySelector('span.task_name')
    expect(nameSpan.textContent).toBe('John Doe')
  })

  it('should fire onMouseEnter and onMouseLeave', function (done) {
    const propsData = {
      task: this.task,
      dueDate: true,
      isPatient: true
    }
    const vm = this.mount(propsData)
    const li = vm.$el
    const taskExtra = li.querySelector('div.task_extra')
    expect(taskExtra.style.display).toBe('none')
    const mouseEnterEvent = new Event('mouseenter')
    const mouseLeaveEvent = new Event('mouseleave')
    li.dispatchEvent(mouseEnterEvent)
    vm.$nextTick(() => {
      expect(taskExtra.style.display).toBe('')
      li.dispatchEvent(mouseLeaveEvent)
      vm.$nextTick(() => {
        expect(taskExtra.style.display).toBe('none')
        done()
      })
    })
  })

  it('should update task to active', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.tasks.update + '/1'), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    vm.$store.commit(symbols.mutations.setTasks, [
      {
        id: 1
      },
      {
        id: 2
      }
    ])

    const input = vm.$el.querySelector('input')
    expect(input.checked).toBe(false)
    input.click()
    moxios.wait(() => {
      expect(input.checked).toBe(true)
      const request = moxios.requests.mostRecent()
      const expectedRequest = {
        status: 1
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedRequest)
      const tasks = vm.$store.state.tasks[symbols.state.tasks]
      expect(tasks.length).toBe(1)
      expect(tasks[0].id).toBe(2)
      input.click()
      vm.$nextTick(() => {
        expect(input.checked).toBe(true)
        done()
      })
    })
  })

  it('should update task to active for patient', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.tasks.update + '/1'), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: true
    }
    const vm = this.mount(propsData)
    vm.$store.commit(symbols.mutations.setTasksForPatient, [
      {
        id: 1
      },
      {
        id: 2
      }
    ])

    const input = vm.$el.querySelector('input')
    expect(input.checked).toBe(false)
    input.click()
    moxios.wait(() => {
      expect(input.checked).toBe(true)
      const request = moxios.requests.mostRecent()
      const expectedRequest = {
        status: 1
      }
      expect(JSON.parse(request.config.data)).toEqual(expectedRequest)
      const tasks = vm.$store.state.tasks[symbols.state.tasksForPatient]
      expect(tasks.length).toBe(1)
      expect(tasks[0].id).toBe(2)
      done()
    })
  })

  it('should update task unsuccessfully', function (done) {
    let consoleMessage = ''
    spyOn(console, 'error').and.callFake((message) => {
      consoleMessage = message
    })
    moxios.stubRequest(http.formUrl(endpoints.tasks.update + '/1'), {
      status: 400,
      responseText: {
        data: {}
      }
    })

    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    vm.$store.commit(symbols.mutations.setTasks, [
      {
        id: 1
      },
      {
        id: 2
      }
    ])

    const input = vm.$el.querySelector('input')
    expect(input.checked).toBe(false)
    input.click()
    moxios.wait(() => {
      const tasks = vm.$store.state.tasks[symbols.state.tasks]
      expect(tasks.length).toBe(2)
      expect(consoleMessage).toBe('updateTaskToActive [status]: 400')
      expect(input.checked).toBe(false)
      done()
    })
  })

  it('should delete task', function (done) {
    spyOn(window, 'confirm').and.returnValue(true)
    moxios.stubRequest(http.formUrl(endpoints.tasks.destroy + '/1'), {
      status: 200,
      responseText: {
        data: {}
      }
    })

    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    vm.$store.commit(symbols.mutations.setTasks, [
      {
        id: 1
      },
      {
        id: 2
      }
    ])

    const deleteLink = vm.$el.querySelector('a.task_delete')
    deleteLink.click()
    moxios.wait(() => {
      const tasks = vm.$store.state.tasks[symbols.state.tasks]
      expect(tasks.length).toBe(1)
      expect(tasks[0].id).toBe(2)
      done()
    })
  })

  it('should delete task unsuccessfully', function (done) {
    spyOn(window, 'confirm').and.returnValue(true)
    let consoleMessage = ''
    spyOn(console, 'error').and.callFake((message) => {
      consoleMessage = message
    })
    moxios.stubRequest(http.formUrl(endpoints.tasks.destroy + '/1'), {
      status: 400,
      responseText: {
        data: {}
      }
    })

    const propsData = {
      task: this.task,
      dueDate: false,
      isPatient: false
    }
    const vm = this.mount(propsData)
    vm.$store.commit(symbols.mutations.setTasks, [
      {
        id: 1
      },
      {
        id: 2
      }
    ])

    const deleteLink = vm.$el.querySelector('a.task_delete')
    deleteLink.click()
    moxios.wait(() => {
      expect(consoleMessage).toBe('deleteTask [status]: 400')
      const tasks = vm.$store.state.tasks[symbols.state.tasks]
      expect(tasks.length).toBe(2)
      done()
    })
  })
})
