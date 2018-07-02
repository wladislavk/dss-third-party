import store from '../../../../src/store'
import PatientMenuElementComponent from '../../../../src/components/manage/patients/PatientMenuElement.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientMenuElement component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientId] = 0

    this.props = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar'
    }

    this.testCase.setComponent(PatientMenuElementComponent)
    this.testCase.setRoutes([
      {
        name: 'route',
        path: '/route'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows normal element', function (done) {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    expect(vm.$el.className).toBe('')
    const link = vm.$el.querySelector('a')
    expect(link.textContent).toBe('bar')
    expect(link.className).toBe('')
    link.click()
    vm.$nextTick(() => {
      expect(this.testCase.redirectUrl).toBe('foo')
      done()
    })
  })

  it('shows element with parsed link', function (done) {
    store.state.patients[symbols.state.patientId] = 1

    this.props.elementLink = 'foo%d'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    link.click()
    vm.$nextTick(() => {
      expect(this.testCase.redirectUrl).toBe('foo1')
      done()
    })
  })

  it('shows active element', function (done) {
    this.props.elementActive = 'route'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    vm.$router.push({ name: 'route' })
    vm.$nextTick(() => {
      expect(link.className).toBe('nav_active')
      done()
    })
  })

  it('shows active element with pattern', function (done) {
    this.props.elementActiveLike = ['som', 'rou']
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    vm.$router.push({ name: 'route' })
    vm.$nextTick(() => {
      expect(link.className).toBe('nav_active')
      done()
    })
  })

  it('shows last element', function () {
    this.props.lastElement = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    expect(vm.$el.className).toBe('last')
  })
})
