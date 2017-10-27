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
      initialOffset: 0
    }
  },
  created () {
    if (this.menuItem.hasOwnProperty('populator')) {
      this.$store.dispatch(this.menuItem.populator, this.menuItem)
    }
    this.initialOffset = this.$el.offsetWidth
  },
  methods: {
    clickLink (action, event) {
      if (!action) {
        return
      }
      event.preventDefault()
      this.$store.dispatch(action)
    },
    resolveCondition (getterName) {
      return this.$store.getters[getterName](this.$store.state.dashboard)
    },
    getChildrenFrom (getterName) {
      return this.$store.getters[getterName](this.$store.state.dashboard)
    }
  }
}
