var handlerMixin = require('../../../modules/handler/HandlerMixin.js')


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
      if (this.$route.query.page != undefined && this.$route.query.page <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +this.$route.query.page)
      }
    },
    '$route.query.sort': function () {
      if (this.$route.query.sort in this.tableHeaders) {
        this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
      } else {
        this.$set(this.routeParameters, 'sortColumn', 'lab')
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir && this.$route.query.sortdir.toLowerCase() == 'desc') {
        this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
      } else {
        this.$set(this.routeParameters, 'sortDirection', 'asc')
      }
    },
    '$route.query.delid': function () {
      if (this.$route.query.delid > 0) {
        // TODO
      }
    },
    'routeParameters': {
      handler: function () {
        // TODO
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
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    getListOfContacts () {
      this.getCorporateContacts(
        this.routeParameters.currentPageNumber,
        this.contactsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
      ).then(function (response) {
          var data = response.data.data
        }, function (response) {
          this.handleErrors('getCorporateContacts', response)
        })
    },
    getCorporateContacts (pageNumber, rowsPerPage, sort, sortDir) {
      var data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir
      }

      return this.$http.post(process.env.API_PATH + 'corporate-contacts/list', data)
    }
  }
}
