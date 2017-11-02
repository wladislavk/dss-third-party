import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'

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

      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: contactId })
    },
    onClickQuickView (contactId) {
      this.$parent.$refs.modal.display('view-contact')
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: contactId })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    removeContact (id) {
      this.deleteContact(id).then(() => {
        this.message = 'Deleted Successfully'

        this.$nextTick(() => {
          setTimeout(() => {
            this.message = ''
          }, 3000)
        })
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'deleteContact', response: response})
      })
    },
    getListOfContacts () {
      this.getCorporateContacts(
        this.routeParameters.currentPageNumber,
        this.contactsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection
      ).then((response) => {
        const data = response.data.data

        data.result = data.result.map((value) => {
          value['name'] = (value.lastname ? value.lastname + (!value.middlename ? ', ' : ' ') : '') +
            (value.middlename ? value.middlename + ', ' : '') +
            (value.firstname || '')

          return value
        })

        this.contacts = data.result
        this.contactsTotalNumber = data.total
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getCorporateContacts', response: response})
      })
    },
    getCorporateContacts (pageNumber, rowsPerPage, sort, sortDir) {
      const data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir
      }

      return http.post(endpoints.contacts.corporate, data)
    },
    deleteContact (id) {
      id = id || 0

      return http.delete(endpoints.corporateContacts.destroy + '/' + id)
    }
  }
}
