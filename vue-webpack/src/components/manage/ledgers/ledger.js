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
        sortColumn: '',
        sortDirection: 'asc'
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
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    }
  }
}
