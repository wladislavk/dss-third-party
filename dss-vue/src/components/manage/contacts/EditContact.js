var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            componentParams                : {},
            contactTypesOfPhysician        : '',
            contact                        : {},
            activeNonCorporateContactTypes : [],
            activeQualifiers               : [],
            pendingVOB                     : {}
        }
    },
    mixins: [handlerMixin],
    computed: {
        filteredContact: function() {
            var phoneFields = ['phone1', 'phone2', 'fax'];

            phoneFields.forEach(el => {
                if (this.contact.hasOwnProperty(el)) {
                    this.contact[el] = this.contact[el].replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                }
            });

            return this.contact;
        }
    },
    events: {
        'setting-component-params': function(parameters) {
            this.componentParams = parameters;

            this.getContact(this.componentParams.contactId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('contact', data);
                    }
                }, function(response) {
                    this.handleErrors('getContactTypesOfPhysician', response);
                });

            this.getPendingVOBsByContactId()
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('pendingVOB', data);
                    }
                }, function(response) {
                    this.handleErrors('getPendingVOBsByContactId', response);
                });
        }
    },
    ready: function() {
        this.getContactTypesOfPhysician()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('contactTypesOfPhysician', data);
                }
            }, function(response) {
                this.handleErrors('getContactTypesOfPhysician', response);
            });

        this.getActiveNonCorporateContactTypes()
            .then(function(response) {
                var data = response.data.data;

                if (data.length) {
                    this.$set('activeNonCorporateContactTypes', data);
                }
            }, function(response) {
                this.handleErrors('getActiveNonCorporateContactTypes', response);
            });

        this.getActiveQualifiers()
            .then(function(response) {
                var data = response.data.data;

                if (data.length) {
                    this.$set('activeQualifiers', data);
                }
            }, function(response) {
                this.handleErrors('getActiveQualifiers', response);
            });
    },
    methods: {
        getFullName: function(contact) {
            return contact.firstname + ' ' + contact.middlename + ' ' + contact.lastname;
        },
        updateContact: function(contact) {
            return this.$http.put(window.config.API_PATH + 'contacts/' + contact.contactid, contact);
        },
        insertContact: function(contact) {
            return this.$http.post(window.config.API_PATH + 'contacts', contact);
        },
        getLetterInfoByDocId: function() {
            return this.$http.post(window.config.API_PATH + 'users/letter-info');
        },
        getContactType: function(contactTypeId) {
            return this.$http.get(window.config.API_PATH + 'contact-types/' + contactTypeId);
        },
        getContactTypesOfPhysician: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/physician');
        },
        getContact: function(contactId) {
            return this.$http.get(window.config.API_PATH + 'contacts/' + contactId);
        },
        getActiveNonCorporateContactTypes: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/active-non-corporate');
        },
        getActiveQualifiers: function() {
            return this.$http.post(window.config.API_PATH + 'qualifiers/active');
        },
        getPendingVOBsByContactId: function(contactId) {
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'insurance-preauth/pending-VOB', data);
        }
    }
}
