import symbols from 'src/symbols'

export default {
  props: {
    patientId: {
      type: Number,
      required: true
    },
    elementId: {
      type: Number,
      required: true
    },
    deviceId: {
      type: Number,
      required: true
    }
  },
  computed: {
    devices () {
      return this.$store.state.flowsheet[symbols.state.devices]
    },
    defaultDeviceId () {
      for (let device of this.devices) {
        if (device.hasOwnProperty('default') && device.default) {
          return device.id
        }
      }
      return this.deviceId
    }
  },
  methods: {
    updateDeviceId (event) {
      const newValue = event.target.value
      if (!newValue) {
        return
      }
      const postData = {
        id: this.elementId,
        data: {
          device_id: newValue
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, postData)
    }
  }
}
