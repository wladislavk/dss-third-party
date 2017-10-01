import symbols from '../../../symbols'

export default {
  methods: {
    closeFancybox () {
      this.$store.commit(symbols.mutations.hideFancybox)
    },
    closeAndReset () {
      this.$store.commit(symbols.mutations.restoreInitialScreenerKeepSession)
      this.$store.commit(symbols.mutations.hideFancybox)
      this.$router.push({ name: 'screener-intro' })
    }
  }
}
