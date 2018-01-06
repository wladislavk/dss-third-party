import symbols from '../../../../symbols'
import VueSliderComponent from 'vue-slider-component'

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    labels: {
      type: Array,
      required: true
    },
    checkedOption: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      checked: false,
      checkedOptionData: this.checkedOption
    }
  },
  components: {
    vueSlider: VueSliderComponent
  },
  methods: {
    checkSetting (event) {
      const data = {
        id: this.id,
        isChecked: event.target.checked
      }
      this.$store.commit(symbols.mutations.checkGuideSetting, data)
    },
    moveSlider (value) {
      let optionId = 0
      for (let [key, label] of this.labels.entries()) {
        if (value === label) {
          optionId = key
          break
        }
      }
      const data = {
        id: this.id,
        value: optionId
      }
      this.$store.commit(symbols.mutations.moveGuideSettingSlider, data)
      this.$store.commit(symbols.mutations.deviceGuideResults, [])
    }
  }
}
