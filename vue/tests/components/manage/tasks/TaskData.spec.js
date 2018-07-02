import TaskDataComponent from '../../../../src/components/manage/tasks/TaskData.vue'
import TaskElementData from '../../../../src/components/manage/tasks/TaskElement'
import TestCase from '../../../cases/ComponentTestCase'

describe('TaskData component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
    const childComponents = [
      {
        name: 'task-element',
        attributes: ['task', 'hasDueDate', 'isPatient'],
        props: TaskElementData.props
      }
    ]
    this.testCase.setComponent(TaskDataComponent)
    this.testCase.setChildComponents(childComponents)
  })

  it('should not display data without tasks', function () {
    const propsData = {
      tasks: [],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.textContent.trim()).toBe('')
  })

  it('should display data without patient', function () {
    const propsData = {
      tasks: [
        { id: 1, task: 'Task 1' },
        { id: 2, task: 'Task 2' }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h4')
    expect(header.textContent).toBe('type')
    expect(header.getAttribute('class')).toBe('task_code_header')
    expect(header.getAttribute('id')).toBe('task_code_header')
    const list = vm.$el.querySelector('ul')
    expect(list.getAttribute('id')).toBe('task_code_list')
    const elements = list.querySelectorAll('div.task-element')
    expect(elements.length).toBe(2)
    expect(elements[0].getAttribute('data-task')).toBe('Task 1')
    expect(elements[0].getAttribute('data-has-due-date')).toBeNull()
    expect(elements[0].getAttribute('data-is-patient')).toBeNull()
  })

  it('should display data with patient and date', function () {
    const propsData = {
      tasks: [
        { id: 1, task: 'Task 1' },
        { id: 2, task: 'Task 2' }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: true,
      hasDueDate: true
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h4')
    expect(header.getAttribute('id')).toBe('pat_task_code_header')
    const list = vm.$el.querySelector('ul')
    expect(list.getAttribute('id')).toBe('pat_task_code_list')
    const elements = list.querySelectorAll('div.task-element')
    expect(elements.length).toBe(2)
    expect(elements[0].getAttribute('data-has-due-date')).toBe('true')
    expect(elements[0].getAttribute('data-is-patient')).toBe('true')
  })

  it('should display data with red header', function () {
    const propsData = {
      tasks: [
        { id: 1, task: 'Task 1' },
        { id: 2, task: 'Task 2' }
      ],
      taskCode: 'code',
      taskType: 'type',
      isPatient: false,
      redHeader: true
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const header = vm.$el.querySelector('h4')
    expect(header.getAttribute('class')).toBe('task_code_header task_header_red')
  })
})
