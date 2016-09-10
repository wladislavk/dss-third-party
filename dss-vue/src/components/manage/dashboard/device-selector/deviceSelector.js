var handlerMixin = require('../../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            constants                 : window.constants,
            currentPatient            : {},
            deviceGuideSettingOptions : [],
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
                        element.labels = element.labels.split(',');
                        element.checkedOption = 0;
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
            var data = $('#device_form').serialize();

            this.getDeviceGuideResults(data)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        $('#results li').remove();
                        data.forEach(function(element){
                            if(element.image_path != ''){
                                $('#results').append("<li class='box_go'><div class='ico'><img src='" + element.image_path + "' /></div><a href='#' onclick=\"updateDevice(" + element.id + ", '" + element.name + "');return false();\">" + element['name'] + " (" + element.value + ")</a></li>");
                            } else {
                                $('#results').append("<li><a href='#' onclick=\"updateDevice(" + element.id + ", '" + element.name + "');return false();\">" + element['name'] + " (" + v.value + ")</a></li>");
                            }
                        });
                    }
                }, function(response) {
                    this.handleErrors('getDeviceGuideResults', response);
                });
        },
        resetForm: function() {
            $(".setting").each(function(){
                $(this).find(".slider").slider("value", $(this).find(".slider").slider("option", "min") );
                $(this).find(".label").html( $(this).find('.label').attr('data-init'));
                $(this).find(".imp_chk").prop("checked", false);
            });

            $('#results li').remove();
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