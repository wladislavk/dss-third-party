import Vue from 'vue'
import store from '../../../../src/store'
import TaskDataComponent from '../../../../src/components/manage/tasks/TaskData.vue'

describe('TaskData component', () => {
  beforeEach(function () {
    Vue.component('task-element', {
      props: ['task', 'dueDate', 'isPatient'],
      template: '<div class="element"><span>{{ JSON.stringify(task) }}</span><span>{{ dueDate }}</span><span>{{ isPatient }}</span></div>'
    })
    const Component = Vue.extend(TaskDataComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should not display data without tasks', function () {
    const propsData = {
      tasks: [],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false
    }
    const vm = this.mount(propsData)
    expect(vm.$el.textContent.trim()).toBe('')
  })

  it('should display data without patient', function () {
    const propsData = {
      tasks: [
        { id: 1 },
        { id: 2 }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false
    }
    const vm = this.mount(propsData)
    const header = vm.$el.querySelector('h4')
    expect(header.textContent).toBe('type')
    expect(header.getAttribute('class')).toBe('task_code_header')
    expect(header.getAttribute('id')).toBe('task_code_header')
    const list = vm.$el.querySelector('ul')
    expect(list.getAttribute('id')).toBe('task_code_list')
    const elements = list.querySelectorAll('div.element')
    expect(elements.length).toBe(2)
    const task = elements[0].querySelector('span:nth-child(1)')
    expect(task.textContent).toBe('{"id":1}')
    const dueDate = elements[0].querySelector('span:nth-child(2)')
    expect(dueDate.textContent).toBe('false')
    const isPatient = elements[0].querySelector('span:nth-child(3)')
    expect(isPatient.textContent).toBe('false')
  })

  it('should display data with patient and date', function () {
    const propsData = {
      tasks: [
        { id: 1 },
        { id: 2 }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: true,
      dueDate: true
    }
    const vm = this.mount(propsData)
    const header = vm.$el.querySelector('h4')
    expect(header.getAttribute('id')).toBe('pat_task_code_header')
    const list = vm.$el.querySelector('ul')
    expect(list.getAttribute('id')).toBe('pat_task_code_list')
    const elements = list.querySelectorAll('div.element')
    expect(elements.length).toBe(2)
    const dueDate = elements[0].querySelector('span:nth-child(2)')
    expect(dueDate.textContent).toBe('true')
    const isPatient = elements[0].querySelector('span:nth-child(3)')
    expect(isPatient.textContent).toBe('true')
  })

  it('should display data with red header', function () {
    const propsData = {
      tasks: [
        { id: 1 },
        { id: 2 }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false,
      redHeader: true
    }
    const vm = this.mount(propsData)
    const header = vm.$el.querySelector('h4')
    expect(header.getAttribute('class')).toBe('task_code_header task_header_red')
  })
})
