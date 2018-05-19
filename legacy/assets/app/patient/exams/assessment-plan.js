/* eslint-env browser */
/* global Vue */
/* global jQuery */
/* global apiRoot */
/* global PatientFormMixin */
/* global UpdatableMixin */
/* global CustomTextMixin */
(function ($) {
  var $form = $('#assessment-plan')
  var patientId = $form.find('[type=hidden][name=patient_id]').val()
  var apiEndPoint = apiRoot + 'api/v1/assessment-plan-exams'
  var moduleEndPoint = apiEndPoint

  var assessmentPlan = new Vue({
    el: '#' + $form.attr('id'),
    mixins: [PatientFormMixin, UpdatableMixin, CustomTextMixin],
    data: {
      mixin: {
        namespace: 'assessment-plan',
        apiEndPoint: moduleEndPoint,
        patientId: patientId,
        modelId: window.historyId || 0,
        messages: {
          saving: 'Saving the Assessment/Plan exam, please wait...',
          saved: 'Exam form updated.',
          saveError: 'There was an error saving the exam. Please wait a minute and try again.',
          postError: 'There was an error saving the exam. Please wait a minute and try again.',
          getError: 'There was an error loading the exam fields. Please try again later.'
        },
        resetForm: $form.find('[name=create_new]').val() === '1'
      },
      form: {
        'assessment_codes': [],
        'assessment_description': '',
        'treatment_codes': [],
        'treatment_description': ''
      }
    }
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(assessmentPlan)
}(jQuery))
