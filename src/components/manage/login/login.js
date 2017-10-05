import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'

export default {
  name: 'login',
  data () {
    return {
      message: '',
      credentials: {
        username: '',
        password: ''
      }
    }
  },
  mixins: [handlerMixin],
  mounted () {
    if (window.storage.get('token')) {
      const data = {
        cur_page: this.$route.path
      }

      http.post(endpoints.loginDetails.store, data)

      this.$router.push('/manage/index')
    }
  },
  methods: {
    submitForm () {
      let alertText
      if (this.credentials.username.trim() === '') {
        alertText = 'Username is Required'
        alert(alertText)
        this.$refs.username.focus()

        return false
      }

      if (this.credentials.password.trim() === '') {
        alertText = 'Password is Required'
        alert(alertText)
        this.$refs.password.focus()

        return false
      }

      this.getToken(this.credentials).then(function (response) {
        const data = response.data

        if (data.token) {
          window.storage.save('token', data.token)
        }

        this.getAccountStatus().then(function (response) {
          const data = response.data.data

          if (data.type.toLowerCase() === 'suspended') {
            this.message = 'This account has been suspended.'
          } else {
            this.$router.push('/manage/index')
          }
        }).catch(function (response) {
          this.handleErrors('getAccountStatus', response)
        })
      }).catch(function (response) {
        if (response.status === 422) {
          this.message = 'Wrong username or password'
        } else {
          this.handleErrors('getToken', response)
        }
      })
    },
    getToken (data) {
      return http.post(endpoints.auth, data)
    },
    getAccountStatus () {
      return http.post(endpoints.users.check, {}, {
        headers: {
          Authorization: 'Bearer ' + window.storage.get('token')
        }
      })
    }
  }
}
