/* eslint-env browser */
/* global Events */
/* global Modal */
/* global Utils */
/* global moment */
/* global examsNavigation */
/* global userTimeZone */
/* exported PatientFormMixin */
var PatientFormMixin = {
  data: {
    mixin: {
      namespace: null,
      apiEndPoint: '/',
      patientId: 0,
      patientKey: 'patient_id',
      modelKey: 'id',
      modelId: 0,
      messages: {
        timeout: 2000,
        loading: 'Loading, please wait... <img src="/manage/images/loading.gif" />',
        saving: 'Saving the form, please wait...',
        saved: 'Form updated.',
        saveError: 'There was an error saving the form. Please wait a minute and try again.',
        postError: 'There was an error saving the form. Please wait a minute and try again.',
        validationError: 'There were errors validating the form fields. Please fix the errors and try again.',
        getError: 'There was an error loading the form fields. Please try again later.',
        tokenNotSet: 'Your session has expired. Please login again and reload the page.',
        tokenExpired: 'Your session has expired. Please login again and reload the page.'
      },
      navigation: {
        nextPage: '',
        patientSummary: '/manage/dss_summ.php?pid={patientId}&addtopat=1'
      },
      nextPage: false,
      resetForm: false
    },
    form: {},
    list: [],
    initialState: {},
    secondaryForms: {},
    defaultSources: {},
    defaultData: [],
    errors: null,
    backupInProgress: false,
    dbDateFormat: 'YYYY-MM-DD HH:mm:ss',
    displayDateFormat: 'MM/DD/YYYY HH:mm'
  },
  computed: {
    initiatedTimestamp: function () {
      if (!this.form) {
        return ''
      }

      if (this.form.created_at) {
        return this.form.created_at
      }

      if (this.form.adddate) {
        return this.form.adddate
      }

      return moment().format(this.dbDateFormat)
    },
    lastModifiedTimestamp: function () {
      if (!this.form) {
        return ''
      }

      if (this.form.updated_at) {
        return this.form.updated_at
      }

      if (this.form.created_at) {
        return this.form.created_at
      }

      if (this.form.adddate) {
        return this.form.adddate
      }

      return ''
    }
  },
  methods: {
    isUndefined: function (value) {
      return typeof value === 'undefined' || value === null
    },
    $update: function (path, value) {
      if (path === 'form' && this.isUndefined(value)) {
        return
      }

      if (path !== 'form' || typeof value !== 'object') {
        this.$set(path, value)
        return
      }
      for (var n in value) {
        if (!value.hasOwnProperty(n)) {
          continue
        }
        if (this.isUndefined(value[n])) {
          continue
        }
        this.$set('form.' + n, value[n])
      }
    },
    isListEmpty: function () {
      return this.list.length < 2
    },
    dynamicPropertyWithDefault: function (baseProperty, syncUpProperty) {
      var value = this.$get(baseProperty)
      var defaults = this.$get(syncUpProperty)
      if (value) {
        this.$set(syncUpProperty, value)
        return value
      }
      if (this.isListEmpty() || typeof defaults === 'undefined' || defaults === null) {
        defaults = ''
      }
      this.$set(baseProperty, defaults)
      return defaults
    },
    dynamicSafeSave: function (property, value) {
      if (typeof value === 'undefined' || value === null) {
        value = ''
      }
      this.$set(property, value)
    },

    on: function (eventName, handler) {
      if (this.$get('mixin.namespace')) {
        Events.on([eventName, this.$get('mixin.namespace')].join(':'), handler, this)
      }
    },
    emit: function (eventName, data) {
      if (this.$get('mixin.namespace')) {
        Events.trigger([eventName, this.$get('mixin.namespace')].join(':'), this, data)
      }
    },

    prepareEndPoint: function (endPoint) {
      var searchAndReplace = [{
        search: '{patientId}',
        replacement: this.$get('patientId')
      }, {
        search: '{userId}',
        replacement: this.$get('userId')
      }, {
        search: '{docId}',
        replacement: this.$get('docId')
      }]

      for (var n = 0; n < searchAndReplace.length; n++) {
        var regexp = new RegExp(searchAndReplace[n].search, 'g')
        endPoint = endPoint.replace(regexp, searchAndReplace[n].replacement)
      }

      return endPoint
    },
    prepareOptions: function (options) {
      if (typeof options !== 'object') {
        options = {}
      }

      return options
    },
    fireHttpGet: function (apiEndPoint, options, successHandler, errorHandler) {
      apiEndPoint = this.prepareEndPoint(apiEndPoint)
      options = this.prepareOptions(options)
      this.$http.get(apiEndPoint, options).then(successHandler, errorHandler)
    },
    fireHttpPut: function (apiEndPoint, data, options, successHandler, errorHandler) {
      apiEndPoint = this.prepareEndPoint(apiEndPoint)
      options = this.prepareOptions(options)
      this.$http.put(apiEndPoint, data, options).then(successHandler, errorHandler)
    },
    fireHttpPost: function (apiEndPoint, data, options, successHandler, errorHandler) {
      apiEndPoint = this.prepareEndPoint(apiEndPoint)
      options = this.prepareOptions(options)
      this.$http.post(apiEndPoint, data, options).then(successHandler, errorHandler)
    },

    invalidTokenError: function (response) {
      /**
       * 400: token_not_provided
       * 401: token_expired
       */
      return response.status === 400 || response.status === 401
    },
    onInvalidToken: function (response, fromLoad) {
      if (fromLoad) {
        this.modalUnblock()
        this.showBusy(this.mixin.messages.tokenExpired, this.$el)
        return
      }

      this.unblockUI()
      this.notifyAction(this.mixin.messages.tokenExpired, this.$el)
    },

    getResponseData: function (response) {
      try {
        var responseData = response.json()
        if (typeof responseData !== 'object') {
          return {}
        }
        return responseData
      } catch (e) {
        return {}
      }
    },

    onBackupStart: function () {
      this.$set('errors', null)
      this.backupInProgress = true
    },
    onBackupSuccess: function () {
      this.backupInProgress = false
      this.resetData()
      this.onReady()
      this.emit('backup:success')
    },
    onBackupError: function () {
      this.backupInProgress = false
      this.emit('backup:error')
    },
    onBackup: function () {
      var self = this
      var options = { params: {} }

      this.mixin.modelId = 0
      this.fireHttpPost(
        this.mixin.apiEndPoint + '?' + this.mixin.patientKey + '=' + this.mixin.patientId,
        null,
        options,
        self.onBackupSuccess,
        self.onBackupError
      )
    },

    saveDataSources: function (dataSource) {
      var self = this
      var n = 0
      for (var name in this[dataSource]) {
        if (!this[dataSource].hasOwnProperty(name)) {
          continue
        }
        (function (name, form, delay) {
          setTimeout(function () {
            var url = form.apiEndPoint
            var method = 'Post'
            if (form.modelId) {
              url += '/' + form.modelId
              method = 'Put'
            }
            if (form.requiresPatientId) {
              url += '?' + self.mixin.patientKey + '=' + self.mixin.patientId
            }
            self['fireHttp' + method](url, form.data, {})
          }, delay)
        }(name, this[dataSource][name], n * 300))
        n++
      }
    },
    saveSecondaryForms: function () {
      this.saveDataSources('secondaryForms')
    },

    loadDataSources: function (dataSource) {
      var self = this
      var n = 0
      for (var name in this[dataSource]) {
        if (!this[dataSource].hasOwnProperty(name)) {
          continue
        }
        (function (name, form, delay) {
          setTimeout(function () {
            var url = form.apiEndPoint
            if (form.retrieveLatest) {
              url += '/latest'
            }
            else if (form.modelId) {
              url += '/' + form.modelId
            }
            if (form.requiresPatientId) {
              url += '?' + self.mixin.patientKey + '=' + self.mixin.patientId
            }
            self.fireHttpGet(url, {}, function (response) {
              var responseData = self.getResponseData(response)
              if (!responseData || !responseData.data) {
                return
              }
              for (var n = 0; n < form.fields.length; n++) {
                self.$set(dataSource + '.' + name + '.data.' + form.fields[n], responseData.data[form.fields[n]])
              }
              self.$set(dataSource + '.' + name + '.modelId', responseData.data[form.modelKey])
              self.emit('dataload', Utils.plainObject(self.formData()))
            }, function () {})
          }, delay)
        }(name, this[dataSource][name], n * 300))
        n++
      }
    },
    loadSecondaryForms: function () {
      this.loadDataSources('secondaryForms')
    },
    loadDefaultSources: function () {
      this.loadDataSources('defaultSources')
    },

    onSaveStart: function () {
      this.$set('errors', null)
      this.showBusy(this.mixin.messages.saving)
    },
    onSaveSuccess: function (response, onSuccessAction) {
      var responseData = this.getResponseData(response)

      this.$set('form.updated_at', moment().format(this.dbDateFormat))

      if (responseData.data !== null) {
        this.$update('form', responseData.data)
        this.$set('mixin.modelId', responseData.data[this.mixin.modelKey])
      }

      this.notifyAction(this.mixin.messages.saved)
      this.emit('save:success', responseData)

      if (typeof window.successAction === 'function') {
        window.successAction(responseData)
      }

      if (this.mixin.nextPage) {
        this.nextPage()
        return
      }

      if (typeof onSuccessAction === 'function') {
        onSuccessAction()
      }

      this.saveSecondaryForms()
    },
    onSaveError: function (response, onErrorAction) {
      var responseData = this.getResponseData(response)
      var message = this.mixin.messages.postError

      this.emit('save:error')

      if (this.invalidTokenError(response)) {
        return this.onInvalidToken(response, false)
      }

      /* Forbidden areas must not allow further interaction */
      if (response.status === 403) {
        this.showBusy(responseData.message.error, this.$el)
        return
      }

      if (responseData.data && responseData.data.errors) {
        this.$set('errors', responseData.data.errors)
      }

      if (response.status === 422 && responseData.message === 'Validation Errors') {
        message = this.mixin.messages.validationError
      }

      this.notifyAction(message)

      if (typeof window.errorAction === 'function') {
        window.errorAction(responseData)
      }

      if (typeof onErrorAction === 'function') {
        onErrorAction()
      }
    },
    onSave: function (params, onSuccessAction, onErrorAction) {
      var self = this
      var options = { params: {} }
      var postValues = JSON.stringify(this.formData())
      var url = this.mixin.apiEndPoint
      var method = 'Post'

      if (this.mixin.modelId) {
        url = url + '/' + this.mixin.modelId
        method = 'Put'
      }

      if (typeof params === 'object' && params !== null) {
        options.params = params
      }

      this['fireHttp' + method](
        url + '?' + this.mixin.patientKey + '=' + this.mixin.patientId, postValues, options,
        function (response) {
          self.onSaveSuccess(response, onSuccessAction)
        }, function (response) {
          self.onSaveError(response, onErrorAction)
        }
      )
    },

    onListLoaded: function (response) {
      var responseData = this.getResponseData(response)
      if (responseData.data === null || !responseData.data.length) {
        this.onLoadSuccess(null)
        return
      }
      this.$set('list', responseData.data)
      if (responseData.data.length) {
        var lastModel = responseData.data[0]
        var modelId = this.mixin.modelId ? this.mixin.modelId : lastModel[this.mixin.modelKey]
        this.$set('mixin.modelId', modelId)
        this.fireHttpGet(this.mixin.apiEndPoint + '/' + modelId, {}, this.onLoadSuccess, this.onLoadError)
      }
    },
    onLoadStart: function () {
      this.$set('errors', null)
      this.showBusy(this.mixin.messages.loading, this.$el)
    },
    onLoadSuccess: function (response) {
      var responseData = this.getResponseData(response)

      this.modalUnblock()

      if (responseData.data !== null) {
        this.$update('form', responseData.data)
      }

      /* Emit the event after setting the data values */
      this.emit('load:success', responseData)

      this.loadSecondaryForms()
      this.loadDefaultSources()
    },
    onLoadError: function (response) {
      var responseData = this.getResponseData(response)
      var message = this.mixin.messages.getError

      this.modalUnblock()
      this.emit('load:error')

      if (this.invalidTokenError(response)) {
        return this.onInvalidToken(response, true)
      }

      /* Forbidden areas must not allow further interaction */
      if (response.status === 403) {
        this.showBusy(responseData.message.error, this.$el)
        return
      }

      if (responseData && responseData.data && responseData.data.errors) {
        this.$set('errors', responseData.data.errors)
      }

      this.notifyAction(message)
    },
    onReady: function () {
      this.fireHttpGet(
        this.mixin.apiEndPoint + '?' + this.mixin.patientKey + '=' + this.mixin.patientId, {},
        this.onListLoaded,
        this.onLoadError
      )
    },

    onResetSuccess: function () {
      /* Show an empty form */
      this.emit('load:success')
      this.modalUnblock()
    },
    onResetReady: function () {
      this.onResetSuccess()
    },

    onCreated: function () {},

    showBusy: function (message, target) {
      if (message === false) {
        return
      }

      Modal.showBusy(message, target)
    },
    notifyAction: function (message, target) {
      if (message === false) {
        return
      }

      Modal.notifyAction(message, target, this.mixin.messages.timeout)
    },
    modalUnblock: function () {
      Modal.unblock(this.$el)
    },
    unblockUI: function () {
      Modal.unblock()
    },

    formData: function () {
      return this.form
    },
    save: function (onSuccessAction, onErrorAction) {
      this.onSaveStart()
      this.onSave({}, onSuccessAction, onErrorAction)
    },
    backup: function () {
      var self = this

      this.onBackupStart()
      this.save(function () {
        self.onBackup()
      }, function () {
        self.onBackupError()
      })
    },
    resetData: function () {
      var defaults = this.$get('form.__default__')
      var resetData = this.$get('initialState')

      resetData = Utils.plainObject(resetData)

      if (defaults) {
        defaults = Utils.plainObject(defaults)
        resetData.__default__ = defaults
      }

      this.$set('form', resetData)
    },
    saveAndProceed: function () {
      this.mixin.nextPage = true
      this.save()
    },

    nextPage: function () {
      var match = -1
      var collection = []
      var current
      var navigationIndex
      var sectionIndex
      var section
      var page

      if (this.mixin.navigation.nextPage.length) {
        Utils.navigate(this.mixin.navigation.nextPage)
        return
      }

      if (!this.mixin.patientId) {
        return
      }

      if (typeof examsNavigation === 'undefined') {
        Utils.navigate(this.mixin.patientSummary.replace('{patientId}', this.mixin.patientId))
        return
      }

      current = Utils.uri()

      /**
       * http://stackoverflow.com/a/35522045/208067
       */
      for (navigationIndex = 0; navigationIndex < examsNavigation.length; navigationIndex++) {
        section = examsNavigation[navigationIndex][1]

        for (sectionIndex = 0; sectionIndex < section.length; sectionIndex++) {
          page = section[sectionIndex][0]

          if (current.indexOf(['manage', page].join('/')) === 0) {
            match = collection.length
          }

          collection.push(page)
        }
      }

      match = (match + 1) % collection.length
      Utils.navigate(['/manage/', collection[match], '.php?pid=', this.mixin.patientId].join(''))
    }
  },
  filters: {
    dateFormat: function (value, format) {
      var date = moment(value, this.dbDateFormat)

      if (!date.isValid()) {
        return value
      }

      return date.tz(userTimeZone).format(format)
    }
  },
  ready: function (options) {
    var resetForm = this.mixin.resetForm || (typeof options === 'object' && options !== null && options.resetForm)

    var initialState = this.$get('form')
    initialState = Utils.plainObject(initialState)
    this.$set('initialState', initialState)
    this.onLoadStart()

    if (resetForm) {
      this.onResetReady()
      return
    }

    this.onReady()
  },
  created: function () {
    var self = this

    /* React to events outside the module */
    if (this.mixin.namespace) {
      this.on('load', function () { self.ready() })
      this.on('load:reset', function () { self.ready({ resetForm: true }) })
      this.on('save', function () { self.save() })
      this.on('save:backup', function () { self.backup() })
      this.on('save:proceed', function () { self.saveAndProceed() })
    }

    /* Setup per-case events */
    this.onCreated()
  }
}
