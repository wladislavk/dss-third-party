var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            consts: window.constants,
            headerInfo: {
                docInfo : {}
            },
            routeParameters: {
                patientId : this.$route.query.pid > 0 ? this.$route.query.pid : null
            },
            billingCompany: {
                exclusive : 0,
                name      : 'DSS'
            },
            patientNotifications      : [],
            homeSleepTestCompanies    : [],
            patient                   : {},
            profilePhoto              : {},
            insuranceCardImage        : {},
            docLocations              : [],
            insuranceContacts         : [],
            introLetter               : {},
            uncompletedHomeSleepTests : [],
            formedFullNames           : {},
            pendingVob                : {},
            patientLocation           : '',
            message                   : '',
            eligiblePayerId           : 0,
            eligiblePayerName         : '',
            sendPin                   : '',
            showReferredNotes         : false,
            showReferredPerson        : false,
            showReferredbyHints       : false,
            foundContactsByName       : [],
            typingTimer               : null,
            doneTypingInterval        : 600,
            autoCompleteSearchValue   : '',
            eligiblePayerSource       : [],
            eligiblePayers            : []
        }
    },
    mixins: [handlerMixin],
    events: {
        'update-header-info': function(headerInfo) {
            this.headerInfo = headerInfo;
        }
    },
    watch: {
        '$route.query.pid': function() {
            if (this.$route.query.pid > 0) {
                this.$set('routeParameters.patientId', this.$route.query.pid);

                this.fillForm(this.$route.query.pid);
            } else {
                this.$set('routeParameters.patientId', null);
            }
        }
    },
    computed: {
        showSendingEmails: function() {
            return this.headerInfo.docInfo.use_patient_portal && this.patient.use_patient_portal;
        },
        inches: function() {
            var result = [];

            for (var i = 0; i < 12; i++) {
                result.push(i);
            }

            return result;
        },
        weight: function() {
            var result = [];

            for (var i = 80; i <= 500; i++) {
                result.push(i);
            }

            return result;
        },
        buttonText: function() {
            return this.patient.userid > 0 ? 'Save/Update ' : 'Add ';
        },
        portalStatus: function() {
            var status = 'Patient Portal In-active';

            if (this.patient.use_patient_portal == 1) {
                switch (+this.patient.registration_status) {
                    case 0:
                        status = 'Unregistered';
                        break;

                    case 1:
                        status = 'Registration Emailed ' + moment(this.patient.registration_senton, 'MM/DD/YYYY h:m a') + ' ET';
                        break;

                    case 2:
                        status = 'Registered';
                        break;

                    default:
                        status = '';
                        break;
                }
            }

            return status;
        },
        showReferredPerson: function() {
            if (
                this.patient.referred_source == window.constants.DSS_REFERRED_PATIENT ||
                this.patient.referred_source == window.constants.DSS_REFERRED_PHYSICIAN
            ) {
                return true;
            } else {
                return false;
            }
        },
        insCompanyContactInfo: function() {
            var foundCompany = this.insuranceContacts.find((el) => {
                return el.contactid == this.patient.p_m_ins_co;
            });

            if (foundCompany) {
                return foundCompany.add1 + "\n"
                    + (foundCompany.add2 ? foundCompany.add2 + "\n" : '')
                    + foundCompany.city + ' ' + foundCompany.state + ' ' + foundCompany.zip + "\n"
                    + this.phone(foundCompany.phone1);
            } else {
                return '';
            }
        }
    },
    created: function() {
        this.fillForm(this.routeParameters.patientId);

        this.getHomeSleepTestCompanies()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('homeSleepTestCompanies', data);
                }
            }, function(response) {
                this.handleErrors('getHomeSleepTestCompanies', response);
            });

        this.getDocLocations()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('docLocations', data);
                }
            }, function(response) {
                this.handleErrors('getDocLocations', response);
            });

        this.getBillingCompany()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('billingCompany', data);
                }
            }, function(response) {
                this.handleErrors('getBillingCompany', response);
            });

        this.getEligiblePayerSource()
            .then(function(response) {
                var data = response.data.data;

                if (data.length) {
                    data = this.populateEligiblePayerSource(data)
                    this.$set('eligiblePayerSource', data);
                }
            }, function(response) {
                this.handleErrors('getEligiblePayerSource', response);

                this.getStaticEligiblePayerSource()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data.length) {
                            data = this.populateEligiblePayerSource(data)
                            this.$set('eligiblePayerSource', data);
                        }
                    }, function(response) {
                        this.handleErrors('getStaticEligiblePayerSource', response);
                    });
            });

        this.getInsuranceContacts()
            .then(function(response) {
                var data = response.data.data;

                if (data.length) {
                    this.$set('insuranceContacts', data);
                }
            }, function(response) {
                this.handleErrors('getInsuranceContacts', response);
            });
    },
    methods: {
        setEligiblePayer: function(id, name) {
            this.$set('patient.p_m_eligible_payer_id', id);
            this.$set('patient.p_m_eligible_payer_name', name);
            this.$set('formedFullNames.ins_payer_name', id + ' - ' + name);
        },
        searchEligiblePayersByName: function(name) {
            const LIMIT_RECORDS_TO_DISPLAY = 5;
            var partsOfRequiredName = name.toLowerCase().split(' ');
            // the description of it is here: http://stackoverflow.com/a/4389683
            var regRequiredName = new RegExp("(?=.*\\b.*" + partsOfRequiredName.join('.*\\b)(?=.*\\b.*') + ".*\\b).*", 'i');

            var foundPayers = [];
            var recordsToDisplay = 0;
            this.eligiblePayerSource.some((el) => {
                var payerId = el.payer_id.replace(/(\r\n|\n|\r)/gm, '');
                // check unique id
                var foundPayerId = foundPayers.find((el) => {
                    return el.id == payerId;
                });

                if (el.payer_name.toLowerCase().search(regRequiredName) != -1 && !foundPayerId) {
                    foundPayers.push({
                        id   : payerId,
                        name : el.payer_name.replace(/(\r\n|\n|\r)/gm, '')
                    });

                    if (++recordsToDisplay == LIMIT_RECORDS_TO_DISPLAY) {
                        return true;
                    }
                }
            });

            return foundPayers;
        },
        populateEligiblePayerSource: function(source) {
            var data = [];

            source.forEach((el) => {
                if (typeof el['names'] === 'undefined' || el['names'].length === 0) {
                    return;
                }

                el['names'].forEach((name) => {
                    data.push({
                        payer_id: el['payer_id'],
                        payer_name: name,
                        enrollment_required: el['enrollment_required'],
                        enrollment_mandatory_fields: el['enrollment_mandatory_fields']
                    });
                });
            });

            return data;
        },
        onKeyUpSearchEligiblePayers: function() {
            clearTimeout(this.typingTimer);

            var insPayerName = this.formedFullNames.ins_payer_name.trim();

            var self = this;
            this.typingTimer = setTimeout(function() {
                if (insPayerName.length > 1) {
                    if (self.autoCompleteSearchValue != insPayerName) {
                        self.autoCompleteSearchValue = insPayerName;
                        var foundPayers = self.searchEligiblePayersByName(insPayerName);

                        if (foundPayers.length > 0) {
                            self.$set('eligiblePayers', foundPayers);
                        } else {
                            self.$set('eligiblePayers', []);
                            self.$els.insPayerName.focus();

                            alert('Error: No match found for this criteria.');
                        }
                    }
                } else {
                    self.$set('eligiblePayers', []);
                }
            }, this.doneTypingInterval);
        },
        setReferredBy: function(id, referredType) {
            this.$set('patient.referred_by', id);
            this.$set('patient.referred_source', referredType);
        },
        onKeyUpSearchReferrers: function(event) {
            clearTimeout(this.typingTimer);

            var self = this;
            this.typingTimer = setTimeout(function() {
                if (self.formedFullNames.referred_name.trim() != '') {
                    if (self.formedFullNames.referred_name.trim().length > 1) {
                        self.getReferrers(self.formedFullNames.referred_name.trim())
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    self.$set('foundContactsByName', data);
                                    self.$set('showReferredbyHints', true);
                                } else if (data.error) {
                                    self.$set('foundContactsByName', []);
                                    alert(data.error);
                                }
                            }, function(response) {
                                self.handleErrors('getListContactsAndCompanies', response);
                            });
                    } else {
                        self.$set('showReferredbyHints', false);
                    }
                }
            }, this.doneTypingInterval);
        },
        showReferredBy: function(type, referredSource) {
            if (type == 'person') {
                this.$set('showReferredNotes', false);
                this.$set('showReferredPerson', true);
            } else {
                this.$set('showReferredNotes', true);
                this.$set('showReferredPerson', false);
            }
            this.$set('patient.referred_source', referredSource);
        },
        editPatient: function() {
            this.addNewPatient()
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        if (data.is_trigger_letters) {
                            this.triggerLetters1and2()
                                .then(function(response) {
                                    var data = response.data.data;

                                    if (data) {
                                        // TODO
                                    }
                                }, function(response) {
                                    this.handleErrors('triggerLetters1and2', response);
                                });

                            if ($patient['introletter'] == 1) {
                                this.triggerLetter3()
                                    .then(function(response) {
                                        var data = response.data.data;

                                        if (data) {
                                            // TODO
                                        }
                                    }, function(response) {
                                        this.handleErrors('triggerLetter3', response);
                                    });
                            }

                            if (isset($patient['add_ref_but'])) {
                                // redirect to add_referredby.php?addtopat= + $patientId
                            }

                            if (isset($patient['add_ins_but'])) {
                                // redicrect to add_contact.php?ctype=ins<?php if(isset($_GET['pid'])){echo "&pid=".$patientId."&type=11&ctypeeq=1&activePat=".$patientId;} ?>
                            }

                            if (isset($patient['add_contact_but'])) {
                                // redirect to add_patient_to.php?ed=<?= $patientId ?>
                            }

                            if (isset($patient['sendHST'])) {
                                // redirect to hst_request_co.php?ed=<?= $patientId ?>
                            }

                            if (this.sendPin) {
                                this.sendPin = '&sendPin=1';
                            } else {
                                this.sendPin = '';
                            }

                            // redirect in parent window to add_patient.php?ed=<?= $patientId ?>&addtopat=1&pid=<?= $patientId ?>&msg=<?php echo $msg;?><?php echo $sendPin; ?>
                        }
                    }
                }, function(response) {
                    this.handleErrors('addNewPatient', response);
                });
        },
        triggerLetter20: function() {
            var data = {};

            return this.$http.post(window.config.API_PATH + 'letters/trigger-patient-treatment-complete', data);
        },
        triggerLetters1and2: function() {
            var data = {};

            return this.$http.post(window.config.API_PATH + 'letters/trigger-letters-12', data);
        },
        triggerLetter3: function() {
            var data = {};

            return this.$http.post(window.config.API_PATH + 'letters/trigger-letter-3', data);
        },
        getBillingCompany: function() {
            return this.$http.post(window.config.API_PATH + 'companies/billing-exclusive-company');
        },
        updateTrackerNotes: function(patientId, notes) {
            var data = {
                patient_id    : patientId || 0,
                tracker_notes : notes
            };

            return this.$http.post(window.config.API_PATH + 'patient-summaries/update-tracker-notes', data);
        },
        fillForm: function(patientId) {
            this.getDataForFillingPatientForm(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.filterPhoneFields(data.patient);
                        this.filterSsnField(data.patient);

                        this.$set('patient', data.patient);
                        this.$set('profilePhoto', data.profile_photo);
                        this.$set('introLetter', data.intro_letter);
                        this.$set('insuranceCardImage', data.insurance_card_image);
                        this.$set('uncompletedHomeSleepTests', data.uncompleted_home_sleep_test);
                        this.$set('patientNotifications', data.patient_notification);
                        this.$set('formedFullNames', data.formed_full_names);
                        this.$set('pendingVob', data.formed_full_names);
                        this.$set('patientLocation', data.patient_location);
                    }
                }, function(response) {
                    this.handleErrors('getDataForFillingPatientForm', response);
                });
        },
        onChangeRelations: function(type) {
            // need to test this function

            if (this.value != 'Self') {
                return;
            }

            var resultFields = [];
            var sourceFields = [
                this.patient.dob,
                this.patient.firstname,
                this.patient.middlename,
                this.patient.lastname,
                this.patient.gender
            ];

            if (type == 'primary_insurance') {
                resultFields = [
                    'ins_dob', 'p_m_partyfname', 'p_m_partymname', 'p_m_partylname', 'p_m_gender'
                ];
            } else if (type == 'secondary_insurance') {
                resultFields = [
                    'ins2_dob', 's_m_partyfname', 's_m_partymname', 's_m_partylname', 's_m_gender'
                ];
            }

            var self = this;
            resultFields.forEach((el, index) => {
                self.$set('patient.' + el, sourceFields[index]);
            });
        },
        onPreferredContactChange: function() {
            // need to test this function
            if (this.patient.preferredcontact == 'email' && this.patient.email.length == 0) {
                alert("You must enter an email address to use email as the preferred contact method.");

                this.$set('patient.preferredcontact', '');
                this.$els.email.focus();
            } else if (this.patient.preferredcontact == 'fax' && this.patient.fax.length == 0) {
                alert("You must enter a fax number to use email as the preferred contact method.");

                this.$set('patient.preferredcontact', '');
                this.$els.fax.focus();
            }
        },
        filterPhoneFields: function(patient) {
            var fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number'];

            var self = this;
            fields.forEach((el) => {
                patient[el] = self.phone(patient[el]);
            });
        },
        filterSsnField: function(patient) {
            patient.ssn = this.ssn(patient.ssn);
        },
        onChangePhone: function(event) {
            this.$set(
                'patient.' + event.target.name,
                this.phone(this.patient[event.target.name])
            );
        },
        onChangeSsn: function(event) {
            this.$set('ssn', this.ssn(this.patient.ssn));
        },
        phone: function(value) {
            return value.replace(/\D/g, '')
                .replace(/^(\d{3})(\d{3})(\d{4})$/, '($1) $2-$3');
        },
        ssn: function(value) {
            return value.replace(/\D/g, '')
                .replace(/^(\d{3})(\d{2})(\d{4})$/, '$1-$2-$3');
        },
        getUncompletedHomeSleepTests: function(patientId) {
            var data = { patientId: patientId || 0};

            return this.$http.post(window.config.API_PATH + 'home-sleep-tests/uncompleted', data);
        },
        getGeneratedDateOfIntroLetter: function(patientId) {
            var data = { patient_id: patientId || 0};

            return this.$http.post(window.config.API_PATH + 'letters/gen-date-of-intro', data);
        },
        getDocLocations: function() {
            return this.$http.post(window.config.API_PATH + 'locations/by-doctor');
        },
        getProfilePhoto: function(patientId) {
            var data = { patient_id: patientId || 0};

            return this.$http.post(window.config.API_PATH + 'profile-images/photo', data);
        },
        getInsuranceCardImage: function(patientId) {
            var data = { patient_id: patientId || 0 };

            return this.$http.post(window.config.API_PATH + 'profile-images/insurance-card-image', data);
        },
        getHomeSleepTestCompanies: function() {
            return this.$http.post(window.config.API_PATH + 'companies/home-sleep-test');
        },
        getPatientById: function(patientId) {
            patientId = patientId || 0;

            return this.$http.get(window.config.API_PATH + 'patients/' + patientId);
        },
        findPatientNotifications: function(patientId) {
            var data = {
                where: {
                    patientid : patientId || 0,
                    status : 1
                }
            };

            return this.$http.post(window.config.API_PATH + 'notifications/with-filter', data);
        },
        addNewPatient: function() {
            var data = {};

            return this.$http.post(window.config.API_PATH + 'patients/add-new-patient', data);
        },
        getDataForFillingPatientForm: function(patientId) {
            var data = { 'patient_id': patientId || 0 }

            return this.$http.post(window.config.API_PATH + 'patients/filling-form', data);
        },
        getReferrers: function(requestedName) {
            var data = { partial_name: requestedName };

            return this.$http.post(window.config.API_PATH + 'patients/referrers', data);
        },
        getEligiblePayerSource: function() {
            return this.$http.get('https://eligibleapi.com/resources/payers/claims/medical.json');
        },
        getStaticEligiblePayerSource: function() {
            return this.$http.get(window.config.API_PATH + 'eligible/payers');
        },
        getInsuranceContacts: function() {
            return this.$http.post(window.config.API_PATH + 'contacts/insurance');
        }
    }
}
