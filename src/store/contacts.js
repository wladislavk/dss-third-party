import constants from '../modules/constants'
import endpoints from '../endpoints'
import http from '../services/http'
import symbols from '../symbols'

export default {
  state: {
    [symbols.state.contact]: {
      contactid: 0,
      phone1: '',
      phone2: '',
      fax: ''
    }
  },
  getters: {
    [symbols.getters.filteredContact] (state) {
      const contact = state[symbols.state.contact]
      constants.PHONE_FIELDS.forEach(el => {
        if (contact.hasOwnProperty(el)) {
          contact[el] = contact[el]
            .replace(/[^0-9]/g, '')
            .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
        }
      })

      return contact
    }
  },
  mutations: {
    [symbols.mutations.setContact] (state, { data }) {
      state[symbols.state.contact] = data
    }
  },
  actions: {
    [symbols.actions.setCurrentContact] ({ commit, dispatch }, payload) {
      const requestData = { contact_id: payload.contactId }

      http.post(endpoints.contacts.withContactType, requestData).then(
        (response) => {
          const data = response.data.data

          if (data) {
            commit(symbols.mutations.setContact, { data: data })
          }

          dispatch(symbols.actions.disablePopupEdit)
        },
        (response) => {
          dispatch(symbols.actions.handleErrors, { title: 'getContactById', response: response })
        }
      )
    }
  }
}
