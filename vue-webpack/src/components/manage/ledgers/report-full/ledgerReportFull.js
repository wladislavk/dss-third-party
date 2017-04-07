var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

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
      name: '',
      message: '',
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
          width: 10
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
  mixins: [handlerMixin],
  computed: {
    currentDate () {
      return new Date()
    },
    totalCharges () {
      return 0
    },
    totalCredits () {
      return 0
    },
    totalAdjustments () {
      return 0
    }
  },
  created () {

  },
  mounted () {

  },
  methods: {
    getLedgerData () {
      this.getLedgerRows()
        .then(function () {
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
    getLedgerRows () {
      var data = {
        
      }

      return this.$http.post(process.env.API_PATH + 'ledgers/list', data)
    }
  }
}
