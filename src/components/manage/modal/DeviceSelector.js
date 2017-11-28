import endpoints from 'endpoints'
import http from 'services/http'
import symbols from 'symbols'
import { DSS_CONSTANTS } from 'constants/main'
import { DEVICE_SELECTOR_INSTRUCTIONS } from 'constants/dashboard'
import Alerter from 'services/Alerter'

export default {
  data () {
    return {
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
      return this.$store.state.patients[symbols.state.patientName]
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
      if (+event.target.checked === 1) {
        const MAX_NUMBER_OF_CHECKED_IMPS = 3
        const checkedImps = this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
          .map(el => el.checkedImp)
          .filter(el => el === 1)

        if (checkedImps.length === MAX_NUMBER_OF_CHECKED_IMPS) {
          event.target.checked = 0
          return
        }
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
      this.$store.commit(symbols.mutations.deviceGuideResults, [])
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
      this.$store.dispatch(symbols.actions.getDeviceGuideResults)
    },
    updateDevice (deviceId, name) {
      if (this.patientName.length === 0) {
        return
      }

      const CONFIRM_TEXT = `Do you want to select ${name} for ${this.patientName}`

      if (!Alerter.isConfirmed(CONFIRM_TEXT)) {
        return
      }

      this.$store.dispatch(symbols.actions.updateFlowDevice, deviceId).then(response => {
        Alerter.alert(response.data.message)

        // TODO: current modal may be used not only for the dashboard.
        // it seems that next logic may be required for other callers of the modal
        // parent.updateDentalDevice(patientId, deviceId)

        // TODO: disable the modal
        // parent.disablePopupClean()
      }).catch(response => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'updateFlowDevice', response: response})
      })
    },
    onClickReset () {
      this.$store.dispatch(symbols.actions.resetDeviceGuideSettingOptions)
    }
  }
}
