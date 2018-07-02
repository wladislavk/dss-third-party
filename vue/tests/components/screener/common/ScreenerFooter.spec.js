import ScreenerFooterComponent from '../../../../src/components/screener/common/ScreenerFooter.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerFooter component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerFooterComponent)
  })

  it('displays current year', function () {
    const vm = this.testCase.mount()

    const year = (new Date()).getFullYear()
    expect(parseInt(year)).toBeGreaterThan(2000)
    const span = vm.$el.querySelector('span.fr')
    expect(span.textContent).toContain(year)
  })
})
