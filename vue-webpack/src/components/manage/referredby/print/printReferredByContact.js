var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'print-referred-by-contact',
  data () {
    return {
      title: 'Referral Source Printout - ' + moment().format('MM/DD/YYYY'),
      message: '',
      contacts: [],
      routeParameters: {
        sortColumn: '',
        sortDirection: 'asc'
      },
      tableHeaders: {
        'name': {
          width: 15,
          title: 'Name'
        },
        'type': {
          width: 15,
          title: 'Physician Type'
        },
        'total': {
          width: 10,
          title: 'Total Referrals'
        },
        'thirty': {
          width: 15,
          title: '30 Days'
        },
        'sixty': {
          width: 15,
          title: '60 Days'
        },
        'ninty': {
          width: 15,
          title: '90 Days'
        },
        'ninty-plus': {
          width: 15,
          title: '90+ Days'
        }
      }
    }
  },
  mixins: [handlerMixin],
  created () {
    $('body').removeClass('main-template')
  },
  mounted () {

  },
  methods: {

  }
}
