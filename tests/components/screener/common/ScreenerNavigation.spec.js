import Vue from 'vue'
import store from '../../../../src/store'
import ScreenerNavigationComponent from '../../../../src/components/screener/common/ScreenerNavigation.vue'

describe('ScreenerNavigation component', () => {
  beforeEach(function () {
    const Component = Vue.extend(ScreenerNavigationComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('shows navigation link', function () {
    const propsData = {
      sectionNumber: 2
    }
    const vm = this.mount(propsData)
    const link = vm.$el
    expect(link.id).toBe('sect2_next')
    expect(link.className).toBe('next btn btn_d btn_medium')
  })

  it('shows link with custom ID', function () {
    const propsData = {
      sectionNumber: 2,
      customId: 'foo'
    }
    const vm = this.mount(propsData)
    const link = vm.$el
    expect(link.id).toBe('foo')
  })

  it('shows disabled link', function () {
    const propsData = {
      sectionNumber: 2,
      disabled: true
    }
    const vm = this.mount(propsData)
    const link = vm.$el
    expect(link.className).toBe('next btn btn_d disabled btn_medium')
  })

  it('shows large link', function () {
    const propsData = {
      sectionNumber: 2,
      large: true
    }
    const vm = this.mount(propsData)
    const link = vm.$el
    expect(link.className).toBe('next btn btn_d btn_large')
  })

  it('shows link with additional class', function () {
    const propsData = {
      sectionNumber: 2,
      additionalClass: 'additional'
    }
    const vm = this.mount(propsData)
    const link = vm.$el
    expect(link.className).toBe('next btn btn_d btn_medium additional')
  })

  it('follows the link', function () {

  })
})
