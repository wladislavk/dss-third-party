import endpoints from 'endpoints'
import http from 'services/http'
import symbols from 'symbols'
import { LEGACY_URL, DEVICE_SELECTOR_INSTRUCTIONS, DSS_CONSTANTS } from '../../../constants'
import Alerter from 'services/Alerter'

export default {
  data () {
    return {
      legacyUrl: LEGACY_URL,
      showInstructions: false,
      instructions: DEVICE_SELECTOR_INSTRUCTIONS
    }
  },
  watch: {
    deviceGuideSettingOptions () {
      this.$nextTick(() => {
        this.deviceGuideSettingOptions.forEach(el => {
          this.setSlider(el.id, 0, el.number - 1, 1)
        })
      })
    }
  },
  computed: {
    patientName () {
      return this.$store.state.main[symbols.state.patientName]
    },
    deviceSelectorTitle () {
      return `Device C-Lect for ${this.patientName}?`
    },
    deviceGuideSettingOptions () {
      return this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
    },
    deviceGuideResults () {
      return this.$store.state.dashboard[symbols.state.deviceGuideResults]
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getDeviceGuideSettingOptions)
      .catch((response) => {
        this.$store.dispatch(
          symbols.actions.handleErrors,
          {title: 'getDeviceGuideSettingOptions', response: response}
        )
      })
  },
  methods: {
    updateGuideSettingStatus (event, id) {
      const MAX_NUMBER_OF_CHECKED_IMPS = 3
      const checkedImps = this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
        .map(el => el.checkedImp)
        .filter(el => el === 1)

      if (checkedImps.length === MAX_NUMBER_OF_CHECKED_IMPS) {
        event.target.checked = 0
        return
      }

      const data = {
        id: id,
        values: {
          checkedImp: +event.target.checked
        }
      }

      this.$store.commit(symbols.mutations.updateGuideSetting, data)
    },
    updateGuideSettingOption (id, value) {
      const data = {
        id: id,
        values: {
          checkedOption: value
        }
      }

      this.$store.commit(symbols.mutations.updateGuideSetting, data)
    },
    getSliderDivId (id) {
      return 'slider_' + id
    },
    setSlider (id, start, end, step) {
      $('#' + this.getSliderDivId(id)).slider({
        value: start,
        min: start,
        max: end,
        step: step,
        slide: (event, ui) => {
          this.updateGuideSettingOption(id, ui.value)
        }
      })
    },
    isSettingTypeRange (type) {
      return type === DSS_CONSTANTS.DSS_DEVICE_SETTING_TYPE_RANGE
    },
    onClickInstructions () {
      this.showInstructions = true
    },
    onClickHide () {
      this.showInstructions = false
    },
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
        if (Alerter.isConfirmed(confirmText)) {
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
