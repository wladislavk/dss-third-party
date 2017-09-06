const handlerMixin = require('../../../modules/handler/HandlerMixin.js')

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
  watch: {
    '$route.query.page': function () {
      const queryPage = this.$route.query.page
      if (queryPage !== undefined && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', +queryPage)
      }
    },
    '$route.query.sort': function () {
      const querySortColumn = this.$route.query.sort
      let sortColumn = 'lab'
      if (querySortColumn in this.tableHeaders) {
        sortColumn = querySortColumn
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn)
    },
    '$route.query.sortdir': function () {
      const querySortDir = this.$route.query.sortdir
      let sortDir = 'asc'
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc'
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir)
    },
    '$route.query.letter': function () {
      const queryLetter = this.$route.query.letter
      let letter = null
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter
      }
      this.$set(this.routeParameters, 'currentLetter', letter)
    },
    '$route.query.delid': function () {
      const queryDelId = this.$route.query.delid
      if (queryDelId > 0) {
        this.removeSleeplab(queryDelId)
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
  created () {
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal)
  },
  mounted () {
    this.getListOfSleeplabs()
  },
  beforeDestroy () {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal)
  },
  methods: {
    onSettingDataFromModal (data) {
      this.message = data.message

      this.$nextTick(() => {
        const self = this

        setTimeout(() => {
          self.message = ''
        }, 3000)
      })
    },
    onClickEdit (id) {
      this.$parent.$refs.modal.display('edit-sleeplab')
      this.$parent.$refs.modal.setComponentParameters({ sleeplabId: id })
    },
    onClickQuickView (id) {
      this.$parent.$refs.modal.display('view-sleeplab')
      this.$parent.$refs.modal.setComponentParameters({ sleeplabId: id })
    },
    removeSleeplab (id) {
      this.deleteSleeplab(id)
        .then(function () {
          this.message = 'Deleted Successfully'

          this.$nextTick(() => {
            const self = this

            setTimeout(() => {
              self.message = ''
            }, 3000)
          })
        }, function (response) {
          this.handleErrors('deleteSleeplab', response)
        })
    },
    getListOfSleeplabs () {
      this.getSleeplabs(
        this.routeParameters.currentPageNumber,
        this.sleeplabsPerPage,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.currentLetter
      ).then(function (response) {
        const data = response.data.data

        data.result = data.result.map((value) => {
          value['name'] = (value.salutation ? value.salutation + ' ' : '') +
            (value.firstname ? value.firstname + ' ' : '') +
            (value.middlename ? value.middlename + ' ' : '') +
            (value.lastname || '')

          value['show_patients'] = false

          return value
        })

        this.sleeplabs = data.result
        this.sleeplabsTotalNumber = data.total
      }, function (response) {
        this.handleErrors('getSleeplabs', response)
      })
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      }
      return 'asc'
    },
    getSleeplabs (pageNumber, rowsPerPage, sort, sortDir, letter) {
      const data = {
        page: pageNumber,
        rows_per_page: rowsPerPage,
        sort: sort,
        sort_dir: sortDir,
        letter: letter
      }

      return this.$http.post(process.env.API_PATH + 'sleeplabs/list', data)
    },
    deleteSleeplab (id) {
      id = id || 0

      return this.$http.delete(process.env.API_PATH + 'sleeplabs/' + id)
    }
  }
}
