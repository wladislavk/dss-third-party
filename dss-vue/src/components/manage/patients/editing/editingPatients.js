var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            consts: window.constants,
            headerInfo             : {
                docInfo: {}
            },
            routeParameters: {
                patientId : this.$route.query.pid > 0 ? this.$route.query.pid : null
            },
            patientNotifications   : [],
            homeSleepTestCompanies : [],
            patient                : {},
            profilePhoto           : {},
            insuranceCardImage     : {},
            docLocations           : [],
            insuranceContacts      : [],
            introLetter            : {},
            message                : '',
            eligiblePayerId        : 0,
            eligiblePayerName      : '',
            exclusiveBilling       : false,
            billingCompany         : ''
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

                this.getPatientById(this.$route.query.pid)
                    .then(function(response) {
                        var data = response.data.data;

                        if (data) {
                            this.$set('patient', data);
                        }
                    }, function(response) {
                        this.handleErrors('findPatientNotifications', response);
                    });
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
        }
    },
    created: function() {
        this.findPatientNotifications()
            .then(function(response) {
                var data = response.data.data;

                if (data.length) {
                    this.$set('patientNotifications', data);
                }
            }, function(response) {
                this.handleErrors('findPatientNotifications', response);
            });

        this.getPatientById(this.routeParameters.patientId)
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('patient', data);
                }
            }, function(response) {
                this.handleErrors('getPatientById', response);
            });

        this.getHomeSleepTestCompanies()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('homeSleepTestCompanies', data);
                }
            }, function(response) {
                this.handleErrors('getHomeSleepTestCompanies', response);
            });

            this.getProfilePhoto(this.routeParameters.patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('profilePhoto', data);
                    }
                }, function(response) {
                    this.handleErrors('getProfilePhoto', response);
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

            this.getGeneratedDateOfIntroLetter(this.routeParameters.patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('introLetter', data);
                    }
                }, function(response) {
                    this.handleErrors('getGeneratedDateOfIntroLetter', response);
                });
    },
    methods: {
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
        getGeneratedDateOfIntroLetter: function(patientId) {
            var data = { patient_id: patientId };

            return this.$http.post(window.config.API_PATH + 'letters/gen-date-of-intro', data);
        },
        getDocLocations: function() {
            return this.$http.post(window.config.API_PATH + 'locations/by-doctor');
        },
        getProfilePhoto: function(patientId) {
            var data = { patient_id: patientId };

            return this.$http.post(window.config.API_PATH + 'profile-images/photo', data);
        },
        getHomeSleepTestCompanies: function() {
            return this.$http.get(window.config.API_PATH + '');
        },
        getPatientById: function(patientId) {
            return this.$http.get(window.config.API_PATH + 'patients/' + patientId);
        },
        findPatientNotifications: function() {
            return this.$http.post(window.config.API_PATH + '');
        }
    }
}
