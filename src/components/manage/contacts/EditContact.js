import Alerter from '../../../services/Alerter'
import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import SwalWrapper from '../../../wrappers/SwalWrapper'

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
  computed: {
    googleLink () {
      const link = 'http://google.com/search?q='
      const requiredFields = [
        'firstname',
        'lastname',
        'company',
        'add1',
        'city',
        'state',
        'zip'
      ]

      const notEmptyRequiredFields = []
      requiredFields.forEach((el) => {
        if (this.contact[el]) {
          notEmptyRequiredFields.push(this.contact[el])
        }
      })

      return link + notEmptyRequiredFields.join('+')
    }
  },
  watch: {
    pendingVOB: function () {
      if (!this.pendingVOB.length) {
        this.getContactSentLetters(this.contact.contactid).then((response) => {
          const data = response.data.data

          if (data.length) {
            this.contactSentLetters = data
          }
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContactSentLetters', response: response})
        })

        this.getContactPendingLetters(this.contact.contactid).then((response) => {
          const data = response.data.data

          if (data.length) {
            this.contactPendingLetters = data
          }
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContactPendingLetters', response: response})
        })
      }
    },
    'contact.contacttypeid': function () {
      if (this.contactTypesOfPhysician.indexOf(this.contact.contacttypeid) > -1) {
        this.$set(this.contact, 'salutation', 'Dr.')
        this.showName = true
        this.showNationalProviderId = true
        // @todo: what is 11?
      } else if (this.contact.contacttypeid === 11) {
        this.$set(this.contact, 'firstname', '')
        this.$set(this.contact, 'lastname', '')
        this.showName = false
        this.showNationalProviderId = false
      } else if (this.contact.contacttypeid > 0) {
        this.showName = true
        this.showNationalProviderId = false
      }
    },
    'contact.phone1': function () {
      const phone1 = this.contact.phone1
        .replace(/[^0-9]/g, '')
        .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
      this.$set(this.contact, 'phone1', phone1)
    },
    'contact.phone2': function () {
      const phone2 = this.contact.phone2
        .replace(/[^0-9]/g, '')
        .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
      this.$set(this.contact, 'phone2', phone2)
    },
    'contact.fax': function () {
      const fax = this.contact.fax
        .replace(/[^0-9]/g, '')
        .replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
      this.$set(this.contact, 'fax', fax)
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
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  mounted () {
    http.post(endpoints.contactTypes.physician).then((response) => {
      const data = response.data.data

      if (data.physician_types) {
        this.$set(this, 'contactTypesOfPhysician', data.physician_types.split(','))
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContactTypesOfPhysician', response: response})
    })

    http.post(endpoints.contactTypes.activeNonCorporate).then((response) => {
      const data = response.data.data

      if (data.length) {
        this.activeNonCorporateContactTypes = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getActiveNonCorporateContactTypes', response: response})
    })

    http.post(endpoints.qualifiers.active).then((response) => {
      const data = response.data.data

      if (data.length) {
        this.activeQualifiers = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getActiveQualifiers', response: response})
    })
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      if (this.componentParams.contactId > 0) {
        this.getContact(this.componentParams.contactId).then((response) => {
          const data = response.data.data

          if (data) {
            this.contact = data

            this.$nextTick(() => {
              this.wasContactDataReceived = true
            })
          }
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getContact', response: response})
        })

        this.getPendingVOBsByContactId(this.componentParams.contactId).then((response) => {
          const data = response.data.data

          if (data.length) {
            this.pendingVOB = data
          }
        }).catch((response) => {
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'getPendingVOBsByContactId', response: response})
        })
      }
    },
    onClickSubmit () {
      this.message = ''

      if (this.componentParams.contactId > 0) {
        this.updateContact(this.contact).then(() => {
          // pass message to parent component
          this.$parent.updateParentData({ message: 'Edited Successfully' })
          this.$parent.$parent.$refs.modal.popupEdit = false
          this.$parent.$parent.$refs.modal.disable()
          this.$router.push('/manage/contacts')
        }).catch((response) => {
          if (response.status === 422) {
            this.displayErrorResponseFromAPI(response.data.data)
            return
          }
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'updateContact', response: response})
        })
      } else {
        this.insertContact(this.contact).then((response) => {
          const data = response.data.data

          if (data) {
            this.createWelcomeLetter(data.contactid, this.contact.contacttypeid).then((response) => {
              const data = response.data.data

              if (data.message) {
                SwalWrapper.callSwal({
                  title: '',
                  text: data.message,
                  type: 'info'
                })
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'createWelcomeLetter', response: response})
            })

            if (this.componentParams.activePat) {
              this.$router.push({
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
              this.$router.push('/manage/contacts')
            }

            // this popup doesn't have any input fields - then set the flag to false
            this.$parent.$parent.$refs.modal.popupEdit = false
            this.$parent.$parent.$refs.modal.disable()
          }
        }).catch((response) => {
          if (response.status === 422) {
            this.displayErrorResponseFromAPI(response.data.data)
            return
          }
          this.$store.dispatch(symbols.actions.handleErrors, {title: 'updateContact', response: response})
        })
      }
    },
    displayErrorResponseFromAPI (data) {
      let message = '<ul style="text-align: left">'

      for (let key in data.errors) {
        if (data.errors.hasOwnProperty(key)) {
          message += '<li>' + key + ': ' + data.errors[key].join(' ') + '</li>'
        }
      }

      message += '</ul>'

      SwalWrapper.callSwal({
        title: 'Wrong data!',
        text: message,
        html: true,
        type: 'error'
      })
    },
    onClickConfirm (type, contactId) {
      let message = ''
      let query = {}
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
      }

      if (confirm(message)) {
        this.$router.push({
          path: '/manage/contacts',
          query: query
        })
      }
    },
    onPreferredContactChange () {
      let alertText
      if (this.contact.preferredcontact === 'email' && this.contact.email.length === 0) {
        alertText = 'You must enter an email address to use email as the preferred contact method.'
        Alerter.alert(alertText)

        this.$set(this.contact, 'preferredcontact', '')
        this.$refs.email.focus()
      } else if (this.contact.preferredcontact === 'fax' && this.contact.fax.length === 0) {
        alertText = 'You must enter a fax number to use email as the preferred contact method.'
        Alerter.alert(alertText)

        this.$set(this.contact, 'preferredcontact', '')
        this.$refs.fax.focus()
      }
    },
    getContactPendingLetters (contactId) {
      // gets letters that were not delivered for contact
      const data = { contact_id: contactId }

      return http.post(endpoints.letters.notDeliveredForContact, data)
    },
    getContactSentLetters (contactId) {
      // gets letters that were delivered for contact
      const data = { contact_id: contactId }

      return http.post(endpoints.letters.deliveredForContact, data)
    },
    getFullName (contact) {
      const middlename = contact.middlename ? contact.middlename + ' ' : ''
      const fullname = contact.firstname + ' ' + middlename + contact.lastname

      return fullname
    },
    updateContact (contact) {
      const phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el].replace(/[^0-9]/g, '')
        }
      })

      return http.put(endpoints.contacts.update + '/' + contact.contactid, contact)
    },
    insertContact (contact) {
      const phoneFields = ['phone1', 'phone2', 'fax']

      phoneFields.forEach(el => {
        if (this.contact.hasOwnProperty(el)) {
          this.contact[el] = this.contact[el].replace(/[^0-9]/g, '')
        }
      })

      return http.post(endpoints.contacts.store, contact)
    },
    getLetterInfoByDocId () {
      return http.post(endpoints.users.letterInfo)
    },
    getContactType (contactTypeId) {
      return http.get(endpoints.contactTypes.show + '/' + contactTypeId)
    },
    getContact (contactId) {
      return http.get(endpoints.contacts.show + '/' + contactId)
    },
    getPendingVOBsByContactId (contactId) {
      const data = { contact_id: contactId }

      return http.post(endpoints.insurancePreauth.pendingVob, data)
    },
    createWelcomeLetter (templateId, contactTypeId) {
      const data = {
        template_id: templateId,
        contact_type_id: contactTypeId
      }

      return http.post(endpoints.letters.createWelcomeLetter, data)
    }
  }
}
