export default {
  props: {
    sectionNumber: {
      type: Number,
      default: 0
    },
    customId: {
      type: String,
      default: ''
    },
    disabled: {
      type: Boolean,
      default: false
    },
    large: {
      type: Boolean,
      default: false
    },
    linkText: {
      type: String,
      default: 'Next'
    },
    additionalClass: {
      type: String,
      default: ''
    }
  },
  computed: {
    resultingClass () {
      const classArray = []
      if (this.disabled) {
        classArray.push('disabled')
      }
      let fontSizeClass = 'btn_medium'
      if (this.large) {
        fontSizeClass = 'btn_large'
      }
      classArray.push(fontSizeClass)
      if (this.additionalClass) {
        classArray.push(this.additionalClass)
      }
      return classArray
    },
    resultingId () {
      if (this.customId) {
        return this.customId
      }
      return 'sect' + this.sectionNumber + '_next'
    }
  },
  methods: {
    onSubmit () {
      // props cannot be modified within child
      this.$emit('update:disabled', true)
      this.$emit('next')
    }
  }
}
