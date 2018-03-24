import initialState from './screener/state'
import getters from './screener/getters'
import mutations from './screener/mutations'
import actions from './screener/actions'

export default {
  state: JSON.parse(JSON.stringify(initialState)),
  getters: getters,
  mutations: mutations,
  actions: actions
}
