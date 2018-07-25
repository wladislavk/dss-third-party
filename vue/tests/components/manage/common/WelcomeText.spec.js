import store from '../../../../src/store'
import WelcomeTextComponent from '../../../../src/components/manage/common/WelcomeText.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('WelcomeText component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.userInfo].username = ''

    this.testCase.setComponent(WelcomeTextComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows welcome text', function () {
    store.state.main[symbols.state.userInfo].username = 'John'
    const vm = this.testCase.mount()

    expect(vm.$el.textContent.trim()).toBe('Welcome John')
  })
})
