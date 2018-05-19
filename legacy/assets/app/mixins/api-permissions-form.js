/* global $ */
/* global Events */
/* global Modal */
/* global Utils */
var ApiPermissionsFormMixin = {
  data: {
    namespace: '',
    apiPath: '',
    model: {},
    models: [],
    loaded: false
  },
  methods: {
    resetModel: function () {},
    setModel: function (model) {},
    replaceModel: function (model) {
      var models = Utils.plainObject(this.models)
      var index

      for (index = 0; index < models.length; index++) {
        if (models[index].id === model.id) {
          models[index] = model
          this.$set('models', models)

          return
        }
      }
    },
    removeModel: function (model) {
      var models = Utils.plainObject(this.models)
      var index

      for (index = 0; index < models.length; index++) {
        if (models[index].id === model.id) {
          models.splice(index, 1)
          this.$set('models', models)

          return
        }
      }
    },
    getResponseData: function (response) {
      var data

      try {
        data = response.json()
      } catch (e) {
        data = {}
      }

      return data
    },
    errorHandler: function (errorMessage) {
      return function (data) {
        try {
          var message = JSON.parse(data.message)
          this.$set('errors', message)
        } catch (e) {
          this.notifyAction(errorMessage)
        }
      }
    },
    httpAction: function (method) {
      this.showBusy('Saving data please wait...')

      var postValues = Utils.plainObject(this.model)
      var url = this.apiPath

      if (method === 'put') {
        url = this.apiPath + '/' + this.model.id
      }

      this.$http[method](url, postValues)
        .then(function (response) {
          if (method === 'post') {
            var data = this.getResponseData(response)
            this.models.push(data.data)
          }

          if (method === 'put') {
            this.replaceModel(postValues)
          }

          Events.trigger(this.namespace + ':update')
          this.notifyAction('Data saved.')
          this.hideModal()
        }, this.errorHandler(
          'There was an error saving the data. Please reload the page and try again.'
        ))

      $.unblockUI()
    },
    showModal: function () {
      Modal.showPopup(this.$el.querySelector('div.modal'), {
        backdrop: true
      })
    },
    hideModal: function () {
      Modal.hidePopup(this.$el.querySelector('div.modal'))
    },
    showBusy: function (message) {
      this.blockUI({
        message: message
      })
    },
    notifyAction: function (message) {
      this.blockUI({
        message: message,
        timeout: 2000,
        onOverlayClick: this.unblockUI
      })
    },
    blockUI: function (options) {
      var baseOptions = {
        css: {
          border: 'none',
          padding: '15px',
          backgroundColor: '#000',
          '-webkit-border-radius': '10px',
          '-moz-border-radius': '10px',
          opacity: 0.5,
          color: '#fff',
          'z-index': 20000
        }
      }
      var extendedOptions = {}

      Utils.merge(extendedOptions, baseOptions)
      Utils.merge(extendedOptions, options)
      Modal.blockUI(extendedOptions)
    },
    unblockUI: function () {
      Modal.unblockUI()
    },
    newModelCallback: function () {
      this.resetModel()
      this.showModal()
    },
    editModelCallback: function (model) {
      this.setModel(model)
      this.showModal()
    },
    saveModelCallback: function () {
      if (+this.model.id === 0) {
        this.httpAction('post')
        return
      }

      this.httpAction('put')
    },
    deleteModelCallback: function (model) {
      if (!confirm('Delete this entry - Are you sure?')) {
        return
      }

      this.showBusy('Deleting entry please wait...')

      this.$http
        .delete(this.apiPath + '/' + model.id)
        .then(function () {
          this.removeModel(model)
          Events.trigger(this.namespace + ':update')
          this.notifyAction('Entry deleted.')
        }, this.errorHandler(
          'There was an error deleting this entry. Please reload the page and try again.'
        ))

      this.unblockUI()
    },
    loadDependencies: function () {}
  },
  ready: function () {
    this.$http
      .get(this.apiPath)
      .then(function (response) {
        var data = this.getResponseData(response)
        this.$set('models', data.data)
        this.loaded = true
      }, function () {
        this.notifyAction('There was an error loading the list. Please try again in a few minutes.')
      })

    this.loadDependencies()
  }
}
