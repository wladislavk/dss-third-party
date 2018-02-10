import Vue from 'vue'
import store from '../../../../src/store'
import HstContactComponent from '../../../../src/components/screener/sections/HstContact.vue'
import symbols from '../../../../src/symbols'

describe('HstContact component', () => {
  beforeEach(function () {
    const Component = Vue.extend(HstContactComponent)
    this.mount = function (propsData) {
      const vm = new Component({
        store: store,
        propsData: propsData
      }).$mount()
      return vm
    }
  })

  it('shows and updates contact', function (done) {
    const props = {
      name: 'first_name',
      label: 'First Name',
      value: 'John',
      className: 'foo'
    }
    const vm = this.mount(props)

    const storedContacts = store.state.screener[symbols.state.storedContactData]
    expect(storedContacts).toEqual({})
    const contactDiv = vm.$el
    expect(contactDiv.id).toBe('hst_first_name_div')
    expect(contactDiv.querySelector('label').textContent).toBe('First Name')
    const input = contactDiv.querySelector('input')
    expect(input.value).toBe('John')
    expect(input.className).toContain('foo')

    input.value = 'Jane'
    input.dispatchEvent(new Event('change'))
    vm.$nextTick(() => {
      expect(storedContacts).toEqual({hst_first_name: 'Jane'})
      done()
    })
  })
})
