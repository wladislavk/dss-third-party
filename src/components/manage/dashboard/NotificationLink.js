import symbols from '../../../symbols'

export default {
  props: {
    linkCount: {
      type: String,
      required: true
    },
    linkLabel: {
      type: String,
      required: true
    },
    linkUrl: {
      type: String,
      default: ''
    },
    countZeroClass: {
      type: String,
      default: 'good_count'
    },
    countNonZeroClass: {
      type: String,
      default: 'bad_count'
    },
    hasChildren: {
      type: Boolean,
      default: false
    },
    showAll: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    linkNumber () {
      return this.$store.state.main[symbols.state.notificationNumbers][this.linkCount]
    }
  }
}
