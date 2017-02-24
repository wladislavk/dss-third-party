module.exports = {
  methods: {
    logout () {
      this.invalidateToken()
        .then(function (response) {
          var vm = this

          window.swal({
            title: '',
            text: 'Logout Successfully!',
            type: 'success'
          }, function () {
            window.storage.remove('token')
            vm.$route.router.go('/manage/login')
          })
        }, function (response) {
          console.error('invalidateToken [status]: ', response.status)
        })
    },
    invalidateToken () {
      return this.$http.post(window.config.API_PATH + 'logout')
    }
  }
}
