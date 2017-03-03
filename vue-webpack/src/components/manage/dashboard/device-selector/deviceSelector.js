var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
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
        this.$set(this, 'id', this.$route.query.id)
      } else {
        this.$set(this, 'id', 0)
      }
    },
    '$route.query.pid': function () {
      if (this.$route.query.pid) {
        this.$set(this, 'patientId', this.$route.query.pid)
      } else {
        this.$set(this, 'patientId', 0)
      }
    }
  },
  created () {
    if (this.patientId > 0) {
      this.getPatientById(this.patientId)
        .then(function (response) {
          var data = response.data.data

          if (data) {
            this.$set(this, 'currentPatient', data)
          }
        }, function (response) {
          this.handleErrors('getPatientById', response)
        })
    }

    this.getDeviceGuideSettingOptions()
      .then(function (response) {
        var data = response.data.data

        if (data) {
          data.forEach(function (element) {
            element.labels = element.labels.split(',')
            element.checkedOption = 0

            if (parseInt(element.setting_type) === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
              element.checkedImp = 0
            } else {
              element.checked = 0
            }
          })

          this.$set(this, 'deviceGuideSettingOptions', data)
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

        if (parseInt(element.setting_type) === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
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
            this.$set(this, 'deviceGuideResults', data)
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

        if (parseInt(element.setting_type) === window.constants.DSS_DEVICE_SETTING_TYPE_RANGE) {
          element.checkedImp = 0
        } else {
          element.checked = 0
        }
      })

      this.$set(this, 'deviceGuideResults', [])
    },
    getPatientById (patientId) {
      patientId = patientId || 0

      return this.$http.get(process.env.API_PATH + 'patients/' + patientId)
    },
    getDeviceGuideSettingOptions () {
      return this.$http.post(process.env.API_PATH + 'guide-setting-options/settingIds')
    },
    getDeviceGuideResults (data) {
      return this.$http.post(process.env.API_PATH + 'guide-devices/with-images', data)
    },
    updateFlowDevice (device) {
      var data = {
        id: this.id,
        device: device,
        pid: this.patientId
      }

      return this.$http.post(process.env.API_PATH + '', data)
    }
  }
}
