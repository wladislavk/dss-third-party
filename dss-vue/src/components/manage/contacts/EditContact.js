var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            componentParams                : {},
            contactTypesOfPhysician        : '',
            contact                        : {},
            activeNonCorporateContactTypes : [],
            activeQualifiers               : [],
            pendingVOB                     : {},
            contactSentLetters             : [],
            contactPendingLetters          : [],
            message                        : '',
            wasContactDataReceived         : false
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
    watch: {
        pendingVOB: function() {
            if (!this.pendingVOB.length) {
                this.getContactSentLetters(this.contact.contactid)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data.length) {
                            this.$set('contactSentLetters', data);
                        }
                    }, function(response) {
                        this.handleErrors('getContactSentLetters', response);
                    });

                this.getContactPendingLetters(this.contact.contactid)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data.length) {
                            this.$set('contactPendingLetters', data);
                        }
                    }, function(response) {
                        this.handleErrors('getContactPendingLetters', response);
                    });
            }
        },
        'contact': {
            handler: function() {
                if (this.wasContactDataReceived) {
                    this.$parent.$parent.$refs.modal.isEditedPopup(true);
                }
            },
            deep: true
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

                        this.$nextTick(function() {
                            this.wasContactDataReceived = true;
                        });
                    }
                }, function(response) {
                    this.handleErrors('getContactTypesOfPhysician', response);
                });

            this.getPendingVOBsByContactId(this.componentParams.contactId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.length) {
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
        onClickSubmit: function() {
            this.$set('message', '');

            if (this.componentParams.contactId > 0) {
                this.updateContact(this.contact)
                    .then(function(response) {
                        // pass message to parent component
                        this.$parent.passDataToComponents({ message: 'Edited Successfully' });
                        this.$parent.$parent.$refs.modal.isEditedPopup(false);
                        this.$parent.$parent.$refs.modal.disable();
                        this.$route.router.go('/manage/contacts');
                    }, function(response) {
                        if (response.status == 422) {
                            var data = response.data.data;
                            var message = '';

                            for (var key in data.errors) {
                                message += key + ': ' + data.errors[key].join('; ') + "\n";
                            }

                            this.$set('message', message);
                        } else {
                            this.handleErrors('updateContact', response);
                        }
                    });
            } else {
                this.insertContact(this.contact)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.createWelcomeLetter(data.inserted_contact_id, this.contact.contacttypeid)
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        alert(data.message);
                                    }
                                }, function(response) {
                                    this.handleErrors('createWelcomeLetter', response);
                                });

                            if (this.componentParams.activePat != '') {
                                this.$route.router.go({
                                    path: '/add/patient',
                                    query: {
                                        ed       : this.componentParams.activePat,
                                        preview  : 1,
                                        addtopat : 1,
                                        pid      : this.componentParams.activePat
                                    }
                                });
                            } else {
                                this.$parent.passDataToComponents({ message: 'Added Successfully' });
                                this.$route.router.go('/manage/contacts');
                            }

                            this.$parent.$parent.$refs.modal.isEditedPopup(false);
                            this.$parent.$parent.$refs.modal.disable();
                        }
                    }, function(response) {
                        this.handleErrors('insertContact', response);
                    });
            }
        },
        onClickConfirm: function(type, contactId) {
            var message = '';
            var query = {};
            contactId = contactId || 0;

            switch (type) {
                case 'delete-pending-vobs':
                    message = 'Warning! There is currently a patient with this insurance company that has a pending VOB. Deleting this insurance company will cause the VOB to fail. Do you want to proceed?';
                    query = { delid: contactId };
                    break;
                case 'inactive':
                    message = 'Letters have previously been sent to this contact; therefore, for medical record purposes the contact cannot be deleted. This contact now will be marked as INACTIVE in your software and will no longer display in search results. Any pending letters associated with this contact will be deleted.';
                    query = { inactiveid: contactId };
                    break;
                case 'delete':
                    message = 'Do Your Really want to Delete?.';
                    query = { delid: contactId };
                    break;
                case 'delete-pending-letters':
                    message = 'Warning: There are pending letters associated with this contact.  When you delete the contact the pending letters will also be deleted. Proceed?';
                    query = { delid: contactId };
                    break;
                default:
                    break;
            }

            if (confirm(message) && url.length) {
                this.$route.router.go({
                    path  : '/manage/contacts',
                    query : query
                });
            }
        },
        onPreferredContactChange: function() {
            if (this.contact.preferredcontact == 'email' && this.contact.email == '') {
                alert("You must enter an email address to use email as the preferred contact method.");

                this.$set('contact.preferredcontact', '');
                this.$els.email.focus();
            } else if (this.contact.preferredcontact == 'fax' && this.contact.fax == '') {
                alert("You must enter a fax number to use email as the preferred contact method.");

                this.$set('contact.preferredcontact', '');
                this.$els.fax.focus();
            }
        },
        getContactPendingLetters: function(contactId) {
            // gets letters that were not delivered for contact
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'letters/not-delivered-for-contact', data);
        },
        getContactSentLetters: function(contactId) {
            // gets letters that were delivered for contact
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'letters/delivered-for-contact', data);
        },
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
        },
        createWelcomeLetter: function(templateId, contactTypeId) {
            var data = {
                template_id     : templateId,
                contact_type_id : contactTypeId
            };

            return this.$http.post(window.config.API_PATH + 'letters/create-welcome-letter')
        }
    }
}
