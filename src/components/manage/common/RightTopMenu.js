import { LEGACY_URL, NOTIFICATION_NUMBERS } from '../../../constants/main'
import symbols from '../../../symbols'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL
    }
  },
  computed: {
    supportTicketsNumber () {
      return this.$store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets]
    },
    notificationsNumber () {
      return this.$store.getters[symbols.getters.notificationsNumber]
    }
  },
  methods: {
    logout () {
      this.$store.dispatch(symbols.actions.logout)
      this.$router.push({ name: 'main-login' })
    }
  }
}
