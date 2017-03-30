var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

import maskMixin from '../../../../modules/masks/MaskMixin.js'
import phoneFilter from '../../../../modules/filters/phoneMixin.js'

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
      isContactDataFetched: false,
      phoneFields: ['phone1', 'phone2', 'fax']
    }
  },
  mixins: [handlerMixin, maskMixin, phoneFilter],
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
    onClickGoogleLink () {
      // TODO
    },
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
            this.fullName = (data.firstname ? data.firstname + ' ' : '')
              + (data.middlename ? data.middlename + ' ' : '')
              + (data.lastname || '')

            this.phoneFields.forEach(el => {
              if (data.hasOwnProperty(el)) {
                data[el] = this.phoneForDisplaying(data[el])
              }
            })

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
      // convert phone fields before storing
      var self = this
      this.phoneFields.forEach(el => {
        if (sleeplabFormData.hasOwnProperty(el)) {
          sleeplabFormData[el] = self.phoneForStoring(sleeplabFormData[el])
        }
      })

      var data = {
        sleeplab_form_data: sleeplabFormData
      }

      return this.$http.post(process.env.API_PATH + 'sleeplabs/edit/' + sleeplabId, data)
    }
  }
}
