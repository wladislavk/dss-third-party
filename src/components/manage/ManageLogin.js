import endpoints from '../../endpoints'
import { LEGACY_URL } from '../../constants/main'
import http from '../../services/http'
import symbols from '../../symbols'
import Alerter from '../../services/Alerter'
import { focus as focusDirective } from 'vue-focus'
import SiteSealComponent from '../SiteSeal.vue'

export default {
  name: 'main-login',
  data () {
    return {
      focusUser: false,
      focusPassword: false,
      legacyUrl: LEGACY_URL,
      message: '',
      credentials: {
        username: '',
        password: ''
      }
    }
  },
  components: {
    siteSeal: SiteSealComponent
  },
  directives: {
    focus: focusDirective
  },
  mounted () {
    const token = this.$store.state.main[symbols.state.mainToken]
    if (token) {
      const data = {
        cur_page: this.$route.path
      }
      http.token = token
      http.post(endpoints.loginDetails.store, data)
      this.$router.push({ name: 'dashboard' })
    }
  },
  methods: {
    setUsername (event) {
      this.credentials.username = event.target.value
    },
    setPassword (event) {
      this.credentials.password = event.target.value
    },
    submitForm () {
      this.message = 'foo'
      let alertText
      if (this.credentials.username.trim() === '') {
        alertText = 'Username is Required'
        Alerter.alert(alertText)
        this.focusUser = true
        return
      }
      this.focusUser = false

      if (this.credentials.password.trim() === '') {
        alertText = 'Password is Required'
        Alerter.alert(alertText)
        this.focusPassword = true
        return
      }
      this.focusPassword = false

      this.$store.dispatch(symbols.actions.mainLogin, this.credentials).then(() => {
        this.$router.push({ name: 'dashboard' })
      }).catch((response) => {
        this.message = response.message
      })
    }
  }
}
