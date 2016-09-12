var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            constants                 : window.constants,
            currentPatient            : {},
            deviceGuideSettingOptions : [],
            deviceGuideResults        : [],
            id                        : 0,
            patientId                 : 0
        }
    },
    mixins: [handlerMixin],
    watch: {
        '$route.query.id': function() {
            if ($route.query.id) {
                this.$set('id', $route.query.id);
            } else {
                this.$set('id', 0);
            }
        },
        '$route.query.pid': function() {
            if ($route.query.pid) {
                this.$set('patientId', $route.query.pid);
            } else {
                this.$set('patientId', 0);
            }
        }
    },
    created: function() {
        this.getPatientById()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('currentPatient', data);
                }
            }, function(response) {
                this.handleErrors('getPatientById', response);
            });

        this.getDeviceGuideSettingOptions()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    data.forEach(function(element) {
                        element.labels        = element.labels.split(',');
                        element.checkedOption = 0;
                        
                        if (element.setting_type == constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
                            element.checkedImp = false;
                            element.checked    = true;
                        } else {
                            element.checked = false;
                        }
                    });

                    this.$set('deviceGuideSettingOptions', data);
                }
            }, function(response) {
                this.handleErrors('getDeviceGuideSettingOptions', response);
            });
    },
    ready: function() {
        $('.imp_chk').click( function(){
            if($(this).is(':checked')){
                if($('.imp_chk:checked').length > 3){
                  $(this).prop("checked", false);
                }
            }
        });
    },
    methods: {
        onDeviceSubmit: function() {
            var data = {
                settings: {}
            };

            this.deviceGuideSettingOptions.forEach(function(element) {
                var settingObj = {
                    checked: element.checked
                };

                if (element.hasOwnProperty('checkedImp') && element.checkedImp) {
                    settingObj['checkedImp'] = element.checkedImp;
                }

                data.settings[element.id] = settingObj;
            });

            this.getDeviceGuideResults(data)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('deviceGuideResults', data);
                    }
                }, function(response) {
                    this.handleErrors('getDeviceGuideResults', response);
                });
        },
        updateDevice: function(device, name) {
            if (this.id && this.patientId) {
                if (confirm("Do you want to select " + name + " for " + currentPatient.firstname + " " + currentPatient.lastname)) {
                    this.updateFlowDevice(device)
                        .then(function(response) {
                            var data = response.data.data;

                            if (data) {
                                parent.updateDentalDevice(valId, device)
                                parent.disablePopupClean();
                            }
                        }, function(response) {
                            this.handleErrors('updateFlowDevice', response);
                        });
                }
            }
        },
        onClickInstructions: function() {
            $('#instructions').show('200');
            $('#ins_show').hide();
        },
        onClickHide: function() {
            $('#instructions').hide('200');
            $('#ins_show').show();
        },
        onClickReset: function() {
            this.deviceGuideSettingOptions.forEach((element) => {
                element.checkedOption = 0;
            });

            $(".setting").each(function(){
                $(this).find(".imp_chk").prop("checked", false);
            });

            this.$set('deviceGuideResults', []);
        },
        getPatientById: function(patientId) {
            patientId = patientId || 0;

            return this.$http.get(window.config.API_PATH + 'patients/' + patientId);
        },
        getDeviceGuideSettingOptions: function() {
            return this.$http.post(window.config.API_PATH + 'guide-setting-options/settingIds');
        },
        getDeviceGuideResults: function(data) {
            return this.$http.post(window.config.API_PATH + 'guide-devices/with-images', data);
        },
        updateFlowDevice: function(device) {
            var data = {
                id     : this.id,
                device : device,
                pid    : this.patientId
            };

            return this.$http.post(window.config.API_PATH + '', data);
        }
    }
}