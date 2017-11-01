import { LEGACY_URL } from '../../../constants'

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
      legacyUrl: LEGACY_URL,
      showChildren: false,
      initialOffset: 0
    }
  },
  computed: {
    menuItemLink () {
      if (this.menuItem.hasOwnProperty('link') && this.menuItem.link) {
        if (this.menuItem.hasOwnProperty('legacy') && !this.menuItem.legacy) {
          return this.menuItem.link
        }
        return this.legacyUrl + this.menuItem.link
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
    }
  },
  created () {
    if (this.menuItem.hasOwnProperty('populator')) {
      this.$store.dispatch(this.menuItem.populator, this.menuItem)
    }
  },
  mounted () {
    // root element is not set before mounting
    this.initialOffset = this.$el.offsetWidth
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
