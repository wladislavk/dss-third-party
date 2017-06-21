export default {
  name: 'ledger-summary-report-full',
  props: {
    reportType: {
      type: String,
      required: true
    },
    patientId: {
      type: Number,
      default: 0
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
      var total = this.charges.reduce((sum, currentRow) => {
        return sum + +currentRow.amount
      }, 0)

      this.$set(this.totals, 'charges', total)
    },
    'credits': function () {
      var total = this.credits.reduce((sum, currentRow) => {
        return sum + +currentRow.amount
      }, 0)

      this.$set(this.totals, 'credits', total)
    },
    'adjustments': function () {
      var total = this.adjustments.reduce((sum, currentRow) => {
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
      this.getLedgerTotals(this.reportType, this.patientId)
        .then(function (response) {
          var data = response.data.data

          var credits = []

          if (data.credits.hasOwnProperty('type')) {
            var notFilteredCredits = data.credits['type'].concat(data.credits['named'])

            notFilteredCredits.forEach((item) => {
              var index = credits.findIndex((element) => {
                return element.payment_description === item.payment_description
              })

              if (index == -1) {
                credits.push({
                  payment_description: item.payment_description,
                  amount: item.amount
                })
              } else {
                credits[index].amount = +credits[index].amount + +item.amount
              }
            })
          } else {
            credits = data.credits
          }

          this.charges = data.charges
          this.credits = credits
          this.adjustments = data.adjustments
        }, function (response) {
          this.handleErrors('getLedgerTotals', response)
        })
    },
    getLedgerTotals (reportType, patientId) {
      var data = {
        report_type: reportType,
        patient_id: patientId
      }

      return this.$http.post(process.env.API_PATH + 'ledgers/totals', data)
    },
    formatLedger (value) {
      return accounting.formatMoney(value, '$')
    }
  }
}
