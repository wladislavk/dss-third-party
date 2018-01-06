import symbols from '../../../../symbols'
import { DEVICE_SELECTOR_INSTRUCTIONS } from '../../../../constants/dashboard'
import DeviceSliderComponent from './DeviceSlider.vue'
import DeviceResultsComponent from './DeviceResults.vue'

export default {
  data () {
    return {
      showInstructions: false,
      instructions: DEVICE_SELECTOR_INSTRUCTIONS
    }
  },
  computed: {
    deviceGuideSettingOptions () {
      return this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
    },
    patientName () {
      if (this.$store.state.main[symbols.state.modal].params.hasOwnProperty('patientName')) {
        return this.$store.state.main[symbols.state.modal].params.patientName
      }
      return ''
    }
  },
  components: {
    deviceSlider: DeviceSliderComponent,
    deviceResults: DeviceResultsComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.getDeviceGuideSettingOptions)
  },
  methods: {
    onClickInstructions () {
      this.showInstructions = true
    },
    onClickHide () {
      this.showInstructions = false
    },
    onDeviceSubmit () {
      this.$store.dispatch(symbols.actions.getDeviceGuideResults)
    }
  }
}
