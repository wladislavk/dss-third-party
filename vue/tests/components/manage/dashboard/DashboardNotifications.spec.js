import Vue from 'vue'
import store from '../../../../src/store'
import DashboardNotificationsComponent from '../../../../src/components/manage/dashboard/DashboardNotifications.vue'
import NotificationBranchData from '../../../../src/components/manage/dashboard/NotificationBranch'
import NotificationLinkData from '../../../../src/components/manage/dashboard/NotificationLink'
import symbols from '../../../../src/symbols'
import { DSS_CONSTANTS } from '../../../../src/constants/main'

describe('DashboardNotifications component', () => {
  beforeEach(function () {
    Vue.component('notification-link', {
      props: NotificationLinkData.props,
      template: '<div class="notification-link" v-bind:data-link-label="linkLabel" v-bind:data-show-all="showAll"></div>'
    })
    Vue.component('notification-branch', {
      props: NotificationBranchData.props,
      template: '<div class="notification-branch" v-bind:data-notification="notification" v-bind:data-show-all="showAll"></div>'
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
    const componentsWithChildren = vm.$el.querySelectorAll('div.notification-branch')
    expect(componentsWithChildren.length).toBe(1)
    const componentsWithoutChildren = vm.$el.querySelectorAll('div > div.notification-link')
    expect(componentsWithoutChildren.length).toBe(11)
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
    const componentWithChildren = vm.$el.querySelector('div.notification-branch')
    expect(componentWithChildren.getAttribute('data-show-all')).toBeNull()
    const componentsWithoutChildren = vm.$el.querySelectorAll('div > div.notification-link')
    const firstComponent = componentsWithoutChildren[0]
    expect(firstComponent.getAttribute('data-show-all')).toBeNull()
    showAllButton.click()
    vm.$nextTick(() => {
      expect(showAllButton.style.display).toBe('none')
      expect(showActiveButton.style.display).toBe('')
      expect(componentWithChildren.getAttribute('data-show-all')).toBe('true')
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
