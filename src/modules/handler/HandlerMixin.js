import symbols from '../../symbols'

export default {
  methods: {
    handleErrors (title, response) {
      // token expired
      if (response.status === 401) {
        this.$store.commit(symbols.mutations.mainToken, '')
        this.$router.push({ name: 'login' })
      } else {
        if (process.env.NODE_ENV === 'development') {
          console.error(title + ' [status]: ', response.status)
        } else {
          // TODO if prod
        }
      }
    }
  }
}
