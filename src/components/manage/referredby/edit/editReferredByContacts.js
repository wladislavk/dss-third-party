import endpoints from '../../../../endpoints'
import http from '../../../../services/http'
import referredByContactValidatorMixin from '../../../../modules/validators/ReferredByContactMixin'
import symbols from '../../../../symbols'

export default {
  name: 'edit-referred-by-contacts',
  data () {
    return {
      message: '',
      componentParams: {
        contactId: 0,
        addToPatient: 0,
        from: ''
      },
      contact: {
        salutation: '',
        preferredcontact: 'paper',
        qualifier: 0,
        status: 1
      },
      contactFullName: '',
      qualifiers: [],
      isContactDataFetched: false
    }
  },
  mixins: [referredByContactValidatorMixin],
  watch: {
    'contact': {
      handler: function () {
        // we are editing some contact and current contact data has already fetched
        if (this.componentParams.contactId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false
          this.$parent.popupEdit = true
        } else if (this.componentParams.contactId === 0) { // we are creating a new contact
          this.$parent.popupEdit = true
        }

        if (!this.isContactDataFetched) {
          this.isContactDataFetched = true
        }
      },
      deep: true
    }
  },
  computed: {
    buttonText () {
      return this.componentParams.contactId > 0 ? 'Edit' : 'Add'
    }
  },
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // no one field was edited
    this.$store.dispatch(symbols.actions.disablePopupEdit)
  },
  mounted () {
    http.post(endpoints.qualifiers.active).then((response) => {
      const data = response.data.data

      if (data.length) {
        this.qualifiers = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getActiveQualifiers', response: response})
    })
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getReferredByContact(this.componentParams.contactId).then((response) => {
        const data = response.data.data

        if (data) {
          this.contactFullName = (data.firstname ? data.firstname + ' ' : '') +
            (data.middlename ? data.middlename + ' ' : '') +
            (data.lastname || '')

          this.contact = response.data.data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getReferredByContact', response: response})
      })
    },
    onSubmit () {
      if (this.validateContactData(this.contact)) {
        this.editContact(this.componentParams.contactId, this.contact).then((response) => {
          const data = response.data.data

          this.$parent.popupEdit = false

          if (this.componentParams.addToPatient) {
            this.$router.push({
              name: 'edit-patient',
              query: { pid: this.componentParams.addToPatient }
            })
          } else {
            if (data.status) {
              this.$parent.updateParentData({ message: data.status })
              this.$parent.disable()
            }
          }

          if (this.componentParams.from === 'flowsheet3') {
            // redirect to "/manage/manage_flowsheet3.php?pid=<?php echo $addedtopat; ?>&refid=<?php echo $rid; ?>"
          }
        }).catch((response) => {
          this.parseFailedResponseOnEditingContact(response.data.data)

          this.$store.dispatch(symbols.actions.handleErrors, {title: 'editContact', response: response})
        })
      }
    },
    parseFailedResponseOnEditingContact (data) {
      const errors = data.errors.shift()

      if (errors !== undefined) {
        const objKeys = Object.keys(errors)

        const arrOfMessages = objKeys.map((el) => {
          return el + ':' + errors[el].join('|').toLowerCase()
        })

        // TODO: create more readable format
        alert(arrOfMessages.join('\n'))
      }
    },
    getReferredByContact (id) {
      return http.get(endpoints.referredByContacts.show + '/' + id)
    },
    editContact (contactId, contactFormData) {
      contactId = contactId || 0

      const data = {
        contact_form_data: contactFormData
      }

      return http.post(endpoints.referredByContacts.edit + '/' + contactId, data)
    }
  }
}
