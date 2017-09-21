import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'
import symbols from '../../../symbols'

export default {
  name: 'referredby',
  data () {
    return {
      constants: window.constants,
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
      }
    }
  },
  mixins: [handlerMixin],
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
        const self = this

        setTimeout(() => {
          self.message = ''
        }, 3000)
      })
    },
    onClickEditReferredByNotes (id) {
      this.$parent.$refs.modal.display('edit-referred-by-note')
      this.$parent.$refs.modal.setComponentParameters({ noteId: id })
    },
    onClickViewContact (id) {
      this.$parent.$refs.modal.display('view-contact')
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: id })
    },
    onClickAddNewReferredBy () {
      this.$parent.$refs.modal.display('edit-referred-by-contact')
    },
    removeContact (id) {
      this.deleteReferredByContact(id).then(
        function () {
          this.message = 'Deleted Successfull'
        },
        function (response) {
          this.handleErrors('deleteReferredByContact', response)
        }
      )
    },
    getContacts () {
      this.getReferredByContacts(
        this.routeParameters.sortColumn,
        this.routeParameters.currentPageNumber,
        this.routeParameters.sortDirection,
        this.contactsPerPage
      ).then(
        function (response) {
          const data = response.data.data

          if (data.total > 0) {
            this.contactsTotalNumber = data.total
            this.contacts = data.contacts
          }
        },
        function (response) {
          this.handleErrors('getReferredByContacts', response)
        }
      )
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
