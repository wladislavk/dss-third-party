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
            message                   : '',
            eligiblePayerId           : 0,
            eligiblePayerName         : '',
            sendPin                   : ''
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

                this.updatePatientData(this.$route.query.pid);
            } else {
                this.$set('routeParameters.patientId', null);
            }
        }
    },
    computed: {
        showSendingEmails: function() {
            return this.headerInfo.docIdnfo && this.patient.use_patient_portal;
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
        }
    },
    created: function() {
        this.updatePatientData(this.routeParameters.patientId);

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
                this.handleErrors('getDocLocations', response);
            });
    },
    methods: {
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
        updatePatientData: function(patientId) {
            this.getPatientById(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('patient', data);
                    }
                }, function(response) {
                    this.handleErrors('getPatientById', response);
                });

            this.getProfilePhoto(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('profilePhoto', data);
                    }
                }, function(response) {
                    this.handleErrors('getProfilePhoto', response);
                });

            this.getGeneratedDateOfIntroLetter(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('introLetter', data);
                    }
                }, function(response) {
                    this.handleErrors('getGeneratedDateOfIntroLetter', response);
                });

            this.getInsuranceCardImage(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('insuranceCardImage', data);
                    }
                }, function(response) {
                    this.handleErrors('getInsuranceCardImage', response);
                });

            this.getUncompletedHomeSleepTests(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('uncompletedHomeSleepTests', data);
                    }
                }, function(response) {
                    this.handleErrors('getUncompletedHomeSleepTests', response);
                });

            this.findPatientNotifications(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.length) {
                        this.$set('patientNotifications', data);
                    }
                }, function(response) {
                    this.handleErrors('findPatientNotifications', response);
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
        }
    }
}
