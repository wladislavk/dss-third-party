import { NOTIFICATIONS } from '../../../constants/dashboard'
import NotificationLinkComponent from './NotificationLink.vue'
import NotificationBranchComponent from './NotificationBranch.vue'

export default {
  data () {
    return {
      notifications: NOTIFICATIONS,
      showAll: false
    }
  },
  components: {
    notificationBranch: NotificationBranchComponent,
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
