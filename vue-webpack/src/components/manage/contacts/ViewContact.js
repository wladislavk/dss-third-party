var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  data () {
    return {
      contact: {},
      componentParams: {}
    }
  },
  mixins: [handlerMixin],
  computed: {
    filteredContact () {
      var phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el].replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
        }
      })

      return this.contact
    }
  },
  created () {
    eventHub.$on('setting-component-params', this.onSettingComponentParams)
  },
  beforeDestroy () {
    eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.setCurrentContact(this.componentParams.contactId)
    },
    setCurrentContact (contactId) {
      this.getContactById(contactId)
        .then(function (response) {
          var data = response.data.data

          if (data) {
            this.$set(this, 'contact', data)
          }
        }, function (response) {
          this.handleErrors('getContactById', response)
        })
    },
    getPhysicianContactTypes () {
      return this.$http.post(process.env.API_PATH + 'contact-types/physician')
    },
    getContactById (contactId) {
      var data = { contact_id: contactId }

      return this.$http.post(process.env.API_PATH + 'contacts/with-contact-type', data)
    }
  }
}
