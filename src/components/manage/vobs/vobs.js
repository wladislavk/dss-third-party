import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import SingleVobComponent from './SingleVob.vue'

export default {
  data () {
    return {
      routeParameters: {
        patientId: null,
        currentPageNumber: 0,
        sortDirection: 'desc',
        sortColumn: 'status',
        viewed: null
      },
      totalVobs: 0,
      vobsPerPage: 20,
      vobs: [],
      message: '',
      tableHeaders: {
        'request_date': 'Requested',
        'patient_name': 'Patient Name',
        'status': 'Status',
        'comments': 'Comments',
        'action': 'Action'
      }
    }
  },
  computed: {
    totalPages () {
      return Math.ceil(this.totalVobs / this.vobsPerPage)
    }
  },
  components: {
    singleVob: SingleVobComponent
  },
  watch: {
    '$route.query.page': function () {
      if (this.$route.query.page) {
        if (this.$route.query.page <= this.totalPages) {
          this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page)
        }
      }
    },
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
    '$route.query.pid': function () {
      if (this.$route.query.pid > 0) {
        this.$set(this.routeParameters, 'patientId', this.$route.query.pid)
      } else {
        this.$set(this.routeParameters, 'patientId', null)
      }
    },
    '$route.query.viewed': function () {
      this.$set(this.routeParameters, 'viewed', this.$route.query.viewed)
    },
    'routeParameters': {
      handler: function () {
        this.getVobs()
      },
      deep: true
    }
  },
  created () {
    this.getVobs()
  },
  methods: {
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    getVobs () {
      this.findVobs(
        this.vobsPerPage,
        this.routeParameters.currentPageNumber,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.viewed
      ).then((response) => {
        const data = response.data.data

        if (data.result.length) {
          this.vobs = data.result
          this.totalVobs = data.total
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'findVobs', response: response})
      })
    },
    findVobs (
      vobsPerPage,
      pageNumber,
      sortColumn,
      sortDir,
      viewed
    ) {
      const data = {
        page: pageNumber || 0,
        vobsPerPage: vobsPerPage,
        sortColumn: sortColumn || 'status',
        sortDir: sortDir || 'desc',
        viewed: viewed
      }

      return http.post(endpoints.insurancePreauth.findVobs, data)
    }
  }
}
