import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import symbols from '../../../../symbols'

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
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // this popup has only readonly input fields - set the flag to false
    this.$parent.popupEdit = false
  },
  mounted () {
    // set all form's fields disabled
    window.$('form :input').attr('readonly', true)
    window.$('form select').attr('disabled', 'disabled')
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getContactType().then((response) => {
        this.contactTypes = response.data.data

        this.fetchContact(this.componentParams.contactId)
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContactById', response: response})
      })
    },
    fetchContact (contactId) {
      this.getContactById(contactId).then((response) => {
        const data = response.data.data

        data['name'] = (data['firstname'] ? data['firstname'] + ' ' : '') +
          (data['middlename'] ? data['middlename'] + ' ' : '') +
          (data['lastname'] || '')

        this.contact = data
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContactById', response: response})
      })
    },
    getContactById (contactId) {
      contactId = contactId || 0

      return http.get(endpoints.contacts.show + '/' + contactId)
    },
    getContactType () {
      return http.post(endpoints.contactTypes.sorted)
    }
  }
}
