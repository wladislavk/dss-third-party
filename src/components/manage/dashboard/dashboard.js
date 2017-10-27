import symbols from '../../../symbols'
import HeaderComponent from '../../header/header.vue'
import DashboardMessagesComponent from './DashboardMessages.vue'
import DashboardNavigationComponent from './DashboardNavigation.vue'
import DashboardNotificationsComponent from './DashboardNotifications.vue'
import DashboardTaskMenuComponent from '../tasks/DashboardTaskMenu.vue'

export default {
  components: {
    headerComponent: HeaderComponent,
    dashboardTaskMenu: DashboardTaskMenuComponent,
    dashboardMessages: DashboardMessagesComponent,
    dashboardNavigation: DashboardNavigationComponent,
    dashboardNotifications: DashboardNotificationsComponent
  },
  created () {
    const token = this.$store.state.main[symbols.state.mainToken]
    if (!token) {
      this.$router.push({ name: 'login' })
      return
    }
    if (this.$store.state[symbols.state.docInfo].homepage !== '1') {
      // @todo: rewrite legacy
      // include_once 'includes/top2.htm'
    }
  }
}
