import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import Alerter from '../../../services/Alerter'

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

    http.post(endpoints.contactTypes.activeNonCorporate).then((response) => {
      const data = response.data.data

      if (data) {
        this.contactTypes = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getActiveNonCorporateContactTypes', response: response})
    })

    this.getContacts()
  },
  mounted () {
    this.showActions = true
  },
  beforeDestroy () {
    window.eventHub.$off('setting-data-from-modal', this.onSettingDataFromModal)
  },
  methods: {
    onSettingDataFromModal (data) {
      this.message = data.message
      this.$nextTick(() => {
        setTimeout(() => {
          this.message = ''
        }, 3000)
      })
    },
    onKeyUpSearchContacts () {
      clearTimeout(this.typingTimer)

      this.typingTimer = setTimeout(() => {
        if (this.requiredContactName.trim() !== '') {
          if (this.requiredContactName.trim().length > 1) {
            this.getListContactsAndCompanies(this.requiredContactName.trim()).then((response) => {
              const data = response.data.data

              if (data.length) {
                this.foundContactsByName = data
                window.$('#contact_hints').show()
              } else if (data.error) {
                this.foundContactsByName = []
                Alerter.alert(data.error)
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'getListContactsAndCompanies', response: response})
            })
          } else {
            window.$('#contact_hints').hide()
          }
        } else {
          this.foundContactsByName = []
        }
      }, this.doneTypingInterval)
    },
    onClickPatients (contactId) {
      window.$('#ref_pat_' + contactId).toggle()
    },
    onClickAddNewContact () {
      this.$store.commit(symbols.mutations.modal, { name: symbols.modals.editContact })
    },
    onClickQuickView (contactId) {
      this.$store.commit(symbols.mutations.modal, { name: symbols.modals.viewContact })
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: contactId })
    },
    onClickEditContact (contactId) {
      this.$store.commit(symbols.mutations.modal, { name: symbols.modals.editContact })
      this.$store.dispatch(symbols.actions.setCurrentContact, { contactId: contactId })
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
      this.findContacts(
        this.routeParameters.selectedContactType,
        this.routeParameters.status,
        this.routeParameters.currentLetter,
        this.routeParameters.sortColumn,
        this.routeParameters.sortDirection,
        this.routeParameters.currentPageNumber,
        this.contactsPerPage
      ).then((response) => {
        const data = response.data.data

        if (data) {
          this.contactsTotalNumber = data.totalCount
          this.contacts = data.result
        }
      }).then(() => {
        const contactsHaveReferrers = this.contacts.map(el => el.referrers > 0 ? el.contactid : 0)
        const contactsHavePatients = this.contacts.map(el => el.patients > 0 ? el.contactid : 0)

        contactsHaveReferrers.forEach((contactId, index) => {
          if (contactId > 0) {
            this.findReferrersByContactId(contactId).then((response) => {
              const data = response.data.data

              if (data.length) {
                const updatedContact = Object.assign({
                  referrers_data: data
                }, this.contacts[index])

                this.$set(this.contacts, index, updatedContact)
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'findReferrersByContactId', response: response})
            })
          }
        })

        contactsHavePatients.forEach((contactId, index) => {
          if (contactId > 0) {
            this.findPatientsByContactId(contactId).then((response) => {
              const data = response.data.data

              if (data.length) {
                const updatedContact = Object.assign({
                  patients_data: data
                }, this.contacts[index])

                this.$set(this.contacts, index, updatedContact)
              }
            }).catch((response) => {
              this.$store.dispatch(symbols.actions.handleErrors, {title: 'findPatientsByContactId', response: response})
            })
          }
        })
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'findContacts', response: response})
      })
    },
    findReferrersByContactId (contactId) {
      const data = { contact_id: contactId }

      return http.post(endpoints.patients.referredByContact, data)
    },
    findPatientsByContactId (contactId) {
      const data = { contact_id: contactId }

      return http.post(endpoints.patients.byContact, data)
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

      return http.post(endpoints.contacts.find, data)
    },
    getListContactsAndCompanies (requestedName) {
      const data = { partial_name: requestedName }

      return http.post(endpoints.contacts.listContactsAndCompanies, data)
    }
  }
}
