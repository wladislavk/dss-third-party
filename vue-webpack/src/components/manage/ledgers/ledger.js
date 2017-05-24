var handlerMixin = require('../../../modules/handler/HandlerMixin.js')
var ledgerSummaryReportFull = require('./summary-report-full/ledgerSummaryReportFull.vue')

export default {
  data () {
    return {
      constants: window.constants,
      message: '',
      routeParameters: {
        patientId: 16,
        openclaims: 0,
        inspay: 0,
        currentPageNumber: 0,
        sortColumn: 'service_date',
        sortDirection: 'desc'
      },
      patient: {},
      showPatientSummary: false,
      ledgerRowsTotalNumber: 0,
      ledgerRowsPerPage: 20,
      ledgerRows: [],
      ledgerHistories: {},
      currentBalance: 0,
      lastServiceDate: null,
      lastEntryDate: null,
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
  components: {
    'ledger-summary-report-full': ledgerSummaryReportFull
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
      } else {
        this.patient = {}
      }
    },
    '$route.query.pid': function () {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid)
      } else {
        this.$set(this.routeParameters, 'patientId', null)
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
    },
    totalCharges () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        return sum + (currentRow.ledger != 'claim' ? +currentRow.amount : 0)
      }, 0)

      return total
    },
    totalCredits () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        var isLedgerNotPaidAndNotAdjustment = !(currentRow.ledger === 'ledger_paid' && currentRow.payer == constants.DSS_TRXN_TYPE_ADJ)

        return sum + (isLedgerNotPaidAndNotAdjustment && currentRow.ledger != 'claim' ? +currentRow.paid_amount : 0)
      }, 0)

      return total
    },
    totalAdjustments () {
      var total = this.ledgerRows.reduce((sum, currentRow) => {
        var isLedgerPaidAndAdjustment = (currentRow.ledger === 'ledger_paid' && currentRow.payer == constants.DSS_TRXN_TYPE_ADJ)

        return sum + (isLedgerPaidAndAdjustment ? +currentRow.paid_amount : 0)
      }, 0)

      return total
    }
  },
  mounted () {
    this.getLedgerData()
    this.getLedgerRowsTotalNumber()
  },
  methods: {
    onClickViewLedgerRecords () {
      // loadPopup('view_ledger_record.php?pid=<?php echo $_GET['pid']; ?>')
    },
    onClickStatementLedgerRow (ledgerId) {
      if (confirm('Do Your Really want to Delete?.')) {
        this.$router.push({
          name  : this.$route.name,
          query : {
            delstatementid: ledgerId,
            pid: this.routeParameters.patientId
          }
        })
      }
    },
    onClickEditLedgerPayment () {
      // loadPopup('edit_ledger_payment.php?ed=' + row.ledgerid + '&pid=' + routeParameters.patientId)
    },
    onClickDeleteClaimLedgerRow (ledgerId) {
      if (confirm('Do Your Really want to Delete?.')) {
        this.$router.push({
          name  : this.$route.name,
          query : {
            delclaimid: ledgerId,
            pid: this.routeParameters.patientId
          }
        })
      }
    },
    onClickEditInsurance () {
      // 'insurance_v2.php?insid=' + row.ledgerid + '&pid=' + routeParameters.patientId
    },
    onClickEditLedgerNote () {
      // loadPopup('edit_ledger_note.php?ed=' + row.ledgerid + '&pid=' + routeParameters.patientId)
    },
    onClickAddLedgerPayment () {
      // loadPopup('add_ledger_payment.php?ed=' + row.primary_claim_id + '&pid=' + routeParameters.patientId)
    },
    onClickViewClaim () {
      // 'view_claim.php?claimid=' + row.primary_claim_id + '&pid=' + routeParameters.patientId
    },
    onClickEditLedger () {
      // loadPopup('add_ledger.php?ed=' + row.ledgerid + '&pid=' + routeParameters.patientId)
    },
    onClickCreateStatement () {
      // window.open('ledger_statement.php?pid=<?php echo $_GET['pid'];?>')
    },
    onClickAddNote () {
      // loadPopup('add_ledger_note.php?pid=<?php echo $_GET['pid'];?>');
    },
    onClickAddInsurancePayment () {
      this.$router.push({
        name  : this.$route.name,
        query : {
          inspay: 1,
          pid: this.routeParameters.patientId
        }
      })
    },
    onClickAddNewTransaction () {
      // loadPopup('add_ledger_entry.php?pid=<?php echo $_GET['pid'];?>');
    },
    onClickPrintLedger () {
      // window.open('print_ledger_report.php?<?php echo (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>')
    },
    onClickClaimsOutstanding () {
      this.$router.push({
        name  : this.$route.name,
        query : {
          openclaims: 1,
          pid: this.routeParameters.patientId
        }
      })
    },
    onClickViewAll () {
      this.$router.push({
        name  : this.$route.name,
        query : {
          pid: this.routeParameters.patientId
        }
      })
    },
    getLedgerRowsTotalNumber () {
      this.getTotalNumber(this.routeParameters.patientId)
        .then(function (response) {
          var data = response.data.data

          this.ledgerRowsTotalNumber = data.number
        }, function (response) {
          this.handleErrors('getTotalNumber', response)
        })
    },
    onClickLedgerRow (row) {
      if (row.ledger == 'claim') {
        if (this.routeParameters.inspay == 1) {
          return 'view_claim.php?inspay=1&claimid=' + row.ledgerid + '&pid=' + this.routeParameters.patientId
        } else {
          return 'view_claim.php?claimid=' + row.ledgerid + '&pid=' + this.routeParameters.patientId
        }
      } else if (row.filename && row.filename.length > 0) {
        return row.filename
      }
    },
    getEntryDate (currentEntryDate) {
      // convert to unix timestamp
      var parsedCurrentEntryDate = moment(currentEntryDate).format('x')

      if (this.lastEntryDate != parsedCurrentEntryDate) {
        this.lastEntryDate = parsedCurrentEntryDate
        return moment(currentEntryDate).format('MM-DD-YYYY')
      } else {
        return ''
      }
    },
    getServiceDate (currentServiceDate) {
      // convert to unix timestamp
      var parsedCurrentServiceDate = moment(currentServiceDate).format('x')

      if (this.lastServiceDate != parsedCurrentServiceDate) {
        this.lastServiceDate = parsedCurrentServiceDate
        return moment(currentServiceDate).format('MM-DD-YYYY')
      } else {
        return ''
      }
    },
    countInitialBalance(ledgerRows) {
      var total = 0

      if (this.routeParameters.sortDirection.toLowerCase() === 'desc') {
        total = ledgerRows.reduce((sum, currentRow) => {
          return sum + (currentRow.ledger != 'claim' ? +currentRow.amount - +currentRow.paid_amount : 0)
        }, 0)
      }

      return total
    },
    getCurrentBalance (row) {
      var isAdjustment = row.ledger == 'ledger_paid' && row.payer == constants.DSS_TRXN_TYPE_ADJ
      var isCredit = !(row.ledger == 'ledger_paid' && row.payer == constants.DSS_TRXN_TYPE_ADJ)
      var bufBalance = 0

      if (row.ledger != 'claim') {
        // if (this.routeParameters.sortDirection.toLowerCase() === 'desc') {
        //   bufBalance -= +row.amount
        // } else {
          bufBalance += +row.amount
        // }
      }

      if (isAdjustment) {
        // if (this.routeParameters.sortDirection.toLowerCase() === 'desc') {
        //   bufBalance += +row.paid_amount
        // } else {
          bufBalance -= +row.paid_amount
        // }
      }

      if (isCredit && row.ledger != 'claim') {
        // if (this.routeParameters.sortDirection.toLowerCase() === 'desc') {
        //   bufBalance += +row.paid_amount
        // } else {
          bufBalance -= +row.paid_amount
        // }
      }

      this.currentBalance += bufBalance

      return this.currentBalance
    },
    getLedgerRowStatus (row) {
      var status = ''

      if (row.ledger == 'claim') {
        status = 'clickable_row status_' + row.status
      } else if (row.ledger == 'ledger') {
        if (row.primary_claim_id > 0) {
          status = 'claimed'
        } else if (row.status == window.constants.DSS_TRXN_PENDING) {
          status = 'claimless clickable_row'
        }
      } else if (row.ledger == 'statement' && row.filename != '') {
        status = 'statement clickable_row'
      }

      if ([3, 5, 9].includes(+row.status)) {
        status += ' completed'
      }

      return status + ' ' + row.ledger
    },
    showHistory (row) {
      if (!this.ledgerHistories.hasOwnProperty(row.ledgerid)) {
        this.getLedgerHistories(this.routeParameters.patientId, row.ledgerid, row.ledger)
        .then(function (response) {
          var data = response.data.data

          this.ledgerHistories[row.ledgerid] = data
        }, function (response) {
          this.handleErrors('getPatient', response)
        })
      }

      row.show_history = true
    },
    getStatus (row) {
      if (row.ledger == 'ledger_paid') {
        return window.constants.dssTransactionStatusLabels(row.status ? +row.status : null)
      } else if (row.ledger == 'claim' || row.ledger == 'ledger') {
        return window.constants.dssClaimStatusLabels(row.status ? +row.status : null)
      }
    },
    getDescription (row) {
      var ledgerNote = row.ledger === 'note' && row.status == 1 ? '(P) ' : ''
      var ledgerPaid = row.ledger === 'ledger_paid' && row.payer > 0 ? constants.dssTransactionTypeLabels(+row.payer) + ' - ' : ''
      var filedByBo = +row.filed_by_bo ? '*' : ''
      var ledgerPayment = ''
      var claim = ''
      var ledger = ''

      if (row.ledger === 'ledger_payment') {
        ledgerPayment = constants.dssTransactionPayerLabels(+row.payer)
          + ' Payment - '
          + constants.dssTransactionPaymentTypeLabels(+row.payment_type) + ' '

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

        // this.currentBalance = this.countInitialBalance(data)
        this.currentBalance = 0

        this.$nextTick(() => {
          data = data.map((value) => {
            // TODO: check it. some ledger row doesn't have this functional
            value['show_history'] = false

            value['service_date'] = this.getServiceDate(value['service_date'])
            value['entry_date'] = this.getEntryDate(value['entry_date'])

            var balanceForDisplaying = ''

            if (['ledger', 'ledger_paid', 'ledger_payment'].includes(value.ledger)) {
              if (['service_date', 'entry_date'].includes(this.routeParameters.sortColumn)) {
                balanceForDisplaying = this.formatLedger(this.getCurrentBalance(value))
              } else {
                balanceForDisplaying = 'N/A'
              }
            }

            value['balance'] = balanceForDisplaying

            return value
          })

          this.ledgerRows = data
        })
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
    },
    getLedgerHistories (patientId, ledgerId, type) {
      var data = {
        patient_id: patientId,
        ledger_id: ledgerId,
        type: type
      }

      return this.$http.post(process.env.API_PATH + 'ledger-histories/ledger-report', data)
    },
    getTotalNumber (patientId) {
      var data = { patient_id: patientId}

      return this.$http.post(process.env.API_PATH + 'ledgers/report-rows-number', data)
    }
  }
}
