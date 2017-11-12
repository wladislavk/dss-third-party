import NotificationLinkComponent from './NotificationLink.vue'

export default {
  props: {
    notification: {
      type: Object,
      required: true
    },
    showAll: {
      type: Boolean,
      required: true
    }
  },
  data () {
    return {
      childrenShown: false
    }
  },
  components: {
    notificationLink: NotificationLinkComponent
  },
  methods: {
    showChildren () {
      this.childrenShown = true
    },
    hideChildren () {
      this.childrenShown = false
    },
    resolveCondition (getterName) {
      if (!getterName) {
        return true
      }
      return this.$store.getters[getterName]
    }
  }
}
