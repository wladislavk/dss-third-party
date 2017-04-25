var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  data () {
    return {
      message: '',
      routeParameters: {
        patientId: 0,
        openclaims: 0,
        inspay: 0,
        currentPageNumber: 0,
        sortColumn: 'service_date',
        sortDirection: 'desc'
      },
      patient: {},
      ledgerRowsTotalNumber: 0,
      ledgerRowsPerPage: 20,
      ledgerRows: [],
      tableHeaders: {
        'service_date': {
          title: 'Svc Date',
          with_link: true,
          width: 10
        },
        'entry_date': {
          title: 'Entry Date',
          with_link: true,
          width: 10
        },
        'producer': {
          title: 'Producer',
          with_link: true,
          width: 30
        },
        'description': {
          title: 'Description',
          with_link: true,
          width: 30
        },
        'amount': {
          title: 'Charges',
          with_link: true,
          width: 10
        },
        'paid_amount': {
          title: 'Credits',
          with_link: true,
          width: 10
        },
        'adjustments': {
          title: 'Adjustments',
          width: 10
        },
        'balance': {
          title: 'Balance',
          width: 10
        },
        'status': {
          title: 'Ins',
          with_link: true,
          width: 5
        },
        'history': {
          title: 'History',
          width: 20
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
    'routeParameters.inspay': function () {
      this.message = this.routeParameters.inspay === 1 ? 'Please select claim below to apply insurance payment.' : ''
    },
    'routeParameters.patientId': function () {
      if (this.routeParameters.patientId > 0) {
        this.updatePatientSummary(this.routeParameters.patientId)
      }
    },
    '$route.query.page': function () {
      if (this.$route.query.page != undefined && this.$route.query.page <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +this.$route.query.page)
      }
    },
    '$route.query.sort': function () {
      if (this.$route.query.sort in this.tableHeaders) {
        this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
      } else {
        this.$set(this.routeParameters, 'sortColumn', 'service_date')
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir && this.$route.query.sortdir.toLowerCase() == 'desc') {
        this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
      } else {
        this.$set(this.routeParameters, 'sortDirection', 'asc')
      }
    },
    'routeParameters': {
      handler: function () {
        this.getLedgerData()
      },
      deep: true
    }
  },
  computed: {
    totalPages () {
      return Math.ceil(this.ledgerRowsTotalNumber / this.ledgerRowsPerPage)
    },
    name () {
      return ''
    }
  },
  created () {

  },
  methods: {
    getLedgerData () {
      this.getLedgerRows(
        this.routeParameters.currentPageNumber,
        this.ledgerRowsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection
      ).then(function (response) {
        var data = response.data.data

        this.ledgerRowsTotalNumber = data.total
        this.ledgerRows = data.result
      }, function (response) {
        this.handleErrors('getLedgerRows', response)
      })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    updatePatientSummary (patientId) {
      var data = { patient_id: patientId }

      return this.$http.post(process.env.API_PATH + 'ledgers/update-patient-summary', data)
    },
    getLedgerRows (pageNumber, rowsPerPage, sortColumn, sortDir) {
      var data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sortColumn,
        sort_dir: sortDir
      }

      return this.$http.post(process.env.API_PATH + 'ledgers/list', data)
    }
  }
}
