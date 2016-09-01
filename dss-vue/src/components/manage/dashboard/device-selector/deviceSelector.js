var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            currentPatient            : null,
            deviceGuideSettings       : [],
            deviceGuideSettingOptions : []
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

                                    this.deviceGuideSettingOptions[setting.id].rangeStep = (setting.range_end - setting.range_endrange_start) / countSettingOptions;

                                    var labels = data.map((element) => element.label);

                                    this.deviceGuideSettingOptions[setting.id].label = labels.join(',');
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
    methods: {
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