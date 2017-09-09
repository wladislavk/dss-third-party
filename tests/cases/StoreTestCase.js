export default class {
  constructor () {
    this.mutations = []
    this.actions = []
    this.mocks = {
      commit: this._commit.bind(this),
      dispatch: this._dispatch.bind(this)
    }
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
