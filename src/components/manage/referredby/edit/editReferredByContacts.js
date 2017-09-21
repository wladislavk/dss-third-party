import endpoints from '../../../../endpoints'
import handlerMixin from '../../../../modules/handler/HandlerMixin'
import http from '../../../../services/http'
import referredByContactValidatorMixin from '../../../../modules/validators/ReferredByContactMixin'

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
  mixins: [handlerMixin, referredByContactValidatorMixin],
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
    this.$parent.popupEdit = false
  },
  mounted () {
    http.post(endpoints.qualifiers.active).then(
      function (response) {
        const data = response.data.data

        if (data.length) {
          this.qualifiers = data
        }
      },
      function (response) {
        this.handleErrors('getActiveQualifiers', response)
      }
    )
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getReferredByContact(this.componentParams.contactId).then(
        function (response) {
          const data = response.data.data

          if (data) {
            this.contactFullName = (data.firstname ? data.firstname + ' ' : '') +
              (data.middlename ? data.middlename + ' ' : '') +
              (data.lastname || '')

            this.contact = response.data.data
          }
        },
        function (response) {
          this.handleErrors('getReferredByContact', response)
        }
      )
    },
    onSubmit () {
      if (this.validateContactData(this.contact)) {
        this.editContact(this.componentParams.contactId, this.contact)
          .then(function (response) {
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
          }, function (response) {
            this.parseFailedResponseOnEditingContact(response.data.data)

            this.handleErrors('editContact', response)
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
