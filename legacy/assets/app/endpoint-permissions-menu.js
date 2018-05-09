/* global EndpointPermissionsFormMixin */
/* global jQuery */
/* global Vue */
Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

(function () {
  var endpointTopMenu = new Vue({
    el: '.endpoint-permissions-menu.menu-top',
    mixins: [EndpointPermissionsFormMixin]
  })
  var endpointBottomMenu = new Vue({
    el: '.endpoint-permissions-menu.menu-bottom',
    mixins: [EndpointPermissionsFormMixin]
  })
  window.VueModules = window.VueModules || []
  window.VueModules.push(endpointTopMenu)
  window.VueModules.push(endpointBottomMenu)
}(jQuery))
