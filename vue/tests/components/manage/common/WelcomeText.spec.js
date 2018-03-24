import Vue from 'vue'
import store from '../../../../src/store'
import WelcomeTextComponent from '../../../../src/components/manage/common/WelcomeText.vue'
import symbols from '../../../../src/symbols'

describe('WelcomeText component', () => {
  beforeEach(function () {
    store.state.main[symbols.state.userInfo].username = ''
    const Component = Vue.extend(WelcomeTextComponent)
    this.mount = function () {
      return new Component({
        store: store
      }).$mount()
    }
  })

  it('shows welcome text', function () {
    store.state.main[symbols.state.userInfo].username = 'John'
    const vm = this.mount()
    expect(vm.$el.textContent.trim()).toBe('Welcome John')
  })
})
