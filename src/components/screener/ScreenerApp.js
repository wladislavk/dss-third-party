import $ from 'jquery'
import HealthAssessment from 'common/HealthAssessment.vue'

export default {
  data: function () {
    return {
      currentYear: (new Date()).getFullYear()
    }
  },
  created () {
    $.mask.definitions['~'] = '[2-9]'
    $('.extphonemask').mask('(~99) 999-9999? ext99999')
    $('.phonemask').mask('(~99) 999-9999')
    $('.ssnmask').mask('999-99-9999')
    $('.datemask').mask('99/99/9999')
  },
  components: {
    'health-assessment': HealthAssessment
  }
}
