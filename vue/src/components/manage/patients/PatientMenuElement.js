import symbols from '../../../symbols'
import ProcessWrapper from '../../../wrappers/ProcessWrapper'

export default {
  props: {
    elementLegacy: {
      type: Boolean,
      default: true
    },
    elementLink: {
      type: String,
      required: true
    },
    elementName: {
      type: String,
      required: true
    },
    elementActive: {
      type: String,
      default: ''
    },
    elementActiveLike: {
      type: Array,
      default: function () {
        return []
      }
    },
    wildcard: {
      type: String,
      default: symbols.getters.patientId
    },
    lastElement: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    isActive () {
      if (this.elementActive) {
        if (this.$route && this.$route.name === this.elementActive) {
          return true
        }
        return false
      }
      if (this.elementActiveLike.length) {
        return this.checkPattern()
      }
      return false
    },
    parsedLink () {
      const wildcardData = this.$store.getters[this.wildcard]
      const link = this.elementLink.replace('%d', wildcardData)
      return ProcessWrapper.getLegacyRoot() + link
    }
  },
  methods: {
    checkPattern () {
      for (let pattern of this.elementActiveLike) {
        if (this.$route && this.$route.name && this.$route.name.indexOf(pattern) > -1) {
          return true
        }
      }
      return false
    }
  }
}
