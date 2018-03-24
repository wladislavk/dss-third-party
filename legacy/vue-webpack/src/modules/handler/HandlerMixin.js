module.exports = {
  methods: {
    handleErrors (title, response) {
      // token expired
      if (response.status === 401) {
        window.storage.remove('token')
        this.$router.push('/manage/login')
      } else {
        // if dev environment
        if (process.env.NODE_ENV === 'development') {
          console.error(title + ' [status]: ', response.status)
        } else {
          // TODO if prod
        }
      }
    }
  }
}
