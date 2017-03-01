var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  data () {
    return {
      componentParams: {},
      contactTypesOfPhysician: [],
      contact: {
        email: '',
        phone1: '',
        phone2: '',
        fax: '',
        preferredcontact: 'default',
        contacttypeid: 0
      },
      activeNonCorporateContactTypes: [],
      activeQualifiers: [],
      pendingVOB: {},
      contactSentLetters: [],
      contactPendingLetters: [],
      message: '',
      wasContactDataReceived: false,
      showNationalProviderId: true,
      showName: true
    }
  },
  mixins: [handlerMixin],
  computed: {
    googleLink () {
      var link = 'http://google.com/search?q='
      var requiredFields = [
        'firstname', 'lastname', 'company',
        'add1', 'city', 'state', 'zip'
      ]

      var notEmptyRequiredFields = []
      var self = this
      requiredFields.forEach(function (el) {
        if (self.contact[el]) {
          notEmptyRequiredFields.push(self.contact[el])
        }
      })

      return link + notEmptyRequiredFields.join('+')
    }
  },
  watch: {
    pendingVOB: function () {
      if (!this.pendingVOB.length) {
        this.getContactSentLetters(this.contact.contactid)
          .then(function (response) {
            var data = response.data.data

            if (data.length) {
              this.$set('contactSentLetters', data)
            }
          }, function (response) {
            this.handleErrors('getContactSentLetters', response)
          })

        this.getContactPendingLetters(this.contact.contactid)
          .then(function (response) {
            var data = response.data.data

            if (data.length) {
              this.$set('contactPendingLetters', data)
            }
          }, function (response) {
            this.handleErrors('getContactPendingLetters', response)
          })
      }
    },
    'contact.contacttypeid': function () {
      if (this.contactTypesOfPhysician.indexOf(this.contact.contacttypeid) > -1) {
        this.$set(this.contact, 'salutation', 'Dr.')
        this.$set('showName', true)
        this.$set('showNationalProviderId', true)
      } else if (this.contact.contacttypeid === 11) {
        this.$set(this.contact, 'firstname', '')
        this.$set(this.contact, 'lastname', '')
        this.$set('showName', false)
        this.$set('showNationalProviderId', false)
      } else if (this.contact.contacttypeid > 0) {
        this.$set('showName', true)
        this.$set('showNationalProviderId', false)
      }
    },
    'contact.phone1': function () {
      this.$set('contact.phone1', this.contact.phone1.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3'))
    },
    'contact.phone2': function () {
      this.$set('contact.phone2', this.contact.phone2.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3'))
    },
    'contact.fax': function () {
      this.$set('contact.fax', this.contact.fax.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3'))
    },
    'contact': {
      handler: function () {
        if (this.wasContactDataReceived) {
          this.$parent.$parent.$refs.modal.popupEdit = true
        }
      },
      deep: true
    }
  },
  events: {
    'setting-component-params': function (parameters) {
      this.componentParams = parameters

      if (this.componentParams.contactId > 0) {
        this.getContact(this.componentParams.contactId)
          .then(function (response) {
            var data = response.data.data

            if (data) {
              this.$set('contact', data)

              this.$nextTick(function () {
                this.wasContactDataReceived = true
              })
            }
          }, function (response) {
            this.handleErrors('getContact', response)
          })

        this.getPendingVOBsByContactId(this.componentParams.contactId)
          .then(function (response) {
            var data = response.data.data

            if (data.length) {
              this.$set('pendingVOB', data)
            }
          }, function (response) {
            this.handleErrors('getPendingVOBsByContactId', response)
          })
      }
    }
  },
  mounted () {
    this.getContactTypesOfPhysician()
      .then(function (response) {
        var data = response.data.data

        if (data.physician_types) {
          this.$set('contactTypesOfPhysician', data.physician_types.split(','))
        }
      }, function (response) {
        this.handleErrors('getContactTypesOfPhysician', response)
      })

    this.getActiveNonCorporateContactTypes()
      .then(function (response) {
        var data = response.data.data

        if (data.length) {
          this.$set('activeNonCorporateContactTypes', data)
        }
      }, function (response) {
        this.handleErrors('getActiveNonCorporateContactTypes', response)
      })

    this.getActiveQualifiers()
      .then(function (response) {
        var data = response.data.data

        if (data.length) {
          this.$set('activeQualifiers', data)
        }
      }, function (response) {
        this.handleErrors('getActiveQualifiers', response)
      })
  },
  methods: {
    onClickSubmit () {
      this.$set('message', '')

      if (this.componentParams.contactId > 0) {
        this.updateContact(this.contact)
          .then(function () {
            // pass message to parent component
            this.$parent.updateParentData({ message: 'Edited Successfully' })
            this.$parent.$parent.$refs.modal.popupEdit = false
            this.$parent.$parent.$refs.modal.disable()
            this.$route.router.push('/manage/contacts')
          }, function (response) {
            if (response.status === 422) {
              this.displayErrorResponseFromAPI(response.data.data)
            } else {
              this.handleErrors('updateContact', response)
            }
          })
      } else {
        this.insertContact(this.contact)
          .then(function (response) {
            var data = response.data.data

            if (data) {
              this.createWelcomeLetter(data.contactid, this.contact.contacttypeid)
                .then(function (response) {
                  var data = response.data.data

                  if (data.message) {
                    window.swal({
                      title: '',
                      text: data.message,
                      type: 'info'
                    })
                  }
                }, function (response) {
                  this.handleErrors('createWelcomeLetter', response)
                })

              if (this.componentParams.activePat) {
                this.$route.router.push({
                  path: '/add/patient',
                  query: {
                    ed: this.componentParams.activePat,
                    preview: 1,
                    addtopat: 1,
                    pid: this.componentParams.activePat
                  }
                })
              } else {
                this.$parent.passDataToComponents({ message: 'Added Successfully' })
                this.$route.router.push('/manage/contacts')
              }

              // this popup doesn't have any input fields - then set the flag to false
              this.$parent.$parent.$refs.modal.popupEdit = false
              this.$parent.$parent.$refs.modal.disable()
            }
          }, function (response) {
            if (response.status === 422) {
              this.displayErrorResponseFromAPI(response.data.data)
            } else {
              this.handleErrors('updateContact', response)
            }
          })
      }
    },
    displayErrorResponseFromAPI (data) {
      var message = '<ul style="text-align: left">'

      for (var key in data.errors) {
        message += '<li>' + key + ': ' + data.errors[key].join(' ') + '</li>'
      }

      message += '</ul>'

      window.swal({
        title: 'Wrong data!',
        text: message,
        html: true,
        type: 'error'
      })
    },
    onClickConfirm (type, contactId) {
      var message = ''
      var query = {}
      contactId = contactId || 0

      switch (type) {
        case 'delete-pending-vobs':
          message = 'Warning! There is currently a patient with this insurance company that has a pending VOB. Deleting this insurance company will cause the VOB to fail. Do you want to proceed?'
          query = { delid: contactId }
          break
        case 'inactive':
          message = 'Letters have previously been sent to this contact therefore, for medical record purposes the contact cannot be deleted. This contact now will be marked as INACTIVE in your software and will no longer display in search results. Any pending letters associated with this contact will be deleted.'
          query = { inactiveid: contactId }
          break
        case 'delete':
          message = 'Do Your Really want to Delete?.'
          query = { delid: contactId }
          break
        case 'delete-pending-letters':
          message = 'Warning: There are pending letters associated with this contact.  When you delete the contact the pending letters will also be deleted. Proceed?'
          query = { delid: contactId }
          break
        default:
          break
      }

      if (confirm(message)) {
        this.$route.router.push({
          path: '/manage/contacts',
          query: query
        })
      }
    },
    onPreferredContactChange () {
      if (this.contact.preferredcontact === 'email' && this.contact.email.length === 0) {
        alert('You must enter an email address to use email as the preferred contact method.')

        this.$set(this.contact, 'preferredcontact', '')
        this.$refs.email.focus()
      } else if (this.contact.preferredcontact === 'fax' && this.contact.fax.length === 0) {
        alert('You must enter a fax number to use email as the preferred contact method.')

        this.$set(this.contact, 'preferredcontact', '')
        this.$refs.fax.focus()
      }
    },
    getContactPendingLetters (contactId) {
      // gets letters that were not delivered for contact
      var data = { contact_id: contactId }

      return this.$http.post(window.config.API_PATH + 'letters/not-delivered-for-contact', data)
    },
    getContactSentLetters (contactId) {
      // gets letters that were delivered for contact
      var data = { contact_id: contactId }

      return this.$http.post(window.config.API_PATH + 'letters/delivered-for-contact', data)
    },
    getFullName (contact) {
      var middlename = contact.middlename ? contact.middlename + ' ' : ''
      var fullname = contact.firstname + ' ' + middlename + contact.lastname

      return fullname
    },
    updateContact (contact) {
      var phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el].replace(/[^0-9]/g, '')
        }
      })

      return this.$http.put(window.config.API_PATH + 'contacts/' + contact.contactid, contact)
    },
    insertContact (contact) {
      var phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el].replace(/[^0-9]/g, '')
        }
      })

      return this.$http.post(window.config.API_PATH + 'contacts', contact)
    },
    getLetterInfoByDocId () {
      return this.$http.post(window.config.API_PATH + 'users/letter-info')
    },
    getContactType (contactTypeId) {
      return this.$http.get(window.config.API_PATH + 'contact-types/' + contactTypeId)
    },
    getContactTypesOfPhysician () {
      return this.$http.post(window.config.API_PATH + 'contact-types/physician')
    },
    getContact (contactId) {
      return this.$http.get(window.config.API_PATH + 'contacts/' + contactId)
    },
    getActiveNonCorporateContactTypes () {
      return this.$http.post(window.config.API_PATH + 'contact-types/active-non-corporate')
    },
    getActiveQualifiers () {
      return this.$http.post(window.config.API_PATH + 'qualifiers/active')
    },
    getPendingVOBsByContactId (contactId) {
      var data = { contact_id: contactId }

      return this.$http.post(window.config.API_PATH + 'insurance-preauth/pending-VOB', data)
    },
    createWelcomeLetter (templateId, contactTypeId) {
      var data = {
        template_id: templateId,
        contact_type_id: contactTypeId
      }

      return this.$http.post(window.config.API_PATH + 'letters/create-welcome-letter', data)
    }
  }
}
