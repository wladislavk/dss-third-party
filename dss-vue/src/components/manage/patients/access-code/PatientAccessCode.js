var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            patient           : {},
            isResetAccessCode : false,
            reset             : false,
            isSubmit          : false,
            pathToPdf         : ''
        }
    },
    mixins: [handlerMixin],
    computed: {
        isResetAccessCode: function() {
            var accessCode = this.patient.hasOwnProperty('access_code') && this.patient.access_code.length > 0;
            return accessCode || this.reset && !this.isSubmit;
        }
    },
    watch: {
        'isResetAccessCode': function() {
            if (this.isResetAccessCode) {
                this.resetPatientAccessCode()
                    .then(function(response) {
                        var data = response.data.data;

                        if (data.hasOwnProperty('access_code') && data.access_code.length > 0) {
                            this.$set('patient.access_code', data.access_code); 
                        }
                    }, function(response) {
                        this.handleErrors('resetPatientAccessCode', response);
                    });
            }
        }
    },
    created: function() {
        this.getPatientById()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('patient', data);
                }
            }, function(response) {
                this.handleErrors('getPatientById', response);
            });
    },
    methods: {
        onSubmit: function() {
            this.createTempPinDocument()
                .then(function(response) {
                    var data = response.data.data;

                    if (data.hasOwnProperty('path_to_pdf') && data.path_to_pdf.length > 0) {
                        this.$set('pathToPdf', data.path_to_pdf);
                    }
                }, function(response) {
                    this.handleErrors('createTempPinDocument', response);
                })
        },
        getPatientById: function(patientId) {
            patientId = patientId || 0;

            return this.$http.get(window.config.API_PATH + 'patients/' + patientId);
        },
        resetPatientAccessCode: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'patients/reset-access-code/' + patientId);
        },
        createTempPinDocument: function(patientId) {
            patientId = patientId || 0;

            return this.$http.post(window.config.API_PATH + 'patients/temp-pin-document/' + patientId);
        }
    }
}
