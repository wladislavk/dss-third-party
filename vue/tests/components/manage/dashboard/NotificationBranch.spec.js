import Vue from 'vue'
import VueVisible from 'vue-visible'
import store from '../../../../src/store'
import NotificationBranchComponent from '../../../../src/components/manage/dashboard/NotificationBranch.vue'
import NotificationLinkData from '../../../../src/components/manage/dashboard/NotificationLink'
import symbols from '../../../../src/symbols'

describe('NotificationBranch component', () => {
  beforeEach(function () {
    Vue.use(VueVisible)
    Vue.component('notification-link', {
      props: NotificationLinkData.props,
      template: '<div class="notification-link" v-bind:data-link-count="linkCount" v-bind:data-link-label="linkLabel" v-bind:data-show-all="showAll"></div>'
    })
    const Component = Vue.extend(NotificationBranchComponent)
    this.mount = function () {
      const propsData = {
        notification: {
          number: '4',
          label: 'foo',
          url: '/foo',
          countZero: '',
          countNonZero: '',
          children: [
            {
              number: '2',
              label: 'bar',
              url: '/bar',
              countZero: '',
              countNonZero: ''
            },
            {
              number: '1',
              label: 'baz',
              url: '/baz',
              countZero: '',
              countNonZero: '',
              shouldParse: symbols.getters.shouldShowEnrollments
            },
            {
              number: 1,
              label: 'unseen',
              url: '/unseen',
              countZero: '',
              countNonZero: '',
              shouldParse: symbols.getters.shouldUseLetters
            }
          ]
        },
        showAll: true
      }
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should display links', function () {
    store.state.main[symbols.state.docInfo] = {
      useEligibleApi: 1
    }
    const vm = this.mount()
    const parentLink = vm.$el.querySelector('ul#notmenu > li > div')
    expect(parentLink.getAttribute('data-link-count')).toBe('4')
    expect(parentLink.getAttribute('data-link-label')).toBe('foo')
    const childLinks = vm.$el.querySelectorAll('ul.children-links > li > div')
    expect(childLinks.length).toBe(2)
    expect(childLinks[0].getAttribute('data-link-label')).toBe('bar')
    expect(childLinks[1].getAttribute('data-link-label')).toBe('baz')
  })

  // @todo: find out how to test v-visible directive
  it('should show and hide links', function () {})
})
