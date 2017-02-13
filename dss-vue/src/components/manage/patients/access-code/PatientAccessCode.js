var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            componentParams   : {
                patientId : 0
            },
            patient           : {},
            isResetAccessCode : false
        }
    },
    mixins: [handlerMixin],
    events: {
        'setting-component-params': function(parameters) {
            this.componentParams = parameters;

            this.getPatientById(this.componentParams.patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('patient', data);

                        var accessCode = data.hasOwnProperty('access_code') && data.access_code > 0;
                        if (!accessCode) {
                            this.resetPinCode(this.componentParams.patientId);
                        }
                    }
                }, function(response) {
                    this.handleErrors('getPatientById', response);
                });

            // this popup doesn't have any input fields - then set the flag to false
            this.$parent.popupEdit = false;
        }
    },
    methods: {
        resetPinCode: function(patientId) {
            patientId = patientId || 0;

            this.resetPatientAccessCode(patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.hasOwnProperty('access_code') && data.access_code > 0) {
                        this.$set('patient.access_code', data.access_code);
                        this.$set('isResetAccessCode', true);
                    }
                }, function(response) {
                    this.handleErrors('resetPatientAccessCode', response);
                });
        },
        onClickReset: function() {
            this.resetPinCode(this.componentParams.patientId);
        },
        onSubmit: function() {
            this.createTempPinDocument(this.componentParams.patientId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data.hasOwnProperty('path_to_pdf') && data.path_to_pdf.length > 0) {
                        alert('Temporary PIN document created and email sent to patient.');
                        window.open(data.path_to_pdf);

                        // pass updated patient to parents
                        this.$parent.updateParentData(this.patient);
                        // close the popup
                        this.$parent.disable();
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
