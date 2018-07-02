import store from '../../../../src/store'
import HstContactComponent from '../../../../src/components/screener/sections/HstContact.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('HstContact component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    const props = {
      name: 'first_name',
      label: 'First Name',
      value: 'John',
      className: 'foo'
    }

    this.testCase.setComponent(HstContactComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows and updates contact', function (done) {
    const vm = this.testCase.mount()

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
