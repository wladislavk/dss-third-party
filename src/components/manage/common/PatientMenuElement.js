import symbols from '../../../symbols'
import { LEGACY_URL } from '../../../constants'

export default {
  props: {
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
      default: []
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
        if (this.$route.name === this.elementActive) {
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
      return LEGACY_URL + link
    }
  },
  methods: {
    checkPattern () {
      for (let pattern of this.elementActiveLike) {
        if (this.$route.name.indexOf(pattern) > -1) {
          return true
        }
      }
      return false
    }
  }
}
