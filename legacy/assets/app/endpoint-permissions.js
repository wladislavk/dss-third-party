/* global EndpointPermissionsFormMixin */
/* global jQuery */
/* global Vue */
(function () {
  Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value

  var endpointPermissions = new Vue({
    el: '.endpoint-permissions',
    mixins: [EndpointPermissionsFormMixin],
    data: {
      namespace: 'permissions',
      forceFirstLoad: true
    },
    methods: {
      toggleEndpoint: function (groupId) {
        this.patientPermissions[groupId].enabled = !this.patientPermissions[groupId].enabled
        this.setInStorage('patientPermissions', this.patientPermissions, this.patientId)
        this.groups[groupId].authorize_per_patient = !this.groups[groupId].authorize_per_patient
        this.groups[groupId].authorize_per_patient = !this.groups[groupId].authorize_per_patient
        this.$http
          .post(
            this.permissionsApiPath + '?patient_id=' + this.patientId,
            { permissions: this.patientPermissions }
          )
      }
    }
  })

  window.VueModules = window.VueModules || []
  window.VueModules.push(endpointPermissions)
}(jQuery))
