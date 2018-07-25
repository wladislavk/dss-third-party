import store from '../../../../src/store'
import LeftMenuComponent from '../../../../src/components/manage/common/LeftTopMenu.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('LeftTopMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.main[symbols.state.userInfo].useCourse = 0
    store.state.main[symbols.state.docInfo].useCourseStaff = 0

    this.testCase.setComponent(LeftMenuComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows menu without snoozle', function () {
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(1)
  })

  it('shows menu with snoozle', function () {
    store.state.main[symbols.state.userInfo].useCourse = 1
    store.state.main[symbols.state.docInfo].useCourseStaff = 1
    const vm = this.testCase.mount()

    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(3)
  })
})
