var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'edit-referred-by-contacts',
  data () {
    return {
      message: '',
      contact: {
        salutation: 'default'
      },
      qualifiers: []
    }
  },
  mixins: [handlerMixin],
  computed: {
    buttonText () {
      return ''
    }
  },
  mounted () {

  },
  methods: {
    onSubmit () {

    }
  }
}
