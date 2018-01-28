import symbols from '../../../symbols'

export default {
  props: {
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    },
    className: {
      type: String,
      required: true
    }
  },
  methods: {
    updateContact (event) {
      const payload = {
        name: event.target.id,
        value: event.target.value
      }
      this.$store.commit(symbols.mutations.addStoredContact, payload)
    }
  }
}
