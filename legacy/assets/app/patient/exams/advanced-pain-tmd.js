/* eslint-env browser */
/* global Vue */
/* global jQuery */
/* global apiRoot */
/* global PatientFormMixin */
/* global UpdatableMixin */
/* global CustomTextMixin */
(function ($) {
  var $form = $('#advanced-pain-tmd')
  var patientId = $form.find('[type=hidden][name=patient_id]').val()
  var apiEndPoint = apiRoot + 'api/v1/advanced-pain-tmd-exams'
  var moduleEndPoint = apiEndPoint

  var advancedPainTMD = new Vue({
    el: '#' + $form.attr('id'),
    mixins: [PatientFormMixin, UpdatableMixin, CustomTextMixin],
    data: {
      mixin: {
        namespace: 'advanced-pain-tmd',
        apiEndPoint: moduleEndPoint,
        patientId: patientId,
        modelId: window.historyId || 0,
        messages: {
          saving: 'Saving the Advanced Pain/TMD exam, please wait...',
          saved: 'Exam form updated.',
          saveError: 'There was an error saving the exam. Please wait a minute and try again.',
          postError: 'There was an error saving the exam. Please wait a minute and try again.',
          getError: 'There was an error loading the exam fields. Please try again later.'
        },
        resetForm: $form.find('[name=create_new]').val() === '1'
      },
      form: {
        'cervical': {
          'evaluate': 0,
          'extension': {
            'rom': null,
            'pain': null
          },
          'flexion': {
            'rom': null,
            'pain': null
          },
          'rotation': {
            'right': {
              'rom': null,
              'pain': null
            },
            'left': {
              'rom': null,
              'pain': null
            },
            'symmetry': null
          },
          'side_bend': {
            'right': {
              'rom': null,
              'pain': null
            },
            'left': {
              'rom': null,
              'pain': null
            },
            'symmetry': null
          },
          'notes': ''
        },
        'morphology': {
          'evaluate': 0,
          'midline': {
            'general': {
              'position': null
            },
            'facial': {
              'position': null
            },
            'teeth': {
              'maxilla': {
                'position': null
              },
              'mandible': {
                'position': null
              }
            },
            'eyes': {
              'right': {
                'position': null
              },
              'left': {
                'position': null
              }
            }
          },
          'posture': {
            'head': {
              'position': null
            },
            'standing': {
              'position': null
            },
            'sitting': {
              'position': null
            }
          },
          'shoulders': {
            'position': null
          },
          'hips': {
            'position': null
          },
          'spine': {
            'position': null
          },
          'pupillary_plane': {
            'position': null
          },
          'notes': ''
        },
        'cranial_nerve': {
          'evaluate': 0,
          'olfactory': null,
          'optic': null,
          'occulomotor': null,
          'trochlear': null,
          'trigeminal': null,
          'abducens': null,
          'facial': null,
          'acoustic': null,
          'glossopharyngeal': null,
          'vagus': null,
          'accessory': null,
          'hypoglossal': null,
          'notes': ''
        },
        'occlusal': {
          'evaluate': 0,
          'contacts': {
            'working': {
              'right': {},
              'left': {}
            },
            'non_working': {
              'right': {},
              'left': {}
            }
          },
          'crossover_interferences': {},
          'guidance': null,
          'notes': ''
        },
        'other': {
          'evaluate': 0,
          'notes': ''
        }
      }
    }
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(advancedPainTMD)
}(jQuery))
