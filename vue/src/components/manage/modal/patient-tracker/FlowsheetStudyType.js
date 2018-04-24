import symbols from '../../../../symbols'
import { BASELINE_TEST_ID, TITRATION_STUDY_ID, BASELINE_TYPES, TITRATION_TYPES } from '../../../../constants/chart'

export default {
  data () {
    return {
      selectedType: '',
      baselineTypes: BASELINE_TYPES,
      titrationTypes: TITRATION_TYPES
    }
  },
  computed: {
    flowId () {
      return this.$store.state.main[symbols.state.modal].params.flowId
    },
    segmentId () {
      return this.$store.state.main[symbols.state.modal].params.segmentId
    },
    patientId () {
      return this.$store.state.main[symbols.state.modal].params.patientId
    },
    patientName () {
      return this.$store.state.patients[symbols.state.patientName]
    },
    isTitration () {
      if (this.segmentId === TITRATION_STUDY_ID) {
        return true
      }
      return false
    },
    isBaseline () {
      if (this.segmentId === BASELINE_TEST_ID) {
        return true
      }
      return false
    }
  },
  methods: {
    selectType () {
      const queryData = {
        id: this.flowId,
        data: {
          type: this.selectedType
        },
        patientId: this.patientId
      }
      this.$store.dispatch(symbols.actions.updateAppointmentSummary, queryData).then(() => {
        this.$store.commit(symbols.mutations.resetModal)
      })
    }
  }
}
