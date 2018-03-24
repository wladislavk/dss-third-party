import RouterKeeper from '../services/RouterKeeper'

export default {
  name: 'app',
  beforeCreate () {
    const body = document.body
    body.style.marginTop = '0'
    body.style.marginLeft = '0'
    body.style.marginRight = '0'
    body.style.marginBottom = '0'
  },
  created () {
    RouterKeeper.setRouter(this.$router)
  }
}
