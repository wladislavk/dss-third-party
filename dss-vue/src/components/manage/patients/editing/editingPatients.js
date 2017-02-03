var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');
var patientValidator = require('../../../../modules/validators/PatientMixin.js');

module.exports = {
    data: function() {
        return {
            consts: window.constants,
            headerInfo: {
                docInfo                    : {},
                patientName                : '',
                patientHomeSleepTestStatus : ''
            },
            routeParameters: {
                patientId : this.$route.query.pid > 0 ? this.$route.query.pid : null
            },
            billingCompany: {
                exclusive : 0,
                name      : 'DSS'
            },
            pressedButtons : {
                send_pin_code : false,
                send_hst      : false
            },
            requestedEmails : {
                registration : false,
                reminder     : false
            },
            componentParams            : {},
            patientNotifications       : [],
            homeSleepTestCompanies     : [],
            patient                    : {},
            profilePhoto               : null,
            insuranceCardImage         : {},
            docLocations               : [],
            insuranceContacts          : [],
            introLetter                : {},
            uncompletedHomeSleepTests  : [],
            formedFullNames            : {},
            pendingVob                 : {},
            patientLocation            : '',
            message                    : '',
            eligiblePayerId            : 0,
            eligiblePayerName          : '',
            sendPin                    : '',
            showReferredNotes          : false,
            showReferredPerson         : false,
            showReferredbyHints        : false,
            isReferredByChanged        : false,
            isInsuranceInfoChanged     : false,
            foundReferrersByName       : [],
            foundPrimaryCareMdByName   : [],
            foundEntByName             : [],
            foundSleepMdByName         : [],
            foundDentistContactsByName : [],
            foundOtherMdByName         : [],
            foundOtherMd2ByName        : [],
            foundOtherMd3ByName        : [],
            typingTimer                : null,
            doneTypingInterval         : 600,
            autoCompleteSearchValue    : '',
            eligiblePayerSource        : [],
            eligiblePayers             : [],
            secondaryEligiblePayers    : []
        }
    },
    mixins: [handlerMixin, patientValidator],
    events: {
        'update-header-info': function(headerInfo) {
            this.headerInfo = headerInfo;
        },
        'setting-component-params': function(parameters) {
            this.componentParams = parameters;
        }
    },
    watch: {
        '$route.query.pid': function() {
            if (this.$route.query.pid > 0) {
                this.$set('routeParameters.patientId', this.$route.query.pid);

                // if patient data need to be updated - check local storage, it may contain status message about created patient
                var message = window.storage.get('message');
                if (message && message.length > 0) {
                    this.$set('message', message);
                    window.storage.remove('message');
                }

                this.fillForm(this.$route.query.pid);
            } else {
                this.$set('routeParameters.patientId', null);
                this.cleanPatientData();
            }
        },
        'patient.home_phone': function() {
            this.$set('patient.home_phone', this.phone(this.patient.home_phone));
        },
        'patient.cell_phone': function() {
            this.$set('patient.cell_phone', this.phone(this.patient.cell_phone));
        },
        'patient.work_phone': function() {
            this.$set('patient.work_phone', this.phone(this.patient.work_phone));
        },
        'patient.emergency_number': function() {
            this.$set('patient.emergency_number', this.phone(this.patient.emergency_number));
        },
        'patient.ssn': function() {
            this.$set('patient.ssn', this.ssn(this.patient.ssn));
        },
        'patient.dob': function() {
            this.$set('patient.dob', this.date(this.patient.dob));
        },
        'patient.feet': function() {
            this.calculateBmi();
        },
        'patient.inches': function() {
            this.calculateBmi();
        },
        'patient.weight': function() {
            this.calculateBmi();
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
                        status = 'Registration Emailed ' + moment(this.patient.registration_senton).format('MM/DD/YYYY hh:mm a') + ' ET';
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
        },
        secondaryInsCompanyContactInfo: function() {
            var foundCompany = this.insuranceContacts.find((el) => {
                return el.contactid == this.patient.s_m_ins_co;
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
        this.$dispatch('get-header-info');

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
        onClickCreateNewContact: function() {
            // TODO: implement displaying the popup for creating a new contact
            // loadPopupRefer('add_contact.php?addtopat={{ routeParameters.patientId }}&from=add_patient');
        },
        validateDate: function(el) {
            if (!this.isValidDate(this.patient[el])) {
                alert('Invalid Day, Month, or Year range detected. Please correct.');
                this.$els[el].focus();
            }
        },
        calculateBmi: function() {
            if (this.patient.feet != 0 && this.patient.inches != -1 && this.patient.weight != 0) {
                var inc = (this.patient.feet * 12) + this.patient.inches;
                var incSqr = inc * inc;

                var wei = this.patient.weight * 703;
                var bmi = wei / incSqr;

                this.$set('patient.bmi', bmi.toFixed(1));
            } else {
                this.$set('patient.bmi', '');
            }
        },
        onClickAddImage: function() {
            // TODO: implement it when certain popup is finished

            // loadPopup('add_image.php?pid=<?= $patientId ?>&sh=<?php echo (isset($_GET['sh']))?$_GET['sh']:'';?>&it=4&return=patinfo&return_field=profile');
        },
        onClickOrderHst: function() {
            alert('Patient has existing HST with status '
                + this.headerInfo.patientHomeSleepTestStatus
                + '. Only one HST can be requested at a time.'
            );
        },
        searchItemById: function(data, id) {
            id = id || 0;
            var removeId = data.findIndex((el) => el.id == id);

            return removeId >= 0 ? data[removeId] : null;
        },
        removeNotification: function(id) {
            this.removeNotificationInDb(id)
                .then(function(response) {
                    this.patientNotifications.$remove(
                        this.searchItemById(this.patientNotifications, id)
                    );
                }, function(response) {
                    this.handleErrors('removeNotificationInDb', response);
                });
        },
        onClickCreatingNewInsuranceCompany: function(fromId) {
            // TODO: implement loading a popup for creating new insurance company

            // loadPopupRefer('add_contact.php?from=add_patient&from_id= + fromId + &ctype=ins{{ routeParameters.patientId ? '&pid=' + routeParameters.patientId + '&type=11&ctypeeq=1&activePat=' + routeParameters.patientId }}');
        },
        handleChangingInsuranceInfo: function() {
            this.isInsuranceInfoChanged = true;
        },
        parseFailedResponseOnEditingPatient: function(data) {
            var errors = data.errors.shift();

            if (errors != undefined) {
                var objKeys = Object.keys(errors);

                var arrOfMessages = objKeys.map((el) => {
                    return el + ':' + errors[el].join('|').toLowerCase();
                });

                // TODO: create more readable format
                alert(arrOfMessages.join("\n"));
            }
        },
        parseSuccessfulResponseOnEditingPatient: function(data) {
            if (data.hasOwnProperty('redirect_to') && data.redirect_to.length > 0) {
                this.$route.router.go(data.redirect_to);
            }

            if (data.hasOwnProperty('created_patient_id') && data.created_patient_id > 0) {
                window.storage.save('message', data.status);
                this.$route.router.go(this.$route.path + '?pid=' + data.created_patient_id);
            }

            if (data.hasOwnProperty('status') && data.status.length > 0) {
                this.$set('message', data.status);
            }

            if (data.hasOwnProperty('mails')) {
                var mails = data.mails;

                mails.forEach((el) => {
                    if (mails[el] && mails[el].length > 0) {
                        alert(mails[el]);
                    }
                });
            }

            this.fillForm(this.routeParameters.patientId);
        },
        submitAddingOrEditingPatient: function() {
            if (this.validatePatientData(this.patient, null, this.formedFullNames.referred_name)) {
                this.checkEmail(this.patient.email, this.routeParameters.patientId)
                    .then(function(response) {
                        var data = response.data.data;

                        var isReadyForProcessing = false;
                        if (data.confirm_message.length > 0) {
                            isReadyForProcessing = confirm(data.confirm_message);
                        } else {
                            isReadyForProcessing = true;
                        }

                        if (isReadyForProcessing) {
                            this.editPatient(this.routeParameters.patientId, this.patient, this.formedFullNames)
                                .then(function(response) {
                                    this.parseSuccessfulResponseOnEditingPatient(response.data.data);
                                }, function(response) {
                                    this.parseFailedResponseOnEditingPatient(response.data.data)

                                    this.handleErrors('getInsuranceContacts', response);
                                });
                        }
                    }, function(response) {
                        alert(response.data.message);
                        this.handleErrors('checkEmail', response);
                    });
            }
        },
        submitSendingPinCode: function() {
            if (this.validatePatientData(this.patient)) {
                this.pressedButtons.send_pin_code = true;

                this.editPatient(
                    this.routeParameters.patientId,
                    this.patient,
                    this.formedFullNames,
                    this.pressedButtons
                ).then(function(response) {
                    this.parseSuccessfulResponseOnEditingPatient(response.data.data);
                }, function(response) {
                    this.parseFailedResponseOnEditingPatient(response.data.data);

                    this.handleErrors('editPatient', response);
                });
            }
        },
        submitSendingRegistrationEmail: function() {
            this.requestedEmails.registration = true;

            if (this.validatePatientData(this.patient, this.requestedEmails)) {
                this.editPatient(
                    this.routeParameters.patientId,
                    this.patient,
                    this.formedFullNames,
                    null,
                    this.requestedEmails
                ).then(function(response) {
                    this.parseSuccessfulResponseOnEditingPatient(response.data.data);
                }, function(response) {
                    this.parseFailedResponseOnEditingPatient(response.data.data);

                    this.handleErrors('editPatient', response);
                });
            }
        },
        submitSendingReminderEmail: function() {
            this.requestedEmails.reminder = true;

            if (this.validatePatientData(this.patient, this.requestedEmails)) {
                this.editPatient(
                    this.routeParameters.patientId,
                    this.patient,
                    this.formedFullNames,
                    null,
                    this.requestedEmails
                );
            }
        },
        submitSendingHst: function() {
            if (
                confirm(
                    'Click OK to initiate a Home Sleep Test request. \
                    The HST request must be electronically signed by an authorized \
                    provider before it can be transmitted. You can view and save/update \
                    the request on the next screen.'
                ) && this.validatePatientData(this.patient)
            ) {
                this.pressedButtons.send_hst = true;

                this.editPatient(
                    this.routeParameters.patientId,
                    this.patient,
                    this.formedFullNames,
                    this.pressedButtons
                );
            }
        },
        setContact: function(type, id) {
            this.$set('patient.' + type, id);
        },
        onKeyUpSearchContacts: function(type) {
            clearTimeout(this.typingTimer);

            var requiredName = this.formedFullNames[type + '_name'].trim();
            var arrName = '';
            switch (type) {
                case 'docpcp':
                    arrName = 'foundPrimaryCareMdByName';
                    break;
                case 'docent':
                    arrName = 'foundEntByName';
                    break;
                case 'docsleep':
                    arrName = 'foundSleepMdByName';
                    break;
                case 'docdentist':
                    arrName = 'foundDentistContactsByName';
                    break;
                case 'docmdother':
                    arrName = 'foundOtherMdByName';
                    break;
                case 'docmdother2':
                    arrName = 'foundOtherMd2ByName';
                    break;
                case 'docmdother3':
                    arrName = 'foundOtherMd3ByName';
                    break;
                default:
                    break;
            }

            var self = this;
            this.typingTimer = setTimeout(function() {
                if (requiredName.length > 1) {
                    if (self.autoCompleteSearchValue != requiredName) {
                        self.autoCompleteSearchValue = requiredName;

                        self.getListContactsAndCompanies(requiredName)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data.length) {
                                    self.$set(arrName, data);
                                } else if (data.error) {
                                    self.$set(arrName, []);
                                    alert(data.error);
                                }
                            }, function(response) {
                                self.handleErrors('getListContactsAndCompanies', response);
                            });
                    }
                } else {
                    self.$set(arrName, []);
                }
            }, this.doneTypingInterval);
        },
        setEligiblePayer: function(id, name, type) {
            var idField, nameField, fullNameField;

            if (type == 'primary') {
                idField = 'p_m_eligible_payer_id';
                nameField = 'p_m_eligible_payer_name';
                fullNameField = 'ins_payer_name';
            } else {
                idField = 's_m_eligible_payer_id';
                nameField = 's_m_eligible_payer_name';
                fullNameField = 's_m_ins_payer_name';
            }

            this.$set('patient.' + idField, id);
            this.$set('patient.' + nameField, name);
            this.$set('formedFullNames.' + fullNameField, id + ' - ' + name);
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
        onKeyUpSearchEligiblePayers: function(type) {
            clearTimeout(this.typingTimer);

            var insPayerName, arrName, elementName;

            if (type == 'primary') {
                insPayerName = this.formedFullNames.ins_payer_name.trim();
                arrName = 'eligiblePayers';
                elementName = 'insPayerName';
            } else {
                insPayerName = this.formedFullNames.s_m_ins_payer_name.trim();
                arrName = 'secondaryEligiblePayers';
                elementName = 'secondaryInsPayerName';
            }

            var self = this;
            this.typingTimer = setTimeout(function() {
                if (insPayerName.length > 1) {
                    if (self.autoCompleteSearchValue != insPayerName) {
                        self.autoCompleteSearchValue = insPayerName;
                        var foundPayers = self.searchEligiblePayersByName(insPayerName);

                        if (foundPayers.length > 0) {
                            self.$set(arrName, foundPayers);
                        } else {
                            self.$set(arrName, []);
                            self.$els[elementName].focus();

                            alert('Error: No match found for this criteria.');
                        }
                    }
                } else {
                    self.$set(arrName, []);
                }
            }, this.doneTypingInterval);
        },
        setReferredBy: function(id, referredType) {
            if (this.patient.referred_by != id || this.patient.referred_source != referredType) {
                this.isReferredByChanged = true;
            }

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
                                    self.$set('foundReferrersByName', data);
                                    self.$set('showReferredbyHints', true);
                                } else if (data.error) {
                                    self.$set('foundReferrersByName', []);
                                    alert(data.error);
                                }
                            }, function(response) {
                                self.handleErrors('getReferrers', response);
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
        cleanPatientData: function() {
            var patient = {};

            this.setDefaultValues(patient);

            this.$set('patient', patient);
            this.$set('profilePhoto', null);
            this.$set('introLetter', {});
            this.$set('insuranceCardImage', {});
            this.$set('uncompletedHomeSleepTests', []);
            this.$set('patientNotifications', []);
            this.$set('formedFullNames', {});
            this.$set('pendingVob', {});
            this.$set('patientLocation', '');

            // update patient name in the header
            this.$dispatch('update-from-child', { patientName: '' });
        },
        fillForm: function(patientId) {
            this.getDataForFillingPatientForm(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.length != 0) {
                        this.filterPhoneFields(data.patient);
                        this.filterSsnField(data.patient);
                        this.setDefaultValues(data.patient);

                        this.$set('patient', data.patient);
                        this.$set('profilePhoto', data.profile_photo);
                        this.$set('introLetter', data.intro_letter);
                        this.$set('insuranceCardImage', data.insurance_card_image);
                        this.$set('uncompletedHomeSleepTests', data.uncompleted_home_sleep_test);
                        this.$set('patientNotifications', data.patient_notification);
                        this.$set('formedFullNames', data.formed_full_names);
                        this.$set('pendingVob', data.pending_vob);
                        this.$set('patientLocation', data.patient_location);

                        // update patient name in the header
                        this.$dispatch('update-from-child', {
                            patientName: data.patient.firstname + ' ' + data.patient.lastname
                        });
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
        setDefaultValues: function(patient) {
            var values = {
                copyreqdate      : moment().format('DD/MM/YYYY'),
                salutation       : 'Mr.',
                preferredcontact : 'paper',
                display_alert    : 0,
                p_m_same_address : 1,
                has_s_m_ins      : 'No'
            };

            var fields = Object.keys(values);

            fields.forEach((el) => {
                if (!patient[el]) {
                    patient[el] = values[el];
                }
            });
        },
        phone: function(value) {
            value = value || '';
            return value.replace(/\D/g, '')
                .replace(/^(\d{3})(\d{3})(\d{4})$/, '($1) $2-$3');
        },
        ssn: function(value) {
            value = value || '';
            return value.replace(/\D/g, '')
                .replace(/^(\d{3})(\d{2})(\d{4})$/, '$1-$2-$3');
        },
        date: function(value) {
            value = value || '';
            return value.replace(/\D/g, '')
                .replace(/^(\d{2})(\d{2})(\d{4})$/, '$1/$2/$3');
        },
        number: function(value) {
            value = value || '';
            return value.replace(/\D/g, '');
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
        },
        getListContactsAndCompanies: function(requestedName) {
            var data = {
                partial_name      : requestedName,
                without_companies : true
            };

            return this.$http.post(window.config.API_PATH + 'contacts/list-contacts-and-companies', data);
        },
        editPatient: function(
            patientId,
            patientFormData,
            formedFullNames,
            pressedButtons,
            requestedEmails,
            trackerNotes
        ) {
            patientId = patientId || 0;
            patientFormData = Object.assign(patientFormData, {
                location: this.patientLocation
            });

            var fields = ['home_phone', 'cell_phone', 'work_phone', 'emergency_number', 'ssn'];

            var self = this;
            fields.forEach((el) => {
                patientFormData[el] = self.number(patientFormData[el]);
            });

            var data = {
                patient_form_data  : patientFormData,
                pressed_buttons    : pressedButtons ? pressedButtons : undefined,
                requested_emails   : requestedEmails ? requestedEmails : undefined,
                tracker_notes      : trackerNotes ? trackerNotes : undefined
            };

            return this.$http.post(window.config.API_PATH + 'patients/edit/' + patientId, data);
        },
        checkEmail: function(email, patientId) {
            var data = { email: email || '', patient_id: patientId || 0 };

            return this.$http.post(window.config.API_PATH + 'patients/check-email', data);
        },
        removeNotificationInDb: function(id) {
            id = id || 0;
            var data = { status: 2 };

            return this.$http.put(window.config.API_PATH + 'notifications/' + id, data);
        }
    }
}
