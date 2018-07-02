import store from '../../../../src/store'
import PatientMenuElementComponent from '../../../../src/components/manage/patients/PatientMenuElement.vue'
import symbols from '../../../../src/symbols'
import LocationWrapper from 'src/wrappers/LocationWrapper'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientMenuElement component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientId] = 0

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
    let destination = ''
    this.testCase.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      destination = url
    })
    const propsData = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar'
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.className).toBe('')
    const link = vm.$el.querySelector('a')
    expect(link.textContent).toBe('bar')
    expect(link.className).toBe('')
    link.click()
    vm.$nextTick(() => {
      expect(destination).toBe('foo')
      done()
    })
  })

  it('shows element with parsed link', function (done) {
    let destination = ''
    this.testCase.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      destination = url
    })
    store.state.patients[symbols.state.patientId] = 1

    const propsData = {
      patientId: 42,
      elementLink: 'foo%d',
      elementName: 'bar'
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    link.click()
    vm.$nextTick(() => {
      expect(destination).toBe('foo1')
      done()
    })
  })

  it('shows active element', function (done) {
    const propsData = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar',
      elementActive: 'route'
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    vm.$router.push({ name: 'route' })
    vm.$nextTick(() => {
      expect(link.className).toBe('nav_active')
      done()
    })
  })

  it('shows active element with pattern', function (done) {
    const propsData = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar',
      elementActiveLike: ['som', 'rou']
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a')
    vm.$router.push({ name: 'route' })
    vm.$nextTick(() => {
      expect(link.className).toBe('nav_active')
      done()
    })
  })

  it('shows last element', function () {
    const propsData = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar',
      lastElement: true
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.className).toBe('last')
  })
})
