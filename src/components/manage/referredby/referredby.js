var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  name: 'referredby',
  data () {
    return {
      constants: window.constants,
      message: '',
      routeParameters: {
        sortColumn: '',
        sortDirection: 'asc'
      },
      contacts: [],
      contactsPerPage: 10
    }
  },
  mixins: [handlerMixin],
  mounted () {
    this.getReferredByContacts(
      this.routeParameters.sortColumn,
      this.routeParameters.sortDirection,
      this.contactsPerPage
    ).then(function (response) {
        var data = response.data.data

        if (data.length > 0) {
          this.contacts = data
        }
      }, function (response) {
        this.handleErrors('getReferredByContacts', response)
      })
  },
  methods: {
    getReferredByContacts (sort, sortDir, contactsPerPage) {
      var data = {
        sort: sort,
        sortdir: sortDir,
        contacts_per_page: contactsPerPage
      }

      return this.$http.post(process.env.API_PATH + 'contacts/referred-by', data)
    }
  }
}
