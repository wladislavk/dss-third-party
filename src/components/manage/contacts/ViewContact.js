import { mapGetters } from 'vuex'
import symbols from '../../../symbols'

export default {
  computed: {
    ...mapGetters({
      filteredContact: symbols.getters.filteredContact
    })
  },
  created () {
  },
  beforeDestroy () {
  },
  methods: {
  }
}
