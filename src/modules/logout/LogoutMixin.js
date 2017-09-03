module.exports = {
  methods: {
    logout () {
      this.invalidateToken()
        .then(function () {
          const vm = this

          window.swal({
            title: '',
            text: 'Logout Successfully!',
            type: 'success'
          }, function () {
            window.storage.remove('token')
            vm.$router.push('/manage/login')
          })
        }, function (response) {
          console.error('invalidateToken [status]: ', response.status)
        })
    },
    invalidateToken () {
      return this.$http.post(process.env.API_PATH + 'logout')
    }
  }
}
