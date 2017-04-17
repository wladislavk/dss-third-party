export default {
  name: 'ledger-summary-report-full',
  props: {
    charges: {
      type: 'Array',
      required: true
    },
    credits: {
      type: 'Array',
      required: true
    },
    adjustments: {
      type: 'Array',
      required: true
    },
  },
  computed: {
    totalPageCharges () {
      var total = this.charges.reduce((sum, currentRow) => {
        return sum + 0
      }, 0)

      return total
    },
    totalPageCredits () {
      var total = this.credits.reduce((sum, currentRow) => {
        return sum + 0
      }, 0)

      return total
    },
    totalPageAdjustments () {
      var total = this.adjustments.reduce((sum, currentRow) => {
        return sum + 0
      }, 0)

      return total
    }
  },
  methods: {
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    }
  }
}
