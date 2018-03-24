import Vue from 'vue'
import store from '../../../../src/store'
import ScreenerFooterComponent from '../../../../src/components/screener/common/ScreenerFooter.vue'

describe('ScreenerFooter component', () => {
  beforeEach(function () {
    const Component = Vue.extend(ScreenerFooterComponent)
    this.mount = function () {
      return new Component({
        store: store
      }).$mount()
    }
  })

  it('displays current year', function () {
    const vm = this.mount()
    const year = (new Date()).getFullYear()
    expect(parseInt(year)).toBeGreaterThan(2000)
    const span = vm.$el.querySelector('span.fr')
    expect(span.textContent).toContain(year)
  })
})
