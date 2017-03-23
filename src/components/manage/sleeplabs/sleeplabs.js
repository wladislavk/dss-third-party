var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  name: 'sleeplabs',
  data () {
    return {
      routeParameters: {
        currentPageNumber: 0,
        sortDirection: 'asc',
        sortColumn: 'name',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      sleeplabsTotalNumber: 0,
      sleeplabsPerPage: 20,
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
  computed: {
    totalPages () {
      return Math.ceil(this.sleeplabsTotalNumber / this.sleeplabsPerPage)
    }
  },
  created () {

  },
  mounted () {
    this.getSleeplabs()
      .then(function (response) {
        var data = response.data.data;

        if (data.total) {
          data.result = data.result.forEach((value) => {
            value['name'] = (value.salutation ? value.salutation + ' ' : '')
              + (value.firstname ? value.firstname + ' ' : '')
              + (value.middlename ? value.middlename + ' ' : '')
              + (value.lastname || '')
          })

          this.sleeplabs = data.result
        }
      }, function (response) {
        this.handleErrors('getSleeplabs', response)
      })
  },
  methods: {
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return sort === 'name' ? 'asc': 'desc'
      }
    },
    getSleeplabs () {
      var data = {
        page: this.routeParameters.currentPageNumber,
        rows_per_page: this.sleeplabsPerPage,
        sort: this.routeParameters.sortColumn,
        sort_dir: this.routeParameters.sortDirection,
        letter: this.routeParameters.currentLetter
      }

      return this.$http.post(process.env.API_PATH + 'sleeplabs/list', data)
    }
  }
}
