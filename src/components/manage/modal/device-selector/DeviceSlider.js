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
    checked: {
      type: Boolean,
      default: false
    },
    checkedOption: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      checkedOptionData: this.checkedOption
    }
  },
  computed: {
    checkedOptionName () {
      if (this.labels.length >= this.checkedOption) {
        return this.labels[this.checkedOption]
      }
      return ''
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
      this.$store.commit(symbols.mutations.deviceGuideResults, [])
    },
    moveSlider (value) {
      const data = {
        id: this.id,
        value: value,
        labels: this.labels
      }
      this.$store.dispatch(symbols.actions.moveGuideSettingSlider, data)
      this.$store.commit(symbols.mutations.deviceGuideResults, [])
    }
  }
}
