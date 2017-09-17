import { mapGetters } from 'vuex'
import symbols from '../../../symbols'

export default {
  computed: {
    ...mapGetters({
      assessmentName: symbols.getters.fullName
    })
  }
}
