/* eslint-env browser */
/* global Vue */
/* global jQuery */
/* global apiRoot */
/* global PatientFormMixin */
/* global UpdatableMixin */
/* global CustomTextMixin */
(function ($) {
  var $form = $('#pain-tmd')
  var patientId = $form.find('[type=hidden][name=patient_id]').val()
  var apiEndPoint = apiRoot + 'api/v1/pain-tmd-exams'
  var moduleEndPoint = apiEndPoint

  var painTMD = new Vue({
    el: '#' + $form.attr('id'),
    mixins: [PatientFormMixin, UpdatableMixin, CustomTextMixin],
    data: {
      mixin: {
        namespace: 'pain-tmd',
        apiEndPoint: moduleEndPoint,
        patientId: patientId,
        modelId: window.historyId || 0,
        messages: {
          saving: 'Saving the Pain/TMD questionnaire, please wait...',
          saved: 'Questionnaire form updated.',
          saveError: 'There was an error saving the questionnaire. Please wait a minute and try again.',
          postError: 'There was an error saving the questionnaire. Please wait a minute and try again.',
          getError: 'There was an error loading the questionnaire fields. Please try again later.'
        },
        resetForm: $form.find('[name=create_new]').val() === '1'
      },
      form: {
        'description': {
          'chief_complaint': '',
          'treatment_goals': ''
        },
        'symptom_review': {
          'onset_of_event': '',
          'provocation': '',
          'quality_of_pain': '',
          'region_and_radiation': '',
          'severity': '',
          'time': ''
        },
        'pain': {
          'back': {
            'general': {
              'level': null
            },
            'upper': {
              'position': null,
              'level': null
            },
            'middle': {
              'position': null,
              'level': null
            },
            'lower': {
              'position': null,
              'level': null
            }
          },
          'jaw': {
            'general': {
              'position': null,
              'level': null
            }
          },
          'jaw_joint': {
            'general': {
              'level': null
            },
            'opening': {
              'position': null,
              'level': null
            },
            'chewing': {
              'position': null,
              'level': null
            },
            'at_rest': {
              'position': null,
              'level': null
            }
          },
          'eyes': {
            'behind': {
              'checked': null,
              'position': null,
              'level': null
            },
            'watery': {
              'checked': null,
              'position': null,
              'level': null
            },
            'visual_disturbance': {
              'checked': null,
              'position': null,
              'level': null
            }
          },
          'ears': {
            'general': {
              'position': null,
              'level': null
            },
            'behind': {
              'level': null,
              'position': null
            },
            'front': {
              'position': null,
              'level': null
            },
            'ringing': {
              'position': null,
              'level': null
            }
          },
          'throat': {
            'general': {
              'level': null
            },
            'swallowing': {
              'level': null
            }
          },
          'face': {
            'general': {
              'position': null,
              'level': null
            }
          },
          'neck': {
            'general': {
              'position': null,
              'level': null
            }
          },
          'shoulder': {
            'general': {
              'position': null,
              'level': null
            }
          },
          'teeth': {
            'general': {
              'position': null,
              'level': null
            }
          }
        },
        'symptoms': {
          'jaw': {
            'locks_open': null,
            'locks_closed': null,
            'opening': {
              'clicks_pops': null,
              'position': null
            },
            'closing': {
              'clicks_pops': null,
              'position': null
            }
          },
          'clenching': {
            'daytime': null,
            'nighttime': null
          },
          'mouth': {
            'limited_opening': null
          },
          'grinding': {
            'daytime': null,
            'nighttime': null
          },
          'muscle_twitching': null,
          'numbness': {
            'lip': null,
            'jawbone': null
          },
          'other': {
            'dry_mouth': null,
            'cheek_biting': null,
            'burning_tongue': null,
            'dizziness': null,
            'buzzing': null,
            'swallowing': null,
            'neck_stiffness': null,
            'vision_changes': null,
            'sciatica': null,
            'ear_infections': null,
            'foreign_feeling': null,
            'shoulder_stiffness': null,
            'blurred_vision': null,
            'fingers_tingling': null,
            'ear_congestion': null,
            'neck_swelling': null,
            'scoliosis': null,
            'visual_disturbances': null,
            'finger_hand_numbness': null,
            'hearing_loss': null,
            'gland_swelling': null,
            'chronic_sinusitis': null,
            'thyroid_swelling': null,
            'difficult_breathing': null,
            'description': ''
          }
        },
        'headaches': {
          'checked': null,
          'front': {
            'frequency': null,
            'duration': null,
            'level': null
          },
          'top': {
            'frequency': null,
            'duration': null,
            'level': null
          },
          'back': {
            'frequency': null,
            'duration': null,
            'level': null
          },
          'temple': {
            'position': null,
            'frequency': null,
            'duration': null,
            'level': null
          },
          'eyes': {
            'position': null,
            'frequency': null,
            'duration': null,
            'level': null
          },
          'symptoms': {
            'dizziness': null,
            'noise_sensitivity': null,
            'throbbling': null,
            'double_vision': null,
            'light_sensitivity': null,
            'vomiting': null,
            'fatigue': null,
            'nausea': null,
            'eye_nose_running': null,
            'sinus_congestion': null,
            'burning': null,
            'other': {
              'checked': null,
              'details': ''
            },
            'dull_aching': null
          },
          'migraines': {
            'checked': null,
            'specialist': null,
            'occurrence': null
          }
        }
      }
    }
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(painTMD)
}(jQuery))
