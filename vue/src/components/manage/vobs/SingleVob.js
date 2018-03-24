import endpoints from '../../../endpoints'
import http from '../../../services/http'
import symbols from '../../../symbols'
import { DSS_CONSTANTS, PREAUTH_STATUS_LABELS } from '../../../constants/main'

export default {
  props: {
    vob: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      statusLabel: PREAUTH_STATUS_LABELS[this.vob.status]
    }
  },
  computed: {
    unviewedClass () {
      return !(this.vob.viewed === 1 || this.vob.status === DSS_CONSTANTS.DSS_PREAUTH_PENDING)
    },
    rejectReason () {
      return this.vob.status === DSS_CONSTANTS.DSS_PREAUTH_REJECTED ? this.vob.reject_reason : ''
    }
  },
  methods: {
    setViewStatus () {
      const data = {
        viewed: this.vob.viewed === 0 ? 1 : 0
      }

      this.updateVob(this.vob.id, data).then(() => {
        this.$router.push({
          name: this.$route.name,
          query: {
            pid: this.vob.patient_id || 0
          }
        })

        const foundVob = this.vobs.find((el) => {
          return el.id === this.vob.id
        })
        foundVob.viewed = data.viewed
      }).catch((response) => {
        this.$store.dispatch(symbols.actions.handleErrors, {title: 'updateVob', response: response})
      })
    },
    updateVob (id, data) {
      id = id || 0

      return http.put(endpoints.insurancePreauth.update + '/' + id, data)
    }
  }
}
