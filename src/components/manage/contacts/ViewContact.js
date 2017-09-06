import handlerMixin from '../../../modules/handler/HandlerMixin'

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
      const phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el]
            .replace(/[^0-9]/g, '')
            .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
        }
      })

      return this.contact
    }
  },
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.setCurrentContact(this.componentParams.contactId)

      // this popup doesn't have any input fields - set the flag to false
      this.$parent.popupEdit = false
    },
    setCurrentContact (contactId) {
      this.getContactById(contactId)
        .then(
          (response) => {
            const data = response.data.data

            if (data) {
              this.contact = data
            }
          },
          (response) => {
            this.handleErrors('getContactById', response)
          }
        )
    },
    getPhysicianContactTypes () {
      return this.$http.post(process.env.API_PATH + 'contact-types/physician')
    },
    getContactById (contactId) {
      const data = { contact_id: contactId }

      const result = this.$http.post(process.env.API_PATH + 'contacts/with-contact-type', data)
      return result
    }
  }
}
