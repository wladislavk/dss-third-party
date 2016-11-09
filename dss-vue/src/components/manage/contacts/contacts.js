var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    el: function() {
        return ''
    },
    data: function() {
        return {
            contactTypes        : [],
            routeParameters     : {
                status              : 0,
                currentPageNumber   : 0,
                sortDirection       : 'asc',
                selectedContactType : 0,
                sortColumn          : 'name',
                currentLetter       : null
            },
            letters             : 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
            message             : '',
            tableHeaders        : {
                'name'    : 'Name',
                'company' : 'Company',
                'type'    : 'Contact Type'
            },
            contacts            : [],
            contactsTotalNumber : 0,
            contactsPerPage     : 50,
            totalPages          : 0,
            showActions         : false,
            requiredContactName : '',
            foundContactsByName : [],
            typingTimer         : null,
            doneTypingInterval  : 600
        }
    },
    mixins: [handlerMixin],
    watch: {
        '$route.query.contacttype': function() {
            if (this.$route.query.contacttype) {
                var foundOption = this.contactTypes.find(
                    el => el.contacttypeid == this.$route.query.contacttype
                );

                if (foundOption) {
                    this.$set('routeParameters.selectedContactType', this.$route.query.contacttype);
                } else {
                    this.$set('routeParameters.selectedContactType', 0);
                }
            } else {
                this.$set('routeParameters.selectedContactType', 0);
            }
        },
        '$route.query.page': function() {
            if (this.$route.query.page) {
                if (this.$route.query.page <= this.totalPages) {
                    this.$set('routeParameters.currentPageNumber', this.$route.query.page);
                }
            }
        },
        '$route.query.sort': function() {
            if (this.$route.query.sort) {
                if (this.$route.query.sort in this.tableHeaders) {
                    this.$set('routeParameters.sortColumn', this.$route.query.sort);
                } else {
                    this.$set('routeParameters.sortColumn', null);
                }
            } else {
                this.$set('routeParameters.sortColumn', 'name');
            }
        },
        '$route.query.sortdir': function() {
            if (this.$route.query.sortdir) {
                if (this.$route.query.sortdir.toLowerCase() == 'desc') {
                    this.$set('routeParameters.sortDirection', this.$route.query.sortdir.toLowerCase());
                } else {
                    this.$set('routeParameters.sortDirection', 'asc');
                }
            } else {
                this.$set('routeParameters.sortDirection', 'asc');
            }
        },
        '$route.query.letter': function() {
            if (this.letters.indexOf(this.$route.query.letter) > -1) {
                this.$set('routeParameters.currentLetter', this.$route.query.letter);
            } else {
                this.$set('routeParameters.currentLetter', null);
            }
        },
        '$route.query.delid': function() {
            if (this.$route.query.delid > 0) {
                this.onDeleteContact(this.$route.query.delid);
            }
        },
        '$route.query.inactiveid': function() {
            if (this.$route.query.inactiveid > 0) {
                this.onInactiveContact(this.$route.query.inactiveid);
            }
        },
        'routeParameters': {
            handler: function() {
                this.getContacts();
            },
            deep: true
        }
    },
    events: {
        'transfer-data-from-modal': function(data) {
            this.$set('message', data.message);
            this.$nextTick(function() {
                var self = this;

                setTimeout(function() {
                    self.$set('message', '');
                }, 3000);
            });
        }
    },
    computed: {
        totalPages: function() {
            return this.contactsTotalNumber / this.contactsPerPage;
        }
    },
    created: function() {
        this.getActiveNonCorporateContactTypes()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('contactTypes', data);
                }
            }, function(response) {
                this.handleErrors('getActiveNonCorporateContactTypes', response);
            });

        this.getContacts();
    },
    ready: function() {
        this.$set('showActions', true);
    },
    methods: {
        onKeyUpSearchContacts: function(event) {
            clearTimeout(this.typingTimer);

            var self = this;
            this.typingTimer = setTimeout(function() {
                if (self.requiredContactName.trim() != '') {
                    // console.log(event.keyCode);

                    if (self.requiredContactName.trim().length > 1) {
                        self.getListContactsAndCompanies(self.requiredContactName.trim())
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    self.$set('foundContactsByName', data);
                                    $('#contact_hints').show();
                                } else if (data.error) {
                                    self.$set('foundContactsByName', []);
                                    alert(data.error);
                                }
                            }, function(response) {
                                self.handleErrors('getListContactsAndCompanies', response);
                            });
                    } else {
                        $('#contact_hints').hide();
                    }
                }
            }, this.doneTypingInterval);
        },
        onClickPatients: function(contactId) {
            $('#ref_pat_' + contactId).toggle();
        },
        onClickAddNewContact: function() {
            this.$parent.$refs.modal.display('edit-contact');
        },
        onClickQuickView: function (contactId) {
            this.$parent.$refs.modal.display('view-contact');
            this.$parent.$refs.modal.setComponentParameters({ contactId: contactId });
        },
        onClickEditContact: function(contactId) {
            this.$parent.$refs.modal.display('edit-contact');
            this.$parent.$refs.modal.setComponentParameters({ contactId: contactId });
        },
        onClickInActive: function() {
            this.$route.router.go({
                name  : this.$route.name,
                query : {
                    status: 2
                }
            });
        },
        onChangeContactType: function() {
            this.$route.router.go({
                name  : this.$route.name,
                query : {
                    contacttype: this.routeParameters.selectedContactType
                }
            });
        },
        getContacts: function() {
            this.findContacts(
                this.routeParameters.selectedContactType,
                this.routeParameters.status,
                this.routeParameters.currentLetter,
                this.routeParameters.sortColumn,
                this.routeParameters.sortDirection,
                this.routeParameters.currentPageNumber,
                this.contactsPerPage
            ).then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('contactsTotalNumber', data.totalCount);
                    this.$set('contacts', data.result);
                }
            }, function(response) {
                this.handleErrors('findContacts', response);
            }).then(function() {
                var contactsHaveReferrers = this.contacts.map(el => el.referrers > 0 ? el.contactid : 0);
                var contactsHavePatients  = this.contacts.map(el => el.patients > 0 ? el.contactid : 0);

                contactsHaveReferrers.forEach((contactId, index) => {
                    if (contactId > 0) {
                        this.findReferrersByContactId(contactId)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    var updatedContact = Object.assign({
                                        referrers_data: data
                                    }, this.contacts[index]);

                                    this.contacts.$set(index, updatedContact);
                                }
                            }, function(response) {
                                this.handleErrors('findReferrersByContactId', response);
                            });
                    }
                });

                contactsHavePatients.forEach((contactId, index) => {
                    if (contactId > 0) {
                        this.findPatientsByContactId(contactId)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    var updatedContact = Object.assign({
                                        patients_data: data
                                    }, this.contacts[index]);

                                    this.contacts.$set(index, updatedContact);
                                }
                            }, function(response) {
                                this.handleErrors('findPatientsByContactId', response);
                            });
                    }
                });
            });
        },
        findReferrersByContactId: function(contactId) {
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'patients/referred-by-contact', data);
        },
        findPatientsByContactId: function(contactId) {
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'patients/by-contact', data);
        },
        getCurrentDirection: function(sort) {
            if (this.routeParameters.sortColumn == sort) {
                return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
            } else {
                return 'asc';
            }
        },
        findContacts: function(
            contactType,
            status,
            currentLetter,
            sortColumn,
            sortDirection,
            pageNumber,
            contactsPerPage
        ) {
            var data = {
                contacttype       : contactType,
                status            : status,
                letter            : currentLetter,
                sort_column       : sortColumn,
                sort_direction    : sortDirection,
                page              : pageNumber,
                contacts_per_page : contactsPerPage
            };

            return this.$http.post(window.config.API_PATH + 'contacts/find', data);
        },
        getActiveNonCorporateContactTypes: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/active-non-corporate');
        },
        getListContactsAndCompanies: function(requestedName) {
            var data = { partial_name: requestedName };

            return this.$http.post(window.config.API_PATH + 'contacts/list-contacts-and-companies', data);
        }
    }
}
