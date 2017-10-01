import symbols from '../../symbols'

export default {
  data: function () {
    return {
      username: '',
      password: '',
      loginError: false
    }
  },
  mounted () {
    if (this.$store.state.screener[symbols.state.screenerToken]) {
      this.$router.push({ name: 'screener-intro' })
    }
  },
  methods: {
    // this method is needed to capture input for password in Headless Chrome
    setPassword (event) {
      this.password = event.target.value
    },
    onSubmit () {
      if (!this.username) {
        alert('Username is Required')
        return
      }
      if (!this.password) {
        alert('Password is Required')
        return
      }

      const data = {
        username: this.username,
        password: this.password
      }
      this.$store.dispatch(symbols.actions.authenticateScreener, data).then(
        () => {
          this.$router.push({ name: 'screener-intro' })
        },
        () => {
          this.loginError = true
        }
      )
    }
  }
}
