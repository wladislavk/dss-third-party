var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  name: 'referredby',
  data () {
    return {
      message: '',
      contacts: [],
      contactsPerPage: 10
    }
  },
  mixins: [handlerMixin],
  mounted () {

  },
  methods: {

  }
}
