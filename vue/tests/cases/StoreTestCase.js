import store from '../../src/store'

export default class {
  constructor () {
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

  _commit (type, payload) {
    if (payload === undefined) {
      payload = {}
    }
    this.mutations.push({type: type, payload: payload})
  }

  _dispatch (type, payload) {
    if (payload === undefined) {
      payload = {}
    }
    this.actions.push({ type: type, payload: payload })
    return new Promise((resolve) => {
      resolve()
    })
  }
}
