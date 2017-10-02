export default class {
  constructor () {
    this.mutations = []
    this.actions = []
    this.state = {}
    this.mocks = {
      state: this.state,
      commit: this._commit.bind(this),
      dispatch: this._dispatch.bind(this)
    }
  }

  setState (state) {
    this.mocks.state = state
  }

  _commit (type, payload) {
    payload = payload || {}
    this.mutations.push({type: type, payload: payload})
  }

  _dispatch (type, payload) {
    payload = payload || {}
    this.actions.push({ type: type, payload: payload })
  }
}
