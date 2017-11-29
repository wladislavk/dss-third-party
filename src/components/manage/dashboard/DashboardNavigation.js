import symbols from '../../../symbols'
import { NAVIGATION_MENU } from '../../../constants/dashboard'
import NavigationElementComponent from './NavigationElement.vue'

export default {
  data () {
    return {
      menu: NAVIGATION_MENU,
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
      return this.$store.getters[getterName]
    }
  }
}
