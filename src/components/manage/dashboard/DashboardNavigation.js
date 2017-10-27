import symbols from '../../../symbols'
import { LEGACY_URL, NAVIGATION_MENU } from '../../../constants'
import NavigationElementComponent from './NavigationElement.vue'

export default {
  data () {
    return {
      menu: NAVIGATION_MENU,
      legacyUrl: LEGACY_URL,
      documentCategories: []
    }
  },
  components: {
    navigationElement: NavigationElementComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.documentCategories)
  },
  methods: {
    resolveCondition (getterName) {
      if (!getterName) {
        return true
      }
      return this.$store.getters[getterName](this.$store.state.dashboard)
    }
  }
}
