export default {
  methods: {
    phoneForDisplaying (phone) {
      phone = phone || ''
      return phone.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
    },
    phoneForStoring (phone) {
      phone = phone || ''
      return phone.replace(/[^0-9]/g, '')
    }
  }
}
