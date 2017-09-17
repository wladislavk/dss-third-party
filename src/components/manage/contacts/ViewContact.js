import { mapGetters } from 'vuex'
import symbols from '../../../symbols'

export default {
  props: [
    'contactid'
  ],
  computed: {
    ...mapGetters({
      filteredContact: symbols.getters.filteredContact
    })
  },
  created () {
    const contact = this.$store.state.contacts[symbols.state.contact]
    if (!contact.contactId && this.contactid) {
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: this.contactid })
    }
  }
}
