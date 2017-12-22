import symbols from '../../src/symbols'

export default class {
  constructor () {
    this.mutations = []
    this.actions = []
    this.state = {}
    this.rootState = {
      main: {
        [symbols.state.mainToken]: ''
      }
    }
    this.mocks = {
      state: this.state,
      rootState: this.rootState,
      commit: this._commit.bind(this),
      dispatch: this._dispatch.bind(this)
    }
  }

  setState (state) {
    this.mocks.state = state
  }

  setRootState (state) {
    this.mocks.rootState = state

    if (this.mocks.rootState.hasOwnProperty('main')) {
      this.mocks.rootState.main[symbols.state.mainToken] = ''
      return
    }

    this.mocks.rootState['main'] = {
      [symbols.state.mainToken]: ''
    }
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
  }
}
