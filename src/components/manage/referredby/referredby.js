import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { DSS_CONSTANTS } from '../../../constants/main'

export default {
  name: 'referredby',
  data () {
    return {
      message: '',
      routeParameters: {
        currentPageNumber: 0,
        sortColumn: '',
        sortDirection: 'asc'
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 10,
      tableHeaders: {
        'name': {
          type: 'general',
          title: 'Name'
        },
        'contacttype': {
          type: 'general',
          title: 'Physician Type'
        },
        'total': {
          type: 'general',
          title: 'Total Referrals'
        },
        'thirty': '30 Days',
        'sixty': '60 Days',
        'ninty': '90 Days',
        'nintyplus': '90+ Days',
        'notes': 'Notes',
        'expand': 'Expand'
      },
      referredPhysician: DSS_CONSTANTS.DSS_REFERRED_PHYSICIAN
    }
  },
  watch: {
    '$route.query.page': function () {
      if (this.$route.query.page <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page)
      }
    },
    '$route.query.sort': function () {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
        } else {
          this.$set(this.routeParameters, 'sortColumn', null)
        }
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc')
        }
      }
    },
    '$route.query.delid': function () {
      if (this.$route.query.delid > 0) {
        this.removeContact(this.$route.query.delid)
      }
    },
    'routeParameters': {
      handler: function () {
        this.getContacts()
      },
      deep: true
    }
  },
  computed: {
    totalPages () {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage)
    }
  },
  created () {
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal)
  },
  mounted () {
    this.getContacts()
  },
  beforeDestroy () {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal)
  },
  methods: {
    onSettingDataFromModal (data) {
      this.message = data.message

      this.$nextTick(() => {
        setTimeout(() => {
          this.message = ''
        }, 3000)
      })
    },
    onClickEditReferredByNotes (id) {
      const modalData = {
        name: symbols.modals.editReferredByNote,
        params: {
          noteId: id
        }
      }
      this.$store.commit(symbols.mutations.modal, modalData)
    },
    onClickViewContact (id) {
      this.$store.commit(symbols.mutations.modal, { name: symbols.modals.viewContact })
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: id })
    },
    onClickAddNewReferredBy () {
      this.$store.commit(symbols.mutations.modal, { name: symbols.modals.editReferredByContact })
    },
    removeContact (id) {
      this.deleteReferredByContact(id).then(() => {
        this.message = 'Deleted Successfully'
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'deleteReferredByContact', response: response})
      })
    },
    getContacts () {
      this.getReferredByContacts(
        this.routeParameters.sortColumn,
        this.routeParameters.currentPageNumber,
        this.routeParameters.sortDirection,
        this.contactsPerPage
      ).then((response) => {
        const data = response.data.data

        if (data.total > 0) {
          this.contactsTotalNumber = data.total
          this.contacts = data.contacts
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getReferredByContacts', response: response})
      })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      }
      return 'asc'
    },
    getReferredByContacts (sort, pageNumber, sortDir, contactsPerPage) {
      const data = {
        sort: sort,
        page: pageNumber,
        sortdir: sortDir,
        contacts_per_page: contactsPerPage
      }

      return http.post(endpoints.contacts.referredBy, data)
    },
    deleteReferredByContact (id) {
      return http.delete(endpoints.referredByContacts.destroy + '/' + id)
    }
  }
}
