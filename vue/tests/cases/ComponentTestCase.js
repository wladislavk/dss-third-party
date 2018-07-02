import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMoment from 'vue-moment'
import VueVisible from 'vue-visible'
import moxios from 'moxios'
import sinon from 'sinon'
import lodash from 'lodash'
import store from '../../src/store'
import LegacyHref from '../../src/directives/LegacyHref'
import UnescapeFilter from '../../src/filters/Unescape'
import LocationWrapper from '../../src/wrappers/LocationWrapper'
import Alerter from '../../src/services/Alerter'

export default class ComponentTestCase {
  constructor () {
    this.sandbox = sinon.createSandbox()
    moxios.install()

    this.component = null
    this.activeRoute = null
    this.routes = []
    this.propsData = {}
    this.renderChildren = false
    this.redirectUrl = ''
    this.alertText = ''
    this.confirmText = ''
    this.confirmDialog = true

    this._makeStubs()

    Vue.use(VueRouter)
    Vue.use(VueVisible)
    Vue.use(VueMoment)
    Vue.directive('legacy-href', LegacyHref)
    Vue.filter('unescape', UnescapeFilter)

    this.originalState = lodash.cloneDeep(store.state)
  }

  _makeStubs () {
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      this.redirectUrl = url
    })
    this.sandbox.stub(Alerter, 'alert').callsFake((text) => {
      this.alertText = text
    })
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake((text) => {
      this.confirmText = text
      return this.confirmDialog
    })
  }

  reset () {
    // store.replaceState(this.originalState)
    moxios.uninstall()
    this.sandbox.restore()
  }

  setComponent (component) {
    this.component = component
  }

  setRoutes (routes) {
    this.routes = routes
  }

  setActiveRoute (routeName) {
    this.activeRoute = routeName
  }

  setPropsData (propsData) {
    this.propsData = propsData
  }

  setRenderChildren (renderChildren) {
    this.renderChildren = renderChildren
  }

  setChildComponents (components) {
    for (let component of components) {
      let componentName = component
      let childComponentTag = 'div'
      let dataAttributes = []
      let props = {}
      if (typeof component === 'object') {
        componentName = component.name
        if (component.hasOwnProperty('tag')) {
          childComponentTag = component.tag
        }
        if (component.hasOwnProperty('attributes') && Array.isArray(component.attributes)) {
          dataAttributes = component.attributes
        }
        if (component.hasOwnProperty('props')) {
          props = component.props
        }
      }
      let attributeString = ''
      for (let attribute of dataAttributes) {
        if (typeof attribute === 'object') {
          attribute = JSON.stringify(attribute)
        }
        attributeString += 'v-bind:data-' + attribute.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase() + '="' + attribute + '" '
      }
      let componentHTML = '<' + childComponentTag + ' class="' + componentName + '" ' + attributeString + '></' + childComponentTag + '>'
      Vue.component(componentName, {
        template: componentHTML,
        props: props
      })
    }
  }

  /**
   * @returns {Vue}
   */
  getVM () {
    const Component = Vue.extend(this.component)
    const Router = new VueRouter({
      mode: 'history',
      routes: this.routes
    })
    const properties = {
      store: store,
      router: Router,
      propsData: this.propsData
    }
    if (this.renderChildren) {
      properties.components = this.component.components
    }
    const vm = new Component(properties)
    if (this.activeRoute) {
      vm.$router.push({name: this.activeRoute})
    }
    return vm
  }

  /**
   * @returns {Vue}
   */
  mount () {
    const vm = this.getVM()
    vm.$mount()
    return vm
  }
}
