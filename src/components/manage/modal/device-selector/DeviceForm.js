import symbols from '../../../../symbols'
import { DSS_CONSTANTS } from '../../../../constants/main'
import $ from 'jquery'

export default {
  computed: {
    deviceGuideSettingOptions () {
      return this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
    }
  },
  watch: {
    deviceGuideSettingOptions: {
      handler () {
        this.$nextTick(() => {
          this.deviceGuideSettingOptions.forEach(el => {
            this.setSlider(el.id, 0, el.number - 1, 1, el.checkedOption)
          })
        })
      },
      deep: true
    }
  },
  created () {
    this.$store.dispatch(symbols.actions.getDeviceGuideSettingOptions)
  },
  methods: {
    updateGuideSettingStatus (event, id) {
      if (event.target.checked) {
        const maxCheckedImpressionsNumber = 3
        const impressions = this.$store.state.dashboard[symbols.state.deviceGuideSettingOptions]
          .map(el => el.impression)
          .filter(el => el === 1)

        if (impressions.length === maxCheckedImpressionsNumber) {
          event.target.checked = 0
          return
        }
      }

      const data = {
        id: id,
        values: {
          impression: +event.target.checked
        }
      }

      this.$store.commit(symbols.mutations.updateGuideSetting, data)
    },
    isSettingTypeRange (type) {
      return type === DSS_CONSTANTS.DSS_DEVICE_SETTING_TYPE_RANGE
    },
    getSliderDivId (id) {
      return 'slider_' + id
    },
    setSlider (id, start, end, step, value) {
      $('#' + this.getSliderDivId(id)).slider({
        value: value,
        min: start,
        max: end,
        step: step,
        slide: (event, ui) => {
          this.updateGuideSettingOption(id, ui.value)
        }
      })
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
  }
}
