import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import alerter from '../../../services/alerter'

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
  watch: {
    '$route.query.id': function () {
      if (this.$route.query.id) {
        this.id = this.$route.query.id
      } else {
        this.id = 0
      }
    },
    '$route.query.pid': function () {
      if (this.$route.query.pid) {
        this.patientId = this.$route.query.pid
      } else {
        this.patientId = 0
      }
    }
  },
  created () {
    if (this.patientId > 0) {
      this.getPatientById(this.patientId).then((response) => {
        const data = response.data.data

        if (data) {
          this.currentPatient = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getPatientById', response: response})
      })
    }

    http.post(endpoints.guideSettingOptions.settingIds).then((response) => {
      const data = response.data.data

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

        this.deviceGuideSettingOptions = data
      }
    }).catch((response) => {
      this.$store.dispatch(symbols.actions.handleErrors, {title: 'getDeviceGuideSettingOptions', response: response})
    })
  },
  mounted () {
    window.$('.imp_chk').click(function () {
      // @todo: what does "this" refer to?
      if (window.$(this).is(':checked')) {
        if (window.$('.imp_chk:checked').length > 3) {
          window.$(this).prop('checked', false)
        }
      }
    })
  },
  methods: {
    onDeviceSubmit () {
      const data = {
        settings: {}
      }

      this.deviceGuideSettingOptions.forEach((element) => {
        const settingObj = {}

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

      this.getDeviceGuideResults(data).then((response) => {
        const data = response.data.data

        if (data) {
          this.deviceGuideResults = data
        }
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'getDeviceGuideResults', response: response})
      })
    },
    updateDevice (device, name) {
      if (this.id && this.patientId) {
        const confirmText = 'Do you want to select ' + name + ' for ' + this.currentPatient.firstname + ' ' + this.currentPatient.lastname
        if (alerter.isConfirmed(confirmText)) {
          this.updateFlowDevice(device).then((response) => {
            const data = response.data.data

            if (data) {
              // parent.updateDentalDevice(valId, device)
              // TODO: need find out what is valId
              parent.updateDentalDevice(0, device)
              parent.disablePopupClean()
            }
          }).catch((response) => {
            this.$store.dispatch(symbols.actions.handleErrors, {title: 'updateFlowDevice', response: response})
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

      this.deviceGuideResults = []
    },
    getPatientById (patientId) {
      patientId = patientId || 0

      return http.get(endpoints.patients.show + '/' + patientId)
    },
    getDeviceGuideResults (data) {
      return http.post(endpoints.guideDevices.withImages, data)
    },
    updateFlowDevice (device) {
      const data = {
        id: this.id,
        device: device,
        pid: this.patientId
      }

      // @todo: check the endpoint
      return http.post('/', data)
    }
  }
}
