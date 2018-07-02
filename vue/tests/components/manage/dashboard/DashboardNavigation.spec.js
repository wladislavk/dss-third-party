import DashboardNavigationComponent from '../../../../src/components/manage/dashboard/DashboardNavigation.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('DashboardNavigation component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(DashboardNavigationComponent)
    const childComponents = [
      {
        name: 'navigation-element',
        tag: 'li'
      }
    ]
    this.testCase.setChildComponents(childComponents)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display menu', function () {
    const vm = this.testCase.mount()

    const elements = vm.$el.querySelectorAll('li.navigation-element')
    expect(elements.length).toBe(10)
  })
})
