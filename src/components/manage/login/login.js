import axios from 'axios'
import endpoints from '../../../endpoints'
import { LEGACY_URL } from '../../../constants'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'
import symbols from '../../../symbols'
import alerter from '../../../services/alerter'
import { focus as focusDirective } from 'vue-focus'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

export default {
  name: 'login',
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
  directives: {
    focus: focusDirective
  },
  mixins: [handlerMixin],
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
      let alertText
      if (this.credentials.username.trim() === '') {
        alertText = 'Username is Required'
        alerter.alert(alertText)
        this.focusUser = true

        return false
      }
      this.focusUser = false

      if (this.credentials.password.trim() === '') {
        alertText = 'Password is Required'
        alerter.alert(alertText)
        this.focusPassword = true

        return false
      }
      this.focusPassword = false

      axios.post(ProcessWrapper.getApiRoot() + 'auth', this.credentials).then((response) => {
        const data = response.data

        if (!data.hasOwnProperty('token') || !data.token) {
          throw new Error('No token retrieved')
        }

        this.$store.commit(symbols.mutations.mainToken, data.token)
        http.token = data.token

        return http.post(endpoints.users.check).then((response) => {
          const data = response.data.data

          // @todo: the token was already set, so it is possible to change route manually for suspended user
          if (data.type.toLowerCase() === 'suspended') {
            this.message = 'This account has been suspended.'
            return
          }
          this.$router.push({ name: 'dashboard' })
        }).catch((response) => {
          this.handleErrors('getAccountStatus', response)
        })
      }).catch((response) => {
        if (response.status === 422) {
          this.message = 'Wrong username or password'
        } else {
          this.handleErrors('getToken', response)
        }
      })
    }
  }
}
