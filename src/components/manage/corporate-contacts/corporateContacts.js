const handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  name: 'corporate-contacts',
  data () {
    return {
      message: '',
      routeParameters: {
        currentPageNumber: 0,
        sortDirection: 'asc',
        sortColumn: ''
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 10,
      tableHeaders: {
        'company': {
          title: 'Company',
          with_link: true,
          width: 30
        },
        'type': {
          title: 'Type',
          with_link: true,
          width: 20
        },
        'name': {
          title: 'Name',
          with_link: true,
          width: 30
        },
        'action': {
          title: 'Action',
          width: 20
        }
      }
    }
  },
  mixins: [handlerMixin],
  watch: {
    '$route.query.page': function () {
      const queryPage = this.$route.query.page
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage)
      }
    },
    '$route.query.sort': function () {
      const querySort = this.$route.query.sort
      let sortColumn = ''
      if (querySort in this.tableHeaders) {
        sortColumn = querySort
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn)
    },
    '$route.query.sortdir': function () {
      const querySortDir = this.$route.query.sortdir
      let sortDir = 'asc'
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc'
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir)
    },
    '$route.query.delid': function () {
      const queryDelId = this.$route.query.delid
      if (queryDelId > 0) {
        this.removeContact(queryDelId)
      }
    },
    'routeParameters': {
      handler: function () {
        this.getListOfContacts()
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
    this.getListOfContacts()
  },
  methods: {
    onClickViewFull (contactId) {
      this.$parent.$refs.modal.display('view-corporate-contact')
      this.$parent.$refs.modal.setComponentParameters({ contactId: contactId })
    },
    onClickQuickView (contactId) {
      this.$parent.$refs.modal.display('view-contact')
      this.$parent.$refs.modal.setComponentParameters({ contactId: contactId })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    removeContact (id) {
      this.deleteContact(id)
        .then(function () {
          this.message = 'Deleted Successfully'

          this.$nextTick(() => {
            const self = this

            setTimeout(() => {
              self.message = ''
            }, 3000)
          })
        }, function (response) {
          this.handleErrors('deleteContact', response)
        })
    },
    getListOfContacts () {
      this.getCorporateContacts(
        this.routeParameters.currentPageNumber,
        this.contactsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection
      ).then(function (response) {
        const data = response.data.data

        data.result = data.result.map((value) => {
          value['name'] = (value.lastname ? value.lastname + (!value.middlename ? ', ' : ' ') : '') +
            (value.middlename ? value.middlename + ', ' : '') +
            (value.firstname || '')

          return value
        })

        this.contacts = data.result
        this.contactsTotalNumber = data.total
      }, function (response) {
        this.handleErrors('getCorporateContacts', response)
      })
    },
    getCorporateContacts (pageNumber, rowsPerPage, sort, sortDir) {
      const data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir
      }

      return this.$http.post(process.env.API_PATH + 'contacts/corporate', data)
    },
    deleteContact (id) {
      id = id || 0

      return this.$http.delete(process.env.API_PATH + 'corporate-contacts/' + id)
    }
  }
}
