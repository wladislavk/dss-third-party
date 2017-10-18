import Vue from 'vue'
import symbols from '../symbols'

export default {
  state: {
    [symbols.state.mainToken]: '',
    [symbols.state.popupEdit]: false
  },
  mutations: {
    [symbols.mutations.mainToken] (state, token) {
      state[symbols.state.mainToken] = token
    },
    [symbols.mutations.popupEdit] (state, { value }) {
      state[symbols.state.popupEdit] = value
    }
  },
  actions: {
    [symbols.actions.disablePopupEdit] ({commit}) {
      commit(symbols.mutations.popupEdit, {
        value: false
      })
    },
    [symbols.actions.handleErrors] ({title, response}) {
      // @todo: use wrappers to make this action testable
      // token expired
      if (response.status === 401) {
        window.storage.remove('token')
        Vue.$router.push('/manage/login')
      } else {
        if (process.env.NODE_ENV === 'development') {
          console.error(title + ' [status]: ', response.status)
        } else {
          // TODO if prod
        }
      }
    }
  }
}
