import Vue from 'vue'
import store from '../../../../src/store'
import SymptomButtonsComponent from '../../../../src/components/screener/sections/SymptomButtons.vue'
import symbols from '../../../../src/symbols'

describe('SymptomButtons component', () => {
  beforeEach(function () {
    const Component = Vue.extend(SymptomButtonsComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('shows and switches buttons', function () {
    const propsData = {
      name: 'foo',
      weight: 5
    }
    const vm = this.mount(propsData)
    const buttons = vm.$el.querySelectorAll('input')
    const labels = vm.$el.querySelectorAll('label')
    expect(buttons[0].name).toBe('foo')
    expect(buttons[0].value).toBe('5')
    expect(labels[0].className).not.toContain('active')
    expect(labels[1].className).not.toContain('active')
  })

  it('updates symptoms', function (done) {
    const propsData = {
      name: 'foo',
      weight: 5
    }
    const vm = this.mount(propsData)
    const buttons = vm.$el.querySelectorAll('input')
    const labels = vm.$el.querySelectorAll('label')
    const storedSymptoms = store.state.screener[symbols.state.storedSymptoms]
    buttons[0].click()
    vm.$nextTick(() => {
      expect(labels[0].className).toContain('active')
      expect(labels[1].className).not.toContain('active')
      expect(storedSymptoms).toEqual({foo: 5})
      buttons[1].click()
      vm.$nextTick(() => {
        expect(labels[0].className).not.toContain('active')
        expect(labels[1].className).toContain('active')
        expect(storedSymptoms).toEqual({foo: 0})
        done()
      })
    })
  })

  it('updates cpap', function (done) {
    const propsData = {
      name: 'foo',
      weight: 5,
      cpap: true
    }
    const vm = this.mount(propsData)
    const buttons = vm.$el.querySelectorAll('input')
    buttons[0].click()
    vm.$nextTick(() => {
      const storedCpap = store.state.screener[symbols.state.storedCpap]
      expect(storedCpap).toEqual(5)
      done()
    })
  })
})
