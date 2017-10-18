import endpoints from '../../../../endpoints'
import handlerMixin from '../../../../modules/handler/HandlerMixin'
import http from '../../../../services/http'

export default {
  name: 'print-referred-by-contact',
  data () {
    return {
      title: 'Referral Source Printout - ' + window.moment().format('MM/DD/YYYY'),
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
        'contacttype': {
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
        'nintyplus': {
          width: 15,
          title: '90+ Days'
        }
      }
    }
  },
  mixins: [handlerMixin],
  watch: {
    '$route.query.sort': function () {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
        } else {
          this.$set(this.routeParameters, 'sortColumn', null)
        }
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() === 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc')
        }
      }
    },
    'routeParameters': {
      handler: function () {
        this.getContacts()
      },
      deep: true
    }
  },
  created () {
    window.$('body').removeClass('main-template')
  },
  mounted () {
    this.getContacts()
  },
  beforeDestroy () {
    window.$('body').addClass('main-template')
  },
  methods: {
    getContacts () {
      this.getReferredByContacts(
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection
      ).then(function (response) {
        const data = response.data.data

        if (data.total > 0) {
          this.contacts = data.contacts
        }
      }).catch(function (response) {
        this.handleErrors('getReferredByContacts', response)
      })
    },
    getReferredByContacts (sort, sortDir) {
      const data = {
        sort: sort,
        sortdir: sortDir,
        detailed: true
      }

      return http.post(endpoints.contacts.referredBy, data)
    }
  }
}
