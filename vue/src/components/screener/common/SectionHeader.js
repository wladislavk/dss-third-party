import { mapGetters } from 'vuex'
import symbols from '../../../symbols'

export default {
  props: {
    title: {
      type: String,
      required: true
    },
    bottomMargin: {
      type: Boolean,
      default: false
    },
    assessment: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    ...mapGetters({
      assessmentName: symbols.getters.fullName
    })
  }
}
