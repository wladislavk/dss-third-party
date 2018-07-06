import store from '../../src/store'
import BaseTestCase from './BaseTestCase'
import http from 'src/services/http'

export default class StoreTestCase extends BaseTestCase {
  constructor () {
    super()

    this.mutations = []
    this.actions = []
    this.state = {}
    this.rootState = store.state
    this.getters = {}
    this.mocks = {
      state: this.state,
      rootState: this.rootState,
      getters: this.getters,
      commit: this._commit.bind(this),
      dispatch: this._dispatch.bind(this)
    }
    this.postData = []

    this.fixedTimeout = 100
  }

  setState (state) {
    this.mocks.state = state
  }

  setRootState (state) {
    this.mocks.rootState = state
  }

  setGetters (getters) {
    this.mocks.getters = getters
  }

  _commit (type, payload = {}) {
    this.mutations.push({type: type, payload: payload})
  }

  _dispatch (type, payload = {}) {
    this.actions.push({ type: type, payload: payload })
    return new Promise((resolve) => {
      resolve()
    })
  }

  stubRequest (requestData) {
    let status = 200
    if (requestData.hasOwnProperty('status')) {
      status = requestData.status
    }
    let error = false
    if (status < 200 || status >= 300) {
      error = true
    }
    let method = 'post'
    if (requestData.hasOwnProperty('method')) {
      method = requestData.method
    }
    let response = {}
    if (requestData.hasOwnProperty('response')) {
      response = requestData.response
    }
    let result = {
      data: {
        data: response
      }
    }
    if (requestData.hasOwnProperty('message')) {
      result = {
        data: {
          message: requestData.message
        }
      }
    }
    this.sandbox.stub(http, method).callsFake((path, data) => {
      const newPostObject = {
        path: path
      }
      if (data) {
        newPostObject.payload = data
      }
      this.postData.push(newPostObject)
      if (error) {
        if (status !== 500) {
          return Promise.reject(new Error({ status: status }))
        }
        return Promise.reject(new Error())
      }
      return Promise.resolve(result)
    })
  }
}
