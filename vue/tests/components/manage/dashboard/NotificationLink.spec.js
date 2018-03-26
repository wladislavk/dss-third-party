import Vue from 'vue'
import LegacyHref from '../../../../src/directives/LegacyHref'
import store from '../../../../src/store'
import NotificationLinkComponent from '../../../../src/components/manage/dashboard/NotificationLink.vue'
import { NOTIFICATION_NUMBERS } from '../../../../src/constants/main'
import symbols from '../../../../src/symbols'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'

describe('NotificationLink component', () => {
  beforeEach(function () {
    Vue.directive('legacy-href', LegacyHref)
    const Component = Vue.extend(NotificationLinkComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should display link without children', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientChanges] = 3
    const propsData = {
      linkCount: NOTIFICATION_NUMBERS.patientChanges,
      linkLabel: 'My link',
      linkUrl: 'foo'
    }
    const vm = this.mount(propsData)
    expect(vm.$el.style.display).toBe('')
    expect(vm.$el.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'foo')
    const expectedClass = 'notification count_3 bad_count'
    expect(vm.$el.className).toBe(expectedClass)
    const counter = vm.$el.querySelector('span.count')
    expect(counter.textContent).toBe('3')
    const label = vm.$el.querySelector('span.label')
    expect(label.textContent).toBe('My link')
    const arrowRight = vm.$el.querySelector('div.arrow_right')
    expect(arrowRight).toBeNull()
  })

  it('should display link with children', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientChanges] = 3
    const propsData = {
      linkCount: NOTIFICATION_NUMBERS.patientChanges,
      linkLabel: 'My link',
      hasChildren: true
    }
    const vm = this.mount(propsData)
    expect(vm.$el.getAttribute('href')).toBe('#')
    const arrowRight = vm.$el.querySelector('div.arrow_right')
    expect(arrowRight).not.toBeNull()
  })

  it('should display link with zero number', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientChanges] = 0
    const propsData = {
      linkCount: NOTIFICATION_NUMBERS.patientChanges,
      linkLabel: 'My link'
    }
    const vm = this.mount(propsData)
    expect(vm.$el.style.display).toBe('')
    const expectedClass = 'notification count_0 good_count'
    expect(vm.$el.className).toBe(expectedClass)
    const counter = vm.$el.querySelector('span.count')
    expect(counter.textContent).toBe('0')
  })

  it('should not display anything if zero number and showAll is false', function () {
    store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.patientChanges] = 0
    const propsData = {
      linkCount: NOTIFICATION_NUMBERS.patientChanges,
      linkLabel: 'My link',
      showAll: false
    }
    const vm = this.mount(propsData)
    expect(vm.$el.style.display).toBe('none')
  })
})
