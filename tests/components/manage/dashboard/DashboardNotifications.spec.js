import Vue from 'vue'
import store from '../../../../src/store'
import DashboardNotificationsComponent from '../../../../src/components/manage/dashboard/DashboardNotifications.vue'
import NotificationLinkData from '../../../../src/components/manage/dashboard/NotificationLink'
import symbols from '../../../../src/symbols'
import { DSS_CONSTANTS } from '../../../../src/constants'

describe('DashboardNotifications component', () => {
  beforeEach(function () {
    Vue.component('notification-link', {
      props: NotificationLinkData.props,
      template: '<div class="notification-link" v-bind:data-link-label="linkLabel" v-bind:data-has-children="hasChildren" v-bind:data-show-all="showAll"></div>'
    })
    const Component = Vue.extend(DashboardNotificationsComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should display notifications', function () {
    const vm = this.mount({})
    const allChildren = vm.$el.querySelectorAll('div > div')
    expect(allChildren.length).toBe(12)
    const componentsWithChildren = vm.$el.querySelectorAll('div > div.notsuckertreemenu')
    expect(componentsWithChildren.length).toBe(1)
    const parentLink = componentsWithChildren[0].querySelector('ul#notmenu > li > div.notification-link')
    expect(parentLink.getAttribute('data-link-label')).toBe('Web Portal')
    expect(parentLink.getAttribute('data-has-children')).toBe('true')
    const childComponents = componentsWithChildren[0].querySelectorAll('ul#notmenu > li > ul > li')
    expect(childComponents.length).toBe(3)
    const firstChild = childComponents[0].querySelector('div.notification-link')
    expect(firstChild.getAttribute('data-has-children')).toBeNull()
    const componentsWithoutChildren = vm.$el.querySelectorAll('div > div.notification-link')
    expect(componentsWithoutChildren.length).toBe(11)
    expect(componentsWithoutChildren[0].getAttribute('data-has-children')).toBeNull()
  })

  it('should display notifications with all conditions set to true', function () {
    Vue.set(store.state.main[symbols.state.docInfo], 'usePaymentReports', 1)
    Vue.set(store.state.main[symbols.state.docInfo], 'useLetters', 1)
    Vue.set(store.state.main[symbols.state.userInfo], 'userType', DSS_CONSTANTS.DSS_USER_TYPE_SOFTWARE)
    const vm = this.mount({})
    const allChildren = vm.$el.querySelectorAll('div > div')
    expect(allChildren.length).toBe(16)
  })

  it('should toggle between show all and show active', function (done) {
    const vm = this.mount({})
    const showAllButton = vm.$el.querySelector('a#not_show_all')
    expect(showAllButton.style.display).toBe('')
    const showActiveButton = vm.$el.querySelector('a#not_show_active')
    expect(showActiveButton.style.display).toBe('none')
    const parentLink = vm.$el.querySelector('div > div.notsuckertreemenu > ul#notmenu > li > div.notification-link')
    expect(parentLink.getAttribute('data-show-all')).toBe('true')
    const childComponents = vm.$el.querySelectorAll('div > div.notsuckertreemenu > ul#notmenu > li > ul > li')
    const firstChild = childComponents[0].querySelector('div.notification-link')
    expect(firstChild.getAttribute('data-show-all')).toBeNull()
    const componentsWithoutChildren = vm.$el.querySelectorAll('div > div.notification-link')
    const firstComponent = componentsWithoutChildren[0]
    expect(firstComponent.getAttribute('data-show-all')).toBeNull()
    showAllButton.click()
    vm.$nextTick(() => {
      expect(showAllButton.style.display).toBe('none')
      expect(showActiveButton.style.display).toBe('')
      expect(parentLink.getAttribute('data-show-all')).toBe('true')
      expect(firstChild.getAttribute('data-show-all')).toBe('true')
      expect(firstComponent.getAttribute('data-show-all')).toBe('true')
      showActiveButton.click()
      vm.$nextTick(() => {
        expect(showAllButton.style.display).toBe('')
        expect(showActiveButton.style.display).toBe('none')
        done()
      })
    })
  })
})
