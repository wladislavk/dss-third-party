import symbols from '../../../../symbols'
import Alerter from '../../../../services/Alerter'

export default {
  computed: {
    deviceGuideResults () {
      return this.$store.state.dashboard[symbols.state.deviceGuideResults]
    }
  },
  methods: {
    updateDevice (deviceId, name) {
      if (this.patientName.length === 0) {
        return
      }

      const CONFIRM_TEXT = `Do you want to select ${name} for ${this.patientName}`

      if (!Alerter.isConfirmed(CONFIRM_TEXT)) {
        return
      }

      this.$store.dispatch(symbols.actions.updateFlowDevice, deviceId)
    },
    onClickReset () {
      this.$store.commit(symbols.mutations.resetDeviceGuideSettingOptions)
      this.$store.commit(symbols.mutations.deviceGuideResults, [])
    }
  }
}
