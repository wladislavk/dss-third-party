var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

module.exports = {
  data () {
    return {
      constants: window.constants,
      currentPatient: {},
      deviceGuideSettingOptions: [],
      deviceGuideResults: [],
      id: 0,
      patientId: 0
    }
  },
  mixins: [handlerMixin],
  watch: {
    '$route.query.id': function () {
      if (this.$route.query.id) {
        this.$set('id', this.$route.query.id)
      } else {
        this.$set('id', 0)
      }
    },
    '$route.query.pid': function () {
      if (this.$route.query.pid) {
        this.$set('patientId', this.$route.query.pid)
      } else {
        this.$set('patientId', 0)
      }
    }
  },
  created () {
    this.getPatientById()
      .then(function (response) {
        var data = response.data.data

        if (data) {
          this.$set('currentPatient', data)
        }
      }, function (response) {
        this.handleErrors('getPatientById', response)
      })

    this.getDeviceGuideSettingOptions()
      .then(function (response) {
        var data = response.data.data

        if (data) {
          data.forEach(function (element) {
            element.labels = element.labels.split(',')
            element.checkedOption = 0

            if (element.setting_type === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
              element.checkedImp = 0
            } else {
              element.checked = 0
            }
          })

          this.$set('deviceGuideSettingOptions', data)
        }
      }, function (response) {
        this.handleErrors('getDeviceGuideSettingOptions', response)
      })
  },
  mounted () {
    window.$('.imp_chk').click(function () {
      if (window.$(this).is(':checked')) {
        if (window.$('.imp_chk:checked').length > 3) {
          window.$(this).prop('checked', false)
        }
      }
    })
  },
  methods: {
    onDeviceSubmit () {
      var data = {
        settings: {}
      }

      this.deviceGuideSettingOptions.forEach(function (element) {
        var settingObj = {}

        if (element.setting_type === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
          settingObj['checked'] = element.checkedOption + 1
        } else {
          settingObj['checked'] = element.checked
        }

        if (element.hasOwnProperty('checkedImp') && element.checkedImp) {
          settingObj['checkedImp'] = element.checkedImp
        }

        data.settings[element.id] = settingObj
      })

      this.getDeviceGuideResults(data)
        .then(function (response) {
          var data = response.data.data

          if (data) {
            this.$set('deviceGuideResults', data)
          }
        }, function (response) {
          this.handleErrors('getDeviceGuideResults', response)
        })
    },
    updateDevice (device, name) {
      if (this.id && this.patientId) {
        if (confirm('Do you want to select ' + name + ' for ' + this.currentPatient.firstname + ' ' + this.currentPatient.lastname)) {
          this.updateFlowDevice(device)
            .then(function (response) {
              var data = response.data.data

              if (data) {
                // parent.updateDentalDevice(valId, device)
                // TODO: need find out what is valId
                parent.updateDentalDevice(0, device)
                parent.disablePopupClean()
              }
            }, function (response) {
              this.handleErrors('updateFlowDevice', response)
            })
        }
      }
    },
    onClickInstructions () {
      window.$('#instructions').show('200')
      window.$('#ins_show').hide()
    },
    onClickHide () {
      window.$('#instructions').hide('200')
      window.$('#ins_show').show()
    },
    onClickReset () {
      this.deviceGuideSettingOptions.forEach((element) => {
        element.checkedOption = 0

        if (element.setting_type === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
          element.checkedImp = 0
        } else {
          element.checked = 0
        }
      })

      this.$set('deviceGuideResults', [])
    },
    getPatientById (patientId) {
      patientId = patientId || 0

      return this.$http.get(window.config.API_PATH + 'patients/' + patientId)
    },
    getDeviceGuideSettingOptions () {
      return this.$http.post(window.config.API_PATH + 'guide-setting-options/settingIds')
    },
    getDeviceGuideResults (data) {
      return this.$http.post(window.config.API_PATH + 'guide-devices/with-images', data)
    },
    updateFlowDevice (device) {
      var data = {
        id: this.id,
        device: device,
        pid: this.patientId
      }

      return this.$http.post(window.config.API_PATH + '', data)
    }
  }
}
