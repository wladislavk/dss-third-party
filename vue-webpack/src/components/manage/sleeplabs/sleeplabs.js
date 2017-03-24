var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  name: 'sleeplabs',
  data () {
    return {
      routeParameters: {
        currentPageNumber: 0,
        sortDirection: 'asc',
        sortColumn: 'lab',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      sleeplabsTotalNumber: 0,
      sleeplabsPerPage: 2,
      sleeplabs: [],
      tableHeaders: {
        'lab': {
          title: 'Lab Name',
          with_link: true,
          width: 30
        },
        'name': {
          title: 'Name',
          with_link: true,
          width: 40
        },
        'patients-number': {
          title: '# Patients',
          width: 10
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
    '$route.query.page': function () {
      if (this.$route.query.page != undefined && this.$route.query.page <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page)
      }
    },
    '$route.query.sort': function () {
      if (this.$route.query.sort in this.tableHeaders) {
        this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
      } else {
        this.$set(this.routeParameters, 'sortColumn', 'lab')
      }
    },
    '$route.query.sortdir': function () {
      if (this.$route.query.sortdir.toLowerCase() == 'desc') {
        this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
      } else {
        this.$set(this.routeParameters, 'sortDirection', 'asc')
      }
    },
    '$route.query.letter': function () {
      if (this.letters.indexOf(this.$route.query.letter) > -1) {
        this.$set(this.routeParameters, 'currentLetter', this.$route.query.letter)
      } else {
        this.$set(this.routeParameters, 'currentLetter', null)
      }
    },
    '$route.query.delid': function () {
      if (this.$route.query.delid > 0) {
        // TODO: set fucntion on this event
      }
    },
    'routeParameters': {
      handler: function () {
        this.getListOfSleeplabs()
      },
      deep: true
    }
  },
  computed: {
    totalPages () {
      return Math.ceil(this.sleeplabsTotalNumber / this.sleeplabsPerPage)
    }
  },
  mounted () {
    this.getListOfSleeplabs()
  },
  methods: {
    getListOfSleeplabs () {
      this.getSleeplabs(
        this.routeParameters.currentPageNumber,
        this.sleeplabsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.currentLetter
      ).then(function (response) {
          var data = response.data.data;

          if (data.total) {
            data.result = data.result.map((value) => {
              value['name'] = (value.salutation ? value.salutation + ' ' : '')
                + (value.firstname ? value.firstname + ' ' : '')
                + (value.middlename ? value.middlename + ' ' : '')
                + (value.lastname || '')

              value['show_patients'] = false

              return value
            })

            this.sleeplabs = data.result
            this.sleeplabsTotalNumber = data.total
          }
        }, function (response) {
          this.handleErrors('getSleeplabs', response)
        })
    },
    getCurrentDirection (sort) {
      return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
    },
    getSleeplabs (pageNumber, rowsPerPage, sort, sortDir, letter) {
      var data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir,
        letter: letter
      }

      return this.$http.post(process.env.API_PATH + 'sleeplabs/list', data)
    }
  }
}
