import { LEGACY_URL, NOTIFICATIONS } from '../../../constants'
import NotificationLinkComponent from './NotificationLink.vue'

export default {
  data () {
    return {
      notifications: NOTIFICATIONS,
      legacyUrl: LEGACY_URL,
      showAll: false
    }
  },
  components: {
    notificationLink: NotificationLinkComponent
  },
  methods: {
    showAllNotifications () {
      this.showAll = true
    },
    showActiveNotifications () {
      this.showAll = false
    },
    resolveCondition (getterName) {
      if (!getterName) {
        return true
      }
      return this.$store.getters[getterName]
    }
  }
}
