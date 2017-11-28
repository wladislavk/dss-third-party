import { NOTIFICATION_NUMBERS } from '../../../constants/main'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'

export default {
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
      this.$store.commit(symbols.mutations.mainToken, '')
      Alerter.alert('Logout successfully')
      this.$router.push({ name: 'main-login' })
    }
  }
}
