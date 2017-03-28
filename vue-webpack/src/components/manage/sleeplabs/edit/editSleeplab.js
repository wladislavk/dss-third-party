var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  name: 'edit-sleeplab',
  data () {
    return {
      componentParam: {
        sleeplabId: 0
      },
      sleeplab: {
        salutation: ''
      },
      message: '',
      fullName: '',
      isContactDataFetched: false
    }
  },
  mixins: [handlerMixin],
  watch: {
    'sleeplab': {
      handler: function () {
        // we are editing some sleeplab and current sleeplab data has already fetched
        if (this.componentParams.sleeplabId > 0 && this.isContactDataFetched) {
          this.isContactDataFetched = false
          this.$parent.popupEdit = true
        } else if (this.componentParams.sleeplabId === 0) { // we are creating a new contact
          this.$parent.popupEdit = true
        }

        if (!this.isContactDataFetched) {
          this.isContactDataFetched = true
        }
      },
      deep: true
    }
  },
  computed: {
    buttonText () {
      return this.sleeplab.sleeplabid > 0 ? 'Edit' : 'Add'
    }
  },
  created () {
    eventHub.$on('setting-component-params', this.onSettingComponentParams)
    // no one field was edited
    this.$parent.popupEdit = false
  },
  beforeDestroy () {
    eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSubmit () {
      if (this.validateSleeplabData(this.sleeplab)) {
        this.editSleeplab(this.componentParams.sleeplabId, this.sleeplab)
          .then(function (response) {
            var data = response.data.data

            this.$parent.popupEdit = false

            if (data.status) {
              this.$parent.updateParentData({ message: data.status })
              this.$parent.disable()
            }
          }, function (response) {
            this.parseFailedResponseOnEditingSleeplab(response.data.data)

            this.handleErrors('editSleeplab', response)
          })
      }
    },
    parseFailedResponseOnEditingSleeplab (data) {
      var errors = data.errors.shift()

      if (errors != undefined) {
        var objKeys = Object.keys(errors)

        var arrOfMessages = objKeys.map((el) => {
          return el + ':' + errors[el].join('|').toLowerCase()
        })

        // TODO: create more readable format
        alert(arrOfMessages.join("\n"))
      }
    },
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.fetchSleeplab(this.componentParams.sleeplabId)
    },
    fetchSleeplab (id) {
      this.getSleeplab(id)
        .then(function (response) {
          var data = response.data.data

          if (data) {
            this.sleeplab = data
          }
        }, function (response) {
          this.handleErrors('getSleeplab', response)
        })
    },
    getSleeplab (id) {
      id = id || 0

      return this.$http.get(process.env.API_PATH + 'sleeplabs/' + id)
    },
    editSleeplab (sleeplabId, sleeplabFormData) {
      var data = {
        sleeplab_form_data: sleeplabFormData
      }

      return this.$http.post(process.env.API_PATH + 'sleeplabs/edit/' + sleeplabId, data)
    }
  }
}
