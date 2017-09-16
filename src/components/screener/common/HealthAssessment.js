import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      assessmentName: this.$store.getters[symbols.getters.fullName]
    }
  }
}
