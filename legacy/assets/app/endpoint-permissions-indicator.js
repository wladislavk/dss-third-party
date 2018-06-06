/* global EndpointPermissionsFormMixin */
/* global jQuery */
/* global Vue */
(function () {
  var endpointPermissionsIndicator = new Vue({
    el: '#endpoint-permissions-indicator',
    data: {
      namespace: 'indicator',
      listenerOnly: true
    },
    mixins: [EndpointPermissionsFormMixin]
  })
}(jQuery))
