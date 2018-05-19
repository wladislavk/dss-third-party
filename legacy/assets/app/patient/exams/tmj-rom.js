/* eslint-env browser */
/* global Vue */
/* global jQuery */
/* global apiRoot */
/* global PatientFormMixin */
/* global UpdatableMixin */
/* global CustomTextMixin */
(function ($) {
  var $form = $('#tmj-rom')
  var patientId = $form.find('[type=hidden][name=patient_id]').val()

  var apiPath = apiRoot + 'api/v1/'
  var apiEndPoints = [
    apiPath + 'tmj-clinical-exams',
    apiPath + 'summaries'
  ]
  var moduleEndPoints = [
    apiEndPoints[0],
    apiEndPoints[1]
  ]
  var secondaryForms = {
    summary: {
      modelKey: 'summaryid',
      retrieveLatest: true,
      requiresPatientId: true,
      apiEndPoint: moduleEndPoints[1],
      fields: [
        'initial_device_titration_1',
        'initial_device_titration_equal_h',
        'initial_device_titration_equal_v',
        'optimum_echovision_ver',
        'optimum_echovision_hor'
      ],
      data: {}
    }
  }

  if (window.historyId) {
    secondaryForms = {}
  }

  var tmjROM = new Vue({
    el: '#' + $form.attr('id'),
    mixins: [PatientFormMixin, UpdatableMixin, CustomTextMixin],
    data: {
      mixin: {
        namespace: 'tmj-rom',
        apiEndPoint: moduleEndPoints[0],
        patientId: patientId,
        modelKey: 'ex_page5id',
        modelId: window.historyId || 0,
        messages: {
          saving: 'Saving the TMJ/ROM exam, please wait...',
          saved: 'Exam form updated.',
          saveError: 'There was an error saving the exam. Please wait a minute and try again.',
          postError: 'There was an error saving the exam. Please wait a minute and try again.',
          getError: 'There was an error loading the exam fields. Please try again later.'
        },
        resetForm: $form.find('[name=create_new]').val() === '1'
      },
      secondaryForms: secondaryForms,
      form: {
        palpationid: '',
        palpationRid: '',
        additional_paragraph_pal: '',
        joint_exam: '',
        jointid: '',
        jointid_stages: '',
        i_opening_from: '',
        i_opening_to: '',
        i_opening_equal: '',
        protrusion_from: '',
        protrusion_to: '',
        protrusion_equal: '',
        l_lateral_from: '',
        l_lateral_to: '',
        l_lateral_equal: '',
        r_lateral_from: '',
        r_lateral_to: '',
        r_lateral_equal: '',
        deviation_from: '',
        deviation_to: '',
        deviation_equal: '',
        deflection_from: '',
        deflection_to: '',
        deflection_equal: '',
        range_normal: '',
        normal: '',
        other_range_motion: '',
        additional_paragraph_rm: '',
        deviation_r_l: '',
        deflection_r_l: '',
        initial_device_titration_1: '',
        initial_device_titration_equal_h: '',
        initial_device_titration_equal_v: '',
        optimum_echovision_ver: '',
        optimum_echovision_hor: ''
      },
      dynamic: {
        musclePalpationDefaults: {},
        musclePalpation: {},
        jointSoundTypes: {},
        jointSounds: {},
        jointExamTypes: {},
        jointExams: {}
      }
    },
    computed: {
      eccovisionHorizontal: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.optimum_echovision_hor', 'secondaryForms.summary.data.optimum_echovision_hor'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.optimum_echovision_hor', value)
          this.dynamicSafeSave('secondaryForms.summary.data.optimum_echovision_hor', value)
        }
      },
      eccovisionVertical: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.optimum_echovision_ver', 'secondaryForms.summary.data.optimum_echovision_ver'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.optimum_echovision_ver', value)
          this.dynamicSafeSave('secondaryForms.summary.data.optimum_echovision_ver', value)
        }
      },
      deviceSettingsIncisal: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.initial_device_titration_1', 'secondaryForms.summary.data.initial_device_titration_1'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.initial_device_titration_1', value)
          this.dynamicSafeSave('secondaryForms.summary.data.initial_device_titration_1', value)
        }
      },
      deviceSettingsVertical: {
        cache: false,
        get: function () {
          return this.dynamicPropertyWithDefault(
            'form.initial_device_titration_equal_v', 'secondaryForms.summary.data.initial_device_titration_equal_v'
          )
        },
        set: function (value) {
          this.dynamicSafeSave('form.initial_device_titration_equal_v', value)
          this.dynamicSafeSave('secondaryForms.summary.data.initial_device_titration_equal_v', value)
        }
      },
      protrusionRange: function () {
        var from = 0
        var to = 0
        var range = 0

        try {
          to = parseInt(this.$get('form.protrusion_to'))
          from = parseInt(this.$get('form.protrusion_from'))
        } catch (e) { /* Fall through */ }

        if (!isNaN(to) && !isNaN(from)) {
          range = to - from
        }

        this.dynamicSafeSave('form.protrusion_equal', range)
        return range
      }
    },
    methods: {
      buildMusclePalpation: function (musclePalpation, toParse, side) {
        var n
        toParse = toParse.split('~')

        for (n = 0; n < toParse.length; n++) {
          var match = toParse[n].match(/^(\d+)\|(\d*)$/)
          if (!match) {
            continue
          }
          var palpationid = match[1]
          var level = match[2]
          if (!musclePalpation.hasOwnProperty(palpationid)) {
            musclePalpation[palpationid] = {
              left: '',
              right: ''
            }
          }
          musclePalpation[palpationid][side] = level
        }

        return musclePalpation
      },
      parseMusclePalpation: function (left, right) {
        var musclePalpation = {}
        musclePalpation = this.buildMusclePalpation(musclePalpation, Utils.nonNullish(left), 'left')
        musclePalpation = this.buildMusclePalpation(musclePalpation, Utils.nonNullish(right), 'right')
        return musclePalpation
      },
      serializeMusclePalpation: function (musclePalpation) {
        var left = [], right = [], serialized = { left: '', right: '' }

        for (var palpationid in musclePalpation) {
          if (!musclePalpation.hasOwnProperty(palpationid)) {
            continue;
          }

          left.push(palpationid + '|' + Utils.nonNullish(musclePalpation[palpationid].left))
          right.push(palpationid + '|' + Utils.nonNullish(musclePalpation[palpationid].right))
        }

        serialized.left = left.join('~')
        serialized.right = right.join('~')
        return serialized
      },
      
      buildJointSounds: function (jointSounds, toParse, property) {
        var n
        toParse = toParse.split('~')

        for (n = 0; n < toParse.length; n++) {
          var match = toParse[n].match(/^(\d+)\|(.*)$/)
          if (!match) {
            continue
          }
          var jointid = match[1]
          var value = match[2]
          if (!jointSounds.hasOwnProperty(jointid)) {
            jointSounds[jointid] = {
              position: '',
              stage: ''
            }
          }
          jointSounds[jointid][property] = value
        }

        return jointSounds
      },
      parseJointSounds: function (position, stage) {
        var jointSounds = {}
        for (var n = 0; n < this.dynamic.jointSoundTypes.length; n++) {
          jointSounds[this.dynamic.jointSoundTypes[n].jointid] = {
            position: '',
            stage: ''
          }
        }
        jointSounds = this.buildJointSounds(jointSounds, Utils.nonNullish(position), 'position')
        jointSounds = this.buildJointSounds(jointSounds, Utils.nonNullish(stage), 'stage')
        return jointSounds
      },
      serializeJointSounds: function (jointSounds) {
        var position = [], stage = [], serialized = { position: '', stage: '' }

        for (var jointid in jointSounds) {
          if (!jointSounds.hasOwnProperty(jointid)) {
            continue;
          }

          position.push(jointid + '|' + Utils.nonNullish(jointSounds[jointid].position))
          stage.push(jointid + '|' + Utils.nonNullish(jointSounds[jointid].stage))
        }

        serialized.position = position.join('~')
        serialized.stage = stage.join('~')
        return serialized
      },

      parseJointExams: function (exams) {
        var jointExams = {}
        for (var n = 0; n < this.dynamic.jointExamTypes.length; n++) {
          jointExams[this.dynamic.jointExamTypes[n].joint_examid] = 0
        }

        exams = Utils.nonNullish(exams)
        exams = exams.split('~')

        for (n = 0; n < exams.length; n++) {
          var match = exams[n].match(/^(\d+)\D*$/)
          if (!match) {
            continue
          }
          jointExams[match[1]] = 1
        }

        return jointExams
      },
      serializeJointExams: function (jointExams) {
        var serialized = []
        for (var examid in jointExams) {
          if (!jointExams.hasOwnProperty(examid)) {
            continue
          }
          if (jointExams[examid] === 1 || jointExams[examid] === '1') {
            serialized.push(examid)
          }
        }
        serialized = serialized.join('~')
        return serialized
      },

      populateJointExamTypes: function () {
        var n, reference

        if (typeof window.jointExamTypes !== 'undefined') {
          reference = Utils.plainObject(window.jointExamTypes)
          for (n = 0; n < reference.length; n++) {
            this.$set('dynamic.jointExams[' + reference[n].joint_examid + ']', 0)
          }
          this.$set('dynamic.jointExamTypes', reference)
        }
      },
      populateJointSoundTypes: function () {
        var n, reference

        if (typeof window.jointSoundTypes !== 'undefined') {
          reference = Utils.plainObject(window.jointSoundTypes)
          for (n = 0; n < reference.length; n++) {
            this.$set('dynamic.jointSounds[' + reference[n].jointid + ']', {
              position: null,
              stage: null
            })
          }
          this.$set('dynamic.jointSoundTypes', reference)
        }
      },
      populateMusclePalpation: function () {
        this.$set(
          'dynamic.musclePalpationDefaults',
          this.parseMusclePalpation(this.$get('form.palpationid'), this.$get('form.palpationRid'))
        )
      },
      populateJointExams: function () {
        this.$set('dynamic.jointExams', this.parseJointExams(this.$get('form.joint_exam')))
      },
      populateJointSounds: function () {
        this.$set(
          'dynamic.jointSounds',
          this.parseJointSounds(this.$get('form.jointid'), this.$get('form.jointid_stages'))
        )
      },

      setJointSoundsCallback: function () {
        var n
        var jointSounds = this.$get('dynamic.jointSounds')

        if (!this.isListEmpty() && this.mixin.modelId !== this.list[0][this.mixin.modelKey]) {
          return
        }

        for (n in jointSounds) {
          if (!jointSounds.hasOwnProperty(n)) {
            continue
          }
          jointSounds[n].position = 'WNL'
          jointSounds[n].stage = null
        }
      },

      onSaveStart: function () {
        var deviceDate = this.$get('form.dentaldevice_date')
        var serialized

        if (deviceDate === '0000-00-00') {
          this.$set('form.dentaldevice_date', null);
        }

        serialized = this.serializeMusclePalpation(this.$get('dynamic.musclePalpation'))
        this.$set('form.palpationid', serialized.left)
        this.$set('form.palpationRid', serialized.right)

        serialized = this.serializeJointSounds(this.$get('dynamic.jointSounds'))
        this.$set('form.jointid', serialized.position)
        this.$set('form.jointid_stages', serialized.stage)

        serialized = this.serializeJointExams(this.$get('dynamic.jointExams'))
        this.$set('form.joint_exam', serialized)

        this.$set('form.protrusion_equal', '' + this.$get('form.protrusion_equal'))

        this.$set('errors', null)
        this.showBusy(this.mixin.messages.saving)
      }
    },
    ready: function () {
      var self = this
      var n, reference

      setTimeout(function () {
        self.populateJointExamTypes()
        self.emit('dataload', Utils.plainObject(self.formData()))
      }, 300)

      setTimeout(function () {
        self.populateJointSoundTypes()
        self.emit('dataload', Utils.plainObject(self.formData()))
      }, 2*300)

      this.on('load:success', function () {
        setTimeout(function () {
          self.populateMusclePalpation()
          self.emit('dataload', Utils.plainObject(self.formData()))
        }, 300)

        setTimeout(function () {
          self.populateJointExams()
          self.emit('dataload', Utils.plainObject(self.formData()))
        }, 2*300)

        setTimeout(function () {
          self.populateJointSounds()
          self.emit('dataload', Utils.plainObject(self.formData()))
        }, 3*300)
      })
    }
  })

  tmjROM.on('backup:success', function () {
    window.location.href = window.location.href
  })

  /**
   * Declare a global module list, to access them from outside the scope
   */
  window.VueModules = window.VueModules || []
  window.VueModules.push(tmjROM)
}(jQuery))
