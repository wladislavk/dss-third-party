const handlerMixin = require('../../../../modules/handler/HandlerMixin.js')

export default {
  data () {
    return {
      componentParams: {
        patientId: 0
      },
      patient: {},
      isResetAccessCode: false
    }
  },
  mixins: [handlerMixin],
  created () {
    window.eventHub.$on('setting-component-params', this.onSettingComponentParams)
  },
  beforeDestroy () {
    window.eventHub.$off('setting-component-params', this.onSettingComponentParams)
  },
  methods: {
    onSettingComponentParams (parameters) {
      this.componentParams = parameters

      this.getPatientById(this.componentParams.patientId)
        .then(function (response) {
          const data = response.data.data

          if (data) {
            this.patient = data

            const accessCode = data.hasOwnProperty('access_code') && data.access_code > 0
            if (!accessCode) {
              this.resetPinCode(this.componentParams.patientId)
            }
          }
        }, function (response) {
          this.handleErrors('getPatientById', response)
        })

      // this popup doesn't have any input fields - set the flag to false
      this.$parent.popupEdit = false
    },
    resetPinCode (patientId) {
      patientId = patientId || 0

      this.resetPatientAccessCode(patientId)
        .then(function (response) {
          const data = response.data.data

          if (data.hasOwnProperty('access_code') && data.access_code > 0) {
            this.$set(this.patient, 'access_code', data.access_code)
            this.isResetAccessCode = true
          }
        }, function (response) {
          this.handleErrors('resetPatientAccessCode', response)
        })
    },
    onClickReset () {
      this.resetPinCode(this.componentParams.patientId)
    },
    onSubmit () {
      this.createTempPinDocument(this.componentParams.patientId)
        .then(function (response) {
          const data = response.data.data

          if (data.hasOwnProperty('path_to_pdf') && data.path_to_pdf.length > 0) {
            alert('Temporary PIN document created and email sent to patient.')
            window.open(data.path_to_pdf)

            // pass updated patient to parents
            this.$parent.updateParentData(this.patient)
            // close the popup
            this.$parent.disable()
          }
        }, function (response) {
          this.handleErrors('createTempPinDocument', response)
        })
    },
    getPatientById (patientId) {
      patientId = patientId || 0

      return this.$http.get(process.env.API_PATH + 'patients/' + patientId)
    },
    resetPatientAccessCode (patientId) {
      patientId = patientId || 0

      return this.$http.post(process.env.API_PATH + 'patients/reset-access-code/' + patientId)
    },
    createTempPinDocument (patientId) {
      patientId = patientId || 0

      return this.$http.post(process.env.API_PATH + 'patients/temp-pin-document/' + patientId)
    }
  }
}
