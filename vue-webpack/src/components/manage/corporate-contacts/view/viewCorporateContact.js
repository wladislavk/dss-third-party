var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'view-corporate-contact',
  data () {
    return {
      message: '',
      contact: {}
    }
  },
  mixins: [handlerMixin],
  computed: {
    buttonText () {
      return 'Hello world'
    }
  },
  mounted () {

  },
  methods: {

  }
}
