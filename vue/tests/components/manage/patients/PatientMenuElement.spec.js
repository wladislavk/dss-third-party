import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../../../../src/store'
import PatientMenuElementComponent from '../../../../src/components/manage/patients/PatientMenuElement.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import symbols from '../../../../src/symbols'

describe('PatientMenuElement component', () => {
  beforeEach(function () {
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

  it('shows normal element', function () {
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
    expect(link.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'foo')
  })

  it('shows element with parsed link', function () {
    store.state.patients[symbols.state.patientId] = 1

    const propsData = {
      patientId: 42,
      elementLink: 'foo%d',
      elementName: 'bar'
    }
    const vm = this.mount(propsData)
    const link = vm.$el.querySelector('a')
    expect(link.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'foo1')
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
