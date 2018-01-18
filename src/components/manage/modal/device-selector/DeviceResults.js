import symbols from '../../../../symbols'
import Alerter from '../../../../services/Alerter'
import FileRetrieverFactory from '../../../../services/file-retrievers/FileRetrieverFactory'
import http from '../../../../services/http'

export default {
  props: {
    patientName: String,
    required: true
  },
  computed: {
    deviceGuideResults () {
      return this.$store.state.dashboard[symbols.state.deviceGuideResults]
    }
  },
  methods: {
    getLogo (logoName) {
      const token = this.$store.state.main[symbols.state.mainToken]
      const factory = new FileRetrieverFactory()
      return factory.getFileRetriever().getMediaFile(logoName, token)
    },
    updateDevice (deviceId, name) {
      if (!this.patientName.length) {
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
    },
    onDeviceSubmit () {
      this.$store.dispatch(symbols.actions.getDeviceGuideResults)
    }
  }
}
