import Vue from 'vue'
import store from '../../../../src/store'
import LeftMenuComponent from '../../../../src/components/manage/common/LeftTopMenu.vue'
import symbols from '../../../../src/symbols'

describe('LeftTopMenu component', () => {
  beforeEach(function () {
    store.state.main[symbols.state.userInfo].useCourse = 0
    store.state.main[symbols.state.docInfo].useCourseStaff = 0

    const Component = Vue.extend(LeftMenuComponent)
    this.mount = function () {
      return new Component({
        store: store
      }).$mount()
    }
  })

  it('shows menu without snoozle', function () {
    const vm = this.mount()
    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(1)
  })

  it('shows menu with snoozle', function () {
    store.state.main[symbols.state.userInfo].useCourse = 1
    store.state.main[symbols.state.docInfo].useCourseStaff = 1
    const vm = this.mount()
    const links = vm.$el.querySelectorAll('a')
    expect(links.length).toBe(3)
  })
})
