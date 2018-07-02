import symbols from '../../../../src/symbols'
import SectionHeaderComponent from '../../../../src/components/screener/common/SectionHeader.vue'
import store from '../../../../src/store'
import { INITIAL_CONTACT_DATA } from '../../../../src/constants/screener'
import TestCase from '../../../cases/ComponentTestCase'

describe('SectionHeader component', () => {
  beforeAll(function () {
    this.testCase = new TestCase()

    const contactData = store.state.screener[symbols.state.contactData]
    for (let element of contactData) {
      if (element.camelName === 'firstName') {
        element.value = 'John'
      }
      if (element.camelName === 'lastName') {
        element.value = 'Doe'
      }
    }
    store.state.screener.contactData = contactData

    this.testCase.setComponent(SectionHeaderComponent)
  })

  afterEach(function () {
    store.state.screener.contactData = INITIAL_CONTACT_DATA
  })

  it('should display full name and title', function () {
    const propsData = {
      title: 'My title'
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const heading = vm.$el.querySelector('h5')
    expect(heading).not.toBeNull()
    const expected = 'Health Assessment - John Doe'
    expect(heading.textContent).toBe(expected)
    const title = vm.$el.querySelector('h3')
    expect(title.className).not.toContain('bottom-margin')
    expect(title.textContent).toBe('My title')
  })

  it('should display bottom margin and no assessment', function () {
    const propsData = {
      title: 'My title',
      bottomMargin: true,
      assessment: false
    }
    this.testCase.setPropsData(propsData)
    const vm = this.testCase.mount()

    const heading = vm.$el.querySelector('h5')
    expect(heading).toBeNull()
    const title = vm.$el.querySelector('h3')
    expect(title.className).toContain('bottom-margin')
  })
})
