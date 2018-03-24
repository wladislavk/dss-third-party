import symbols from '../../../symbols'

export default {
  props: {
    name: {
      type: String,
      required: true
    },
    weight: {
      type: Number,
      required: true
    },
    cpap: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      yes: false,
      no: false
    }
  },
  methods: {
    updateValue (event) {
      const valueNumber = parseInt(event.target.value)
      if (valueNumber) {
        this.yes = true
        this.no = false
      } else {
        this.yes = false
        this.no = true
      }
      if (this.cpap) {
        const storedCpap = parseInt(event.target.value)
        this.$store.commit(symbols.mutations.addStoredCpap, storedCpap)
        return
      }
      const payload = {
        name: event.target.name,
        value: valueNumber
      }
      this.$store.commit(symbols.mutations.addStoredSymptom, payload)
    }
  }
}
