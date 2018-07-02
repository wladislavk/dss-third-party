import ScreenerNavigationComponent from '../../../../src/components/screener/common/ScreenerNavigation.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerNavigation component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      sectionNumber: 2
    }

    this.testCase.setComponent(ScreenerNavigationComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows navigation link', function () {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el
    expect(link.id).toBe('sect2_next')
    expect(link.className).toBe('next btn btn_d btn_medium')
  })

  it('shows link with custom ID', function () {
    this.props.customId = 'foo'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el
    expect(link.id).toBe('foo')
  })

  it('shows disabled link', function () {
    this.props.disabled = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el
    expect(link.className).toBe('next btn btn_d disabled btn_medium')
  })

  it('shows large link', function () {
    this.props.large = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el
    expect(link.className).toBe('next btn btn_d btn_large')
  })

  it('shows link with additional class', function () {
    this.props.additionalClass = 'additional'
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const link = vm.$el
    expect(link.className).toBe('next btn btn_d btn_medium additional')
  })

  it('follows the link', function () {
    // @todo: currently it is unclear how emitting of events can be tested
  })
})
