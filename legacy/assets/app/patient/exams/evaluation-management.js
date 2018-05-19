/* eslint-env browser */
/* global Vue */
/* global jQuery */
/* global apiRoot */
/* global PatientFormMixin */
/* global UpdatableMixin */
/* global CustomTextMixin */
(function ($) {
  var $form = $('#evaluation-management')
  var patientId = $form.find('[type=hidden][name=patient_id]').val()
  var resetForm = $form.find('[name=create_new]').val() === '1'
  var apiPath = apiRoot + 'api/v1/'
  var apiEndPoints = [
    apiPath + 'evaluation-management-exams',
    apiPath + 'tongue-clinical-exams',
    apiPath + 'patients',
    apiPath + 'symptoms',
    apiPath + 'health-histories'
  ]
  var secondaryForms = {
    tongueClinicalExam: {
      modelKey: 'ex_page1id',
      retrieveLatest: true,
      requiresPatientId: true,
      apiEndPoint: apiEndPoints[1],
      fields: [
        'blood_pressure',
        'pulse',
        'neck_measurement',
        'respirations'
      ],
      data: {}
    },
    patient: {
      modelKey: 'patientid',
      modelId: patientId,
      retrieveLatest: false,
      requiresPatientId: false,
      apiEndPoint: apiEndPoints[2],
      fields: [
        'feet',
        'inches',
        'weight',
        'bmi'
      ],
      data: {}
    }
  }
  var defaultSources = {
    symptoms: {
      modelKey: 'q_page1id',
      retrieveLatest: true,
      requiresPatientId: true,
      apiEndPoint: apiEndPoints[3],
      fields: [
        'chief_complaint_text'
      ],
      data: {}
    },
    healthHistories: {
      modelKey: 'q_page3id',
      retrieveLatest: true,
      requiresPatientId: true,
      apiEndPoint: apiEndPoints[4],
      fields: [
        'family_hd',
        'family_hdbp',
        'family_dia',
        'family_sd',
        'allergenscheck',
        'allergens',
        'other_allergens',
        'medicationscheck',
        'medications',
        'other_medications',
        'history',
        'other_history',
        'dental_health',
        'wisdom_extraction',
        'wisdom_extraction_text',
        'removable',
        'removable_text',
        'dentures',
        'dentures_text',
        'orthodontics',
        'year_completed',
        'tmj_cp',
        'tmj_cp_text',
        'tmj_pain',
        'tmj_pain_text',
        'tmj_surgery',
        'tmj_surgery_text',
        'injury',
        'injury_text',
        'drymouth',
        'drymouth_extra',
        'gum_prob',
        'gum_prob_text',
        'completed_future',
        'future_dental_det',
        'clinch_grind',
        'clinch_grind_text',
        'alcohol',
        'sedative',
        'caffeine',
        'smoke',
        'smoke_packs',
        'tobacco',
        'additional_paragraph'
      ],
      data: {}
    }
  }

  if (window.historyId) {
    secondaryForms = {}
    defaultSources = {}
  }

  var eM = new Vue({
    el: '#' + $form.attr('id'),
    mixins: [PatientFormMixin, UpdatableMixin, CustomTextMixin],
    data: {
      mixin: {
        namespace: 'evaluation-management',
        apiEndPoint: apiEndPoints[0],
        patientId: patientId,
        modelId: window.historyId || 0,
        messages: {
          saving: 'Saving the EM exam, please wait...',
          saved: 'Exam form updated.',
          saveError: 'There was an error saving the exam. Please wait a minute and try again.',
          postError: 'There was an error saving the exam. Please wait a minute and try again.',
          getError: 'There was an error loading the exam fields. Please try again later.'
        },
        resetForm: resetForm
      },
      secondaryForms: secondaryForms,
      defaultSources: defaultSources,
      form: {
        'history': {
          'chief_complaint': {
            'value': '',
            'default': ''
          },
          'present': {
            'location': '',
            'quality': '',
            'severity': '',
            'duration': '',
            'timing': '',
            'context': '',
            'modifying_factor': '',
            'symptoms': ''
          },
          'past': {
            'family': {
              'value': '',
              'default': ''
            },
            'medical': {
              'allergens': {
                'value': '',
                'default': ''
              },
              'medication': {
                'value': '',
                'default': ''
              },
              'general': {
                'value': '',
                'default': ''
              },
              'dental': {
                'value': '',
                'default': ''
              }
            },
            'social': {
              'value': '',
              'default': ''
            }
          }
        },
        'systems': {
          'constitutional': '',
          'eyes': '',
          'ears_nose_mouth_throat': '',
          'cardiovascular': '',
          'respiratory': '',
          'gastrointestinal': '',
          'genitourinary': '',
          'musculoskeletal': '',
          'integumentary': '',
          'neurologic': '',
          'psychiatric': '',
          'endocrine': '',
          'hematologic_lymphatic': '',
          'allergic_immunologic': ''
        },
        'vital_signs': {
          'height': {
            'feet': 0,
            'inches': 0
          },
          'weight': '',
          'bmi': '',
          'blood_pressure': '',
          'pulse': '',
          'neck_measurement': '',
          'respirations': '',
          'appearance': '',
          'orientation': '',
          'mood_affect': '',
          'gait_station': '',
          'coordination_balance': '',
          'sensation': ''
        },
        'body_area': {
          'first_description': '',
          'palpation': '',
          'rom': '',
          'stability': '',
          'strength': '',
          'skin': '',
          'second_description': '',
          'lips_teeth_gums': '',
          'oropharynx': '',
          'nasal_septum_turbinates': ''
        }
      }
    },
    computed: {
      bmi: function () {
        function getValue (value) {
          value = +value

          if (isNaN(value)) {
            return 0
          }

          return value
        }

        var bmi = 0

        try {
          var feet = (+this.vitalSignsHeightFeet) * 12
          var inches = (+this.vitalSignsHeightInches)
          var height = feet + inches
          var weight = (+this.vitalSignsWeight) * 703

          if (height && weight) {
            bmi = weight / Math.pow(height, 2)
          }
        } catch (e) {
          bmi = 0
        }

        this.dynamicSafeSave('form.vital_signs.bmi', bmi.toFixed(1))
        this.dynamicSafeSave('secondaryForms.patient.data.bmi', bmi.toFixed(1))
        return bmi.toFixed(1)
      },
      bodyAreaFirstDescription: {
        cache: false,
        get: function () {
          var value = this.$get('form.body_area.first_description')
          var defaults = 'Head and Neck'
          if (value) {
            return value
          }
          if (!this.isListEmpty()) {
            return ''
          }
          this.dynamicSafeSave('form.body_area.first_description', defaults)
          return defaults
        },
        set: function (value) {
          this.dynamicSafeSave('form.body_area.first_description', value)
        }
      },
      bodyAreaSecondDescription: {
        cache: false,
        get: function () {
          var value = this.$get('form.body_area.second_description')
          var defaults = 'Ear, Nose and Throat'
          if (value) {
            return value
          }
          if (!this.isListEmpty()) {
            return ''
          }
          this.dynamicSafeSave('form.body_area.second_description', defaults)
          return defaults
        },
        set: function (value) {
          this.dynamicSafeSave('form.body_area.second_description', value)
        }
      },
      vitalSignsBloodPressure: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.blood_pressure', 'secondaryForms.tongueClinicalExam.data.blood_pressure'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.blood_pressure', value)
          this.dynamicSafeSave('secondaryForms.tongueClinicalExam.data.blood_pressure', value)
        }
      },
      vitalSignsPulse: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.pulse', 'secondaryForms.tongueClinicalExam.data.pulse'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.pulse', value)
          this.dynamicSafeSave('secondaryForms.tongueClinicalExam.data.pulse', value)
        }
      },
      vitalSignsNeckMeasurement: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.neck_measurement', 'secondaryForms.tongueClinicalExam.data.neck_measurement'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.neck_measurement', value)
          this.dynamicSafeSave('secondaryForms.tongueClinicalExam.data.neck_measurement', value)
        }
      },
      vitalSignsRespirations: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.respirations', 'secondaryForms.tongueClinicalExam.data.respirations'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.respirations', value)
          this.dynamicSafeSave('secondaryForms.tongueClinicalExam.data.respirations', value)
        }
      },
      vitalSignsHeightFeet: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.height.feet', 'secondaryForms.patient.data.feet'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.height.feet', value)
          this.dynamicSafeSave('secondaryForms.patient.data.feet', value)
        }
      },
      vitalSignsHeightInches: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.height.inches', 'secondaryForms.patient.data.inches'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.height.inches', value)
          this.dynamicSafeSave('secondaryForms.patient.data.inches', value)
        }
      },
      vitalSignsWeight: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.vital_signs.weight', 'secondaryForms.patient.data.weight'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.vital_signs.weight', value)
          this.dynamicSafeSave('secondaryForms.patient.data.weight', value)
        }
      },
      chiefComplaint: {
        cache: false,
        get: function () {
          return this.fieldWithBackup(
            'form.history.chief_complaint.value',
            'defaultSources.symptoms.chief_complaint_text',
            'form.history.chief_complaint.default',
            'None specified'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.chief_complaint.value', value)
        }
      },
      familyHistory: {
        cache: false,
        get: function () {
          var defaults = {
            hd: this.$get('defaultSources.healthHistories.family_hd'),
            hbp: this.$get('defaultSources.healthHistories.family_hdbp'),
            dia: this.$get('defaultSources.healthHistories.family_dia'),
            sd: this.$get('defaultSources.healthHistories.family_sd')
          }
          return this.fieldWithBackup(
            'form.history.past.family.value',
            defaults,
            'form.history.past.family.default',
            'None selected',
            function () {
              var value
              var placeholders = []
              var defaultMap = {
                hd: 'Hearth Disease',
                hbp: 'High Blood Pressure',
                dia: 'Diabetes',
                sd: 'Sleep Disorder'
              }

              for (var tag in defaultMap) {
                if (!defaultMap.hasOwnProperty(tag)) {
                  continue
                }

                if (defaults[tag] === 'Yes') {
                  placeholders.push(defaultMap[tag])
                }
              }

              value = placeholders.length ? placeholders.join(', ') : ''
              return value
            }
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.family.value', value)
        }
      },
      allergensHistory: {
        cache: false,
        get: function () {
          var defaults = this.$get('defaultSources.healthHistories.data')
          return this.fieldWithBackup(
            'form.history.past.medical.allergens.value',
            defaults,
            'form.history.past.medical.allergens.default',
            'None selected',
            function () {
              return +defaults.allergenscheck === 1 && (defaults.other_allergens || '').trim().length
                ? defaults.other_allergens : ''
            }
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.medical.allergens.value', value)
        }
      },
      medicationHistory: {
        cache: false,
        get: function () {
          var defaults = this.$get('defaultSources.healthHistories.data')
          return this.fieldWithBackup(
            'form.history.past.medical.medication.value',
            defaults,
            'form.history.past.medical.medication.default',
            'None selected',
            function () {
              return +defaults.medicationscheck === 1 && (defaults.other_medications || '').trim().length
                ? defaults.other_medications : ''
            }
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.medical.medication.value', value)
        }
      },
      generalHistory: {
        cache: false,
        get: function () {
          return this.fieldWithBackup(
            'form.history.past.medical.general.value',
            'defaultSources.healthHistories.data.other_history',
            'form.history.past.medical.general.default',
            'None selected'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.medical.general.value', value)
        }
      },
      dentalHistory: {
        cache: false,
        get: function () {
          var defaults = this.$get('defaultSources.healthHistories.data')
          return this.fieldWithBackup(
            'form.history.past.medical.dental.value',
            defaults,
            'form.history.past.medical.dental.default',
            '',
            function () {
              var value
              var placeholders = []
              var defaultMap = {
                wisdom_extraction: {
                  label: 'Teeth extracted'
                },
                removable: {
                  label: 'Removable partials'
                },
                dentures: {
                  label: 'Wears dentures'
                },
                orthodontics: {
                  label: 'Wears orthodontics',
                  details: {
                    label: 'Year completed',
                    field: 'year_completed'
                  }
                },
                tmj_cp: {
                  label: 'TMJ clicks or pops'
                },
                tmj_pain: {
                  label: 'Pain in jaw joint'
                },
                tmj_surgery: {
                  label: 'TMJ surgery'
                },
                injury: {
                  label: 'Injury to head, face, neck, mouth or teeth'
                },
                drymouth: {
                  label: 'Morning dry mouth',
                  details: {
                    field: 'drymouth_extra'
                  }
                },
                gum_prob: {
                  label: 'Gum problems'
                },
                completed_future: {
                  label: 'Planning to have dental work done in the near future',
                  details: {
                    field: 'future_dental_det'
                  }
                },
                clinch_grind: {
                  label: 'Clinches or grinds teeth'
                }
              }

              for (var tag in defaultMap) {
                if (!defaultMap.hasOwnProperty(tag)) {
                  continue
                }

                var placeholder = []
                var current = defaultMap[tag]
                var details = current.details || {}

                details.label = (details && details.label) || 'Details'
                details.field = (details && details.field) || [tag, '_text'].join('')

                placeholder.push([current.label, ':'].join(''))

                if (defaults[tag] === 'Yes') {
                  placeholder.push('Yes.')

                  if ((defaults[details.field] || '').trim().length) {
                    placeholder.push([details.label, ':'].join(''))
                    placeholder.push(defaults[details.field])
                  }
                } else {
                  placeholder.push('No.')
                }

                placeholders.push(placeholder.join(' '))
              }

              value = placeholders.join('\n')
              return value
            }
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.medical.dental.value', value)
        }
      },
      socialHistory: {
        cache: false,
        get: function () {
          var defaults = this.$get('defaultSources.healthHistories.data')
          return this.fieldWithBackup(
            'form.history.past.social.value',
            defaults,
            'form.history.past.social.default',
            '',
            function () {
              var value
              var placeholders = []

              placeholders.push([
                'Alcohol consumption: ',
                defaults.alcohol === 'Yes' ? 'Yes.' : 'No.'
              ].join(''))

              placeholders.push([
                'Sedative consumption: ',
                defaults.sedative === 'Yes' ? 'Yes.' : 'No.'
              ].join(''))

              placeholders.push([
                'Caffeine consumption: ',
                defaults.caffeine === 'Yes' ? 'Yes.' : 'No.'
              ].join(''))

              if (defaults.smoke === 'Yes') {
                placeholders.push([
                  'Smokes, ',
                  defaults.smoke_packs,
                  +defaults.smoke_packs === 1 ? ' pack ' : ' packs ',
                  'per day'
                ].join(''))
              } else {
                placeholders.push('No smoking')
              }

              placeholders.push(defaults.tobacco === 'Yes' ? 'Chews tobacco' : 'No tobacco chewing')
              value = placeholders.join('\n')

              return value
            }
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.history.past.social.value', value)
        }
      }
    },
    methods: {
      fieldWithBackup: function (source, primaryDefault, secondaryDefault, fallback, calculateDefault) {
        var value = this.$get(source)

        if (value.length) {
          return value
        }

        if (!this.isListEmpty()) {
          return ''
        }

        value = primaryDefault
        if (typeof value === 'string') {
          value = this.$get(primaryDefault)
        }

        if (typeof value === 'undefined') {
          value = this.$get(secondaryDefault)
        } else if (typeof calculateDefault !== 'undefined') {
          value = calculateDefault(this)
        }

        this.$set(secondaryDefault, value)
        return value.length ? value : fallback
      }
    }
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(eM)
}(jQuery))
