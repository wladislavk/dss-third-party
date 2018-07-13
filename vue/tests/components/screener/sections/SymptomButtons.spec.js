import store from '../../../../src/store'
import SymptomButtonsComponent from '../../../../src/components/screener/sections/SymptomButtons.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('SymptomButtons component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.props = {
      name: 'foo',
      weight: 5
    }

    this.testCase.setComponent(SymptomButtonsComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows and switches buttons', function () {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const buttons = vm.$el.querySelectorAll('input')
    const labels = vm.$el.querySelectorAll('label')
    expect(buttons[0].name).toBe('foo')
    expect(buttons[0].value).toBe('5')
    expect(labels[0].className).not.toContain('active')
    expect(labels[1].className).not.toContain('active')
  })

  it('updates symptoms', function (done) {
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const buttons = vm.$el.querySelectorAll('input')
    const labels = vm.$el.querySelectorAll('label')
    const storedSymptoms = store.state.screener[symbols.state.storedSymptoms]
    buttons[0].click()
    this.testCase.wait(() => {
      expect(labels[0].className).toContain('active')
      expect(labels[1].className).not.toContain('active')
      expect(storedSymptoms).toEqual({foo: 5})
      buttons[1].click()
      this.testCase.wait(() => {
        expect(labels[0].className).not.toContain('active')
        expect(labels[1].className).toContain('active')
        expect(storedSymptoms).toEqual({foo: 0})
        done()
      })
    })
  })

  it('updates cpap', function (done) {
    this.props.cpap = true
    this.testCase.setPropsData(this.props)
    const vm = this.testCase.mount()

    const buttons = vm.$el.querySelectorAll('input')
    buttons[0].click()
    this.testCase.wait(() => {
      const storedCpap = store.state.screener[symbols.state.storedCpap]
      expect(storedCpap).toEqual(5)
      done()
    })
  })
})
