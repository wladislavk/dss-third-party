import { LEGACY_URL } from '../../../constants/main'
import { mapGetters } from 'vuex'
import symbols from '../../../symbols'

export default {
  props: [
    'contactid'
  ],
  data () {
    return {
      legacyUrl: LEGACY_URL
    }
  },
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
