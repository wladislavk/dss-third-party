import { NOTIFICATION_NUMBERS } from '../../../constants'
import symbols from '../../../symbols'

export default {
  data () {
    return {
      supportTicketsNumber: this.$store.state.main[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.supportTickets]
    }
  },
  computed: {
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
