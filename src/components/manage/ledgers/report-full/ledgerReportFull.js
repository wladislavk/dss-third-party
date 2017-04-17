var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')
var ledgerSummaryReportFull = require('../summary-report-full/ledgerSummaryReportFull.vue')

export default {
  name: 'ledger-report-full',
  data () {
    return {
      patientId: 0,
      routeParameters: {
        currentPageNumber: 0,
        sortColumn: 'service_date',
        sortDirection: 'desc'
      },
      reportType: 'today', // other posible values: daily, monthly
      name: '',
      message: '',
      ledgerRowsTotalNumber: 0,
      ledgerRowsPerPage: 20,
      ledgerRows: [],
      totalCharges: 0,
      totalCredits: 0,
      totalAdjustments: 0,
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
        'patient': {
          title: 'Patient',
          with_link: true,
          width: 10
        },
        'producer': {
          title: 'Producer',
          with_link: true,
          width: 10
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
        'status': {
          title: 'Ins',
          with_link: true,
          width: 5
        }
      }
    }
  },
  components: {
    'ledger-summary-report-full': ledgerSummaryReportFull
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
        this.$set(this.routeParameters, 'sortColumn', 'service_date')
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir && this.$route.query.sortdir.toLowerCase() == 'desc') {
        this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
      } else {
        this.$set(this.routeParameters, 'sortDirection', 'desc')
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
    currentDate () {
      return new Date()
    },
    totalPageCharges () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        return sum + (currentRow.ledger === 'ledger' && currentRow.amount > 0 ? +currentRow.amount : 0)
      }, 0)

      return total
    },
    totalPageCredits () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        var isNotLedgerPaidAndAdjustment = !(currentRow.ledger === 'ledger_paid' && currentRow.payer == constants.DSS_TRXN_TYPE_ADJ)

        return sum + (
          isNotLedgerPaidAndAdjustment && currentRow.ledger != 'claim' && currentRow.paid_amount > 0
          ? +currentRow.paid_amount : 0
        )
      }, 0)

      return total
    },
    totalPageAdjustments () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        var isLedgerPaidAndAdjustment = (currentRow.ledger === 'ledger_paid' && currentRow.payer == constants.DSS_TRXN_TYPE_ADJ)

        return sum + (isLedgerPaidAndAdjustment && currentRow.paid_amount > 0 ? +currentRow.paid_amount : 0)
      }, 0)

      return total
    },
    totalPages () {
      return Math.ceil(this.ledgerRowsTotalNumber / this.ledgerRowsPerPage)
    }
  },
  mounted () {
    this.getLedgerData()

    this.formReportTotals()
  },
  methods: {
    formReportTotals () {
      this.getLedgerTotals(this.reportType)
        .then(function (response) {
          var data = response.data.data

          this.totalCharges = +data.charges
          this.totalCredits = +data.credits
          this.totalAdjustments = +data.adjustments
        }, function (response) {
          this.handleErrors('getLedgerTotals', response)
        })
    },
    getPatientFullName(patientInfo) {
        return patientInfo ? (patientInfo.lastname + ', ' + patientInfo.firstname) : ''
    },
    getDescription (ledgerRow) {
      var description;

      switch (ledgerRow.ledger) {
        case 'ledger_payment':
          description = constants.dssTransactionPayerLabels(ledgerRow.payer) + ' Payment - '
            + constants.dssTransactionPaymentTypeLabels(ledgerRow.payment_type) + ' '
          break

        default:
          description = ''
          break
      }

      description += ledgerRow.description

      return description
    },
    getLedgerData () {
      this.getLedgerRows(
        this.reportType,
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
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    getLedgerRows (reportType, pageNumber, rowsPerPage, sortColumn, sortDir) {
      var data = {
        report_type: reportType,
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sortColumn,
        sort_dir: sortDir
      }

      return this.$http.post(process.env.API_PATH + 'ledgers/list', data)
    },
    getLedgerTotals (reportType) {
      var data = { report_type: reportType }

      return this.$http.post(process.env.API_PATH + 'ledgers/totals', data)
    }
  }
}
