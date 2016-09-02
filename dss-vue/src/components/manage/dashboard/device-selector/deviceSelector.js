var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            constants                 : window.constants,
            currentPatient            : {},
            deviceGuideSettings       : [],
            deviceGuideSettingOptions : {}
        }
    },
    mixins: [handlerMixin],
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

        this.getDeviceGuideSettings()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('deviceGuideSettings', data);

                    data.forEach((setting) => {
                        this.getDeviceGuideSettingOptions(setting.id)
                            .then(function(response) {
                                var data = response.data.data;

                                if (data) {
                                    var countSettingOptions = data.length != 1 ? data.length - 1 : 1;
                                    var labels = data.map((element) => element.label);

                                    this.deviceGuideSettingOptions[setting.id] = {
                                        rangeStep : (setting.range_end - setting.range_start) / countSettingOptions,
                                        label     : labels.join(',')
                                    };

                                    setSlider(
                                        this.deviceGuideSettingOptions[setting.id].label,
                                        this.setting.id,
                                        this.setting.range_start,
                                        this.setting.range_end,
                                        this.deviceGuideSettingOptions[setting.id].rangeStep
                                    );
                                }
                            }, function(response) {
                                this.handleErrors('getDeviceGuideSettingOptions', response);
                            });
                    });
                }
            }, function(response) {
                this.handleErrors('getDeviceGuideSettings', response);
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
            
        },
        getPatientById: function(patientId) {
            patientId = patientId || 0;

            return this.$http.get(window.config.API_PATH + 'patients/' + patientId);
        },
        getDeviceGuideSettings: function() {
            var data = {
                order: 'rank'
            };

            return this.$http.post(window.config.API_PATH + 'guide-settings/sort', data);
        },
        getDeviceGuideSettingOptions: function(settingId)
        {
            var data = {
                where : {
                    setting_id: settingId
                },
                order : 'option_id'
            };

            return this.$http.post(window.config.API_PATH + 'guide-setting-options/filter', data);
        }
    }
}