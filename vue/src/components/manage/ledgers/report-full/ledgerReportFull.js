import accounting from 'accounting'
import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import ledgerSummaryReportFull from '../summary-report-full/ledgerSummaryReportFull.vue'
import symbols from '../../../../symbols'
import { DSS_CONSTANTS } from '../../../../constants/main'
import ConstantTitleGetter from '../../../../services/ConstantTitleGetter'

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
  watch: {
    '$route.query.page': function () {
      const queryPage = this.$route.query.page
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage)
      }
    },
    '$route.query.sort': function () {
      const querySort = this.$route.query.sort
      let sortColumn = 'service_date'
      if (querySort in this.tableHeaders) {
        sortColumn = querySort
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn)
    },
    '$route.query.sortdir': function () {
      const querySortDir = this.$route.query.sortdir
      let sortDir = 'asc'
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'asc'
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir)
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
      const total = this.ledgerRows.reduce((sum, currentRow) => {
        return sum + (currentRow.ledger === 'ledger' && currentRow.amount > 0 ? +currentRow.amount : 0)
      }, 0)

      return total
    },
    totalPageCredits () {
      const total = this.ledgerRows.reduce((sum, currentRow) => {
        const isNotLedgerPaidAndAdjustment = !(currentRow.ledger === 'ledger_paid' && currentRow.payer === DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ)

        return sum + (
          isNotLedgerPaidAndAdjustment && currentRow.ledger !== 'claim' && currentRow.paid_amount > 0 ? +currentRow.paid_amount : 0
        )
      }, 0)

      return total
    },
    totalPageAdjustments () {
      const total = this.ledgerRows.reduce((sum, currentRow) => {
        const isLedgerPaidAndAdjustment = (currentRow.ledger === 'ledger_paid' && currentRow.payer === DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ)

        return sum + (isLedgerPaidAndAdjustment && currentRow.paid_amount > 0 ? +currentRow.paid_amount : 0)
      }, 0)

      return total
    },
    totalPages () {
      return Math.ceil(this.ledgerRowsTotalNumber / this.ledgerRowsPerPage)
    }
  },
  created () {
    window.eventHub.$on('setting-totals-from-summary-block', this.onSetTotalsFromSummaryBlock)
  },
  mounted () {
    this.getLedgerData()
  },
  beforeDestroy () {
    window.eventHub.$off('setting-totals-from-summary-block', this.onSetTotalsFromSummaryBlock)
  },
  methods: {
    isCredit (row) {
      return (!(row.ledger === 'ledger_paid' && row.payer === DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ))
    },
    isAdjustment (row) {
      return (row.ledger === 'ledger_paid' && row.payer === DSS_CONSTANTS.DSS_TRXN_TYPE_ADJ)
    },
    onSetTotalsFromSummaryBlock (totals) {
      this.totalCharges = totals.charges
      this.totalCredits = totals.credits
      this.totalAdjustments = totals.adjustments
    },
    getPatientFullName (patientInfo) {
      return patientInfo ? (patientInfo.lastname + ', ' + patientInfo.firstname) : ''
    },
    getDescription (ledgerRow) {
      let description

      switch (ledgerRow.ledger) {
        case 'ledger_payment':
          description = ConstantTitleGetter.dssTransactionPayerLabels(+ledgerRow.payer) +
            ' Payment - ' +
            ConstantTitleGetter.dssTransactionPaymentTypeLabels(+ledgerRow.payment_type) +
            ' '
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
      ).then((response) => {
        const data = response.data.data

        this.ledgerRowsTotalNumber = data.total
        this.ledgerRows = data.result
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getLedgerRows', response: response})
      })
    },
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      }
      return 'asc'
    },
    getLedgerRows (reportType, pageNumber, rowsPerPage, sortColumn, sortDir) {
      const data = {
        report_type: reportType,
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sortColumn,
        sort_dir: sortDir
      }

      return http.post(endpoints.ledgers.list, data)
    }
  }
}
