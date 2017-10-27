import handlerMixin from '../../../modules/handler/HandlerMixin'
import symbols from '../../../symbols'
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
  computed: {
    patientNotificationsNumber () {
      return this.$store.getters[symbols.getters.patientNotificationsNumber]
    }
  },
  components: {
    notificationLink: NotificationLinkComponent
  },
  mixins: [handlerMixin],
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
      return this.$store.getters[getterName](this.$store.state.dashboard)
    }
  }
}
