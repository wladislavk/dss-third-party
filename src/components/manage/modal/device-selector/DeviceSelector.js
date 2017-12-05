import symbols from 'symbols'
import { DEVICE_SELECTOR_INSTRUCTIONS } from 'constants/dashboard'
import DeviceForm from './DeviceForm.vue'
import DeviceResults from './DeviceResults.vue'

export default {
  data () {
    return {
      showInstructions: false,
      instructions: DEVICE_SELECTOR_INSTRUCTIONS
    }
  },
  components: {
    'device-form': DeviceForm,
    'device-results': DeviceResults
  },
  computed: {
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    }
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
