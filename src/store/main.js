import Vue from 'vue'
import symbols from '../symbols'

export default {
  state: {
    popupEdit: false
  },
  mutations: {
    [symbols.mutations.popupEdit] (state, { value }) {
      state.popupEdit = value
    }
  },
  actions: {
    [symbols.actions.disablePopupEdit] ({commit}) {
      commit(symbols.mutations.popupEdit, {
        value: false
      })
    },
    [symbols.actions.handleErrors] ({title, response}) {
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
