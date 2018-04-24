import Vue from 'vue'
import VueRouter from 'vue-router'
import sinon from 'sinon'
import store from '../../../../src/store'
import PatientMenuElementComponent from '../../../../src/components/manage/patients/PatientMenuElement.vue'
import symbols from '../../../../src/symbols'
import LocationWrapper from 'src/wrappers/LocationWrapper'

describe('PatientMenuElement component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    store.state.patients[symbols.state.patientId] = 0

    const Component = Vue.extend(PatientMenuElementComponent)
    const Router = new VueRouter({
      mode: 'history',
      routes: [
        {
          name: 'route',
          path: '/route'
        }
      ]
    })
    this.mount = function (propsData) {
      return new Component({
        store: store,
        router: Router,
        propsData: propsData
      }).$mount()
    }
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  it('shows normal element', function (done) {
    let destination = ''
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      destination = url
    })
    const propsData = {
      patientId: 42,
      elementLink: 'foo',
      elementName: 'bar'
    }
    const vm = this.mount(propsData)
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
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      destination = url
    })
    store.state.patients[symbols.state.patientId] = 1

    const propsData = {
      patientId: 42,
      elementLink: 'foo%d',
      elementName: 'bar'
    }
    const vm = this.mount(propsData)
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
    const vm = this.mount(propsData)
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
    const vm = this.mount(propsData)
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
    const vm = this.mount(propsData)
    expect(vm.$el.className).toBe('last')
  })
})
