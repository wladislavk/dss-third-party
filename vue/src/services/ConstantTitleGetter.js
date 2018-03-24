import { PAYMENT_TYPE_LABELS, TRANSACTION_PAYER_LABELS, TRANSACTION_TYPE_LABELS } from '../constants/main'

export default {
  dssTransactionTypeLabels (status) {
    if (TRANSACTION_TYPE_LABELS.hasOwnProperty(status)) {
      return TRANSACTION_TYPE_LABELS[status]
    }
    return null
  },

  dssTransactionPaymentTypeLabels (status) {
    if (PAYMENT_TYPE_LABELS.hasOwnProperty(status)) {
      return PAYMENT_TYPE_LABELS[status]
    }
    return null
  },

  dssTransactionPayerLabels (status) {
    if (TRANSACTION_PAYER_LABELS.hasOwnProperty(status)) {
      return TRANSACTION_PAYER_LABELS[status]
    }
    return null
  }
}
