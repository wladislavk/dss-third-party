var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

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
        if (this.$route.query.sortdir.toLowerCase() == 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc')
        }
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
  mounted () {
    this.getContacts()
  },
  methods: {
    removeContact (id) {
      this.deleteReferredByContact(id)
        .then(function () {
          this.message = 'Deleted Successfull';
        }, function (response) {
          this.handleErrors('deleteReferredByContact', response)
        })
    },
    getContacts () {
      this.getReferredByContacts(
        this.routeParameters.sortColumn,
        this.routeParameters.currentPageNumber,
        this.routeParameters.sortDirection,
        this.contactsPerPage
      ).then(function (response) {
        var data = response.data.data

        if (data.total > 0) {
          this.contactsTotalNumber = data.total
          this.contacts = data.contacts
        }
      }, function (response) {
        this.handleErrors('getReferredByContacts', response)
      })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    getReferredByContacts (sort, pageNumber, sortDir, contactsPerPage) {
      var data = {
        sort: sort,
        page: pageNumber,
        sortdir: sortDir,
        contacts_per_page: contactsPerPage
      }

      return this.$http.post(process.env.API_PATH + 'contacts/referred-by', data)
    },
    deleteReferredByContact (id) {
      return this.$http.delete(process.env.API_PATH + 'referred-by/' + id)
    }
  }
}
