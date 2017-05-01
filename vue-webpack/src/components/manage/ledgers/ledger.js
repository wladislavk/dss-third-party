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
        this.getPatientInfo()
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
  mounted () {
    this.getLedgerData()
  },
  methods: {
    getDescription (row) {
      var ledgerNote = row.ledger === 'note' && row.status === 1 ? '(P) ' : ''
      var ledgerPaid = row.ledger === 'ledger_paid' && row.payer > 0 ? constants.dssTransactionTypeLabels(row.payer) + ' - ' : ''
      var filedByBo = row.filed_by_bo ? '*' : ''
      var ledgerPayment = ''
      var claim = ''
      var ledger = ''

      if (row.ledger === 'ledger_payment') {
        ledgerPayment = constants.dssTransactionPayerLabels(row.payer)
          + ' Payment - '
          + constants.dssTransactionPaymentTypeLabels(row.payment_type) + ' '

        ledgerPayment += row.primary_claim_id > 0 ? '(' + row.primary_claim_id + ') ' : ''
      } else if (row.ledger === 'ledger') {
        if (row.primary_claim_id > 0) {
          ledger = '(' + row.primary_claim_id + ') '
        } else if (!row.primary_claim_id && row.status === constants.DSS_TRXN_PENDING) {
          ledger = ' (Click to file)'
        }
      } else if (row.ledger === 'claim') {
        if (row.ledgerid > 0) {
          claim = '(' + row.ledgerid + ') '
        } else if (row.primary_claim_id > 0) {
          claim = 'Secondary to (' + row.primary_claim_id + ') '
        } else if (row.num_notes > 0) {
          claim = ' - Notes (' + row.num_notes + ') '
        }
      }

      return ledgerNote + ledgerPaid + row.description + ledger + claim + filedByBo + ledgerPayment
    },
    getPatientInfo () {
      this.getPatient(this.routeParameters.patientId)
        .then(function (response) {
          var data = response.data.data

          this.patient = data
          this.patient.name = (this.patient['lastname'] ? this.patient['lastname'] + ' ' : '')
            + (this.patient['middlename'] ? this.patient['middlename'] + ' ' : '')
            + (this.patient['firstname'] || '')
        }, function (response) {
          this.handleErrors('getPatient', response)
        })
    },
    getLedgerData () {
      this.getLedgerRows(
        this.routeParameters.patientId,
        this.routeParameters.currentPageNumber,
        this.ledgerRowsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.openclaims
      ).then(function (response) {
        var data = response.data.data

        // this.ledgerRowsTotalNumber = data.total
        this.ledgerRows = data
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
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    },
    updatePatientSummary (patientId) {
      var data = { patient_id: patientId }

      return this.$http.post(process.env.API_PATH + 'ledgers/update-patient-summary', data)
    },
    getLedgerRows (patientId, pageNumber, rowsPerPage, sortColumn, sortDir, openClaims) {
      var data = {
        patient_id: patientId,
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sortColumn,
        sort_dir: sortDir,
        open_claims: openClaims
      }

      return this.$http.post(process.env.API_PATH + 'ledgers/report-data', data)
    },
    getPatient (patientId) {
      return this.$http.get(process.env.API_PATH + 'patients/' + patientId)
    }
  }
}
