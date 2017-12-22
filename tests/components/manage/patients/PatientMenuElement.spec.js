import Vue from 'vue'
import store from '../../../../src/store'
import PatientMenuElementComponent from '../../../../src/components/manage/patients/PatientMenuElement.vue'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'
import symbols from '../../../../src/symbols'

describe('PatientMenuElement component', () => {
  beforeEach(function () {
    store.state.patients[symbols.state.patientId] = 0

    const Component = Vue.extend(PatientMenuElementComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('shows normal element', function () {
    const propsData = {
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
      elementLink: 'foo%d',
      elementName: 'bar'
    }
    const vm = this.mount(propsData)
    const link = vm.$el.querySelector('a')
    expect(link.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'foo1')
  })

  it('shows active element', function () {

  })

  it('shows active element with pattern', function () {

  })

  it('shows last element', function () {
    const propsData = {
      elementLink: 'foo',
      elementName: 'bar',
      lastElement: true
    }
    const vm = this.mount(propsData)
    expect(vm.$el.className).toBe('last')
  })
})
