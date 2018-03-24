import populators from '../../../services/populators'
import LegacyModifier from '../../../services/LegacyModifier'
import symbols from '../../../symbols'

export default {
  // name must be set explicitly to allow self-references
  name: 'navigation-element',
  props: {
    menuItem: {
      type: Object,
      required: true
    },
    firstLevel: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      showChildren: false,
      elementName: ''
    }
  },
  computed: {
    menuItemLink () {
      if (this.menuItem.hasOwnProperty('link') && this.menuItem.link) {
        if (this.menuItem.hasOwnProperty('legacy') && !this.menuItem.legacy) {
          return this.menuItem.link
        }
        const token = this.$store.state.main[symbols.state.mainToken]
        return LegacyModifier.modifyLegacyLink(this.menuItem.link, token)
      }
      return '#'
    },
    menuItemChildren () {
      if (this.menuItem.hasOwnProperty('children')) {
        return this.menuItem.children
      }
      return []
    },
    menuItemBlank () {
      if (this.menuItem.hasOwnProperty('blank')) {
        return this.menuItem.blank
      }
      return false
    },
    linkClass () {
      if (this.menuItemChildren.length && this.firstLevel) {
        return 'mainfoldericon'
      }
      if ((this.menuItemChildren.length || this.menuItem.childrenFrom) && !this.firstLevel) {
        return 'subfoldericon'
      }
      return ''
    }
  },
  created () {
    let elementName = this.menuItem.name
    if (this.menuItem.hasOwnProperty('populator') && this.menuItem.populator) {
      elementName = populators[this.menuItem.populator](this.$store.state, elementName)
    }
    this.elementName = elementName
  },
  methods: {
    clickLink (event) {
      if (this.menuItem.hasOwnProperty('action') && this.menuItem.action) {
        event.preventDefault()
        this.$store.dispatch(this.menuItem.action)
      }
    },
    resolveCondition (getterName) {
      if (!getterName) {
        return true
      }
      return this.$store.getters[getterName]
    },
    getChildrenFrom (getterName) {
      return this.$store.getters[getterName]
    }
  }
}
