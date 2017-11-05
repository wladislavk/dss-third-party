import Vue from 'vue'
import store from '../../../../src/store'
import ElementData from '../../../../src/components/manage/dashboard/NavigationElement'
import DashboardNavigationComponent from '../../../../src/components/manage/dashboard/DashboardNavigation.vue'

describe('DashboardNavigation component', () => {
  beforeEach(function () {
    Vue.component('navigation-element', {
      props: ElementData.props,
      template: '<li class="navigation-element"></li>'
    })
    const Component = Vue.extend(DashboardNavigationComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should display menu', function () {
    const vm = this.mount({})
    const elements = vm.$el.querySelectorAll('li.navigation-element')
    expect(elements.length).toBe(10)
  })
})
