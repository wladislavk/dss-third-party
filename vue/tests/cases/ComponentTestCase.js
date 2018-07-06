import Vue from 'vue'
import VueRouter from 'vue-router'
import VueMoment from 'vue-moment'
import VueVisible from 'vue-visible'
import moxios from 'moxios'
import lodash from 'lodash'
import store from '../../src/store'
import LegacyHref from '../../src/directives/LegacyHref'
import UnescapeFilter from '../../src/filters/Unescape'
import http from '../../src/services/http'
import BaseTestCase from './BaseTestCase'

export default class ComponentTestCase extends BaseTestCase {
  constructor () {
    super()

    this.component = null
    this.activeRoute = null
    this.routes = []
    this.propsData = {}
    this.renderChildren = false
    this.skippedChildren = []
    this.waitForRequest = false
    this.vm = null

    Vue.use(VueRouter)
    Vue.use(VueVisible)
    Vue.use(VueMoment)
    Vue.directive('legacy-href', LegacyHref)
    Vue.filter('unescape', UnescapeFilter)

    this.originalState = lodash.cloneDeep(store.state)
  }

  _initialize () {
    super._initialize()
    moxios.install()
  }

  stubRequest (requestData) {
    let responseData = []
    let status = 200
    let dataKey = 'data'
    if (requestData.hasOwnProperty('response')) {
      responseData = requestData.response
    }
    if (requestData.hasOwnProperty('status')) {
      status = requestData.status
    }
    if (requestData.hasOwnProperty('dataKey')) {
      dataKey = requestData.dataKey
    }
    let url = http.formUrl(requestData.url)
    if (requestData.hasOwnProperty('rawUrl') && requestData.rawUrl) {
      url = requestData.url
    }
    moxios.stubRequest(url, {
      status: status,
      responseText: {
        [dataKey]: responseData
      }
    })
    this.waitForRequest = true
  }

  getRequestResults () {
    const results = []
    const resultsNumber = moxios.requests.count()
    for (let i = 0; i < resultsNumber; i++) {
      const currentRequest = moxios.requests.at(i)
      const newResult = {
        url: http.deformUrl(currentRequest.url)
      }
      let currentRequestData = currentRequest.config.data
      if (currentRequestData) {
        newResult.body = JSON.parse(currentRequestData)
      }
      results.push(newResult)
    }
    return results
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

  skipChildren (skippedComponents) {
    if (!this.component) {
      return
    }
    this.skippedChildren = skippedComponents
    for (let componentName of skippedComponents) {
      this.component.components[componentName] = {
        template: '<div class="' + componentName + '"></div>'
      }
    }
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
    if (this.renderChildren || this.skippedChildren.length) {
      properties.components = this.component.components
    }
    this.vm = new Component(properties)
    if (this.activeRoute) {
      this.vm.$router.push({name: this.activeRoute})
    }
    return this.vm
  }

  /**
   * @returns {Vue}
   */
  mount () {
    this.vm = this.getVM()
    this.vm.$mount()
    return this.vm
  }

  wait (callback) {
    if (!this.vm) {
      return
    }
    if (this.fixedTimeout) {
      super.wait(callback)
      return
    }
    if (this.waitForRequest) {
      moxios.wait(callback)
      return
    }
    this.vm.$nextTick(callback)
  }

  reset () {
    store.replaceState(this.originalState)
    moxios.uninstall()
    super.reset()
  }
}
