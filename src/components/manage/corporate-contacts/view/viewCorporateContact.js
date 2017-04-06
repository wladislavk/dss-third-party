var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'view-corporate-contact',
  data () {
    return {
      message: '',
      contact: {},
      componentParams: {},
      contactTypes: []
    }
  },
  mixins: [handlerMixin],
  created () {
    eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // this popup has only readonly input fields - set the flag to false
    this.$parent.popupEdit = false
  },
  mounted () {
    // set all form's fields disabled
    $('form :input').attr('readonly', true)
    $('form select').attr('disabled', 'disabled')
  },
  beforeDestroy () {
    eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getContactType()
        .then(function (response) {
          var data = response.data.data

          this.contactTypes = data

          this.fetchContact(this.componentParams.contactId)
        }, function (response) {
          this.handleErrors('getContactById', response)
        })
    },
    fetchContact (contactId) {
      this.getContactById(contactId)
        .then(function (response) {
          var data = response.data.data

          data['name'] = (data['firstname'] ? data['firstname'] + ' ' : '')
            + (data['middlename'] ? data['middlename'] + ' ' : '')
            + (data['lastname'] || '')

          this.contact = data
        }, function (response) {
          this.handleErrors('getContactById', response)
        })
    },
    getContactById (contactId) {
      contactId = contactId || 0

      return this.$http.get(process.env.API_PATH + 'contacts/' + contactId)
    },
    getContactType () {
      return this.$http.post(process.env.API_PATH + 'contact-types/sorted')
    }
  }
}
