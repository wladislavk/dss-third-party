var handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  data () {
    return {
      componentParam: {
        sleeplabId: 0
      },
      sleeplab: {}
    }
  },
  mixins: [handlerMixin],
  created () {
    eventHub.$on('setting-component-params', this.onSettingComponentParams)

    this.$parent.popupEdit = false
  },
  beforeDestroy () {
    eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.fetchSleeplab(this.componentParams.sleeplabId)
    },
    fetchSleeplab (id) {
      this.getSleeplab(id)
        .then(function (response) {
          var data = response.data.data

          if (data) {
            data['name'] = data.salutation + ' ' + data.firstname + ' ' + data.middlename + ' ' + data.lastname

            var phoneFields = ['phone1', 'phone2', 'fax']

            phoneFields.forEach(el => {
              if (data.hasOwnProperty(el)) {
                data[el] = data[el].replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3')
              }
            })

            this.sleeplab = data
          }
        }, function (response) {
          this.handleErrors('getSleeplab', response)
        })
    },
    getSleeplab (id) {
      return this.$http.get(process.env.API_PATH + 'sleeplabs/' + id)
    }
  }
}
