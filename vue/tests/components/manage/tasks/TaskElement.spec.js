import endpoints from '../../../../src/endpoints'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TaskElementComponent from '../../../../src/components/manage/tasks/TaskElement.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('TaskElement component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(TaskElementComponent)

    this.props = {
      taskId: 1,
      patientId: 2,
      task: 'task 1',
      dueDate: new Date('2016-03-02 10:53:00'),
      firstName: '',
      lastName: '',
      hasDueDate: false,
      isPatient: false
    }
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display base HTML', function () {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const input = vm.$el.querySelector('input')
    expect(input.getAttribute('value')).toBe('1')
    expect(input.getAttribute('class')).toBe('task_status task_status_general')
    const taskContent = vm.$el.querySelector('div.task_content')
    expect(taskContent.getAttribute('class')).toBe('task_content task_content_general')
    expect(taskContent.textContent.trim()).toBe('task 1')
  })

  it('should display HTML for patient', function () {
    this.props.isPatient = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const input = vm.$el.querySelector('input')
    expect(input.getAttribute('class')).toBe('task_status')
    const taskContent = vm.$el.querySelector('div.task_content')
    expect(taskContent.getAttribute('class')).toBe('task_content task_content_patient')
  })

  it('should display HTML for due date', function () {
    this.props.hasDueDate = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const dueDateSpan = vm.$el.querySelector('span.task_due_date')
    expect(dueDateSpan.textContent).toBe('03 02 - ')
  })

  it('should display HTML for first name and last name', function () {
    this.props.firstName = 'John'
    this.props.lastName = 'Doe'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const nameSpan = vm.$el.querySelector('span.task_name')
    expect(nameSpan.textContent.trim()).toBe('(John Doe)')
    const nameLink = nameSpan.querySelector('a.task_name_link')
    expect(nameLink.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/add_patient.php?ed=2&addtopat=1&pid=2')
  })

  it('should fire onMouseEnter and onMouseLeave', function (done) {
    this.props.isPatient = true
    this.props.hasDueDate = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

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
    this.testCase.stubRequest({
      url: endpoints.tasks.update + '/1'
    })
    this.testCase.stubRequest({
      url: endpoints.tasks.index
    })

    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

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
      const requestResults = this.testCase.getRequestResults()
      const expectedResults = [
        {
          url: endpoints.tasks.update + '/1',
          body: {
            status: 1
          }
        },
        {
          url: endpoints.tasks.index
        }
      ]
      expect(requestResults).toEqual(expectedResults)
      input.click()
      vm.$nextTick(() => {
        expect(input.checked).toBe(true)
        done()
      })
    })
  })

  it('should delete task', function (done) {
    this.testCase.stubRequest({
      url: endpoints.tasks.destroy + '/1'
    })
    this.testCase.stubRequest({
      url: endpoints.tasks.index
    })

    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const deleteLink = vm.$el.querySelector('a.task_delete')
    deleteLink.click()
    moxios.wait(() => {
      const requestResults = this.testCase.getRequestResults()
      expect(requestResults.length).toBe(2)
      expect(requestResults[0].url).toBe(endpoints.tasks.destroy + '/1')
      expect(requestResults[1].url).toBe(endpoints.tasks.index)
      done()
    })
  })
})
