import endpoints from '../../../../endpoints'
import http from '../../../../services/http'

export default {
  name: 'ledger-summary-report-full',
  props: {
    reportType: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      charges: [],
      credits: [],
      adjustments: [],
      totals: {
        charges: 0,
        credits: 0,
        adjustments: 0
      }
    }
  },
  watch: {
    'charges': function () {
      const total = this.charges.reduce((sum, currentRow) => {
        return sum + +currentRow.amount
      }, 0)

      this.$set(this.totals, 'charges', total)
    },
    'credits': function () {
      const total = this.credits.reduce((sum, currentRow) => {
        return sum + +currentRow.amount
      }, 0)

      this.$set(this.totals, 'credits', total)
    },
    'adjustments': function () {
      const total = this.adjustments.reduce((sum, currentRow) => {
        return sum + +currentRow.amount
      }, 0)

      this.$set(this.totals, 'adjustments', total)
    },
    'totals': {
      handler: function () {
        window.eventHub.$emit('setting-totals-from-summary-block', this.totals)
      },
      deep: true
    }
  },
  created () {
    this.formReportTotals()
  },
  methods: {
    formReportTotals () {
      this.getLedgerTotals(this.reportType).then(function (response) {
        const data = response.data.data

        this.charges = data.charges
        this.credits = data.credits.hasOwnProperty('type') ? data.credits['type'].concat(data.credits['named']) : data.credits
        this.adjustments = data.adjustments
      }).catch(function (response) {
        this.handleErrors('getLedgerTotals', response)
      })
    },
    getLedgerTotals (reportType) {
      const data = { report_type: reportType }

      return http.post(endpoints.ledgers.totals, data)
    },
    formatLedger (value) {
      return window.accounting.formatMoney(value, '$')
    }
  }
}
