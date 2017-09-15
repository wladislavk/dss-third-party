import symbols from '../../../symbols'

export default {
  data: function () {
    return {
      assessmentName: this.$store.state[symbols.state.assessmentName]
    }
  }
}
