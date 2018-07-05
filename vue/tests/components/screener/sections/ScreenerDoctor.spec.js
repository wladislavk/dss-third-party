import symbols from '../../../../src/symbols'
import ScreenerDoctorComponent from '../../../../src/components/screener/sections/ScreenerDoctor.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerDoctor component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerDoctorComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-hst',
        path: '/hst'
      },
      {
        name: 'screener-intro',
        path: '/intro'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display results', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const riskImage = vm.$el.querySelector('div#risk_image_doc > img').getAttribute('src')
      expect(riskImage).toContain('screener-low_risk')

      const resultsDiv = vm.$el.querySelector('div#results_div')
      expect(resultsDiv.style.display).toBe('none')
      const resultsButton = vm.$el.querySelector('a#sect_results_next')
      resultsButton.click()
      vm.$nextTick(() => {
        expect(resultsDiv.style.display).toBe('')
        done()
      })
    })
  })

  it('should route to intro', function () {
    const vm = this.testCase.mount()

    expect(store.state.screener[symbols.state.showFancybox]).toBe(false)
    const link = vm.$el.querySelector('a#fancy-reg')
    link.click()
    expect(store.state.screener[symbols.state.showFancybox]).toBe(true)
  })

  it('should route to HST', function () {
    const vm = this.testCase.mount()

    const link = vm.$el.querySelector('a#sect6_next')
    link.click()
    expect(vm.$router.currentRoute.name).toBe('screener-hst')
  })
})
