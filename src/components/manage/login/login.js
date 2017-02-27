var handlerMixin = require('../../../modules/handler/HandlerMixin.js')
var scriptLoaderMixin = require('../../../modules/loader/ScriptLoaderMixin.js')

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
  mixins: [handlerMixin, scriptLoaderMixin],
  mounted () {
    if (window.storage.get('token')) {
      var data = {
        cur_page: this.$route.path
      }

      this.setLoginDetails(data)

      this.$route.router.push('/manage/index')
    }

    this.$nextTick(() => {
      this.loadScriptFrom(
        'https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf',
        '#siteseal',
        window.verifySeal,
        window.seal_installSeal
      )
    })
  },
  methods: {
    submitForm () {
      // username is a required field
      if (this.credentials.username.trim() === '') {
        alert('Username is Required')
        this.$refs.username.focus()

        return false
      }

      // password is a required field
      if (this.credentials.password.trim() === '') {
        alert('Password is Required')
        this.$refs.password.focus()

        return false
      }

      this.getToken(this.credentials)
        .then(function (response) {
          var data = response.data

          if (data.token) {
            window.storage.save('token', data.token)
          }

          this.getAccountStatus()
            .then(function (response) {
              var data = response.data.data

              if (data.type.toLowerCase() === 'suspended') {
                this.message = 'This account has been suspended.'
              } else {
                this.$route.router.push('/manage/index')
              }
            }, function (response) {
              this.handleErrors('getAccountStatus', response)
            })
        }, function (response) {
          if (response.status === 422) {
            this.message = 'Wrong username or password'
          } else {
            this.handleErrors('getToken', response)
          }
        })
    },

    getToken (data) {
      return this.$http.post(process.env.API_ROOT + 'auth', data)
    },
    setLoginDetails (data) {
      return this.$http.post(process.env.API_PATH + 'login-details', data)
    },
    getAccountStatus () {
      return this.$http.post(process.env.API_PATH + 'users/check', {}, {
        headers: {
          Authorization: 'Bearer ' + window.storage.get('token')
        }
      })
    }
  }
}
