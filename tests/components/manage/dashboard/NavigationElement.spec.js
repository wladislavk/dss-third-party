import Vue from 'vue'
import VueVisible from 'vue-visible'
import store from '../../../../src/store'
import NavigationElementComponent from '../../../../src/components/manage/dashboard/NavigationElement.vue'
import symbols from '../../../../src/symbols'
import { NOTIFICATION_NUMBERS } from '../../../../src/constants'

describe('NavigationElement component', () => {
  beforeEach(function () {
    Vue.use(VueVisible)
    const Component = Vue.extend(NavigationElementComponent)
    this.mount = function (propsData) {
      return new Component({
        store: store,
        propsData: propsData
      }).$mount()
    }
  })

  it('should display link without children', function () {
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name'
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.className).toBe('')
    expect(link.getAttribute('href')).toBe('http://legacy/foo')
    expect(link.getAttribute('target')).toBe('_self')
    expect(link.textContent).toBe('Element name')
    const list = vm.$el.querySelector('ul')
    expect(list).toBeNull()
  })

  it('should display for target blank', function () {
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name',
        blank: true
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.getAttribute('target')).toBe('_blank')
  })

  it('should display with non-legacy link', function () {
    const props = {
      menuItem: {
        link: '/foo',
        name: 'Element name',
        legacy: false
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.getAttribute('href')).toBe('/foo')
  })

  it('should display without link', function () {
    const props = {
      menuItem: {
        name: 'Element name'
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.getAttribute('href')).toBe('#')
  })

  it('should display link with children for first level', function () {
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name',
        children: [
          {
            name: 'Child 1'
          },
          {
            name: 'Child 2',
            shouldParse: symbols.getters.shouldShowEnrollments
          }
        ]
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.className).toBe('mainfoldericon')
    const list = vm.$el.querySelector('ul')
    expect(list).not.toBeNull()
    const childItems = list.querySelectorAll('li')
    expect(childItems.length).toBe(1)
    expect(childItems[0].textContent.trim()).toBe('Child 1')
  })

  it('should display link with children for second level', function () {
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name',
        children: [
          {
            name: 'Child 1'
          },
          {
            name: 'Child 2'
          }
        ]
      },
      firstLevel: false
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.className).toBe('subfoldericon')
    const list = vm.$el.querySelector('ul')
    expect(list).not.toBeNull()
    const childItems = list.querySelectorAll('li')
    expect(childItems.length).toBe(2)
  })

  it('should display variable children', function () {
    store.state.dashboard[symbols.state.documentCategories] = [
      {
        categoryId: 1,
        name: 'Child 1'
      },
      {
        categoryId: 2,
        name: 'Child 2'
      }
    ]
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name',
        childrenFrom: symbols.getters.documentCategories,
        childId: 'categoryId',
        childName: 'name'
      }
    }
    const vm = this.mount(props)
    const list = vm.$el.querySelector('ul')
    expect(list).not.toBeNull()
    const childItems = list.querySelectorAll('li')
    expect(childItems.length).toBe(2)
    const firstChild = childItems[0].querySelector('a')
    expect(firstChild.textContent).toBe('Child 1')
    expect(firstChild.getAttribute('href')).toBe('http://legacy/foo/1')
  })

  it('should show and hide children', function (done) {
    const props = {
      menuItem: {
        link: 'foo',
        name: 'Element name',
        children: [
          {
            name: 'Child 1'
          },
          {
            name: 'Child 2'
          }
        ]
      }
    }
    const vm = this.mount(props)
    const list = vm.$el.querySelector('ul')
    expect(list.style.visibility).toBe('hidden')
    const mouseOverEvent = new Event('mouseover')
    const mouseOutEvent = new Event('mouseout')
    vm.$el.dispatchEvent(mouseOverEvent)
    vm.$nextTick(() => {
      expect(list.style.visibility).toBe('visible')
      vm.$el.dispatchEvent(mouseOutEvent)
      vm.$nextTick(() => {
        expect(list.style.visibility).toBe('hidden')
        done()
      })
    })
  })

  it('should click link with action', function (done) {
    store.state.main[symbols.state.popupEdit] = true
    const props = {
      menuItem: {
        name: 'Element name',
        action: symbols.actions.disablePopupEdit
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    link.click()
    vm.$nextTick(() => {
      expect(store.state.main[symbols.state.popupEdit]).toBe(false)
      done()
    })
  })

  it('should fire populator', function () {
    Vue.set(store.state.main[symbols.state.notificationNumbers], NOTIFICATION_NUMBERS.pendingClaims, 3)
    const props = {
      menuItem: {
        name: 'Element name',
        populator: symbols.populators.populateClaims
      }
    }
    const vm = this.mount(props)
    const link = vm.$el.querySelector('li > a')
    expect(link.textContent).toBe('Element name (3)')
  })
})
