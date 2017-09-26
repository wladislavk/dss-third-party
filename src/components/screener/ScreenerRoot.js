import symbols from '../../symbols'

export default {
  mounted () {
    document.title = 'Dental Sleep Solutions :: Screener'
    if (!this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({name: 'screener-login'})
      return
    }
    this.$router.push({name: 'screener-main'})
  }
}
