var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            headerInfo             : {},
            patientNotifications   : [],
            homeSleepTestCompanies : [],
            patient                : {},
            profilePhoto           : {},
            insuranceCardImage     : {},
            docLocations           : [],
            insuranceContacts      : [],
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

        this.getPatientById(0)
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
                    this.$set('getHomeSleepTestCompanies', data);
                }
            }, function(response) {
                this.handleErrors('getHomeSleepTestCompanies', response);
            });

            this.getProfilePhoto()
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
    },
    methods: {
        getDocLocations: function() {
            return this.$http.get(window.config.API_PATH + '');
        },
        getProfilePhoto: function() {
            return this.$http.get(window.config.API_PATH + '');
        },
        getHomeSleepTestCompanies: function() {
            return this.$http.get(window.config.API_PATH + '');
        },
        getPatientById: function() {
            return this.$http.get(window.config.API_PATH + '');
        },
        findPatientNotifications: function() {
            return this.$http.post(window.config.API_PATH + '');
        }
    }
}
