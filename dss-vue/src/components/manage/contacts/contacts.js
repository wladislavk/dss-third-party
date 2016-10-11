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
            referrers           : {},
            patients            : {},
            contactsTotalNumber : 0,
            contactsPerPage     : 50,
            totalPages          : 0,
            showActions         : false
        }
    },
    mixins: [handlerMixin],
    watch: {
        '$route.query.contacttype': function() {
            if (this.$route.query.contacttype) {
                var foundOption = this.contactTypes.find(
                    el => el.contacttype == this.$route.query.contacttype
                );

                if (foundOption) {
                    this.$set('routeParameters.selectedContactType', this.$route.query.contacttype);
                } else {
                    this.$set('routeParameters.selectedContactType', 0);
                }
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
            }
        },
        '$route.query.sortdir': function() {
            if (this.$route.query.sortdir) {
                if (this.$route.query.sortdir.toLowerCase() == 'desc') {
                    this.$set('routeParameters.sortDirection', this.$route.query.sortdir.toLowerCase());
                } else {
                    this.$set('routeParameters.sortDirection', 'asc');
                }
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
        /*
        function(){
            setup_autocomplete('contact_name', 'contact_hints', 'contact', '', 'list_contacts_and_companies.php');
        }
        */
    },
    methods: {
        /*test: function(data) {
            console.log(data);
        },*/
        getContactTypeLabel: function(contactTypeId) {
            var foundContactType = this.contactTypes.find((el) => el.contacttypeid == contactTypeId);

            if (foundContactType) {
                return foundContactType.contacttype;
            } else {
                return 'Contact Type Not Set';
            }
        },
        onClickPatients: function(contactId) {
            $('#ref_pat_' + contactId).toggle();
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
                /*
                this.$nextTick(function() {
                    var bufObject = this.contacts[0] || {};
                    bufObject['test'] = [{ hello: 'world' }];
                    this.contacts.$set(0, bufObject);

                    this.$nextTick(function() {
                        console.log(this.contacts);
                    });
                });
                */
            }, function(response) {
                this.handleErrors('findContacts', response);
            }).then(function() {
                var referrers = {};
                var patients  = {};

                this.contacts.forEach((contact) => { 
                    if (contact.referrers > 0) {
                        this.findReferrersByContactId(contact.contactid)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    referrers[contact.contactid] = data;
                                }
                            }, function(response) {
                                this.handleErrors('findReferrersByContactId', response);
                            });
                    }

                    if (contact.patients > 0) {
                        this.findPatientsByContactId(contact.contactid)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    patients[contact.contactid] = data;
                                }
                            }, function(response) {
                                this.handleErrors('findPatientsByContactId', response);
                            });
                    }
                });

                this.$set('referrers', referrers);
                this.$set('patients', patients);
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
                return sort === 'name' ? 'asc': 'desc';
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
        }
    }
}
