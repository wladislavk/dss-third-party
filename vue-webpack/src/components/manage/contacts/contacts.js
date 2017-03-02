var handlerMixin = require('../../../modules/handler/HandlerMixin.js')

export default {
  data: function() {
    return {
      contactTypes: [],
      routeParameters: {
        status: 0,
        currentPageNumber: 0,
        sortDirection: 'asc',
        selectedContactType: 0,
        sortColumn: 'name',
        currentLetter: null
      },
      letters: 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
      message: '',
      tableHeaders: {
        'name': 'Name',
        'company': 'Company',
        'type': 'Contact Type'
      },
      contacts: [],
      contactsTotalNumber: 0,
      contactsPerPage: 50,
      showActions: false,
      requiredContactName: '',
      foundContactsByName: [],
      typingTimer: null,
      doneTypingInterval: 600
    }
  },
  mixins: [handlerMixin],
  watch: {
    '$route.query.contacttype': function() {
      if (this.$route.query.contacttype) {
        var foundOption = this.contactTypes.find(
          el => el.contacttypeid == this.$route.query.contacttype
        )

        if (foundOption) {
          this.$set(this.routeParameters, 'selectedContactType', this.$route.query.contacttype)
        } else {
          this.$set(this.routeParameters, 'selectedContactType', 0)
        }
      } else {
        this.$set(this.routeParameters, 'selectedContactType', 0)
      }
    },
    '$route.query.page': function() {
      if (this.$route.query.page) {
        if (this.$route.query.page <= this.totalPages) {
          this.$set(this.routeParameters, 'currentPageNumber', this.$route.query.page)
        }
      }
    },
    '$route.query.sort': function() {
      if (this.$route.query.sort) {
        if (this.$route.query.sort in this.tableHeaders) {
          this.$set(this.routeParameters, 'sortColumn', this.$route.query.sort)
        } else {
          this.$set(this.routeParameters, 'sortColumn', null)
        }
      } else {
        this.$set(this.routeParameters, 'sortColumn', 'name')
      }
    },
    '$route.query.sortdir': function() {
      if (this.$route.query.sortdir) {
        if (this.$route.query.sortdir.toLowerCase() == 'desc') {
          this.$set(this.routeParameters, 'sortDirection', this.$route.query.sortdir.toLowerCase())
        } else {
          this.$set(this.routeParameters, 'sortDirection', 'asc')
        }
      } else {
        this.$set(this.routeParameters, 'sortDirection', 'asc')
      }
    },
    '$route.query.letter': function() {
      if (this.letters.indexOf(this.$route.query.letter) > -1) {
        this.$set(this.routeParameters, 'currentLetter', this.$route.query.letter)
      } else {
        this.$set(this.routeParameters, 'currentLetter', null)
      }
    },
    '$route.query.delid': function() {
      if (this.$route.query.delid > 0) {
        this.onDeleteContact(this.$route.query.delid)
      }
    },
    '$route.query.inactiveid': function() {
      if (this.$route.query.inactiveid > 0) {
        this.onInactiveContact(this.$route.query.inactiveid)
      }
    },
    'routeParameters': {
      handler: function() {
        this.getContacts()
      },
      deep: true
    }
  },
  events: {
    'setting-data-from-modal': function(data) {
      this.$set(this, 'message', data.message)
      this.$nextTick(function() {
        var self = this

        setTimeout(function() {
          self.$set(self, 'message', '')
        }, 3000)
      })
    }
  },
  computed: {
    totalPages: function() {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage)
    }
  },
  created () {
    this.getActiveNonCorporateContactTypes()
      .then(function(response) {
        var data = response.data.data

        if (data) {
          this.$set(this, 'contactTypes', data)
        }
      }, function(response) {
        this.handleErrors('getActiveNonCorporateContactTypes', response)
      })

    this.getContacts()
  },
  mounted () {
    this.$set(this, 'showActions', true)
  },
  methods: {
    onKeyUpSearchContacts (event) {
      clearTimeout(this.typingTimer)

      var self = this
      this.typingTimer = setTimeout(function() {
        if (self.requiredContactName.trim() != '') {
          // console.log(event.keyCode)

          if (self.requiredContactName.trim().length > 1) {
            self.getListContactsAndCompanies(self.requiredContactName.trim())
              .then(function(response) {
                var data = response.data.data

                if (data.length) {
                  self.$set(self, 'foundContactsByName', data)
                  $('#contact_hints').show()
                } else if (data.error) {
                  self.$set(self, 'foundContactsByName', [])
                  alert(data.error)
                }
              }, function(response) {
                self.handleErrors('getListContactsAndCompanies', response)
              })
          } else {
            $('#contact_hints').hide()
          }
        } else {
            self.$set(self, 'foundContactsByName', [])
        }
      }, this.doneTypingInterval)
    },
    onClickPatients (contactId) {
      $('#ref_pat_' + contactId).toggle()
    },
    onClickAddNewContact () {
      this.$parent.$refs.modal.display('edit-contact')
    },
    onClickQuickView (contactId) {
      this.$parent.$refs.modal.display('view-contact')
      this.$parent.$refs.modal.setComponentParameters({ contactId: contactId })
    },
    onClickEditContact (contactId) {
      this.$parent.$refs.modal.display('edit-contact')
      this.$parent.$refs.modal.setComponentParameters({ contactId: contactId })
    },
    onClickInActive () {
      this.$router.push({
        name  : this.$route.name,
        query : {
          status: 2
        }
      })
    },
    onChangeContactType () {
      this.$router.push({
        name  : this.$route.name,
        query : {
          contacttype: this.routeParameters.selectedContactType
        }
      })
    },
    getContacts () {
      this.findContacts(
        this.routeParameters.selectedContactType,
        this.routeParameters.status,
        this.routeParameters.currentLetter,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.currentPageNumber,
        this.contactsPerPage
      ).then(function(response) {
        var data = response.data.data

        if (data) {
          this.$set(this, 'contactsTotalNumber', data.totalCount)
          this.$set(this, 'contacts', data.result)
        }
      }, function(response) {
        this.handleErrors('findContacts', response)
      }).then(function() {
        var contactsHaveReferrers = this.contacts.map(el => el.referrers > 0 ? el.contactid : 0)
        var contactsHavePatients  = this.contacts.map(el => el.patients > 0 ? el.contactid : 0)

        contactsHaveReferrers.forEach((contactId, index) => {
          if (contactId > 0) {
            this.findReferrersByContactId(contactId)
              .then(function(response) {
                var data = response.data.data

                if (data.length) {
                  var updatedContact = Object.assign({
                    referrers_data: data
                  }, this.contacts[index])

                  this.$set(this.contacts, index, updatedContact)
                }
              }, function(response) {
                this.handleErrors('findReferrersByContactId', response)
              })
          }
        })

        contactsHavePatients.forEach((contactId, index) => {
          if (contactId > 0) {
            this.findPatientsByContactId(contactId)
              .then(function(response) {
                var data = response.data.data

                if (data.length) {
                  var updatedContact = Object.assign({
                    patients_data: data
                  }, this.contacts[index])

                  this.$set(this.contacts, index, updatedContact)
                }
              }, function(response) {
                this.handleErrors('findPatientsByContactId', response)
              })
          }
        })
      })
    },
    findReferrersByContactId (contactId) {
      var data = { contact_id: contactId }

      return this.$http.post(process.env.API_PATH + 'patients/referred-by-contact', data)
    },
    findPatientsByContactId (contactId) {
      var data = { contact_id: contactId }

      return this.$http.post(process.env.API_PATH + 'patients/by-contact', data)
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn == sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      } else {
        return 'asc'
      }
    },
    findContacts (
      contactType,
      status,
      currentLetter,
      sortColumn,
      sortDirection,
      pageNumber,
      contactsPerPage
    ) {
      var data = {
        contacttype     : contactType,
        status      : status,
        letter      : currentLetter,
        sort_column     : sortColumn,
        sort_direction  : sortDirection,
        page        : pageNumber,
        contacts_per_page : contactsPerPage
      }

      return this.$http.post(process.env.API_PATH + 'contacts/find', data)
    },
    getActiveNonCorporateContactTypes () {
      return this.$http.post(process.env.API_PATH + 'contact-types/active-non-corporate')
    },
    getListContactsAndCompanies (requestedName) {
      var data = { partial_name: requestedName }

      return this.$http.post(process.env.API_PATH + 'contacts/list-contacts-and-companies', data)
    }
  }
}
