import symbols from '../../../symbols'
import DashboardMessagesComponent from './DashboardMessages.vue'
import DashboardNavigationComponent from './DashboardNavigation.vue'
import DashboardNotificationsComponent from './DashboardNotifications.vue'
import DashboardTaskMenuComponent from './DashboardTaskMenu.vue'

export default {
  computed: {
    homepage () {
      return parseInt(this.$store.state.main[symbols.state.docInfo].homepage)
    }
  },
  components: {
    dashboardTaskMenu: DashboardTaskMenuComponent,
    dashboardMessages: DashboardMessagesComponent,
    dashboardNavigation: DashboardNavigationComponent,
    dashboardNotifications: DashboardNotificationsComponent
  },
}
