import symbols from '../../symbols'
import HeaderComponent from './common/CommonHeader.vue'

export default {
  components: {
    headerComponent: HeaderComponent
  },
  created () {
    this.$store.dispatch(symbols.actions.userInfo).then(() => {
      this.$store.dispatch(symbols.actions.docInfo)
    })
    this.$store.dispatch(symbols.actions.courseStaff)
  },
  mounted () {
    if (!this.$store.state.main[symbols.state.mainToken]) {
      this.$router.push({ name: 'main-login' })
    }
  },
  beforeRouteEnter (to, from, next) {
    next((vm) => {
      vm.$store.dispatch(symbols.actions.storeLoginDetails, this.$route.query)
    })
  },
  beforeRouteUpdate (to, from, next) {
    let toPatientId = 0
    if (to.params.hasOwnProperty('pid')) {
      toPatientId = parseInt(to.params.pid)
    }
    if (!toPatientId) {
      this.clearPatientData()
      return
    }
    let fromPatientId = 0
    if (from.params.hasOwnProperty('pid')) {
      fromPatientId = parseInt(from.params.pid)
    }
    if (toPatientId !== fromPatientId) {
      this.updatePatientData(toPatientId)
    }
    next()
  },
  methods: {
    updatePatientData (patientId) {
      this.$store.dispatch(symbols.actions.patientData, patientId)
    },
    clearPatientData () {
      this.$store.dispatch(symbols.actions.clearPatientData)
    }
  }
}
