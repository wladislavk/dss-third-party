import handlerMixin from '../../../modules/handler/HandlerMixin'

export default {
  data: function () {
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
    '$route.query.contacttype': function () {
      const queryContactType = this.$route.query.contacttype
      let selectedContactType = 0
      if (queryContactType) {
        const foundOption = this.contactTypes.find(
          el => el.contacttypeid === queryContactType
        )
        if (foundOption) {
          selectedContactType = queryContactType
        }
      }
      this.$set(this.routeParameters, 'selectedContactType', selectedContactType)
    },
    '$route.query.page': function () {
      const queryPage = this.$route.query.page
      if (queryPage && queryPage <= this.totalPages) {
        this.$set(this.routeParameters, 'currentPageNumber', queryPage)
      }
    },
    '$route.query.sort': function () {
      const querySort = this.$route.query.sort
      let sortColumn = 'name'
      if (querySort) {
        sortColumn = null
        if (querySort in this.tableHeaders) {
          sortColumn = querySort
        }
      }
      this.$set(this.routeParameters, 'sortColumn', sortColumn)
    },
    '$route.query.sortdir': function () {
      const querySortDir = this.$route.query.sortdir
      let sortDir = 'asc'
      if (querySortDir && querySortDir.toLowerCase() === 'desc') {
        sortDir = 'desc'
      }
      this.$set(this.routeParameters, 'sortDirection', sortDir)
    },
    '$route.query.letter': function () {
      const queryLetter = this.$route.query.letter
      let letter = null
      if (this.letters.indexOf(queryLetter) > -1) {
        letter = queryLetter
      }
      this.$set(this.routeParameters, 'currentLetter', letter)
    },
    '$route.query.delid': function () {
      const queryDelId = this.$route.query.delid
      if (queryDelId > 0) {
        this.onDeleteContact(queryDelId)
      }
    },
    '$route.query.inactiveid': function () {
      const queryInactiveId = this.$route.query.inactiveid
      if (queryInactiveId > 0) {
        this.onInactiveContact(queryInactiveId)
      }
    },
    'routeParameters': {
      handler: function () {
        this.getContacts()
      },
      deep: true
    }
  },
  computed: {
    totalPages: function () {
      return Math.ceil(this.contactsTotalNumber / this.contactsPerPage)
    }
  },
  created () {
    window.eventHub.$on('setting-data-from-modal', this.onSettingDataFromModal)

    this.getActiveNonCorporateContactTypes()
      .then(
        function (response) {
          const data = response.data.data

          if (data) {
            this.contactTypes = data
          }
        },
        function (response) {
          this.handleErrors('getActiveNonCorporateContactTypes', response)
        }
      )

    this.getContacts()
  },
  mounted () {
    this.showActions = true
  },
  beforeDestroy () {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal)
  },
  methods: {
    onSettingDataFromModal () {
      // @todo: this will not work
      this.message = data.message
      this.$nextTick(function () {
        const self = this

        setTimeout(function () {
          self.message = ''
        }, 3000)
      })
    },
    onKeyUpSearchContacts () {
      clearTimeout(this.typingTimer)

      const self = this
      this.typingTimer = setTimeout(function () {
        if (self.requiredContactName.trim() !== '') {
          if (self.requiredContactName.trim().length > 1) {
            self.getListContactsAndCompanies(self.requiredContactName.trim())
              .then(
                function (response) {
                  const data = response.data.data

                  if (data.length) {
                    self.foundContactsByName = data
                    window.$('#contact_hints').show()
                  } else if (data.error) {
                    self.foundContactsByName = []
                    alert(data.error)
                  }
                },
                function (response) {
                  self.handleErrors('getListContactsAndCompanies', response)
                }
              )
          } else {
            window.$('#contact_hints').hide()
          }
        } else {
          self.foundContactsByName = []
        }
      }, this.doneTypingInterval)
    },
    onClickPatients (contactId) {
      window.$('#ref_pat_' + contactId).toggle()
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
        name: this.$route.name,
        query: {
          status: 2
        }
      })
    },
    onChangeContactType () {
      this.$router.push({
        name: this.$route.name,
        query: {
          contacttype: this.routeParameters.selectedContactType
        }
      })
    },
    getContacts () {
      const self = this
      this.findContacts(
        this.routeParameters.selectedContactType,
        this.routeParameters.status,
        this.routeParameters.currentLetter,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.currentPageNumber,
        this.contactsPerPage
      ).then(
        function (response) {
          const data = response.data.data

          if (data) {
            this.contactsTotalNumber = data.totalCount
            this.contacts = data.result
          }
        },
        function (response) {
          this.handleErrors('findContacts', response)
        }
      ).then(
        function () {
          const contactsHaveReferrers = this.contacts.map(el => el.referrers > 0 ? el.contactid : 0)
          const contactsHavePatients = this.contacts.map(el => el.patients > 0 ? el.contactid : 0)

          contactsHaveReferrers.forEach((contactId, index) => {
            if (contactId > 0) {
              this.findReferrersByContactId(contactId)
                .then(
                  function (response) {
                    const data = response.data.data

                    if (data.length) {
                      const updatedContact = Object.assign({
                        referrers_data: data
                      }, self.contacts[index])

                      this.$set(self.contacts, index, updatedContact)
                    }
                  },
                  function (response) {
                    this.handleErrors('findReferrersByContactId', response)
                  }
                )
            }
          })

          contactsHavePatients.forEach((contactId, index) => {
            if (contactId > 0) {
              this.findPatientsByContactId(contactId)
                .then(
                  function (response) {
                    const data = response.data.data

                    if (data.length) {
                      const updatedContact = Object.assign({
                        patients_data: data
                      }, self.contacts[index])

                      this.$set(self.contacts, index, updatedContact)
                    }
                  },
                  function (response) {
                    this.handleErrors('findPatientsByContactId', response)
                  }
                )
            }
          })
        }
      )
    },
    findReferrersByContactId (contactId) {
      const data = { contact_id: contactId }

      return this.$http.post(process.env.API_PATH + 'patients/referred-by-contact', data)
    },
    findPatientsByContactId (contactId) {
      const data = { contact_id: contactId }

      return this.$http.post(process.env.API_PATH + 'patients/by-contact', data)
    },
    getCurrentDirection (sort) {
      if (this.routeParameters.sortColumn === sort) {
        return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc'
      }
      return 'asc'
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
      const data = {
        contacttype: contactType,
        status: status,
        letter: currentLetter,
        sort_column: sortColumn,
        sort_direction: sortDirection,
        page: pageNumber,
        contacts_per_page: contactsPerPage
      }

      return this.$http.post(process.env.API_PATH + 'contacts/find', data)
    },
    getActiveNonCorporateContactTypes () {
      return this.$http.post(process.env.API_PATH + 'contact-types/active-non-corporate')
    },
    getListContactsAndCompanies (requestedName) {
      const data = { partial_name: requestedName }

      return this.$http.post(process.env.API_PATH + 'contacts/list-contacts-and-companies', data)
    }
  }
}
